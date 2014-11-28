<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>禁止匹配场次列表管理</title>
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
	</div>
	<!--  内容  -->
	<div class="container-fluid">
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 禁止匹配场次（该场所有匹配禁止） -->
			<div class="col-xs-6 match-list">
				<blockquote>			
					<h4>
						<strong>禁止匹配场次（该场所有匹配禁止）</strong>&nbsp;&nbsp;<a href="javascript:void(location.reload());" class="" data-url=""><span class="label label-success"><font>更新赔率</font>&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>		
					</h4>			
				</blockquote>
				<!--<p><button type="button" class="btn btn-danger">已关注球队</button></p>-->				
				<table class="table table-bordered table-hover table-condensed allsptab">
				<thead>
					<tr class="danger">
						<th class="dellist"><i class="glyphicon glyphicon-remove"></i></th><th>场次</th><th>联赛</th><th>竞彩主客队</th><th>外围主客队</th><th>更新时间</th><th class="red">操作</th>
					</tr>
				</thead>
				<colgroup>
					<col width="2%"><col width="7%"><col width="14%"><col width="26%"><col width="26%"><col width="14%"><col width="11%">
				</colgroup>
				<tbody>
					<?php if($banmatch && is_array($banmatch)){ foreach($banmatch as $k=>$m){ ?>
						<tr class="banmatch" data-id="<?php echo $m['mid']; ?>">
							<td class="delbtn"><?php echo $k+1; ?></td>
							<td><?php echo $m['mid']; ?></td>
							<td><?php echo $m['simpleleague'].'<br>'.date('m/d H:i',strtotime($m['matchtime'])); ?></td>
							<td><?php echo $m['team'].'<br>'.$m['sp']; ?></td>
							<td><?php echo $m['oteam'].'<br>'.$m['fun88']; ?></td>							
							<td class="matchtime"><?php echo $m['isban']==1?'<span class="label label-warning">禁止匹配</span>':'<span class="label label-success">允许匹配</span>'; ?><br><?php echo date('m/d H:i',strtotime($m['uptime'])); ?></td>
							<td class="isban del"><a href="javascript:;"><span class="label label-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;删除</span></a></td>
						</tr>		
					<?php } } ?>												
				</tbody>
				</table>			
			</div>
			<!-- 禁止匹配，配对场次（该匹配场次禁止） -->
			<div class="col-xs-6 match-list">
				<blockquote>			
					<h4>
						<strong>禁止配对场次（该匹配场次禁止）</strong>&nbsp;&nbsp;<a href="javascript:void(location.reload());" class="" data-url=""><span class="label label-success"><font>更新赔率</font>&nbsp;<span class="glyphicon glyphicon-refresh"></span></span></a>		
					</h4>			
				</blockquote>
				<!--<p><button type="button" class="btn btn-danger">已关注球队</button></p>-->				
				<table class="table table-bordered table-hover table-condensed allsptab">
				<thead>
					<tr class="danger">
						<th class="dellist"><i class="glyphicon glyphicon-remove"></i></th><th>场次1</th><th>主客队1</th><th>场次2</th><th>主客队2</th><th class="red">操作</th>
					</tr>
				</thead>
				<colgroup>
					<col width="2%"><col width="9%"><col width="34%"><col width="9%"><col width="34%"><col width="12%">
				</colgroup>
				<tbody>
					<?php if($listban && is_array($listban)){ foreach($listban as $k=>$m){ ?>
						<tr class="listban" data-m1id="<?php echo $m['m1']['id']; ?>" data-m2id="<?php echo $m['m2']['id']; ?>">
							<td class="delbtn"><?php echo $k+1; ?></td>
							<td><?php echo $m['m1']['id']; ?></td>
							<td>
							<?php if(isset($m['m1']['simpleleague']) && isset($m['m1']['matchtime'])){ echo $m['m1']['simpleleague'].'['.date('m/d H:i',strtotime($m['m1']['matchtime'])).']<br>'.$m['m1']['homename'].'/'.$m['m1']['awayname'].'<br>'.$m['m1']['sp'].'['.$m['m1']['fun88'].']'; }else{ echo ''; } ?>
							</td>
							<td><?php echo $m['m2']['id']; ?></td>							
							<td>
							<?php if(isset($m['m2']['simpleleague']) && isset($m['m2']['matchtime'])){ echo $m['m2']['simpleleague'].'['.date('m/d H:i',strtotime($m['m2']['matchtime'])).']<br>'.$m['m2']['homename'].'/'.$m['m2']['awayname'].'<br>'.$m['m2']['sp'].'['.$m['m2']['fun88'].']'; }else{ echo ''; } ?>
							</td>
							<td class="isban del"><a href="javascript:;"><span class="label label-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;删除</span></a></td>
						</tr>		
					<?php } } ?>												
				</tbody>
				</table>						
			</div>
			<input type="hidden" id="delbanmatch" value="<?php echo U('Match/delBanmatch');?>">
			<input type="hidden" id="dellistban" value="<?php echo U('Match/delListban');?>">	
		</div>
	</div>
	<!-- 底部 -->
</body>
</html>