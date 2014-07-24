<?php
namespace Think\Controller;
/**
 * ThinkPHP Hprose控制器类
 */
class YarController {

   /**
     * 架构函数
     * @access public
     */
    public function __construct() {
        //控制器初始化
        if(method_exists($this,'_initialize'))
            $this->_initialize();
        //判断扩展是否存在
        if(!extension_loaded('yar'))
            E(L('_NOT_SUPPERT_').':yar');
        //实例化phprpc
        $server     =   new \Yar_Server($this);
        // 启动server
        $server->handle();
    }

    /**
     * 魔术方法 有不存在的操作的时候执行
     * @access public
     * @param string $method 方法名
     * @param array $args 参数
     * @return mixed
     */
    public function __call($method,$args){}
}
