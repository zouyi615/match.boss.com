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
	<div class="container">
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 显示比赛列表 -->
			<div class="col-xs-12 match-list">
				<!--<p><button type="button" class="btn btn-danger">已关注球队</button></p>-->				
				<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr class="danger">
						<th>序号</th>
						<th>开赛时间</th>
						<th>联赛</th>
						<th>主队</th>
						<th>客队</th>
						<th>赔率</th>
						<th>水位</th>
						<th>返还率</th>
					</tr>
				</thead>
				<tbody>
					<?php $k = 0; if(isset($match['match']) && is_array($match['match'])){ foreach($match['match'] as $key=>$value){ if($value['show'] == 1){ echo '<tr class="title success" date="'.date("Ymd",strtotime($value['date'])).'"><td colspan=8>'.$value['title'].'&nbsp;&nbsp;(共'.count($value['data']).'场比赛，其中'.$value['allend'].'场已截止)</td></tr>'; $mlist = $value['data']; foreach($mlist as $id=>$m){ $k++; ?>
									<tr class="data" id="<?php echo $m['id']; ?>" mid="" pname="" pdate="" lg="" rq="" pendtime="" win="" draw="" lost="" gdate="">
										<td><?php echo $k; ?></td>
										<td><?php echo $m['matchtime']; ?></td>
										<td><?php echo $m['league']; ?></td>
										<td><?php echo $m['homesxname']; ?></td>
										<td><?php echo $m['awaysxname']; ?></td>
										<td><?php echo $m['win']; ?></td>
										<td><?php echo $m['sp']; ?></td>
										<td><?php echo sprintf("%.6f",1/(1/$m['win']+1/$m['sp'])); ?></td>										
									</tr>		
					<?php } } } } ?>												
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
	<div class="tips" id="tips">		
		<a href="javascript:;"><span class="glyphicon glyphicon-resize-full"></span></a>
	</div>	
	<!-- 底部 -->
</body>
</html>