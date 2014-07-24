<?php
header("Content-type: text/html; charset=utf-8");
//开启调试模式
define('APP_DEBUG', true);
define('UPLOAD_PATH','./Uploads/');
define('VERSION', 'Bate - 1.0');
define('UPDATETIME','2014-3-9');
//定义项目名称和路径
define('APP_NAME', 'collect');
define('APP_PATH', './collect/');
// 加载框架入口文件
require( "ThinkPHP/ThinkPHP.php");