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
	//更新单条竞彩、外围匹配数据
	public function modUp(){
		header("Content-type:text/html;charset=UTF-8"); 
		$m = M('match');
		$arr = array();
		$mid = I('param.mid','','htmlspecialchars'); //场次ID
		$homesp = I('param.homesp','','htmlspecialchars'); //匹配主队
		$awaysp = I('param.awaysp','','htmlspecialchars'); //匹配客队
		$offset = I('param.offset','','htmlspecialchars'); //是否匹配
		if($mid == '') {echo '所选场次错误！'; exit;}
		if($homesp == '') {echo '请填写匹配主队！'; exit;}
		if($awaysp == '') {echo '请填写匹配客队！'; exit;}
		if($offset == '') {echo '是否匹配错误！'; exit;}
		$arr['id'] = $mid;
		$arr['homenamesp'] = $homesp;
		$arr['awaynamesp'] = $awaysp;
		$arr['isoffset'] = $offset;
		$rs = $m->field(array('id','homenamesp','awaynamesp','isoffset'))->save($arr);
		if($rs){
			echo 'ok'; exit;
		}else{
			echo '匹配数据更新错误！'; exit;
		}
	}

}