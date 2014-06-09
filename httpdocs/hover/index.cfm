<!DOCTYPE html>
	<head>
		<style type="text/css">
			
			body{ 
				font-family: arial;
			}
			
			.wrap{
				border: 1px solid #888;
				border-radius: 2px;
				position: absolute;
				width: 90px;
				height: 20px;
				padding-top: 1px;
				overflow: hidden;
				box-shadow:inset 1px 1px 1px rgba(0,0,0,0.4);
			}
			.wrap div{ 
				width: 90px;
				position: absolute;
				padding: 2px 5px;
				cursor: pointer;
				box-shadow: inset 1px 1px 1px rgba(255,255,255,0.2), inset -1px -1px 1px rgba(0,0,0,0.2),  1px 1px 1px rgba(0,0,0,0.2);
				border-radius: 5px;
				color: #EEE;
				text-shadow: -1px -1px 0 rgba(0,0,0,0.2);
				font-size: 12px;
			}
			.wrap div:hover{
				text-decoration: underline;
			}
			.complink{ 
				background-color: #722;
				right: -55px; 
				-webkit-transition: right 0.5s;
			}
			.complink:hover{ 
				right: -25px;
			} 
			.complink:hover + div.selectlink{ 
				left: -85px;
			}
			.selectlink{
				background-color: #B22;
				text-align: right;
				left: -55px;
				-webkit-transition: left 0.5s;
			}
			.selectlink:hover{ 
				left: -25px;
			} 
		</style>
		
	</head>
	<body>
		<h1>Hover slide left right</h1>

			<div class="wrap">
				<div class="complink">Compare</div>
				<div class="selectlink">Select</div>
			</div>

	</body>