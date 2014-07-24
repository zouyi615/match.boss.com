<?php
namespace Think\Template\Driver;
defined('THINK_PATH') or exit();
/**
 * MobileTemplate模板引擎驱动 
 */
class Mobile {
    /**
     * 渲染模板输出
     * @access public
     * @param string $templateFile 模板文件名
     * @param array $var 模板变量
     * @return void
     */
    public function fetch($templateFile,$var) {
		$templateFile=substr($templateFile,strlen(THEME_PATH));
		$var['_think_template_path']=$templateFile;
		exit(json_encode($var));	
    }
}
