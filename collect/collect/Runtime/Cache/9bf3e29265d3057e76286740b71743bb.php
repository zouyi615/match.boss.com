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
                <div class="navbar">
    <div class="container">
        <div class="navbar-inner">
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="#">工具条</a>
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav">
                    <li><a href="#"><i class="icon-search icon-print"></i> 批量打印</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-search icon-download-alt"></i> 批量导出 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">CSV格式</a></li>
                            <li><a href="#">Excel2000</a></li>
                            <li><a href="#">txt制表符</a></li>
                            <li><a href="#">CSV逗号分割</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="icon-search icon-trash"></i> 批量删除</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-search icon-list"></i> 快速筛选 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">全部订单</a></li>
                            <li><a href="#">等待付款</a></li>
                            <li><a href="#">已付款未发货</a></li>
                            <li><a href="#">已发货</a></li>
                            <li><a href="#">已完成</a></li>
                            <li><a href="#">已退款</a></li>
                            <li><a href="#">已退货</a></li>
                            <li><a href="#">已作废</a></li>
                            <li><a href="#">回收站</a></li>
                        </ul>
                    </li>
                    <!--<li class="divider-vertical"></li>-->
                    <li><a href="#"><i class="icon-search icon-wrench"></i> 其他设置</a></li>
                </ul>

                <form class="navbar-form pull-right" action="###">
                    <div class="input-prepend input-append">
                        <div class="btn-group">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                订单号 <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">来源单号</a></li>
                                <li><a href="#">货号</a></li>
                                <li><a href="#">商品名称</a></li>
                                <li><a href="#">物流单号</a></li>
                                <li><a href="#">会员名</a></li>
                                <li><a href="#">收货人</a></li>
                            </ul>
                        </div>
                        <input type="text" class="span5" placeholder="搜索订单">
                        <button type="submit" class="btn"><i class="icon-search"></i> 搜索</button>
                        <button type="button" class="btn" data-toggle="modal" role="button" data-target="#myModal" >高级搜索</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!--列表区域-->
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>项目编号</th>
            <th>网站路径</th>
            <th>采集项目名称</th>
            <th>下载图片</th>
            <th>页面编码</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>
            <th>功能 <a href="###" data-toggle="tooltip" title="按钮分别为：批量采集、测试采集"><i class="icon-question-sign"></i></a></th>
        </tr>
    </thead>
    <tbody>
        <?php if(is_array($volist)): $i = 0; $__LIST__ = $volist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><input type="checkbox"></td>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["site"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><span class="label label-success"><?php if($vo['isdown']==1): ?>下载<?php else: ?>不下载<?php endif; ?></span></td>
            <td><span class="label label-warning"><?php echo ($vo["charset"]); ?></span></td>
            <td><?php echo date("Y-m-d",$vo['createtime']);?></td>
            <td><?php echo date("Y-m-d H:i",$vo['updatetime']);?></td>
            <td>
                <div class="btn-group">
                    <a href="###" class="btn btn-primary btn-small">编辑</a>
                    <a href="###" class="btn btn-warning btn-small">删除</a>
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo U('Index/runCollect',array(id=>$vo['id']));?>" class="btn btn-primary btn-small">批</a>
                    <a href="<?php echo U('Index/collect',array(id=>$vo['id']));?>" class="btn btn-primary btn-small">测</a>
                </div>
            </td>            
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="99">
            <div class="pagination">
                <ul>
                    <li><a href="#">首页</a></li>
                    <li><a href="#">上一页</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">下一页</a></li>
                    <li><a href="#">尾页</a></li>
                </ul>
            </div>
        </td>
    </tr>
</tfoot>
</table>


<!--弹出对话框-->

<div id="myModal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>高级搜索</h3>
    </div>
    <div class="modal-body">
        <p>内容等等…</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a>
        <a href="#" class="btn btn-primary">搜索</a>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('a').tooltip();
    });
</script>
            </div>
        </div>
    </div>
</body>
</html>