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
	</head>
	<body>	
	<!-- 头部 -->
	<div class="header">
		
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
				<tbody>
					<?php if($rsMat && is_array($rsMat)){ foreach($rsMat as $k=>$m){ ?>
						<tr class="data" id="<?php echo $m['id']; ?>">
							<td><?php echo $m['id']; ?></td>
							<td><?php echo $m['matchnum'].'<br>'.$m['matchtime']; ?></td>
							<td><?php echo $m['league']; ?></td>
							<td><?php echo $m['homename'].'<br>'.$m['awayname']; ?></td>
							<td><?php echo $m['rangqiu']; ?></td>
							<td><?php echo $m['win']; ?></td>
							<td><?php echo $m['leagueCh']; ?></td>
							<td><?php echo $m['homenameCh'].'<br>'.$m['awaynameCh']; ?></td>
							<td><?php echo $m['sp']; ?></td>
							<td><?php echo $m['homenamesp']; ?></td>
							<td><?php echo $m['awaynamesp']; ?></td>
							<td><?php echo $m['isoffset']; ?></td>
						</tr>		
					<?php } } ?>												
				</tbody>
				</table>	
			</div>
			<!-- 操作区域 -->
			<div class="tips_con rows" id="tips_con">
				<!-- 修改下注金额 -->
				<!--
				<div class="mod-inmoney col-xs-8">
					<table class="table table-bordered table-hover table-condensed">
						<tr class="danger"><th colspan="2">水位1</th><th>下注</th><th>预计</th><th>返利</th><th>1下注金额</th></tr>
						<tr><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td></tr>
						<tr class="danger"><th>水位2</th><th>水位3</th><th><font color="red">X</font>&nbsp;&nbsp;<font color="red">X</font></th><th>V&nbsp;&nbsp;V</th><th>V&nbsp;&nbsp;<font color="red">X</font></th><th>2下注金额</th></tr>
						<tr><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td></tr>
						<tr><td colspan="6"><button type="button" class="btn btn-default">修改</button></td></tr>
					</table>
				</div>
				-->
				<!-- 修改匹配值 -->
				<div class="mod-rate col-xs-12">
					<form action="<?php echo U('Index/matching');?>" method="POST" target="_blank" id="dosubform">
					<table class="table table-bordered table-hover table-condensed">
						<tr class="danger">
							<th colspan="4">返还率修改</th>
						</tr>
						<tr>
							<td colspan="3"><input type="text" name="rnrate" id="rnrate" class="form-control"></td>
							<td><button type="button" class="btn btn-default" id="setrn">设置</button></td>
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
	</div>
	<!-- 底部 -->
</body>
</html>