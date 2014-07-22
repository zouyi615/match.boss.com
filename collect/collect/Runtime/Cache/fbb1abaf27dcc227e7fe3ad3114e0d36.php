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
                <?php echo ($doc); ?>
</br>
<h1></h1>
<div class="jumbotron">
  <h1><?php echo ($val[0]["title"]); ?></h1>
  <div class="detail-bd"><?php echo ($val[0]["con"]); ?></div>
</div>

<style>
/* 详情页内容（公共） */
.detail-bd {
	margin-bottom: 10px;
	line-height: 1.8;
	font-size: 16px;
	color: #323232;
	width: 600px;
	word-wrap: break-word;
}
code.prettyprint {
	position: relative;
	border: 0;
	border: 1px solid #D1D7DC;
	margin-left: 0;
	padding: 10px;
	padding: 2px;
	font-size: 14px;
	display: block;
	font-family: Consolas, "Liberation Mono", Courier, monospace, \5FAE\8F6F\96C5\9ED1;
	margin: 10px 0;
	white-space: normal;
	word-wrap: break-word;
}
	
</style>
            </div>
        </div>
    </div>
</body>
</html>