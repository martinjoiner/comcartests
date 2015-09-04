<style type="text/css">

	body{
		padding: 1em 2em;
	    font-family: Arial,Verdana,Helvetica,sans-serif;
	}
	
	p{
		margin-bottom: 2em;
	}

	a{
		font-weight: inherit;
	}

	sub{
		vertical-align: baseline;
	}
	
	table {
	    border-collapse: collapse;
	}

	caption{
		font-weight: bold;
		text-align: left;
		margin-bottom: .5em;
	}

	td, 
	th{
		vertical-align: top;
		text-align: left;
	}

	table thead th{
		vertical-align: bottom;
		font-weight: normal;
	}

	table tbody tr{
		border-bottom: 2px solid #BBB;
	}

	th.currentSort,
	td.currentSort{
		font-weight: bold;
	}

	table.result th.currentSort{
		border-bottom: 4px solid #222;
	}

	td.numeric{
		text-align: right;
	}

	@media all and (min-width: 751px){
		table thead th{
			border-bottom: 2px solid #666;
		}

		td, 
		th{
			vertical-align: top;
			text-align: left;
			padding-top: 5px;
			padding-bottom: 5px;
		    padding-left: 12px;
		    padding-right: 12px;
		}

	}

	@media all and (max-width: 750px){

		table,
		caption,
		thead,
		tbody,
		tr,
		th,
		td{
			display: block;
			float: left;
		}

		thead:before{
			content: "Sort by: ";
			float: left;
			margin-top: 0.5em;
			margin-bottom: 0.5em;
			font-size: 1.1em;
			font-weight: bold;
		}
		
		thead tr,
		thead th{
			display: inline-block;
			padding: 0;
		}

		tr{
			width: 100%;
			float: left;
			margin-bottom: 1.5em;
		}
		
		a{
			float: left;
			display: block;
			padding: 0.4em 0.7em;
			border: 1px solid #333;
			width: auto;
			border-radius: 4px;
			background-color: #114A9A;
			margin: 0 0.5em 0.5em 0;
			color: white;
			text-decoration: none;
		}

		.currentSort a{
			background-color: #002354;
		}

		td.make,
		td.model{
			font-weight: bold;
			font-size: 1.3em;
			margin-bottom: 0.3em;
		}

		td.derivative{
			clear: left;
			width: 100%;
			margin-bottom: 0.6em;
		}

		td.transmission,
		td.ptratio,
		td.co2 {
			font-weight: bold;
			clear: left;
		}

		td.transmission:before,
		td.ptratio:before,
		td.co2:before{
			font-weight: normal;
			padding-left: 1em;
		}

		td.transmission:before{
			content: "Transmission: ";
		}

		td.co2:before{
			content: "CO2: ";
		}

		td.ptratio:before{
			content: "PT Ratio: ";
		}

		td.details{
			width: 100%;
			clear: left;
		}

		td.details a{
			float: right;
		}

	}

</style>
