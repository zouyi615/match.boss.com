<?php if (!defined('THINK_PATH')) exit();?><html lang="en">
<head>
	<title>错误</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/Public/img/favicon.png">
	<link rel="stylesheet" href="/Public/Qingworld/css/bootstrap.min.css" /> <!-- bootstrap样式 -->
	<link rel="stylesheet" href="/Public/Qingworld/css/bootstrap-responsive.min.css" /> 
	<link rel="stylesheet" href="/Public/Qingworld/css/matrix-style.css" />
	<link rel="stylesheet" href="/Public/font-awesome/css/font-awesome.css"/>
</head>
<body>
<div class="content-err">
	<div id="content-header"><h1>错误提示！</h1></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"><span class="icon"><i class="icon-info-sign"></i></span>
            <h5>error,页面错误！</h5>
          </div>
          <div class="widget-content">
            <div class="error_ex">								
              <h3><?=isset($param['msg'])?$param['msg']:'error!';?></h3>
              <?php echo '<?'; ?>
 if(isset($param['url']) && $param['url'] == 'login'){?>
              <a class="btn btn-warning btn-big" href="{:U('Index/login')}">重新登录</a>
              <script language="javascript" type="text/javascript"> 
              // 以下方式定时跳转
              setTimeout("javascript:location.href='<?php echo U('Index/login');?>'", 2000); 
              </script>
              <?php echo '<?'; ?>
 }?>								
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>