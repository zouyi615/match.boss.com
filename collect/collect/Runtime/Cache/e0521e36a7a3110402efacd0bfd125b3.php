<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>thinkphp 采集系统</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="__PUBLIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="__PUBLIC__/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <script src="__PUBLIC__/jquery/jquery-1.10.2.min.js"></script>
        <script src="__PUBLIC__/bootstrap/js/bootstrap.min.js"></script>
        <link href="__PUBLIC__/css/layout.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <!--公共页头-->
    <div class="navbar navbar-static-top navbar-inverse">
    <div class="navbar-inner">
        <div class="container-fluid">

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse-top">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="#">thinkphp 采集系统</a>

            <div class="nav-collapse collapse nav-collapse-top">
                <!--<div class="navbar-text pull-right">
                    顶端右侧
                </div>-->
                <ul class="nav pull-left">
                    <li class="active"><a href="#">首页</a></li>
                    <li><a href="#about">采集</a></li>
                    <li><a href="#contact">新闻</a></li>
                </ul>

                <ul class="nav pull-right">
                    <li><a href="<?php echo U('Index/add');?>"><i class="icon-th-list icon-white"></i> 添加采集</a></li>
                </ul>

            </div>


        </div>
    </div>
</div>
    <!--布局左侧-->
    <div class="container-fluid" style="margin-top:20px;">
        <div class="row-fluid">
            <div class="span2">
                <div class="well well-small">
    <h4>你好，欢迎使用采集系统</h4>
    <div class="btn-group">
        <a href="/" class="btn btn-primary btn-mini">前台</a>
        <a href="/" class="btn btn-primary btn-mini">地图</a>
        <a href="/" class="btn btn-primary btn-mini">退出</a>
    </div>
</div>

<div class="accordion" id="accordionMenu">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseMenu1">
                <b>信息采集</b>
            </a>
        </div>
        <div id="collapseMenu1" class="accordion-body collapse in">
            <ul class="nav nav-tabs nav-stacked" style="text-indent: 14px;">
                <li><a href="<?php echo U('Index/index');?>">采集列表</a></li>
                <li><a href="<?php echo U('Index/add');?>" >添加采集</a></li>
                <li><a href="<?php echo U('Index/collect_list');?>">采集记录</a></li>
            </ul>
        </div>
    </div>

    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseMenu2">
                <b>文章列表</b>
            </a>
        </div>
        <div id="collapseMenu2" class="accordion-body collapse">
            <ul class="nav nav-tabs nav-stacked" style="text-indent: 14px;">
                <li><a href="<?php echo U('article/index');?>" >文章列表</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="well well-small">
    <h4>其他</h4>
    <p>
        <small><a href="javascript:;" target="_blank">下载地址</a></small>
    </p>
</div>
            </div>
            <div class="span10">
                <!--面包屑导航-->
<ul class="breadcrumb">
    <li class="active"><b>您的位置：</b></li>
    <li><a href="#">首页</a> <span class="divider">&raquo;</span></li>
    <li><a href="#">一级菜单#1</a> <span class="divider">&raquo;</span></li>
    <li class="active">二级菜单#2</li>
</ul>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示</title>
<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
.system-message{ padding: 24px 48px; }
.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 10px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
</style>
</head>
<body>
<div class="system-message">
<?php if(isset($message)): ?><h1>:)</h1>
<p class="success"><?php echo($message); ?></p>
<?php else: ?>
<h1>:(</h1>
<p class="error"><?php echo($error); ?></p><?php endif; ?>
<p class="detail"></p>
<p class="jump">
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time == 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
            </div>
        </div>
    </div>
</body>
</html>