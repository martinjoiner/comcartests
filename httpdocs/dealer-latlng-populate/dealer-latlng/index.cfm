<!DOCTYPE html>

<html>
<head>


</head>
<body>
<cfoutput>

	<cfparam name="URL.startFrom" default="0">

	<p>Starting from #URL.startFrom#</p>

	<script>
	var startFrom = #URL.startFrom#;
	</script>

	<fieldset>
		<legend>Get Data</legend>
		<label>Start From</label><input type="number" id="startFrom" value="#startFrom#"><br>
		<label>Channel ID</label><input type="number" id="channelID" value="232"><br>
		<input type="button" id="btnGetMissing" value="Get Missing LatLngs">
	</fieldset>

	<fieldset>
		<legend>Auto-find</legend>
		<input type="button" id="btnStart" value="Start">
		<input type="button" id="btnStop" value="Stop">
	</fieldset>

	<div id="dealerButtons"></div>

	<div id="mapCanvas" style="width: 400px; height: 300px;">

	<textarea></textarea>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script src="http://www.google.com/jsapi?autoload=%7B%27modules%27%3A%5B%7Bname%3A%27maps%27%2Cversion%3A3%2Cother_params%3A%27sensor%3Dtrue%27%7D%5D%7D"></script>
	<script src="js/map.js"></script>


</cfoutput>
</body>
</html>