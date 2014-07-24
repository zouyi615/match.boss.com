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
	<!--  内容  -->
	<div class="container-fluid">
		<!-- 头部 -->
		<div class="header">
			
		</div>
		<!-- 主体内容 -->
		<div class="row main">
			<!-- 显示比赛列表 -->
			<div class="col-xs-8 match-list" id="matchList">
				<!--<p><button type="button" class="btn btn-danger">已关注球队</button></p>-->				
				<table class="table table-bordered table-hover table-condensed" id="matching" data-betmoney="<?php echo ($betmoney); ?>" data-rebate="<?php echo ($rebate); ?>">
				<thead>
					<tr class="danger">
						<th>序号</th>
						<th>开赛时间</th>
						<th>联赛</th>
						<th>主队</th>
						<th>客队</th>
						<th>赔率</th>
						<th>水位</th>
						<th colspan="2">返还率</th>
						<th>操作</th>
					</tr>
				</thead>
				<colgroup>
					<col width="5%" >
					<col width="20%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="8%">                                
					<col width="8%">
					<col width="9%">
					<col width="9%">
					<col width="5%">
				</colgroup>
				<tbody>
					<?php $k = 0; if(isset($comMatchArr) && is_array($comMatchArr)){ foreach($comMatchArr as $key=>$val){ ?>
						<tr class="data" id="m<?php echo $key; ?>" mid="m<?php echo $key; ?>" data="<?php echo '{s1:'.$val['m1']['win'].',s2:'.$val['m2']['win'].',s3:'.$val['m1']['sp'].',s4:'.$val['m2']['sp'].'}'; ?>" vs="<?php echo '['.$val['m1']['homesxname'].'vs'.$val['m1']['awaysxname'].']/['.$val['m2']['homesxname'].'vs'.$val['m2']['awaysxname'].']'; ?>" rate="<?php echo $val['rnrate']; ?>">
							<td rowspan="2" class="tobox"><?php echo $key+1; ?></td>
							<td><?php echo $val['m1']['matchtime']; ?></td>
							<td><?php echo $val['m1']['league']; ?></td>
							<td><?php echo $val['m1']['homesxname']; ?></td>
							<td><?php echo $val['m1']['awaysxname']; ?></td>
							<td><?php echo $val['m1']['win']; ?></td>
							<td><?php echo $val['m1']['sp']; ?></td>
							<td><?php echo $val['m1']['rnrate']; ?></td>
							<td rowspan="2" class="tobox"><?php echo $val['rnrate']; ?></td>
							<td rowspan="2" class="tobox"><a href="javascript:;">详情</a></td>							
						</tr>
						<tr class="data" mid="" pname="" pdate="" lg="" rq="" pendtime="" win="" draw="" lost="" gdate="">
							<td><?php echo $val['m2']['matchtime']; ?></td>
							<td><?php echo $val['m2']['league']; ?></td>
							<td><?php echo $val['m2']['homesxname']; ?></td>
							<td><?php echo $val['m2']['awaysxname']; ?></td>
							<td><?php echo $val['m2']['win']; ?></td>
							<td><?php echo $val['m2']['sp']; ?></td>
							<td><?php echo $val['m2']['rnrate']; ?></td>
						</tr>
					<?php } } ?>												
				</tbody>
				</table>	
			</div>
			<div class="col-xs-4 mod-inmoney">
				<table class="table table-bordered table-condensed tableDetail" id="tableDetail">
				<colgroup>
					<col width="14%" >
					<col width="14%">
					<col width="18%">
					<col width="18%">
					<col width="18%">
					<col width="18%">                                
				</colgroup>
				<tbody>
					<tr>
						<td colspan="6" class="vs">&nbsp;</td>
					</tr>
					<tr class="">
						<th colspan="2">水位1</th><th>下注</th><th>预计</th><th>返利</th><th class="red">1下注金额</th>
					</tr>
					<tr>
						<td><input type="text" class="form-control input-sm" name="s1" value=""></td>
						<td><input type="text" class="form-control input-sm" name="s2" value=""></td>
						<td><input type="text" class="form-control input-sm" name="betmoney" value=""></td>
						<td><input type="text" class="form-control input-sm" name="prize" value=""></td>
						<td><input type="text" class="form-control input-sm" name="rebate" value=""></td>
						<td><input type="text" class="form-control input-sm" name="in1" value=""></td>
					</tr>
					<tr class="">
						<th>水位2</th><th>水位3</th><th><font color="red">X</font>&nbsp;&nbsp;<font color="red">X</font></th><th>V&nbsp;&nbsp;V</th><th>V&nbsp;&nbsp;<font color="red">X</font></th><th class="red">2下注金额</th>
					</tr>
					<tr>
						<td><input type="text" class="form-control input-sm" name="s3" value=""></td>
						<td><input type="text" class="form-control input-sm" name="s4" value=""></td>
						<td><input type="text" class="form-control input-sm" value="0.00"></td>
						<td><input type="text" class="form-control input-sm" value="0.00"></td>
						<td><input type="text" class="form-control input-sm" name="profit" value=""></td>
						<td><input type="text" class="form-control input-sm" name="in2" value=""></td>
					</tr>
					<tr>
						<td colspan="6">
						<button type="button" class="btn btn-default btn-sm" id="clear">清空</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-default btn-sm" id="recount">重新计算</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-default btn-sm" id="savepro">保存方案</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-default btn-sm" id="clearpro">清空方案</button>
						<input type="hidden" name="mid" id="mid" value="">
						<input type="hidden" name="rnrate" id="rnrate" value="">
						</td>
					</tr>
				</tbody>
				</table>				
				<table class="table table-bordered table-hover table-condensed tableProList" id="tableProList">
				<!-- 保存方案列表 -->
				</table>
			</div>			
		</div>
	</div>
	<!-- <div class="tips" id="tips">		
		<a href="javascript:;"><span class="glyphicon glyphicon-resize-full"></span></a>
	</div>	 -->
	<!-- 底部 -->
</body>
</html>