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
		<script type="text/javascript" src="/Public/js/match/index.js"></script>
		<!--<script type="text/javascript" src="/Public/js/index.js"></script>-->
	</head>
	<script>
	$(document).ready(function(){
		$('#flush').click(function(){
			var url = 'http://match.boss.com/index.php/Home/Index/getAjaxMatch.html', para = {rnrate:'3.65'};
			$.post(url, para, function(data){
				var list = $.parseJSON(data);
				$.match.box.list = list;
				$.match.box.createList();
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
				<a href="javascript:;" id="flush">flush</a>
			</div>			
		</div>
	</div>
	<!-- 底部 -->
</body>
</html>