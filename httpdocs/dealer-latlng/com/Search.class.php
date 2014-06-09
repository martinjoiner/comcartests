<?php
class Search{

    protected $objUser;
    protected $pageLimit        = 10;

    protected $country          = 'UK';
    protected $rootLocation     = NULL;
    protected $areaLevel1ID     = NULL;
    protected $countyID         = NULL;
    protected $townID           = NULL;
    protected $status           = 'live';
    protected $q                = NULL;
    protected $radiusMiles      = 10;
    protected $eventID          = NULL;
    protected $day              = NULL;

    protected $boolLoadThumbnails  = false;
    protected $rootLocationIsUser = false;

    protected $arrEvents        = array();

    protected $initTimeTaken    = 0;

    /* 
    @location - The location from which the distance should be calculated
    */
    function __construct( $objConfig ) {

        $searchDatabase = true;
        $intiStart = microtime(true);

        if( isSet( $objConfig["country"]        ) ){ $this->country                 = $objConfig["country"];            }
        if( isSet( $objConfig["rootLocation"]   ) ){ $this->rootLocation            = $objConfig["rootLocation"];       }
        if( isSet( $objConfig["areaLevel1ID"]   ) ){ $this->areaLevel1ID            = $objConfig["areaLevel1ID"];       }
        if( isSet( $objConfig["countyID"]       ) ){ $this->countyID                = $objConfig["countyID"];           }
        if( isSet( $objConfig["townID"]         ) ){ $this->townID                  = $objConfig["townID"];             }
        if( isSet( $objConfig["status"]         ) ){ $this->status                  = $objConfig["status"];             }
        if( isSet( $objConfig["q"]              ) ){ $this->q                       = $objConfig["q"];                  }
        if( isSet( $objConfig["radiusMiles"]    ) ){ $this->radiusMiles             = $objConfig["radiusMiles"];        }
        if( isSet( $objConfig["eventID"]        ) ){ $this->eventID                 = $objConfig["eventID"];            }
        if( isSet( $objConfig["day"]            ) ){ $this->day                     = $objConfig["day"];                }
        if( isSet( $objConfig["loadThumbnails"] ) ){ $this->boolLoadThumbnails      = $objConfig["loadThumbnails"];     }
        if( isSet( $objConfig["rootLocationIsUser"] ) ){ $this->rootLocationIsUser  = $objConfig["rootLocationIsUser"]; }

        if( $this->rootLocationIsUser == true && !$this->eventID ){
            $this->objUser = new User();
            if( $this->objUser->locationSet ){
                $this->rootLocation = $this->objUser->getLocation();
            } else {
                $this->rootLocationIsUser = false;
                $searchDatabase = false;
            }
            $this->radiusMiles = $this->objUser->radiusMiles;
        }

        if( $searchDatabase ){
            $this->arrEvents    = $this->searchDatabase();
        }
        if( $this->boolLoadThumbnails ){
            $this->loadThumbnails();
        }
        $this->arrDays      = $this->groupByDay();  // Two dimensional array

        $this->initTimeTaken = microtime(true) - $intiStart;
    }

    function convertAgeLimit($dayagelimit){
        if(is_null($dayagelimit)){
            $dayagelimit = 9999;
        }
        $sixmonthsago = time() - ($dayagelimit * 24 * 60 * 60);
        return $sixmonthsago;
    }

    public function getSingleEvent(){
        return $this->arrEvents[0];
    }

    public function reportInitTime(){
        return $this->initTimeTaken;
    }

    private function interpretQ(){
        $sConditions = "";
        if( $this->q ){

            if (preg_match("[ ]",$this->q))
                $qParts = split(" ",$this->q); 
            else
                $qParts[] = $this->q;
                
            // Strip the S off the end in case of pluralisation
            for ($i = 0; $i < sizeof($qParts); $i++)
            {
                if (strtolower(substr($qParts[$i],strlen($qParts[$i])-1,1)) == "s" )
                {
                    //print "<p>qParts ".$i." is pluralised</p>";
                    $qParts[$i] = substr($qParts[$i],0,strlen($qParts[$i])-1);
                }
            }
            
            $sConditions = "AND (CONCAT_WS(' ', `event_name`, `event_venue`, `town_name`, `county_name`, `arealevel1`.`name`, `event_address`) LIKE ";
            for ($i = 0; $i < sizeof($qParts); $i++){
                if ($i == 0)
                    $sConditions .= "'%".$qParts[$i]."%'";
                else
                    $sConditions .= " AND CONCAT_WS(' ', `event_name`, `event_venue`, `town_name`, `county_name`, `arealevel1`.`name`, `event_address`) LIKE '%".$qParts[$i]."%' ";
            }
            $sConditions .= " ) ";
        }
        return $sConditions;
    }

