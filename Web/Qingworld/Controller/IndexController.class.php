<?php
namespace Qingworld\Controller;
use Think\Controller;

header("Content-type:text/html;charset=UTF-8");
import('Libs.Public.Function');//公用函数

class IndexController extends Controller {	
	//定义输入json数组
	//public $out = array('state'=>-1,'msg'=>'err','info'=>'','list'=>'');
    public function index(){
		checklogin('admin');//检测登录
		//获取服务器使用情况
        //$status = get_used_status();
        $status = array(
            "tast_running" => "1",
            "cpu_usage" => "0.5%", 
            "mem_total" => "8058056k", 
            "mem_used" => "2588000k", 
            "mem_usage" => 32.12,
            "hd_avail" => "16G", 
            "hd_used" => "2.8G", 
            "hd_usage" => "15%", 
            "detection_time" => "2014-10-21 07:57",
            "service_ip" => "10.165.19.75"
        );		
		$this->display(); 
    }
	//登录
	public function login(){
		//获取参数
		$name = I('param.name','','htmlspecialchars'); //用户名
		$passwd = I('param.password','','htmlspecialchars'); //密码
		$type = I('param.type','form','htmlspecialchars'); //登录类型form,ajax
		if(!$name){
			$this->display();
		}else{
			//检测登录
			$ret = logstate(); 
			eval($ret['func']);
			//实例化
			$User = D('User');
			$rs = $User->login($name,$passwd);			
			if($rs){
				//保存session
				$ck = RC4('en@ck',$rs[0]['u_id'].'_'.$rs[0]['u_username'].'_'.$rs[0]['u_state'].'_'.$rs[0]['u_type']);
				session('name',$name);
				session('ck',$ck);
				if($rs[0]['u_state'] == -1){					
					$this->redirect('Public/error', array('url'=>'login', 'msg' =>'对不起，您的账号已禁用！'));			
				}else{					
					$this->redirect('/Home/Index/index');
				}
			}else{
				$this->redirect('Public/error', array('url'=>'login', 'msg' =>'用户名或密码错误！'));
			}
		}
    }
	
	//退出登录
	public function logout(){
		session(null); //清除SESSION值.
        session('[destroy]');  //销毁session
        $this->redirect('Index/login');
	}
	
	//全局json输出函数
	public function outJson($msg='err', $state=-1, $info='', $list=''){
		$this->out = array('state'=>$state,'msg'=>$msg,'info'=>$info,'list'=>$list);
		echo json_encode($this->out);
		exit;
	}

}