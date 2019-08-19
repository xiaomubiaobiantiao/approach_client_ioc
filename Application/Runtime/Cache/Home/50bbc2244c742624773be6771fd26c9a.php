<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>更新中...</title>

<link href="/Public/css/progress/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="/Public/css/progress/demo.css">

<script type="text/javascript" src="/Public/js/jquery.js"></script>

<style type="text/css">
	.progress-title{
		font-size: 16px;
		font-weight: 700;
		color: #333;
		margin: 0 0 20px;
	}
	.progress{
		height: 10px;
		background: #333;
		border-radius: 0;
		box-shadow: none;
		margin-bottom: 30px;
		overflow: visible;
	}
	.progress .progress-bar{
		position: relative;
		-webkit-animation: animate-positive 4s;
		animation: animate-positive 4s;
	}
	.progress .progress-bar:after{
		content: "";
		display: inline-block;
		width: 9px;
		background: #fff;
		position: absolute;
		top: -10px;
		bottom: -10px;
		right: -1px;
		z-index: 1;
		transform: rotate(35deg);
	}
	.progress .progress-value{
		display: block;
		font-size: 16px;
		font-weight: 600;
		color: #333;
		position: absolute;
		top: -30px;
		right: -25px;
	}
	@-webkit-keyframes animate-positive{
		0%{ width: 0; }
	}
	@keyframes animate-positive {
		0%{ width: 0; }
	}
	/*.progress .progress-bar {
		width:100px;
		height:100px;
		background:blue;
		transition:width linear 2s;
		-moz-transition:width linear 2s; 
		-webkit-transition:width linear 2s; 
		-o-transition:width linear 2s; 
	}
	*/
	
</style>
</head>
<!-- body><script src="/demos/googlegg.js"></script> -->

<br /><br /><br />

<div class="demo">
<div class="container">
	<div class="row">
		<div class="col-md-offset-3 col-md-6">

			<h3 class="progress-title">更新文件...<div style="float:right;" id="number"></div></h3>
			<div class="progress">
				<div class="progress-bar" style="width:100%; background:#97c513; animation-timing-function: linear;">
					<!--<div class="progress-value">100%</div>-->
				</div>

			</div>
			
			<!-- linear  transition 属性——逐渐变慢/匀速/加速/减速/加速然后减速

			<h3 class="progress-title">HTML5</h3>
			<div class="progress">
				<div class="progress-bar" style="width:70%; background:#97c513;">
					<div class="progress-value">70%</div>
				</div>
			</div>

			<h3 class="progress-title">CSS3</h3>
			<div class="progress">
				<div class="progress-bar" style="width:90%; background:#f2545b;">
					<div class="progress-value">90%</div>
				</div>
			</div>

			<h3 class="progress-title">J-Query</h3>
			<div class="progress">
				<div class="progress-bar" style="width:55%; background:#ffc304;">
					<div class="progress-value">55%</div>
				</div>
			</div>

			<h3 class="progress-title">Bootstrap</h3>
			<div class="progress">
				<div class="progress-bar" style="width:80%; background:#2e9dc2;">
					<div class="progress-value">80%</div>
				</div>
			</div>
			-->
		</div>
	</div>
</div>
</div>

<div style="text-align:center;margin:50px 0; font:normal 14px/24px 'MicroSoft YaHei';"> 
<script type="text/javascript">

/* 输入值 */
magic_number(101);

/* 向 id=number的 div 同步时间 - 多少秒内读多少数字 */
function magic_number(value) { 
    var num = $("#number"); 
    num.animate({count: value}, { 
        duration: 4100, /* 秒数 */
        step: function() { 
        	var value = String(parseInt(this.count));
            num.text( value + '%' );
            if ( value == 100 ) {
            	window.location.href = "http://localhost:81/index.php/Home/Common/message";
            }
        } 
    }); 
};


</script>
</div>
</body>
</html>