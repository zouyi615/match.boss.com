<?php
//对阵处理类文件
namespace Home\Controller;
use Think\Controller;
class MatchController extends Controller {
	public $out = array("code"=>-100,"msg"=>"");
	//参数
	public $xmlUrl = 'http://trade.500.com/static/public/jczq/xml/match/match.xml'; //对阵xml
	public $xmlspfpl = 'http://trade.500.com/static/public/jczq/xml/pl/pl_spf_2.xml'; //让球胜平负赔率
	public $xmlodds = 'http://trade.500.com/static/public/jczq/xml/odds/odds.xml'; //欧赔
	//public $spUrl = 'http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=0&LeagueIdList=-1&SortingType=0&OddsType=1&UserTimeZone=-480&Language=1&FilterDay=1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=1&OddsPageCode=0&ViewType=0&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0';	
	//public $spHost = 'sports1.im.fun88.com'; //抓取赔率域名
	//外围网站赔率
	//public $spUrl = 'http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsData2';
	//public $spHost = 'sports1.im.fun88.com'; //抓取赔率域名
	//处理函数
	public function index(){
		header("Content-type:text/html;charset=UTF-8"); 
		$m = M('match');
		$rsMat = $m->join('LEFT JOIN __PL__ ON __MATCH__.id = __PL__.id')->order('matchtime')->select();		
        $this->assign('rsMat',$rsMat); 
        $this->display();
	}	
	//获取初始xml数据
	public function getXml(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
        $match = $jc->getMatchData();
		if($match){
			$m = M('match');
			$p = M('pl');
			$m->where('1')->delete();
			$rs = $m->addAll($match['match']);
			if($rs){
				$p->where('1')->delete();
				$p->field('id,rq')->addAll($match['match']);
				$this->out['code'] = 100;
				$this->out['msg'] = 'suc';
				$this->out['info'] = array('uptime'=>date('Y-m-d H:i:s'),'num'=>count($match['match']));
			}else{
				$this->out['msg'] = '保存对阵xml失败！';
			}
		}else{
			$this->out['msg'] = '获取对阵xml失败！';
		}
		echo json_encode($this->out); exit;
	}
	//更新欧赔
	public function getOdds(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
       //获取球探网欧赔赔率(利记)
		$oddsArr = $jc->getOddsQt();
		$o = M('odds');
		$t = M('team');
		$o->where('1')->delete();
		$rs = $o->addAll($oddsArr);
		if($rs){			
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('uptime'=>date('Y-m-d H:i:s'),'num'=>$rs);
		}else{
			$this->out['msg'] = '保存对阵xml失败！';		
		}
		echo json_encode($this->out); exit;		
	}
	//更新球队名匹配
	public function teamUpAll(){
		header("Content-type:text/html;charset=UTF-8");
		//获取数据库信息
		$m = M('match');
		$o = M('odds');
		$t = M('team');
		//获取竞彩对阵信息
		$mInfo = $m->getField('id,homeid,homename,awayid,awayname');
		//获取外围场次信息
		$map['urlty&oddty'] =array('qiutan','liji','_multi'=>true);
		$oddInfo = $o->field('hname,aname')->where($map)->select();
		$team = array();
		$i = 0;
		foreach($mInfo as $val){
			foreach($oddInfo as $v){
				if($val['homename'] == $v['hname']){
					$team[$i]['tid'] = $val['homeid'];
					$team[$i]['tname'] = $val['homename'];
					$team[$i]['qtname'] = $v['hname'];					
					$r = $t->data($team[$i])->add();
					if($r){
						$i++;
					}					
				}
				if($val['awayname'] == $v['aname']){
					$team[$i]['tid'] = $val['awayid'];
					$team[$i]['tname'] = $val['awayname'];
					$team[$i]['qtname'] = $v['aname'];
					$r = $t->data($team[$i])->add();
					if($r){
						$i++;
					}	
				}
			}
		}
		$this->out['code'] = 100;
		$this->out['msg'] = 'suc';
		$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$i);
		echo json_encode($this->out); exit;
	}
	//更新赔率
	public function getPl(){
		header("Content-type:text/html;charset=UTF-8");
		$newplArr = array();
		//获取数据库信息
		$m = M('match');
		$o = M('odds');
		$t = M('team');
		$p = M('pl');
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
		//获取竞彩赔率
		$plArr = $jc->getSp(); 
		//获取球探网欧赔赔率(利记)
		$map['urlty&oddty'] =array('qiutan','liji','_multi'=>true);
		$oInfo = $o->field('oid,hname,aname,hw,st,aw')->where($map)->select();
		//获取对阵信息
		$mInfo = $m->getField('id,rq,homeid,homename,awayid,awayname,matchtime');
		$i = 0;
		if($mInfo && $oInfo){
			foreach($mInfo as $key=>$val){
				//球探网对应队名
				$qt_hname = $t->getFieldByTid($val['homeid'],'qtname'); //主队
				$qt_aname = $t->getFieldByTid($val['awayid'],'qtname'); //客队
				foreach($oInfo as $k=>$v){
					if($qt_hname == $v['hname'] && $qt_aname == $v['aname']){
						$newplArr[$i]['id'] = $val['id'];
						$newplArr[$i]['rq'] = $val['rq'];
						if($val['rq'] == "-1"){
							$sp = isset($plArr[$key]['lost'])?strval($plArr[$key]['lost']):'';
						}elseif($val['rq'] == "1"){
							$sp = isset($plArr[$key]['win'])?strval($plArr[$key]['win']):'';
						}
						if(empty($sp)) continue;						
						$newplArr[$i]['sp'] = $sp;
						$newplArr[$i]['liji'] = min(array($v['hw'],$v['st'],$v['aw']));					
						if(strtotime($val['matchtime']) < strtotime("+20 minutes")){
							$newplArr[$i]['isend'] = 1;
						}else{
							$newplArr[$i]['isend'] = 0;
						}
						$newplArr[$i]['ismat'] = 1; //是否匹配
						$newplArr[$i]['uptime'] = date('Y-m-d H:i:s');
						$rr = $p->field('id,rq,sp,liji,isend,ismat,uptime')->save($newplArr[$i]);
						$i++;
					}				
				}
			}
		}else{
			$this->out['msg'] = '本地xml数据为空，请先载入xml数据！';
		}
		if($newplArr && !$this->out['msg']){
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>count($newplArr));
		}
		echo json_encode($this->out); exit;
	}
	
	//获取外围赔率1
	public function getSp1(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
		$jc = new \Jcpublic();		
		$spJson = $jc->curl($this->spUrl,$this->spHost);
		$spArr = (array)json_decode($spJson);
		$legEn = $legCh = $homename = $awayname = $sp = $matchtime = '';
		$ptr = '/Date\((.*)\)/';		
		$spMatch = array();
		$ms = M('match_sp');
		$i = 0;	
		//var_dump($spArr['d']);
		if($spArr['d']){
			foreach($spArr['d'] as $key=>$val){
				$match = $val[4];
				if($match){
					foreach($match as $k=>$v){
						//var_dump($v);						
						foreach($v[10] as $m){
							if(isset($m[6][3]) && $m[6][3] == 0){
								$spMatch[$i]['sid'] = $v[0];
								$spMatch[$i]['leagueEn'] = $val[1][0];
								$spMatch[$i]['leagueCh'] = $val[1][1];
								$spMatch[$i]['homenameEn'] = $v[5][0];
								$spMatch[$i]['homenameCh'] = $v[5][1];
								$spMatch[$i]['awaynameEn'] = $v[6][0];
								$spMatch[$i]['awaynameCh'] = $v[6][1];
								preg_match($ptr,$v[7],$matchtime);
								$spMatch[$i]['matchtimesp'] = intval(substr($matchtime[1],0,10));
								$spMatch[$i]['sp'] = $m[6][4];
								$spMatch[$i]['rangqiusp'] = 0;
								$add = $ms->data($spMatch[$i])->add();
								$up = $ms->field(array('sid','rangqiusp','leagueEn','leagueCh','homenameEn','homenameCh','awaynameEn','awaynameCh','sp','matchtimesp'))->save($spMatch[$i]);
								$i++;
							}else{
								continue;
							}
						}						
					}
				}						
			}		
		}		
		if($spMatch){
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = $spMatch;
		}else{
			$this->out['msg'] = '获取外围赔率sp1失败';
		}
		echo json_encode($this->out); exit;
	}
	//清空外围赔率1
	public function clearSp1(){
		header("Content-type:text/html;charset=UTF-8");
		$mp = M('match_sp');
		$rs = $mp->where('1')->delete();
		if($rs === false){
			$this->out['msg'] = '清空外围sp1失败';
		}else{
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = $rs;
		}		
		echo json_encode($this->out);exit;
	}
}