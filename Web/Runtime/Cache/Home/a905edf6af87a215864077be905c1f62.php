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
				<strong>外围赔率数据对阵表</strong>&nbsp;&nbsp;&nbsp;&nbsp;								
			</h4>
		</blockquote>		
	</div>
	<!--  内容  -->
	<div class="container-fluid">
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 显示比赛列表 -->
			<div class="col-xs-12 match-list">			
				<table class="table table-bordered table-hover table-condensed" id="allsptab">
				<thead>
					<tr class="danger">
						<th>编号</th>
						<th>场次ID</th>
						<th>比赛时间</th>
						<th>主队</th>
						<th>客队</th>
						<th>胜</th>
						<th>平</th>
						<th>负</th>
						<th>来源</th>
						<th>欧赔</th>
						<th>赔率更新时间</th>
					</tr>
				</thead>
				<colgroup>
					<col width="4%">
					<col width="5%">
					<col width="12%">
					<col width="10%">
					<col width="10%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="12%">
				</colgroup>
				<tbody>
					<?php if($odds && is_array($odds)){ foreach($odds as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>" ismod="0">
							<td><?php echo $k+1; ?></td>
							<td><?php echo $m['oid']; ?></td>
							<td><?php echo $m['matchtime']; ?></td>
							<td><?php echo $m['hname']; ?></td>
							<td><?php echo $m['aname']; ?></td>
							<td class="<?php echo $m['hw'] == min($m['hw'],$m['st'],$m['aw'])?'red':'' ?>"><?php echo $m['hw']; ?></td>
							<td class="<?php echo $m['st'] == min($m['hw'],$m['st'],$m['aw'])?'red':'' ?>"><?php echo $m['st']; ?></td>
							<td class="<?php echo $m['aw'] == min($m['hw'],$m['st'],$m['aw'])?'red':'' ?>"><?php echo $m['aw']; ?></td>
							<td><?php echo $m['urlty']; ?></td>
							<td><?php echo $m['oddty']; ?></td>
							<td><?php echo $m['uptime']; ?></td>
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