    private function searchDatabase(){

        $clause = '';

        if( $this->eventID ){
            $clause .= ' AND event.event_id = '.$this->eventID.' ';
        }

        if( $this->areaLevel1ID ){
            $clause .= ' AND `arealevel1`.`id` = '.$this->areaLevel1ID.' ';
        }

        if( $this->countyID ){
            $clause .= ' AND `county_id` = ' . $this->countyID . ' ';
        }

        if( $this->status ){
            $clause .= " AND `event_status` = '".$this->status."' ";
        }

        $clause .= $this->interpretQ();

        // ------------------------------------------------------- SEARCH THING ------------------------------------------------------------------//

        $queryText = "  SELECT 	event.event_id AS event_id,
        						event_address,      event_postcode,		eslug1.slug,      	`event_name`,         `event_venue`,       `event_phone`,
                                event_entryfee,     event_updated,      event_latcoord,     `event_loncoord`,     `event_fbgroupid` AS facebook, event_twithandle AS twithandle,
                                town_slug,          town_name,          county_name,        `county_slug`,        `country`,    town_id AS 'grouper', event_link AS website, 
                                event_notes, event_status AS status,   `arealevel1`.`id` AS 'areaLevel1ID',     `arealevel1`.`name` AS 'areaLevel1Name',   `arealevel1`.`slug` AS 'areaLevel1Slug',
                            	event_latcoord AS lat, event_loncoord AS lon, 
                            	GROUP_CONCAT(DISTINCT CONCAT_WS(',',occurrence.index,occurrence.day,occurrence.starttime,occurrence.endtime) SEPARATOR '|') AS csvOccurrence,
                                GROUP_CONCAT(DISTINCT `youtube_v` SEPARATOR ',') AS csvYoutubeVs,
                                GROUP_CONCAT( `eml_medium_id` SEPARATOR ',' ) AS csvMediums
                        FROM `occurrence`
                        LEFT JOIN `event`           ON event.event_id = occurrence.event_id
                        LEFT JOIN `event_slug` eslug1  ON event.event_id = eslug1.event_id
                        LEFT JOIN `event_slug` eslug2  ON event.event_id = eslug2.event_id AND eslug2.created > eslug1.created
                        LEFT JOIN `town`            ON `event_town_id` = `town_id`
                        LEFT JOIN `county`          ON `town_county_id` = `county_id`
                        LEFT JOIN `arealevel1`      ON county.arealevel1_id = arealevel1.id
                        LEFT JOIN `youtube`         ON `youtube_event_id` = event.event_id
                        LEFT JOIN `eventmediumlink` ON event.event_id = `eml_event_id`
                        WHERE eslug2.created IS NULL
                        ".$clause." 
                        
                        GROUP BY event.event_id
                    ";
        //AND country = '".$this->country."'

        //require_once('phDump/phDump.inc.php');
        //phDump( $queryText );

        include( $_SERVER["DOCUMENT_ROOT"] . '/db_connect.inc.php' );
        $query = mysql_query( $queryText, $dbh);
        include( $_SERVER["DOCUMENT_ROOT"] . '/db_disconnect.inc.php' );

        require_once("lldistance.inc.php");
        $returnArray = array();
        if ($query){
            while( $result = mysql_fetch_array($query) ){
                
                if( $this->rootLocation ){
                    $miles = distance( $this->rootLocation["lat"], $this->rootLocation["lon"], $result["event_latcoord"], $result["event_loncoord"],"m");
                }
                else{
                    $miles = NULL;
                }

                if( $this->rootLocationIsUser ){
                    $eventConfig["showDistanceFromRoot"] = true;
                } else {
                    $eventConfig["showDistanceFromRoot"] = false;
                }
                
                $eventConfig["id"]              = $result["event_id"];
                $eventConfig["eventName"]       = $result["event_name"];
                $eventConfig["slug"]            = $result["slug"];
                $eventConfig["venueName"]       = $result["event_venue"];
                $eventConfig["venuePhone"]      = $result["event_phone"];
                $eventConfig["notes"]           = $result["event_notes"];
                $eventConfig["status"]          = $result["status"];
                $eventConfig["website"]         = $result["website"];
                $eventConfig["facebook"]        = $result["facebook"];
                $eventConfig["twithandle"]      = $result["twithandle"];
                $eventConfig["address"]         = $result["event_address"];
                $eventConfig["postcode"]        = $result["event_postcode"];
                $eventConfig["lat"]             = $result["lat"];
                $eventConfig["lon"]             = $result["lon"];
                $eventConfig["areaLevel1Name"]  = $result["areaLevel1Name"];
                $eventConfig["areaLevel1Slug"]  = $result["areaLevel1Slug"];
                $eventConfig["countyName"]      = $result["county_name"];
                $eventConfig["countySlug"]      = $result["county_slug"];
                $eventConfig["townSlug"]        = $result["town_slug"];
                $eventConfig["townName"]        = $result["town_name"];
                $eventConfig["csvOccurrence"]   = $result["csvOccurrence"];
                $eventConfig["csvMediums"]      = $result["csvMediums"];
                $eventConfig["entryFee"]        = $result["event_entryfee"];
                $eventConfig["updated"]         = $result["event_updated"];
                $eventConfig["csvYoutubeVs"]    = $result["csvYoutubeVs"];
                $eventConfig["milesFromRoot"]   = $miles;
                
                $tempEvent                      = new Event( $eventConfig );

                if(is_null($this->radiusMiles)){
                    $returnArray[] = $tempEvent;
                } else {
                    if($miles < $this->radiusMiles){
                        $returnArray[] = $tempEvent;
                    }
                }
            }
        } else {
            echo mysql_error();
        }

        return $returnArray;
    }

