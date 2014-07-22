<?php
namespace Behavior;
use Think\Storage;
/**
 * 系统行为扩展：静态缓存写入
 */
class WriteHtmlCacheBehavior {

    // 行为扩展的执行入口必须是run
    public function run(&$content){
        if(C('HTML_CACHE_ON') && defined('HTML_FILE_NAME'))  {
            //静态文件写入
            Storage::put(HTML_FILE_NAME , $content,'html');
        }
    }
}