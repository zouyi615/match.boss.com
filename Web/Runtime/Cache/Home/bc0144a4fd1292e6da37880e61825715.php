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
			$.index.ui.box.index();
		});
		</script>
	</head>
	<body>	
	<!-- 头部 -->
	<div class="header">
		<blockquote>			
			<h4>
				<strong>抓取竞彩和欧赔数据，获取已匹配的场次信息</strong>&nbsp;&nbsp;&nbsp;&nbsp;	
			</h4>
			<p class="fontkt"><small>按返还率从高到低排序</small></p>
		</blockquote>
	</div>
	<!--  内容  -->
	<div class="container-fluid">
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 显示比赛列表 -->
			<div class="col-xs-9 match-list">
				<!--<p><button type="button" class="btn btn-danger">已关注球队</button></p>-->				
				<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr class="danger">
						<th>序号</th>
						<th>场次</th>
						<th>开赛时间</th>
						<th>联赛</th>
						<th>主队</th>
						<th>客队</th>
						<th class="red">赔率</th>
						<th class="red">水位</th>
						<th class="red">返还率&nbsp;<span class="label label-default"><span class="glyphicon glyphicon-refresh"></span></span></th>
					</tr>
					<tr>
						<td colspan="9">
						<div class="progress">
							<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
						</div>
						</td>
					</tr>
				</thead>
				<colgroup>
					<col width="6%">
					<col width="8%">
					<col width="14%">
					<col width="10%">
					<col width="14%">
					<col width="14%">
					<col width="10%">
					<col width="12%">
					<col width="12%">
				</colgroup>
				<tbody>
					<?php if(isset($match) && is_array($match)){ foreach($match as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>" mid="" pname="" pdate="" lg="" rq="" pendtime="" win="" draw="" lost="" gdate="">
							<td><?php echo $k+1; ?></td>
							<td><?php echo $m['id']; ?></td>
							<td><?php echo $m['matchtime']; ?></td>
							<td><?php echo $m['simpleleague']; ?></td>
							<td><?php echo $m['homename']; ?></td>
							<td><?php echo $m['awayname']; ?></td>
							<td><?php echo $m['w']; ?></td>
							<td><?php echo $m['lj'].'(利记)'; ?></td>
							<td><?php echo $m['rate']; ?></td>
						</tr>						
					<?php } } ?>												
				</tbody>
				</table>	
			</div>
			<!-- 操作区域/修改匹配值 -->
			<div class="setbox col-xs-3">
				<form action="<?php echo U('Index/matching');?>" method="POST" target="_blank" id="dosubform">
				<table class="table table-bordered table-hover table-condensed">
					<tr class="danger">
						<th colspan="2">返还率修改</th>
						<th colspan="2"></th>
					</tr>
					<tr>
						<td colspan="2"><input type="text" name="rnrate" id="rnrate" class="form-control"></td>
						<td colspan="2"></td>
					</tr>
					<tr class="danger">
						<th colspan="4">计算值修改</th>
					</tr>
					<tr>
						<td>下注</td>
						<td><input type="text" name="betmoney" id="betmoney" class="form-control"></td>
						<td>返利</td>
						<td><input type="text" name="rebate" id="rebate" class="form-control"></td>
					</tr>
					<tr>
						<td colspan="4" align="right"><button type="button" class="btn btn-default" id="dosub">提交</button></td>
					</tr>
				</table>
				</form>
			</div>		
		</div>
	</div>
	<!-- 底部 -->
</body>
</html>