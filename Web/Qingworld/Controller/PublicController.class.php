<?php
namespace Qingworld\Controller;
use Think\Controller;

class PublicController extends Controller {
	//通用成功
	public function success(){
		
		
	}
	//通用错误页面
	public function error(){
		$param = I('param.',array(),'htmlspecialchars'); //来源
		$this->assign('param',$param);    
		$this->display();	
	}
	
	
}