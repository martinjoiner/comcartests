<!DOCTYPE html>
<html>

	<head>
		<meta name="viewport" content="initial-scale=1">

	</head>
	<body>
		<div id="result" style="font-size: 2em;"></div>
	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script>

		var analyseEyesSize = function (){
			var viewportWidth = $(window).width();
			var html = 'window.width() = ' + viewportWidth + '<br>';

			html += 'window.height() = ' + $(window).height() + '<br>';

			if( viewportWidth > 1 && viewportWidth < 700 ){
				html += 'Mobile?';
			}

			$('#result').html( html );

		}();

	</script>
</html>