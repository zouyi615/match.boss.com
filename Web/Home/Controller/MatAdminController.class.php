<?php
namespace Home\Controller;
use Think\Controller;
class MatAdminController extends Controller {
	//获取抓取数据列表
    public function index(){
        header("Content-type:text/html;charset=UTF-8"); 
		$m = M('match');
		$rsMat = $m->join('peilv ON match.id = peilv.id')->select();
        $this->assign('rsMat',$rsMat);
        $this->display();
    }

}