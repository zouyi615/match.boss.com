<?php
//对阵处理类文件
namespace Home\Controller;
use Think\Controller;
class MatchController extends Controller {
	//参数
	public $xmlUrl = 'http://trade.500.com/static/public/jczq/xml/match/match.xml'; //对阵xml
	public $xmlspfpl = 'http://trade.500.com/static/public/jczq/xml/pl/pl_spf_2.xml'; //让球胜平负赔率
	//处理函数
	public function index(){
		
	}
	//获取xml数据
	public function getXml(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
        $match = $jc->getMatchData();
		$m = M('match');
		$rs = $m->addAll($match['match']);
		if($rs){
			echo "队阵保存成功！";
		}else{
			echo "对阵保存失败！";
		}
		exit;
		//var_dump(strtotime('2014-07-30 01:30'));
	}
	//获取赔率
	public function getPl(){
		header("Content-type:text/html;charset=UTF-8");
		$m = M('match');
		$list = $m->getField('id,rangqiu,league,homename,awayname,win,matchtime,date');
		if($list){
			
		}
		var_dump($list);
	
	
	}
}