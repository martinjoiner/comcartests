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
		font-size: 1.5em;
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
		border-bottom: 1px solid #BBB;
	}

	th.currentSort,
	td.currentSort{
		font-weight: bold;
	}

	th.numeric,
	td.numeric{
		text-align: right;
	}

	@media all and (min-width: 751px){
		table thead th{
			border-bottom: 2px solid #666;
		}

		table th.currentSort{
			border-bottom: 4px solid #222;
		}

		tbody tr:hover{
			background-color: #DDD;
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

		thead{
			background-color: #DDD;
			padding: 0.5em 0 0.5em 1em;
			margin-bottom: 1em;
		}

		thead:before{
			content: "Sort results by...";
			float: left;
			margin-bottom: 0.5em;
			font-size: 1.1em;
			font-weight: bold;
			color: #333;
		}
		
		thead tr,
		thead th{
			display: inline-block;
			padding: 0;
		}

		tr{
			width: 100%;
			float: left;
		}

		tbody tr{
			margin-bottom: 1.3em;
			padding-bottom: 1em;
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
			font-size: 1.2em;
			margin-bottom: 0.3em;
		}

		td.model{
			padding-left: 0.2em;
		}

		td.derivative{
			font-size: 1.2em;
			clear: left;
			width: 100%;
			margin-bottom: 0.3em;
		}

		td.transmission,
		td.ptratio,
		td.co2 {
			font-weight: bold;
			clear: left;
			margin-bottom: 0.4em;
		}

		td.transmission:before,
		td.ptratio:before,
		td.co2:before{
			font-weight: normal;
			padding-left: 1.5em;
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
			float: right;
		}

		td.details a{
			float: right;
			margin-top: -1em;
		}

	}

</style>
