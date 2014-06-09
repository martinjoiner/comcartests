<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="wrapper">
			
			<div id="shape">
			
				<cfloop from="1" to="8" index="i">
					<cfoutput><div class="plane p#i#"><object type="image/svg+xml" data="play.svg"></object></div></cfoutput>
				</cfloop>
			</div>
			
		</div>
	</body>