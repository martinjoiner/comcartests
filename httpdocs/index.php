<!DOCTYPE html>
<html>
<head>
	
	<title>Testing Server</title>

	<link rel="stylesheet" href="/css/style.css">

</head>
<body>

	<h1>Testing VHost</h1>

	<ul>
		<?php
		$arrFolders = scandir($_SERVER['DOCUMENT_ROOT']);
		$arrIgnoredFolders = array('Packages', 'node_modules', 'js', 'css', '.', '..', 'index.php' );
		foreach( $arrFolders as $thisFolder ){
			if( !in_array($thisFolder, $arrIgnoredFolders ) ){
				$spaceyName = preg_replace('/-/', ' ', $thisFolder);
				print '<li><a href="' . $thisFolder . '">' . $spaceyName . '</a></li>';
			}
		}
		?>
		
	</ul>

	<p>Martin would like a cup of tea please</p>

</body>
</html>
