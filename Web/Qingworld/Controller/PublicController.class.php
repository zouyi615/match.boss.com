<?php
namespace Qingworld\Controller;
use Think\Controller;

class PublicController extends Controller {
	//ͨ�óɹ�
	public function success(){
		
		
	}
	//ͨ�ô���ҳ��
	public function error(){
		$param = I('param.',array(),'htmlspecialchars'); //��Դ
		$this->assign('param',$param);    
		$this->display();	
	}
	
	
}