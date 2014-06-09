
component  
	displayname="Proximity Dealers" 
	hint="Returns nearest dealers"
{

	VARIABLES.objSort 	= new core.utility.sort();

	/*
	Set channelID to restrict 
	*/
	remote function nearestDealers( latitude = 51.454513, longitude = -2.5879099999999653, channelID = 232, maxRadius = 10 ){
		
		// Bristol 51.454513,-2.5879099999999653

		// Query Database
		var strSelect = "
			SELECT `c_name`, `c_lease_email`, `c_address1`, `c_address2`, `c_address3`, `c_addresstown`, `c_addresscounty`, `c_postcode`, `latitude`, `longitude`
			FROM `dealer_channel`
			LEFT JOIN `dealersyn` ON `dealer_id` = `z_id`
			WHERE `channel_id` = '" & channelID & "' 
			AND `latitude` != ''
			AND `z_type` = 'dealer'
		";
		
		var qrySelect = new Query();             
        qrySelect.setDataSource('dsnallcars');             
        qrySelect.setSQL(strSelect);             
        rstSelect = qrySelect.Execute().getResult();

        var cntDealers = rstSelect.recordcount;

	    var arrResult = [];

        for(var i=1; i <= cntDealers; i++) {
        	thisDealer = {};
        	thisDealer['address'] 		= rstSelect.c_address1[i] & ' ' & rstSelect.c_address2[i] & ' ' & rstSelect.c_address3[i] & ' ' & rstSelect.c_addresstown[i] & ' ' & rstSelect.c_addresscounty[i] & ' ' & rstSelect.c_postcode[i];
        	thisDealer['postcode'] 		= rstSelect.c_postcode[i];
        	thisDealer['leaseEmail'] 	= rstSelect.c_lease_email[i];
        	thisDealer['latitude'] 		= rstSelect.latitude[i];
        	thisDealer['longitude'] 	= rstSelect.longitude[i];
        	thisDealer['distanceMiles'] = distance( rstSelect.latitude[i], rstSelect.longitude[i], latitude, longitude );
        	ArrayAppend( arrResult, thisDealer );
        }

        arrResult = VARIABLES.objSort.msArray(arrResult,'distanceMiles',true);

	    return SerializeJSON(arrResult[1]);

	}

	private function distance(lat1, lon1, lat2, lon2, unit = 'm'){
	    theta = lon1 - lon2; 
	    dist = sin(deg2rad(lat1)) * sin(deg2rad(lat2)) +  cos(deg2rad(lat1)) * cos(deg2rad(lat2)) * cos(deg2rad(theta)); 
	    dist = acos(dist); 
	    dist = rad2deg(dist); 
	    distmiles = dist * 60 * 1.1515;
	    
	    if (unit == "k")
	        return round(distmiles * 1.609344); 
	    else if (unit == "n")
	        return round(distmiles * 0.8684);
	    else if (unit == "m")
	        return round(distmiles);
	}

	private function deg2rad(deg) {
		return (deg * Pi() / 180.0);
	}

	private function rad2deg(rad) {
		return (rad * 180 / Pi() );
	}

}