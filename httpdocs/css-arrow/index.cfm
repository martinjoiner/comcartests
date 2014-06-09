<!DOCTYPE html>
<style type="text/css">
body{ background-color: #000; }

div{
	position: absolute;
}

.square{
	width: 98px;
	height: 122px;
	border: 2px solid #AAA;
	border-right: 0;
	background-color:  #333;
	top: 10px;
	left: 10px;
}

.arrow-left {
	width: 0; 
	height: 0; 
	border-top: 60px solid transparent;
	border-bottom: 60px solid transparent;
	
	border-left: 60px solid #333;

	top: 13px;
	left: 110px;

}
.arrow-left2 {
	width: 0; 
	height: 0; 
	border-top: 63px solid transparent;
	border-bottom: 63px solid transparent;
	
	border-left: 63px solid #AAA;

	top: 10px;
	left: 110px;
}

.signtext{
	font-size: 52px;
	font-weight: bold;
	left: 30px;
	top: 38px;
	color: #00FF44;
	text-shadow: 0 0 8px #00CC44;
}
</style>

<div class="square"></div>
<div class="arrow-left2"></div>
<div class="arrow-left"></div>
<div class="signtext">Exit</div>
</html>