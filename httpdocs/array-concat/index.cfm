<cfset objArray = new core.utility.array()>

<cfset arrXevi = [ "nachos", "sombraros", "enchiladas" ]>

<cfdump var="#arrXevi#">

<cfset arrPete = [ "kicking", "punching", "korean" ]>

<cfdump var="#arrPete#">

<cfset arrPevi = objArray.concat( arrXevi, arrPete )>

<cfdump var="#arrPevi#">