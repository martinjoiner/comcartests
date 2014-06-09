<cfoutput>
	INSERT INTO articles.types_sections (`type_id`,`section_id`)
	VALUES
<cfloop from="102" to="106" index="i">
	<cfloop from="7" to="17" index="n"><cfif n EQ 11><cfelse><cfif i EQ 102 AND n EQ 7><cfelse>,</cfif>('#i#','#n#')</cfif></cfloop>
</cfloop>
</cfoutput>