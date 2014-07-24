<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Bootstrap, from LayoutIt!</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="/Public/css/bootstrap.css" rel="stylesheet">
		<link href="/Public/css/public.css" rel="stylesheet">
		<link href="/Public/css/adipoli.css" rel="stylesheet">
		<!-- <link href="css/bootstrap-responsive.min.css" rel="stylesheet"> -->
		<link rel="shortcut icon" href="/Public/img/favicon.png">
		<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
		<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
		<!--<script type="text/javascript" src="/Public/js/index.js"></script>-->
	</head>
	<style type="text/css">
	body{position: relative;}
	.main{position: relative;}
	.operate{position: absolute; bottom: 50px;}
	.mod-inmoney,.mod-rate{background: #fff;  padding: 20px; }
	.operate th,.operate td{text-align: center;}
	.tips{width:0;height:0;border-width:100px 0px 0px 100px;border-style:solid;border-color:transparent transparent transparent #563d7c;margin:0px auto;position:fixed; bottom: 0px;left:0px; cursor: pointer;}	
	.tips a{font-size: 40px; color: #fff; position: absolute; bottom: -4px; left: -94px;}
	.tips_con{background: #ccc; opacity:0.7; border:1px solid #333; width:500px; height: 200px; display: none; position:fixed; left: 0px; bottom:0px;}
	</style>
	<script>
	$(document).ready(function(){
	    //$(".inline").colorbox({inline:true, width:"510", height:"230", scrolling:false});
	    //$(".well").fixme({scroll_top_threshold : 110});  //<==here 把class=well的页面元素当屏幕垂直滚动条的位置>110时，该元素固定
	    $(window).bind('scroll',function() {
	    	var xytips = $('#tips').offset(), curtop = $(window).scrollTop();
		    		    
		    console.log(xytips,curtop)
		});
		$('#tips').live('click',function(){
			var s = $(this).find('span');
			$('#tips_con').toggle('slow',function(){
				if(s.hasClass('glyphicon-resize-full')){
					s.removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
				}else{
					s.removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
				}
			});		
		});
	});	
	</script>
	<body>	
	<!-- 头部 -->
	<div class="header">

	</div>
	<!--  内容  -->
	<div class="container">
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 显示比赛列表 -->
			<div class="col-xs-12 match-list" style="width:100%; height:1200px; border:1px solid #ccc;">
				
			</div>			
		</div>
	</div>
	<div class="tips_con" id="tips_con">
		ssssssssss
	</div>
	<div class="tips" id="tips">		
		<a href="javascript:;"><span class="glyphicon glyphicon-resize-full"></span></a>
	</div>
	<!-- 底部 -->
</body>
</html>