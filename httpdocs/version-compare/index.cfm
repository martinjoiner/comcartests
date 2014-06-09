<html>
<head>
	<title>Version Compare</title>

	<style type="text/css">
	table{
		border-collapse: collapse;
	}

	th, td{
		border: 1px solid #888;
		padding: .5em;
	}

	th{
		background-color: #888;
	}

	</style>
</head>
<body>

<cfset objVersionComparison = new core.utility.versionComparison()>

<cfoutput>

<table>
	<caption>isVersionGTE()</caption>
	<thead>
		<tr>
			<th>First Version</th>
			<th>Second Version</th>
			<th>Result of Comparison</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>1</td>
			<td>2</td>
			<td>#objVersionComparison.isVersionGTE('1','2')#</td>
		</tr>
		<tr>
			<td>6</td>
			<td>1</td>
			<td>#objVersionComparison.isVersionGTE('6','1')#</td>
		</tr>
		<tr>
			<td>4.2</td>
			<td>2.8.1</td>
			<td>#objVersionComparison.isVersionGTE('4.2','2.8.1')#</td>
		</tr>
		<tr>
			<td>1.43.23.12.6</td>
			<td>12.8.821</td>
			<td>#objVersionComparison.isVersionGTE('1.43.23.12.6','12.8.821')#</td>
		</tr>
		<tr>
			<td>0.0.0.1</td>
			<td>0</td>
			<td>#objVersionComparison.isVersionGTE('0.0.0.1','0')#</td>
		</tr>
		<tr>
			<td>8</td>
			<td>8</td>
			<td>#objVersionComparison.isVersionGTE('8','8')#</td>
		</tr>
		<tr>
			<td>8.11.3.1</td>
			<td>8.11.3.0</td>
			<td>#objVersionComparison.isVersionGTE('8.11.3.1','8.11.3.0')#</td>
		</tr>
		<tr>
			<td>1.65.1698.195.78</td>
			<td>7</td>
			<td>#objVersionComparison.isVersionGTE('1.65.1698.195.78','7')#</td>
		</tr>
	</tbody>
</table>

</cfoutput>

</body>
</html>