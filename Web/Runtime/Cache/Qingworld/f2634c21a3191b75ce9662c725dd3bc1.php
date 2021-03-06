<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"> 
<head>
	<title>QingWorld登录</title><meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="/Public/img/favicon.png">
	<link rel="stylesheet" href="/Public/Qingworld/css/bootstrap.min.css" /> <!-- bootstrap样式 -->
	<link rel="stylesheet" href="/Public/Qingworld/css/bootstrap-responsive.min.css" /> 
	<link rel="stylesheet" href="/Public/Qingworld/css/matrix-login.css" />
	<link rel="stylesheet" href="/Public/font-awesome/css/font-awesome.css"/>
    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" method="POST" action="<?php echo U('Index/login');?>">
				<div class="control-group normal_text"> <h3><img src="/Public/img/logo.png" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"></i></span><input type="text" name="name" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left" style="display:none;"><a href="javascript:;" class="flip-link btn btn-info" id="to-recover">忘记密码</a></span>
                    <span class="pull-right"><input type="submit" href="javascript:;" class="btn btn-success" value="登录"/></span>
                </div>
            </form>
        </div>
    </body>

</html>