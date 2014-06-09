
var zoommode = 6;
var map;
var originMarker = null;
var origin = new google.maps.LatLng( 51.454513,-2.5879099999999653 );
var geocoder = new google.maps.Geocoder();
var dealerPointer = 0;

var arrDealers;

function init(){

	var mapDiv = document.getElementById('mapCanvas');
	
	map = new google.maps.Map(mapDiv, {
          center: origin,
          zoom: zoommode,
          mapTypeId: google.maps.MapTypeId.ROADMAP
    });


    $.ajax({
		type: "GET",
		url: "/dealer-latlng/com/dealerAdmin.cfc",
		dataType: 'json',
		data: { method: 'missingLatLngs', returnFormat: 'json' }
	}).done(function( data ) {
		arrDealers = data;
		callApiAndWait();
	}).error( function(x, t, e){
		console.error(x, t, e);
	});
	
}



function callApiAndWait(){
	console.log("Searching");
	dealerSearch( arrDealers[dealerPointer++] );
	delaySec = 1;
	if( dealerPointer % 20 == 0 ){
		delaySec = 20;
	}
	delayMiliSec = delaySec * 1000;
	console.log("Waiting " + delaySec + " seconds");
	window.setTimeout( callApiAndWait, delayMiliSec );
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
	for( var i in objResult.address_components ){
		if( objResult.address_components[i].types[0] == 'postal_code' ){
			console.log("Post Code found at " + i );
			saveLatLng( objResult.address_components[i].long_name, objResult.geometry.location.mb, objResult.geometry.location.nb );
		}
	}
}


function saveLatLng( postCode, latitudem, longitude ){
	$.ajax({
		type: "GET",
		url: "/dealer-latlng/com/dealerAdmin.cfc",
		dataType: 'json',
		data: { method: 'saveLatLong', postCode: postCode, latitude: latitudem, longitude: longitude }
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

	geocoder.geocode( { 'address': dealer.locationQ }, function (result, status){
		if( status == "OK" ){
			console.log( result );
			origin = result[0]['geometry']['location'];
			processResult( result[0] );
			originMarker.set('title', result[0].formatted_address);
			originMarker.set('position', origin);
			map.set('zoom',12);
			map.set('center', originMarker.position);
		}
	});

}

google.maps.event.addDomListener(window, 'load', init);
