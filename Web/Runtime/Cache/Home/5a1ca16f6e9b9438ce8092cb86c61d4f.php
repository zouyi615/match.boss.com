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
			$.matadmin.box.index();
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
				<strong>外围场次主客队匹配管理</strong>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:;" id="upallsp" data-url="<?php echo U('Match/getPl');?>"><span class="label label-success">更新匹配场次&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>						
			</h4>
			<p>
				<a href="javascript:;" id="getallxml" data-url="<?php echo U('Match/getXml');?>"><span class="label label-danger">重新载入竞彩xml&nbsp;<span class="glyphicon glyphicon-download"></span></span></a>
				<a href="javascript:;" id="getallsp1" data-url="<?php echo U('Match/getSp1');?>"><span class="label label-danger">更新外围数据1&nbsp;</span></a>
				<a href="<?php echo U('MatAdmin/showSpLs');?>" target="_blank"><span class="label label-info">查看外围数据1<span class="glyphicon glyphicon-tag"></span></span></a>
			</p>
			<p class="fontkt"><small>双击行可以修改主客队匹配值</small></p>
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
						<th>主队/客队</th>
						<th>让球数</th>
						<th>赔率</th>
						<th>联赛sp</th>
						<th>主队sp/客队sp</th>
						<th>赔率sp</th>
						<th>主队匹配</th>
						<th>客队匹配</th>
						<th>是否匹配</th>
					</tr>
				</thead>
				<colgroup>
					<col width="4%">
					<col width="12%">
					<col width="10%">
					<col width="10%">
					<col width="4%">
					<col width="4%">
					<col width="12%">
					<col width="12%">
					<col width="6%">
					<col width="10%">
					<col width="10%">
					<col width="6%">
				</colgroup>
				<tbody>
					<?php if($rsMat && is_array($rsMat)){ foreach($rsMat as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>" ismod="0">
							<td><?php echo $m['id']; ?></td>
							<td><?php echo $m['matchnum'].'<br>'.date('Y/m/d H:i:s',$m['matchtime']); ?></td>
							<td><?php echo $m['league']; ?></td>
							<td><?php echo $m['homename'].'<br>（'.$m['awayname'].'）'; ?></td>
							<td><?php echo $m['rangqiu']; ?></td>
							<td><?php echo $m['win']; ?></td>
							<td><?php echo $m['leagueCh']; ?></td>
							<td><?php echo $m['homenameCh']; ?><br><?php echo $m['awaynameCh']?'（'.$m['awaynameCh'].'）':''; ?></td>
							<td><?php echo $m['sp']; ?></td>
							<td class="homesp" data-homesp="<?php echo $m['homenamesp']; ?>"><?php echo $m['homenamesp']; ?></td>
							<td class="awaysp" data-awaysp="<?php echo $m['awaynamesp']; ?>"><?php echo $m['awaynamesp']; ?></td>
							<td class="offset" data-offset="<?php echo $m['isoffset']; ?>" title="先填写主客队再开启匹配"><?php echo $m['isoffset']==1?'<span class="label label-success">匹配</span>':'<span class="label label-warning">不匹配</span>'; ?></td>
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