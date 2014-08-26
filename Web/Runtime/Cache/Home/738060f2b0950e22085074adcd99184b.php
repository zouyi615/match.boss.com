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

		});
		</script>
	</head>
	<body>	
	<!-- 头部 -->
	<div class="header">
		<blockquote>			
			<h4>
				<strong>外围网站主客队名匹配</strong>&nbsp;&nbsp;&nbsp;&nbsp;								
			</h4>
		</blockquote>		
	</div>
	<!--  内容  -->
	<div class="container-fluid">
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 显示比赛列表 -->
			<div class="col-xs-12 match-list">
				<!--<p><button type="button" class="btn btn-danger">已关注球队</button></p>-->				
				<table class="table table-bordered table-hover table-condensed" id="allsptab">
				<thead>
					<tr class="danger">
						<th>编号</th>
						<th>队名ID</th>
						<th>500队名</th>
						<th>球探网队名</th>	
						<th></th>							
					</tr>
				</thead>
				<colgroup>
					<col width="6%">
					<col width="6%">
					<col width="12%">
					<col width="12%">
					<col width="">
				</colgroup>
				<tbody>
					<?php if($team && is_array($team)){ foreach($team as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>" ismod="0">
							<td><?php echo $k+1; ?></td>
							<td><?php echo $m['tid']; ?></td>
							<td><?php echo $m['tname']; ?></td>
							<td class="<?php echo $m['tname'] != $m['qtname']?'red':'' ?>"><?php echo $m['qtname']; ?></td>
							<td></td>	
						</tr>		
					<?php } } ?>												
				</tbody>
				</table>
				<input type="hidden" id="modupurl" value="<?php echo U('MatAdmin/modUp');?>">
			</div>		
		</div>
	</div>
	<!-- 底部 -->
</body>
</html>