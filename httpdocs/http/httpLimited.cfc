<cfcomponent
	displayname="HTTP Limited"
	output="true"
	hint="Does a HTTP request in a limited time">
 
	<!--- Define the page request properties. --->
	
 	
 	<cffunction name="gogo">

 		<cfsetting
			requesttimeout="1"
			showdebugoutput="false"
			enablecfoutputonly="false"
		/>
	 		
		<cfhttp url="http://openmicfinder.co.uk/sitemap.xml" result="result" charset="utf-8" throwonerror="false" userAgent="ColdFusion"> 
		</cfhttp>

		<cfreturn result>

 	</cffunction>

 	
</cfcomponent>
