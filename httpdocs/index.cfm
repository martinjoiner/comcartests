<!DOCTYPE html>
<html>
<head>
	<title>Testing Server</title>

	<!-- injector:css -->
	<link rel="stylesheet" href="/css/780e58ce.style.min.css">
	<!-- endinjector -->

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
		<cfif !ReFind('Packages|node_modules|js|css|core|page',qFile.name) >
	    	<li><a href="#qFile.name#">#ReReplace(qFile.name, '-', ' ', 'ALL')#</a></li>
	    </cfif>
	</cfloop>
	</ul>
	</cfoutput>


	<!-- injector:js -->
	<script src="/js/d352d358.main.min.js"></script>
	<!-- endinjector -->

	<script type='text/javascript'>//<![CDATA[
	;document.write("<script defer src='//HOST:3000/socket.io/socket.io.js'><\/script><script defer src='//HOST:3001/client/browser-sync-client.0.9.1.js'><\/script>".replace(/HOST/g, location.hostname));
	//]]></script>

</body>
</html>