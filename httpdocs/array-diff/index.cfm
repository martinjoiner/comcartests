<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
	td{
		vertical-align: top;
	}
	</style>
</head>
<body>

	<cfset objArray = new core.utility.array()>



	<table>
		<tr>
			<th>Party1</th>
			<th>Party2</th>
			<th>Diff</th>
		</tr>

		<cfset arrParty1 = [ "nachos", "sombraros", "enchiladas", "dancing" ]>
		<!---
		<cfset arrParty2 = [ "nachos", "sombraros", "enchiladas", "flamenco" ]>
		<cfset arrParty1USPs = objArray.diff( arrParty1, arrParty2 )>
		--->

		<tr>
			<td><cfdump var="#arrParty1#"></td>
			
			<cfscript>
				ArrayDeleteAt(arrParty1,3);
			</cfscript>
			<td><cfdump var="#arrParty1#"></td>
		</tr>

		<!---

		<cfset arrParty2USPs = objArray.diff( arrParty2, arrParty1 )>

		<tr>
			<td><cfdump var="#arrParty1#"></td>
			<td><cfdump var="#arrParty2#"></td>
			<td><cfdump var="#arrParty2USPs#"></td>
		</tr>


		<cfset arrXeviNum = [ 1,2,5,6,7,200,300,400,423 ]>
		<cfset arrMartinNum = [ 2,3,5,6,7,200,203,300 ]>

		<cfset arrXeviNumUSPs = objArray.OrderedNumericArrayDiff( arrXeviNum, arrMartinNum )>

		<tr>
			<td><cfdump var="#arrXeviNum#"></td>
			<td><cfdump var="#arrMartinNum#"></td>
			<td><cfdump var="#arrXeviNumUSPs#"></td>
		</tr>
		--->

		<cfset arrXeviNum = [ 102,103,104,120,200,216,320,378,399 ]>
		<cfset arrMartinNum = [ 103,104,213,216,325,378,400 ]>

		<cfset arrXeviNumUSPs = objArray.OrderedNumericArrayDiff( arrXeviNum, arrMartinNum )>
		
		<tr>
			<td><cfdump var="#arrXeviNum#"></td>
			<td><cfdump var="#arrMartinNum#"></td>
			<td><cfdump var="#arrXeviNumUSPs#"></td>
		</tr>


		<cfset arrNumList1 = [ 1029561,1029850,1030728,1032076,1033817,1035082,1035083,1035632,1035633 ]>
		<cfset arrNumList2 = [ 1032076,1038423,1038747,1039044,1039146,1039486,1039488 ]>

		<cfset arrNumList1USPs = objArray.OrderedNumericArrayDiff( arrNumList1, arrNumList2 )>

		<tr>
			<td><cfdump var="#arrNumList1#"></td>
			<td><cfdump var="#arrNumList2#"></td>
			<td><cfdump var="#arrNumList1USPs#"></td>
		</tr>
		
	</table>


<body>
</html>