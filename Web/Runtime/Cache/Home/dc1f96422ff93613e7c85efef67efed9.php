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
				$.match.box.index();
			});		
		</script>
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
				<table class="table table-bordered table-hover table-condensed" id="matching" data-irate="<?php echo ($irate); ?>" data-betmoney="<?php echo ($betmoney); ?>" data-rebate="<?php echo ($rebate); ?>">
				<thead>
					<tr class="danger">
						<th>序号</th>
						<th>场次</th>
						<th>开赛时间</th>
						<th>联赛</th>
						<th>主队</th>
						<th>客队</th>
						<th>赔率</th>
						<th>水位</th>
						<th colspan="2">
							返还率&nbsp;&nbsp;
							<span class="label label-success relup" id="relup" data-url="<?php echo U('Index/getAjaxMatch');?>">
								<i class="glyphicon glyphicon-refresh"></i>
							</span>
						</th>
					</tr>
				</thead>
				<colgroup>
					<col width="5%">
					<col width="6%">
					<col width="15%">
					<col width="7%">
					<col width="14%">
					<col width="14%">
					<col width="6%">
					<col width="10%">
					<col width="10%">
					<col width="">
				</colgroup>
				<tbody id="mlist_show">
					<?php $k = 0; if(isset($comMatchArr) && is_array($comMatchArr)){ foreach($comMatchArr as $key=>$val){ $sp1 = $sp_r1 = $nt1 = $sp2 = $sp_r2 = $nt2 = ''; if($val['t1'] == 'bet365'){ $sp1 = $val['m1']['b']; $sp_r1 = $val['m1']['bet_r']; $nt1 = '(bet365)'; }elseif($val['t1'] == 'hg'){ $sp1 = $val['m1']['h']; $sp_r1 = $val['m1']['hg_r']; $nt1 = '(皇冠)'; } if($val['t2'] == 'bet365'){ $sp2 = $val['m2']['b']; $sp_r2 = $val['m2']['bet_r']; $nt2 = '(bet365)'; }elseif($val['t2'] == 'hg'){ $sp2 = $val['m2']['h']; $sp_r2 = $val['m2']['hg_r']; $nt2 = '(皇冠)'; } ?>
						<tr class="data" id="m<?php echo $key; ?>" mid="m<?php echo $key+1; ?>" data="<?php echo '{s1:'.$val['m1']['w'].',s2:'.$val['m2']['w'].',s3:'.$sp1.',s4:'.$sp2.'}'; ?>" vs="<?php echo '['.$val['m1']['homename'].'vs'.$val['m1']['awayname'].']/['.$val['m2']['homename'].'vs'.$val['m2']['awayname'].']'; ?>" rate="<?php echo $val['rnrate']; ?>">
							<td rowspan="2" class="tobox"><a href="javascript:;"><?php echo $key+1; ?></a></td>
							<td><?php echo $val['m1']['id']; ?></td>
							<td><?php echo $val['m1']['matchtime']; ?></td>
							<td><?php echo $val['m1']['simpleleague']; ?></td>
							<td><?php echo $val['m1']['homename']; ?></td>
							<td><?php echo $val['m1']['awayname']; ?></td>
							<td><?php echo $val['m1']['w']; ?></td>
							<td><?php echo $sp1.$nt1; ?></td>
							<td><?php echo $sp_r1; ?></td>
							<td rowspan="2" class="tobox"><?php echo $val['rnrate']; ?>&nbsp;<a href="javascript:;">详情</a></td>					
						</tr>
						<tr class="data" mid="" pname="" pdate="" lg="" rq="" pendtime="" win="" draw="" lost="" gdate="">
							<td><?php echo $val['m2']['id']; ?></td>
							<td><?php echo $val['m2']['matchtime']; ?></td>
							<td><?php echo $val['m2']['simpleleague']; ?></td>
							<td><?php echo $val['m2']['homename']; ?></td>
							<td><?php echo $val['m2']['awayname']; ?></td>
							<td><?php echo $val['m2']['w']; ?></td>
							<td><?php echo $sp2.$nt2; ?></td>
							<td><?php echo $sp_r2; ?></td>
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
						<input type="hidden" name="vs" id="vs" value="">
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
	<!-- 底部 -->
</body>
</html>