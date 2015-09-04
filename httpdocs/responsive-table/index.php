<!DOCTYPE html>
<html>
	<head>
		<title>Responsive Table Example</title>

		<?php include "css.inc.php"; ?>

	</head>
	<body>

	<div class="bodyWrap">
	
		<h1 class="contentH1">Tax efficient cars</h1>
										
		<p>
			Cars are shown here ranked according to the "Price Tax Ratio" . This measure is simply the company car tax
			payable at the higher personal rate expressed as a percentage of the vehicle's current list price. Of course this
			is not the only way of measuring "tax efficiency", but it does act as a simple guide.
		</p>

		<?php 

		if( isset($_GET['orderby']) ){
			$GLOBALS['orderby'] = $_GET['orderby'];
		} else {
			$GLOBALS['orderby'] = 'co2';
		}
		$orderby = $GLOBALS['orderby'];

		include "data.inc.php";

		usort( $arrData, 'comp');

		function comp( $valA, $valB ){
			$orderby = $GLOBALS['orderby'];
			if( strcasecmp($valA[$orderby], $valB[$orderby]) > 0 ){
				return true;
			} else {
				return false;
			}
		}

		?>

		<table>
			<caption>Top 30 tax efficient cars</caption>
			<thead>
				<tr>
					<th scope="col" <?php if( $orderby == 'make' ){ print 'class="currentSort"'; }?>>
						<a href="?orderby=make">Make</a>
					</th>
					<th scope="col" <?php if( $orderby == 'model' ){ print 'class="currentSort"'; }?>>
						<a href="?orderby=model">Model</a>
					</th>
					<th scope="col" <?php if( $orderby == 'derivative' ){ print 'class="currentSort"'; }?>>
						<a href="?orderby=derivative">Derivative</a>
					</th>
					<th scope="col" <?php if( $orderby == 'transmission' ){ print 'class="currentSort"'; }?>>
						<a href="?orderby=transmission">Transmission</a>
					</th>
					<th scope="col" <?php if( $orderby == 'ptratio' ){ print 'class="currentSort"'; }?>>
						<a href="?orderby=ptratio">PT Ratio</a>
					</th>
					<th scope="col" <?php if( $orderby == 'co2' ){ print 'class="currentSort"'; }?>>
						<a href="?orderby=co2">CO<sub>2</sub></a>
					</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>

			 	<?php
				foreach( $arrData as $i=>$vehicle ){
					?>

				<tr> 
					
					<td class="make<?php if( $orderby == 'make' ){ print ' currentSort'; }?>"><?=$vehicle['make']?></td>
					<td class="model<?php if( $orderby == 'model' ){ print ' currentSort'; }?>"><?=$vehicle['model']?></td>
					<td class="derivative<?php if( $orderby == 'derivative' ){ print ' currentSort'; }?>"><?=$vehicle['derivative']?></td>
					<td class="transmission<?php if( $orderby == 'transmission' ){ print ' currentSort'; }?>"><?=$vehicle['transmission']?></td>
					<td class="ptratio<?php if( $orderby == 'ptratio' ){ print ' currentSort'; }?>"><?=$vehicle['ptratio']?></td>
					<td class="co2<?php if( $orderby == 'co2' ){ print ' currentSort'; }?>"><?=$vehicle['co2']?></td>
					<td class="details">
	                	<a href="details<?=$i?>">Details</a>
	            	</td>
				</tr>

					<?php
				}

				?>
				
			</tbody>
		</table>
		
	</div>

	</body>
</html>
