<cfscript>
	
VARIABLES.objSort 	= new core.utility.sort();


arrThings = [];

objTemp = {};
objTemp['id'] = 605;
objTemp['price'] = 400;
ArrayAppend( arrThings, objTemp);

objTemp = {};
objTemp['id'] = 945;
objTemp['price'] = 200;
ArrayAppend( arrThings, objTemp);

objTemp = {};
objTemp['id'] = 745;
objTemp['price'] = 100;
ArrayAppend( arrThings, objTemp);

writeDump( arrThings );

arrResult = VARIABLES.objSort.msArray(arrThings,'id',true);

writeDump( arrResult );

</cfscript>
	