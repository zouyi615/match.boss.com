<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>外围场次主客队匹配管理</title>
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
			<p id="getdata">
				<a href="javascript:;" id="getxml" class="updataC" data-url="<?php echo U('Match/getXml');?>"><span class="label label-danger"><font>重新载入竞彩xml</font>&nbsp;<span class="glyphicon glyphicon-download"></span></span></a>
				<a href="javascript:;" id="getOdds" class="updataC" data-url="<?php echo U('Match/getOdds');?>"><span class="label label-danger"><font>重新载入欧赔odds</font>&nbsp;<span class="glyphicon glyphicon-download"></span></span></a>
				<a href="javascript:;" id="getsp" class="updataD" data-url="<?php echo U('Match/getPl');?>"><span class="label label-success"><font>更新赔率</font>&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>
			</p>
			<p>
				<a href="<?php echo U('Match/odds');?>" target="_blank"><span class="label label-info"><font>查看欧赔数据</font>&nbsp;<span class="glyphicon glyphicon-list"></span></span></a>
				<a href="<?php echo U('Match/team');?>" target="_blank"><span class="label label-info"><font>查看主客队匹配数据</font>&nbsp;<span class="glyphicon glyphicon-list"></span></span></a>
				<a href="<?php echo U('Match/showblist');?>" target="_blank"><span class="label label-info"><font>查看禁止匹配列表</font>&nbsp;<span class="glyphicon glyphicon-list"></span></span></a>
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
				<table class="table table-bordered table-hover table-condensed allsptab" id="allsptab">
				<thead>
					<tr class="danger">
						<th>编号</th>
						<th>场次ID</th>
						<th>比赛时间</th>
						<th>联赛</th>
						<th>让球</th>
						<th>主队/客队</th>
						<th>球探网主客队</th>
						<th>赔率</th>
						<th class="red">欧赔（乐天堂）</th>					
						<th>匹配状态</th>
						<th>更新时间</th>
					</tr>
				</thead>
				<colgroup>
					<col width="3%">
					<col width="5%">
					<col width="11%">
					<col width="8%">
					<col width="4%">
					<col width="19%">
					<col width="19%">
					<col width="9%">
					<col width="9%">				
					<col width="7%">
					<col width="6%">
				</colgroup>
				<tbody>
					<?php if($rsMat && is_array($rsMat)){ foreach($rsMat as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>" matchtime="<?php echo $m['matchtime']; ?>" ismod="0">
							<td><?php echo $k+1; ?></td>
							<td><?php echo $m['id']; ?></td>
							<td class="matchtime"><?php echo $m['matchnum'];echo $m['isend']==0?'<span class="label label-success">开售</span>':'<span class="label label-warning">已截止</span>';echo '<br><a href="javascript:;" title="截止时间'.$m['endtime'].'">'.$m['matchtime'].'</a>'; ?></td>
							<td class="league"><?php echo $m['simpleleague']; ?></td>
							<td class="rq"><?php echo $m['rq']; ?></td>
							<td data-hid="<?php echo $m['homeid']; ?>" data-homename="<?php echo $m['homename']; ?>" data-aid="<?php echo $m['awayid']; ?>" data-awayname="<?php echo $m['awayname']; ?>" class="team"><?php echo $m['homename'].'&nbsp;VS&nbsp;'.$m['awayname']; ?></td>							
							<td class="team_op row"><?php echo $rsTeam[$m['homeid']].'VS'.$rsTeam[$m['awayid']]; ?></td>
							<td><?php echo $m['sp']; ?></td>
							<td class="red"><?php echo $m['fun88']; ?></td>						
							<td class="isban" data-isban="<?php echo $m['isban']; ?>"><a href="javascript:;"><?php echo $m['isban']==1?'<span class="label label-warning">禁止匹配</span>':'<span class="label label-success">允许匹配</span>'; ?></a></td>
							<td><?php echo date('H:i:s',strtotime($m['uptime'])); ?></td>
						</tr>		
					<?php } } ?>												
				</tbody>
				</table>
				<input type="hidden" id="modupurl" value="<?php echo U('Match/teamUp');?>">
				<input type="hidden" id="modbanurl" value="<?php echo U('Match/teamBan');?>">				
			</div>		
		</div>
	</div>
	<!-- 底部 -->
</body>
</html>