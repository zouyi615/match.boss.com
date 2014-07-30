<?php
return array(
	//调试配置
    'SHOW_ERROR_MSG' => true,
	//是否记录日志
	'LOG_RECORD' => false,
    //系统配置
    'DEFAULT_THEME' => 'Default', //当前主题
    'DB_FIELDS_CACHE' => false, //模型不缓存数据表字段
    'TMPL_CACHE_ON' => false, //是否开启模板编译缓存
    'TMPL_STRIP_SPACE' => false, //是否去除模板文件里面的html空格与换行
    'TMPL_DENY_PHP' => true, //是否禁用PHP原生代码
    'URL_MODEL' => '2', //URL模式
    //模板替换
    'TMPL_PARSE_STRING'  => array(
        '../Public' => __ROOT__.'/Public',
    ),
    //数据库配置信息
    'DB_TYPE'    => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'  => 'match', // 数据库名
    'DB_USER'    => 'root', // 用户名
    'DB_PWD'    => '123456', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀 
    //网站自定义公共类库
    'AUTOLOAD_NAMESPACE' => array(
    	'Libs'=> APP_PATH.'/Libs',
    ),
);