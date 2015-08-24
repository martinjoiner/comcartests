<!DOCTYPE html>
<html>
<head>
	
	<title>Testing Server</title>

	<link rel="stylesheet" href="/css/style.css">

</head>
<body>

	<h1>Testing VHost</h1>

	<cfdirectory
		action="list"
		directory="#ExpandPath( '\' )#"
		recurse="false"
		listinfo="name"
		sort="name asc"
		name="qFile"
		type="dir"
		/>

	<cfoutput>
	<ul>
	<cfloop query="qFile">
		<cfif !ArrayFind( ['Packages', 'node_modules', 'js', 'css', 'page' ], qFile.name) >
	    	<li><a href="#qFile.name#">#ReReplace(qFile.name, '-', ' ', 'ALL')#</a></li>
	    </cfif>
	</cfloop>
	</ul>
	</cfoutput>

	<p>Martin would like a cup of tea please</p>

</body>
</html>
