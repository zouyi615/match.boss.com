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
		<script type="text/javascript">
		$(document).ready(function(){
			$.showspls.box.index();
		});
		</script>
	</head>
	<body>	
	<!-- 头部 -->
	<div class="header">
		<div class="alert alert-warning alert-dismissible fade in" role="alert" id="alert-warning" style="display:none;">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<div class="content">&nbsp;</div>
		</div>
		<blockquote>			
			<h4>
				<strong>外围数据列表</strong>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:;" id="clearsp" data-url="<?php echo U('Match/clearSp1');?>"><span class="label label-danger">清空外围数据&nbsp;<span class="glyphicon glyphicon-trash"></span></span></a>
				<a href="javascript:;" id="getsp" data-url="<?php echo U('Match/getSp1');?>"><span class="label label-success">更新外围数据&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>
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
				<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr class="danger">
						<th>编号sp</th>
						<th>比赛时间sp</th>
						<th>让球sp</th>
						<th>联赛Ensp</th>
						<th>联赛Chsp</th>
						<th>主队Ensp</th>
						<th>主队Chsp</th>
						<th>客队Ensp</th>
						<th>客队Chsp</th>
						<th>赔率sp</th>
					</tr>
				</thead>
				<colgroup>
					<col width="6%">
					<col width="12%">
					<col width="5%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="5%">
				</colgroup>
				<tbody>
					<?php if($spLs && is_array($spLs)){ foreach($spLs as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>" ismod="0">
							<td><?php echo $m['sid']; ?></td>
							<td><?php echo date('Y/m/d H:i:s',$m['matchtimesp']); ?></td>
							<td><?php echo $m['rangqiusp']; ?></td>
							<td><?php echo $m['leagueEn']; ?></td>
							<td><?php echo $m['leagueCh']; ?></td>
							<td><?php echo $m['homenameEn']; ?></td>
							<td><?php echo $m['homenameCh']; ?></td>
							<td><?php echo $m['awaynameEn']; ?></td>
							<td><?php echo $m['awaynameCh']; ?></td>
							<td><?php echo $m['sp']; ?></td>
						</tr>		
					<?php } } ?>												
				</tbody>
				</table>
			</div>		
		</div>
	</div>
	<!-- 底部 -->
</body>
</html>