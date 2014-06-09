
// The user defined variables
var startFrom = 0;
var channelID = 0;

// The Google Maps objects
var zoommode = 6;
var map;
var originMarker = null;
var origin = new google.maps.LatLng( 51.454513,-2.587909 );
var geocoder = new google.maps.Geocoder();

// The data array and pointer
var arrDealers;
var dealerPointer = 0;

function init(){

	var mapDiv = document.getElementById('mapCanvas');
	
	map = new google.maps.Map(mapDiv, {
          center: origin,
          zoom: zoommode,
          mapTypeId: google.maps.MapTypeId.ROADMAP
    });

}



function loadData(){
	
	// Reset the data array and pointer
	arrDealers = [];
	dealerPointer = 0;

	// Update the user-defined variables
	channelID = $('#channelID').val();
	startFrom = $('#startFrom').val();

	$.ajax({
		type: "GET",
		url: "/dealer-latlng/com/dealerAdmin.cfc",
		dataType: 'json',
		data: { method: 'missingLatLngs', startFrom: startFrom, channelID: channelID, returnFormat: 'json' }
	}).done(function( data ) {
		arrDealers = data;
		var btnHTML = '';
		for(var i in arrDealers){
			btnHTML += '<input type="button" data-locationq="' + arrDealers[i].locationQ + '" value="' + arrDealers[i].name + '" />';
		}
		console.log(btnHTML);
		$('#dealerButtons').html(btnHTML);
	}).error( function(x, t, e){
		console.error(x, t, e);
	});
}



$('#btnGetMissing').click( function(){
	loadData();
});



$('#btnStop').click( function(){
	var id = window.setTimeout(function() {}, 0);
	while (id--) {
	    window.clearTimeout(id); // will do nothing if no timeout with id is present
	}
	console.log("Stopped");
});



$('#btnStart').click( function(){
	callApiAndWait();
});





function callApiAndWait(){
	console.log("Searching");
	dealerSearch( arrDealers[dealerPointer++] );
	delaySec = 1;
	if( dealerPointer % 20 == 0 ){
		delaySec = 20;
	}
	delayMiliSec = delaySec * 1000;
	console.log("Waiting " + delaySec + " seconds");

	if( dealerPointer < arrDealers.length ){
		window.setTimeout( callApiAndWait, delayMiliSec );
	}
}



/* Initialised a position marker on the map */
function initOriginMarker(){
	originMarker = new PositionWidget(map,origin);
}



function PositionWidget(map,position){
	this.set('map', map);
	this.set('position', position);
	
	var marker = new google.maps.Marker({
		draggable: true,
		icon: 'images/Map-Marker-Green.png'
	});

	// Bind the marker map property to the PositionWidget map property
	marker.bindTo('map', this);
	
	// Bind the marker position property to the PositionWidget position property
	marker.bindTo('position', this);
	marker.bindTo('title', this);

	google.maps.event.addListener(marker, 'dragstart', function() { 
		marker.set('title', 'Custom Position');
	});

	google.maps.event.addListener(marker, 'dragend', function() { 
		map.set('center', marker.position);
	});

}
PositionWidget.prototype = new google.maps.MVCObject();



/* Populates the values of form inputs */
function processResult( objResult ){
	var postCodeNotFound = true;
	for( var i in objResult.address_components ){
		if( objResult.address_components[i].types[0] == 'postal_code' ){
			postCodeNotFound = false;
			console.log("Post Code found at " + i );
			saveLatLng( objResult.address_components[i].long_name, objResult.geometry.location.mb, objResult.geometry.location.nb );
		}
	}
	if( postCodeNotFound ){
		saveLatLng( originMarker.title, originMarker.position.mb, originMarker.position.nb );
	}
}



/* Saves a postcode, latitude and longitude in the database */
function saveLatLng( postCode, latitude, longitude ){
	$.ajax({
		type: "GET",
		url: "/dealer-latlng/com/dealerAdmin.cfc",
		dataType: 'json',
		data: { method: 'saveLatLong', postCode: postCode, latitude: latitude, longitude: longitude }
	}).done(function( data ) {
		console.log("db Updated");
	}).error( function(x, t, e){
		console.error(x, t, e);
	});
}



/* Uses a user-inputted string to perform a Google geocoder API call */ 
function dealerSearch( dealer ){

	if( originMarker === null ){
		initOriginMarker();
	}
	originMarker.set('title', dealer.postcode );
	geocoder.geocode( { 'address': dealer.locationQ }, function (result, status){
		if( status == "OK" ){
			console.log( result );

			if( result.length = 1 && result[0].partial_match ){
				console.log( "Partial match" );
				//recordBasedOnPointer();
			}
			origin = result[0]['geometry']['location'];
			processResult( result[0] );
			
			originMarker.set('position', origin);
			map.set('zoom',12);
			map.set('center', originMarker.position);
		}
	});

}

google.maps.event.addDomListener(window, 'load', init);
