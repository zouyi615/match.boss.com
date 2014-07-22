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
    <div class="navbar-inner">
        <a class="brand" href="javascript:void(0);">添加采集</a>
    </div>
    <p></p>
    <div class="well">
        <ul id="myTab" class="nav nav-pills span12">
            <li class="active"><a href="#info" data-toggle="tab">基本信息</a></li>
            <li><a href="#seo" data-toggle="tab">采集节点设置</a></li>
<!--             <li><a href="#contact" data-toggle="tab">相关商品</a></li>
            <li><a href="#trd" data-toggle="tab">第三方平台</a></li> -->
        </ul>
        <p>&nbsp;</p>
        <form class="form-horizontal tab-content" id="myTabContent" style="overflow: hidden;" action="<?php echo U(Index/add);?>" method="post">
            <div class="tab-pane fade in active" id="info">
                <div class="control-group">
                    <label class="control-label" for="name">采集项目名称</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" placeholder="请输入采集项目名称" />
                        <span class="help-inline">采集项目名称，中文</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="charset">采集编码</label>
                    <div class="controls">
                        <select id="charset" name="charset">
                            <option>UTF-8</option>
                            <option>GB2312</option>
                        </select>
                        <span class="help-inline">抓取页面编码</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="site">站点地址</label>
                    <div class="controls">
                        <input type="text" name="site" id="site" placeholder="请输入站点地址" />
                        <span class="help-inline">站点地址，以 http:// 开始</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="url">采集页面路径</label>
                    <div class="controls">
                        <!-- <textarea name="url" id="url" class="span4" placeholder="请输入采集页面路径"></textarea> -->
                        <input type="text" name="url" id="url" class="span5" placeholder="请输入站点地址" />
                        <span class="help-block">采集页面路径</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">是否下载图片</label>
                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" name="isdown" id="inlineCheckbox1" value="1"> 是
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="isdown" checked id="inlineCheckbox2" value="0"> 否
                        </label>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade in " id="seo">
                <div class="control-group" >
                  <pre class="pre-scrollable" style="background-color:#fff;">&lt;div class="test"&gt;<br/>   &lt;ul&gt;
        &lt;li&gt;&lt;a href="http://www.test.com/1.html"&gt;节点1&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href="http://www.test.com/1.html"&gt;节点2&lt;/a&gt;&lt;/li&gt;
   &lt;/ul&gt;
&lt;/div&gt;</pre>
                </div>
                <div class="control-group">
                    <label class="control-label" for="list_list">采集节点范围</label>
                    <div class="controls">
                        <input type="text" name="list_list" id="list_list" class="span4" />
                        <span class="help-inline">采集列表节点范围标记(jquery 语法) 如：
                        <code>.test li</code></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="list_title">列表地址</label>
                    <div class="controls">
                        <input type="text" name="list_title" id="list_title" class="span4" />
                        <span class="help-inline">地址节点标记(jquery 语法) 如：<code>li a:eq(0) </code></span>
                    </div>
                </div>                

                <div class="control-group">
                    <label class="control-label" for="list_title">标题</label>
                    <div class="controls">
                        <input type="text" name="list_title" id="list_title" class="span4" />
                        <span class="help-inline">标题节点标记(jquery 语法) 如：<code>li a:eq(0) </code></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="list_date">时间</label>
                    <div class="controls">
                        <input type="text" name="list_date" id="list_date" class="span4" />
                        <span class="help-inline">时间节点标记(jquery 语法) 如：<code>.date</code></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="list_author">作者</label>
                    <div class="controls">
                        <input type="text" name="list_author" id="list_author" class="span4" />
                        <span class="help-inline">作者节点标记(jquery 语法) 如：<code>.author</code></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="list_hits">访问量</label>
                    <div class="controls">
                        <input type="text" name="list_hits" id="list_hits" class="span4" />
                        <span class="help-inline">访问量节点标记(jquery 语法) 如：<code>.list_hits</code></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="list_content">页面内容</label>
                    <div class="controls">
                        <input type="text" name="list_content" id="list_content" class="span4" />
                        <span class="help-inline">页面内容节点标记(jquery 语法) 如：<code>.content</code></span>
                    </div>
                </div>                

            </div>
<!-- 
            <div class="tab-pane fade in" id="contact">
                <p>
                    TODO:选择相关商品
                </p>
            </div>

            <div class="tab-pane fade in" id="trd">
                <p>
                    TODO:第三方平台商品状态
                </p>
            </div> -->

            <input type="submit" value="提 交" class="btn btn-success" />
            <input type="button" value="取 消" class="btn btn-info" />
        </form>
        <div class="clearfix"></div>
    </div>
</div>
            </div>
        </div>
    </div>
</body>
</html>