    /* Executes a second database query to get thumbnail images for the events */
    private function loadThumbnails(){
        include( $_SERVER["DOCUMENT_ROOT"] . '/db_connect.inc.php' );
        $q = mysql_query("  SELECT `image_event_id`,`thumbspritex`,`thumbspritey` FROM `image` 
                            WHERE `onthumbsprite` = 1
                            GROUP BY image_event_id 
                            ORDER BY `image_id` 
                        ", $dbh);
        include( $_SERVER["DOCUMENT_ROOT"] . '/db_disconnect.inc.php' );
        $imgs = array();
        while($r = mysql_fetch_array($q)){
            $imgs[] = array( 'id' => $r["image_event_id"], 'thumbspritex' => $r["thumbspritex"], 'thumbspritey' => $r["thumbspritey"] );
        }

        foreach($this->arrEvents as $event){
            foreach($imgs as $img){
                if($img['id'] == $event->id){
                    $event->setThumbnailXY('-'.$img['thumbspritex'].'px -'.$img['thumbspritey'].'px');
                }
            }
        }

    }

    /* ----------------------------------------------- */

    public function printCompactResultsList(){
        $resultCount = 0;
        for( $i = 0; $i < 7; $i++ ){
            if( sizeof( $this->arrDays[$i]->events ) ){
                print '<h2>' . $this->arrDays[$i]->name . '</h2>';
                print '<ul class="day">';
                $resultCount += $this->printCompactResultsDay( $this->arrDays[$i]->events );
                print '</ul>';
            }
        }
    }


    private function printCompactResultsDay( $arrEvents ){
        
        if( sizeof( $arrEvents ) == 0 ){
            //print 'No events on this day';
            return 0;
        }
        else{
            $counter = 0;
            foreach( $arrEvents as $event ){
                $counter++;
                $event->printAsCompactResult();
            }
            return $counter;
        }
                    
    }

    /* ----------------------------------------------- */

    private function printDay( $arrEvents ){
        
        if( sizeof( $arrEvents ) == 0 ){
            //print 'No events on this day';
            return 0;
        }
        else{
            $counter = 0;
            foreach( $arrEvents as $event ){
                $counter++;
                $event->printAsResult();
            }
            return $counter;
        }
    }

    /* Loop through each day printing lists of events inside wrapper divs */
    public function printResults(){

        $resultCount = 0;
        $moreEventsNotPrinted = TRUE;
        for( $i = 0; $i < 7; $i++ ){

            if( $resultCount > $this->pageLimit ){
                if($moreEventsNotPrinted){
                    $moreEventsNotPrinted = FALSE;
                    print '<div class="moreeventscleartop">&nbsp;</div><h2 class="moreeventsh2">More events...</h2>';
                }
                
                print '<a class="moreevents" href="' . $this->arrDays[$i]->name . '"> ' . $this->arrDays[$i]->name . '(' . sizeof($this->arrDays[$i]->events) . ')</a>';
               
            } else {
                print '<div class="eventgroup embossed punched"><h2>'.$this->arrDays[$i]->name.'</h2>';
                $resultCount += $this->printDay( $this->arrDays[$i]->events );
                print '</div>';
            }
        }

        if( $resultCount == 0 ){
            print '<div class="noresultsdiv"><h2>No Results</h2></div>';
        }
    
    }

    /* Loop through each day printing keywords */
    public function printKeywords(){
        $runningTotal = 0;
        for($i = 0; $i < 7; $i++){
            if( $runningTotal < 30 ){
                if( sizeof( $this->arrDays[$i]->events ) ){
                    print 'Open mics on '.$this->arrDays[$i]->name.": ";
                    $counter = 0;
                    foreach( $this->arrDays[$i]->events as $event){
                        if($counter++ > 0){
                            print ',';
                        }
                        print ' '.$event->venueName.' ('.$event->townName.')';
                    }
                    $runningTotal += $counter;
                    print '. ';
                }
            }
        }
    }


    /* ------------ Twitter stuff ------------------- */

    /* Creates a Tweet config and returns JSON encoded object to be used by JS */
    public function printTweetConfigJSON(){

        if( $this->rootLocation ){
            $tweetConfig["location"] = $this->rootLocation;
        } else if( sizeof( $this->arrEvents ) == 1 ){
            $singleLocation = array( 'lat'=>$this->arrEvents[0]->lat, 'lon'=>$this->arrEvents[0]->lon );
            $tweetConfig["location"] = $singleLocation;
        }

        $tweetConfig["radius"] = $this->radiusMiles;

        $handles = $this->getAllTwitterHandles();

        if( strlen( $handles ) ){
            $tweetConfig["hashesAndHandles"] = $handles;
        }

        return urlencode( json_encode( $tweetConfig ) );
    }

    private function getAllTwitterHandles(){
        $limit = sizeof( $this->arrEvents );
        $handles = '';
        for( $i = 0; $i < $limit; $i++){
            if( $this->arrEvents[$i]->twithandle ){
                $handles .= $this->arrEvents[$i]->twithandle . ' ';
            }
        }
        return trim( str_replace( '/ +/' , ' ', $handles ) );
    }

    /* -------------------------------------------- */

    private function groupByDay(){

        if( isSet($this->day) ){
            $startDay = $this->day;
        } else {
            $startDay = date('N');
        }

        $returnArray = array();
        for($i = 0; $i < 7; $i++){
            $returnArray[$i] = array();
        }
        
        // Run through each event, inserting it into any day arrays that it belongs in
        foreach($this->arrEvents as $objEvent){
            foreach($objEvent->days as $ds){
                $returnArray[$ds][] = $objEvent;
            }
        }

        // For each day (0 = Sunday, 6 = Saturday), sort the results by next occurance
        for($i = 0; $i < 6; $i++){
            usort($returnArray[$i], function($a, $b)
            {
                $aval = $a->nextEventTimeStamp;
                $bval = $b->nextEventTimeStamp;
                if(is_null($aval)) {
                    $aval = time()*2; }
                if(is_null($bval)) {
                    $bval = time()*2; }
                return ($aval < $bval) ? -1 : 1;
            });
        }


        $sortedReturnArray = array();
        for($i = 0; $i < 7; $i++){
            $sortedReturnArray[$i] = NULL;
        }

        $settingday = $startDay;
        // Loop through 7 times
        for($i = 0; $i < 7; $i++)
        {
            if($settingday == 7){   
                $settingday = 0;
            }
            $sortedReturnArray[$i] = new Day($settingday,$returnArray[$settingday]);
            $settingday++;
        }

        return $sortedReturnArray;  
    }


    function sortByDistance(){
 
        usort($this->arrEvents, function($a, $b)
        {
            return ($a->distanceMiles < $b->distanceMiles) ? -1 : 1;
        });

        return $this->arrEvents;  
    }

    public function getMapJSON(){
        $cntEvents = sizeof(  $this->arrEvents );
        $arrLimited = array();
        for( $i = 0; $i < $cntEvents; $i++){
            $arrLimited[$i]["lat"] = $this->arrEvents[$i]->lat;
            $arrLimited[$i]["lon"] = $this->arrEvents[$i]->lon;
            $arrLimited[$i]["title"] = $this->arrEvents[$i]->getTitle( false, false );
            $arrLimited[$i]["occurrenceDescription"] = $this->arrEvents[$i]->occurrenceDescription;
            $arrLimited[$i]["url"] = $this->arrEvents[$i]->url;
        }
        return json_encode( $arrLimited );
    }

}

?>