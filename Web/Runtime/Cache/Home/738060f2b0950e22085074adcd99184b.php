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
		<link rel="shortcut icon" href="/Public/img/favicon.png">
		<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
		<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/Public/js/jquery.cookie.js"></script>		
		<script type="text/javascript" src="/Public/js/match/index.js"></script>
		<script type="text/javascript" src="/Public/js/match/common.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$.admin.box.index();
		});
		</script>
	</head>
	<body>	
	<!-- 头部 -->
	<div class="header">
		<div class="alert alert-warning alert-dismissible fade in" role="alert" id="alert-warning">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<div class="content">&nbsp;</div>
		</div>
		<blockquote>			
			<h4>
				<strong>外围网站主客队名匹配</strong>&nbsp;&nbsp;&nbsp;&nbsp;								
			</h4>
			<p id="getdata">
				<a href="javascript:;" id="teamUpAll" class="updataD" data-url="<?php echo U('Match/teamUpAll');?>"><span class="label label-success"><font>匹配主客队名</font>&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>
				<a href="javascript:;" id="getsp" class="updataD" data-url="<?php echo U('Match/getPl');?>"><span class="label label-success"><font>更新赔率</font>&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>
			</p>
		</blockquote>	
	</div>
	<!--  内容  -->
	<div class="container-fluid">
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 显示比赛列表 -->
			<div class="col-xs-8 match-list">
				<table class="table table-bordered table-hover table-condensed" id="oddsteam">
				<thead>
					<tr class="danger">
						<th>编号</th>
						<th>队名ID</th>
						<th>500队名</th>
						<th>外围队名</th>	
						<th>操作</th>
						<th></th>
					</tr>
				</thead>
				<colgroup>
					<col width="6%">
					<col width="10%">
					<col width="16%">
					<col width="16%">
					<col width="8%">
					<col width="">
				</colgroup>
				<tbody>
					<?php if($team && is_array($team)){ foreach($team as $k=>$m){ ?>
						<tr class="data" data-id="<?php echo $m['tid']; ?>" ismod="0">
							<td><?php echo $k+1; ?></td>
							<td><?php echo $m['tid']; ?></td>
							<td><?php echo $m['tname']; ?></td>
							<td class="oddsname <?php echo $m['tname'] != $m['oname']?'red':'' ?>"><?php echo $m['oname']; ?></td>
							<td class=""><button type="button" class="btn btn-danger btn-xs delteam">删除<i class="glyphicon glyphicon-remove"></i></button></td>
							<td></td>
						</tr>		
					<?php } } ?>												
				</tbody>
				</table>				
			</div>
			<div class="col-xs-4">
				<form action="<?php echo U('Match/addteamUp');?>" method="POST" target="_blank" id="addteamform">
				<table class="table table-bordered table-hover table-condensed">
					<thead>
						<tr class="danger">
							<th colspan="2">添加球队匹配名称</th>
							<td align="right"><a href="javascript:;" id="addOneTd"><span class="label label-default">添加一行&nbsp;<span class="glyphicon glyphicon-plus"></span></span></a></td>
						</tr>
						<tr><th>队名ID</th><th>500队名</th><th>外围队名</th></tr>
					</thead>
					<colgroup><col width="20%"><col width="40%"><col width="40%"></colgroup>
					<tbody class="tbody">
						<tr>
							<td><input type="text" class="form-control input-sm" name="tid[]" value=""></td>
							<td><input type="text" class="form-control input-sm" name="tname[]" value=""></td>
							<td><input type="text" class="form-control input-sm" name="oname[]" value=""></td>
						</tr>
					</tbody>
					<tr>
						<td colspan="3" align="right"><button type="button" class="btn btn-default" id="addteamup">提交</button></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
	<input type="hidden" id="modteamurl" value="<?php echo U('Match/modteamUp');?>">
	<input type="hidden" id="addteamurl" value="<?php echo U('Match/addteamUp');?>">
	<input type="hidden" id="delteamurl" value="<?php echo U('Match/delteamUp');?>">
	<!-- 底部 -->
</body>
</html>