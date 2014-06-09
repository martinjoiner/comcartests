
component  
	displayname="Dealer Admin" 
	hint="Lean component for previwing articles with cache"
{
	
	remote function missingLatLngs( startFrom, channelID = '' ){
		
		var channelConditions = '';
		if( channelID != '' ){
			channelConditions = " AND `channel_id` = '" & channelID  & "' ";
		}

		// Query Database
		var strSelect = "
			SELECT `c_address1`, `c_address2`, `c_address3`,  `c_addresstown`, `c_addresscounty`,  `c_postcode`, `c_name`, `channel_id`, `z_id`, `c_postcode`, `latitude`, `longitude`
			FROM `dealersyn`
			LEFT JOIN `dealer_channel` ON `dealer_id` = `z_id`
			WHERE `c_postcode` != '' 
			AND `latitude` IS NULL
			AND `longitude` IS NULL 
			AND `z_type` = 'dealer'
			" & channelConditions & "
			LIMIT " & startFrom & ", 1000";
		
		var qrySelect = new Query();             
        qrySelect.setDataSource('dsnallcars');             
        qrySelect.setSQL(strSelect);             
        rstSelect = qrySelect.Execute().getResult();

        var cntDealers = rstSelect.recordcount;

	    var arrResult = [];

 		if( cntDealers > 0 ){
	        for(var i=1; i <= cntDealers; i++) {
	        	thisDealer = {};
	        	thisDealer['channelID'] = rstSelect.channel_id[i];
	        	thisDealer['name'] 		= rstSelect.c_name[i];
	        	thisDealer['latitude'] 	= rstSelect.latitude[i];
	        	thisDealer['longitude'] = rstSelect.longitude[i];
	        	thisAddress = rstSelect.c_address1[i] & ' ' & rstSelect.c_address2[i] & ' ' &  rstSelect.c_address3[i] & ' ';
	        	thisAddress &= rstSelect.c_addresstown[i] & ' ' &  rstSelect.c_addresscounty[i] & ' ' &  rstSelect.c_postcode[i] & ' UK';
	        	thisDealer['locationQ'] = reReplace(thisAddress, ' {2,}', ' ', 'ALL'); 
	        	thisDealer['postcode'] 	= rstSelect.c_postcode[i];
	        	ArrayAppend( arrResult, thisDealer );
	        }
	    }

	    return SerializeJSON(arrResult);

	}

	remote function saveLatLong( postCode, latitude, longitude ){
		// Query Database
		var strUpdate = " 	UPDATE `dealersyn`
							SET `latitude` = '" & latitude & "',
								`longitude` = '" & longitude & "'
							WHERE TRIM(`c_postcode`) = TRIM('" & postCode & "')
						";
		
		var qryUpdate = new Query();             
        qryUpdate.setDataSource('dsnallcars');             
        qryUpdate.setSQL(strUpdate);             
        rstUpdate = qryUpdate.Execute().getResult();
	}

}