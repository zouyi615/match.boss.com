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
				<strong>外围场次主客队匹配管理</strong>&nbsp;&nbsp;&nbsp;&nbsp;								
			</h4>
			<p>
				<a href="javascript:;" id="getxml" data-url="<?php echo U('Match/getXml');?>"><span class="label label-danger">重新载入竞彩xml&nbsp;<span class="glyphicon glyphicon-download"></span></span></a>
				<a href="javascript:;" id="getsp" data-url="<?php echo U('Match/getPl');?>"><span class="label label-success">更新赔率&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>				
			</p>
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
						<th>比赛时间</th>						
						<th>联赛</th>
						<th>让球</th>
						<th>主队</th>
						<th>客队</th>
						<th>赔率</th>
						<th class="red">欧赔（bet365）</th>
						<th class="red">欧赔（皇冠）</th>
						<th>开售状态</th>
					</tr>
				</thead>
				<colgroup>
					<col width="6%">
					<col width="12%">
					<col width="12%">
					<col width="6%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="10%">
					<col width="10%">
					<col width="8%">
				</colgroup>
				<tbody>
					<?php if($rsMat && is_array($rsMat)){ foreach($rsMat as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>" ismod="0">
							<td><?php echo $m['id']; ?></td>
							<td><?php echo $m['matchnum'].'<br>'.$m['matchtime']; ?></td>
							<td><?php echo $m['league']; ?></td>
							<td><?php echo $m['rangqiu']; ?></td>
							<td><?php echo $m['homename']; ?></td>
							<td><?php echo $m['awayname']; ?></td>
							<td>
								<?php echo '<span class="label label-default">'.$m['s'].'</span>&nbsp;<span class="label label-default">'.$m['p'].'</span>&nbsp;<span class="label label-default">'.$m['f'].'</span>'; ?></td>
							<td class="red"><?php echo $m['bet365']; ?></td>
							<td class="red"><?php echo $m['hg']; ?></td>
							<td class="offset" data-end="<?php echo $m['end']; ?>"><?php echo $m['isend']==0?'<span class="label label-success">开售</span>':'<span class="label label-warning">已截止</span>'; ?></td>
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