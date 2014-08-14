<?php
namespace Home\Controller;
use Think\Controller;
class MatAdminController extends Controller {
	public $out = array("code"=>-100,"msg"=>"");
	//获取抓取数据列表
    public function index(){
        header("Content-type:text/html;charset=UTF-8"); 
		$m = M('match');
		$rsMat = $m->join('peilv ON match.id = peilv.id')->join('LEFT JOIN match_sp ON match_sp.sid = peilv.sid')->select();
        $this->assign('rsMat',$rsMat);
        $this->display();
    }
	//显示外围数据列表
	public function showSpLs(){
		header("Content-type:text/html;charset=UTF-8"); 
		$ms = M('match_sp');
		$spLs = $ms->order('matchtime')->select();
        $this->assign('spLs',$spLs);
        $this->display();
	}
	//更新单条竞彩、外围匹配数据
	public function modUp(){
		header("Content-type:text/html;charset=UTF-8"); 
		$m = M('match');
		$arr = array();
		$mid = I('param.mid','','htmlspecialchars'); //场次ID
		$homesp = I('param.homesp','','htmlspecialchars'); //匹配主队
		$awaysp = I('param.awaysp','','htmlspecialchars'); //匹配客队
		$offset = I('param.offset','','htmlspecialchars'); //是否匹配
		if($mid == ''){$this->out['msg'] = '所选场次错误！&mid='.$mid; echo json_encode($this->out); exit;}
		$arr['id'] = $mid;
		if($homesp != '') $arr['homenamesp'] = $homesp;
		if($awaysp != '') $arr['awaynamesp'] = $awaysp;
		if($offset != '') $arr['isoffset'] = $offset;
		$rs = $m->field(array_keys($arr))->save($arr);
		if($rs === false){
			$this->out['msg'] = '匹配数据更新错误！';
		}else{
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = $arr;
		}
		echo json_encode($this->out); exit;
	}

}