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
	//对阵管理页面
	public function index(){
		header("Content-type:text/html;charset=UTF-8"); 
		$m = M('match');
		$t = M('team');
		$h = $m->getField('homeid',true);
		$a = $m->getField('awayid',true);
		$rsMat = $m->alias('m')->field('m.id,m.matchnum,m.homeid,m.homename,m.awayid,m.awayname,m.matchtime,m.simpleleague,m.homename,m.awayname,p.sp,p.fun88,p.rq,p.isend,p.uptime,bm.isban')->join('LEFT JOIN __PL__ p ON m.id = p.id LEFT JOIN __BANMATCH__ bm ON m.id = bm.mid')->order('m.matchtime')->select();
		$rsTeam = $this->getTeamById(array_merge($h,$a));
		$this->assign('rsTeam',$rsTeam); 
        $this->assign('rsMat',$rsMat);
        $this->display();
	}
	//外围赔率显示页面
	public function odds(){
		header("Content-type:text/html;charset=UTF-8"); 
		$o = M('odds');		
		$odds = $o->order('matchtime')->select();
		$this->assign('odds',$odds); 
        $this->display();
	}
	//主客队匹配显示页面
	public function team(){
		header("Content-type:text/html;charset=UTF-8"); 
		$t = M('team');
		$team = $t->select();
		$this->assign('team',$team); 
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
	public function getOddsQt(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
		//获取球探网欧赔赔率(利记)
		$time1 = microtime(true);
		$oddsArr = $jc->getOddsQt();
		$time2 = microtime(true);
		$o = M('odds');
		$t = M('team');
		$o->where('1')->delete();
		$rs = $o->addAll(array_values($oddsArr));
		$time3 = microtime(true);
		if($rs){			
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('uptime'=>date('Y-m-d H:i:s'),'num'=>$rs,'oddscost'=>($time2-$time1),'addcost'=>($time3-$time2));
		}else{
			$this->out['msg'] = '保存对阵xml失败！';		
		}
		echo json_encode($this->out); 
		exit;		
	}
	//获取外围赔率 乐天堂
	public function getOdds(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
		$jc = new \Jcpublic();
		$spUrl_1 = 'http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=0&LeagueIdList=-1&SortingType=0&OddsType=1&UserTimeZone=-480&Language=1&FilterDay=1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=0&OddsPageCode=1&ViewType=0&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0';	 //今日		
		$spUrl_2 = 'http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=2&LeagueIdList=-1&SortingType=0&OddsType=0&UserTimeZone=-480&Language=1&FilterDay=-1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=2&OddsPageCode=1&ViewType=0&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0'; //早盘
		$spHost = 'sports1.im.fun88.com'; //抓取赔率域名
		$pl_odds = $pl_odds_1 = $pl_odds_2 = array();
		$time1 = microtime(true);
		$spJson_1 = $jc->curl($spUrl_1,$spHost);
		if($spJson_1){
			$spArr_1 = (array)json_decode($spJson_1);
			$pl_odds_1 = $this->getOddsArr($spArr_1['d']);
		}		
		$time2 = microtime(true);
		$spJson_2 = $jc->curl($spUrl_2,$spHost);
		if($spJson_2){
			$spArr_2 = (array)json_decode($spJson_2);
			$pl_odds_2 = $this->getOddsArr($spArr_2['d']);
		}
		$time3 = microtime(true);
		$pl_odds = $pl_odds_1 + $pl_odds_2;
		$o = M('odds');
		$o->where('1')->delete(); 
		$rs = $o->addAll(array_values($pl_odds));
		$time4 = microtime(true);
		if($rs){			
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('uptime'=>date('Y-m-d H:i:s'),'num'=>$rs,'oddscost1'=>($time2-$time1),'oddscost2'=>($time3-$time2),'addcost'=>($time4-$time3));
		}else{
			$this->out['msg'] = '获取odds赔率失败！';		
		}		
		echo json_encode($this->out); 
		exit;
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
		$time1 = microtime(true);
		$plArr = $jc->getSp(); 
		//获取球探网欧赔赔率(利记)
		$time1_o = microtime(true);
		$map['urlty'] = 'fun88';
		$oInfo = $o->field('oid,hname,aname,fun88,matchtime')->where($map)->select(); 
		$time2_o = microtime(true);
		//获取对阵信息
		$mInfo = $m->getField('id,rq,homeid,homename,awayid,awayname,matchtime');
		//获取主客队匹配信息
		$time3_o = microtime(true);
		$h = $m->getField('homeid',true);
		$a = $m->getField('awayid',true);	
		$mTeam = $this->getTeamById(array_merge($h,$a));
		$time4_o = microtime(true);
		
		// echo '<br>取竞彩赔率时间：'.($time1_o-$time1);
		// echo '<br>取欧赔时间：'.($time2_o-$time1_o);
		// echo '<br>取对阵时间：'.($time3_o-$time2_o);
		// echo '<br>取主客队匹配信息时间：'.($time4_o-$time3_o);
		
		$i = 0;
		if($mInfo && $oInfo){
			foreach($mInfo as $key=>$val){
				$newplArr[$i]['fun88'] = '';				
				$newplArr[$i]['isend'] = 0;
				$newplArr[$i]['ismat'] = 0; //是否匹配
				$newplArr[$i]['id'] = $val['id'];
				$newplArr[$i]['rq'] = $val['rq'];										
				$newplArr[$i]['sp'] = $plArr[$key]['win'].','.$plArr[$key]['draw'].','.$plArr[$key]['lost'];
				//比赛已经截止 不抓赔率 (竞彩官网提前10分钟截止)
				if(strtotime($val['matchtime']) < strtotime("+10 minutes")){				
					$newplArr[$i]['isend'] = 1;
				}else{
					//球探网对应队名
					$qt_hname = isset($mTeam[$val['homeid']])?$mTeam[$val['homeid']]:''; //主队
					$qt_aname = isset($mTeam[$val['awayid']])?$mTeam[$val['awayid']]:''; //客队
					foreach($oInfo as $k=>$v){
						//匹配对应场次，首先根据日期匹配，其次根据主客队名匹配
						//两场比赛时间差允许超过一小时
						if(abs(strtotime($val['matchtime']) - strtotime($v['matchtime'])) > 1*60*60) continue;
						if($qt_hname == $v['hname'] && $qt_aname == $v['aname']){						
							$newplArr[$i]['fun88'] = $v['fun88'];
							$newplArr[$i]['ismat'] = 1; //是否匹配
							break;
						}
					}
				}
				$newplArr[$i]['uptime'] = date('Y-m-d H:i:s');
				$rr = $p->field('id,rq,sp,fun88,isend,ismat,uptime')->save($newplArr[$i]);
				$i++;
			}
		}else{
			$this->out['msg'] = '本地xml数据为空，请先载入xml数据！';
		}
		$time5_o = microtime(true);
		if($newplArr && !$this->out['msg']){
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>count($newplArr),'plArr'=>($time1_o-$time1),'oInfo'=>($time2_o-$time1_o),'mInfo'=>($time3_o-$time2_o),'mTeam'=>($time4_o-$time3_o),'match'=>($time5_o-$time4_o),'cost'=>($time5_o-$time1));
		}
		echo json_encode($this->out); exit;
	}
	//切换匹配状态
	public function teamBan(){
		header("Content-type:text/html;charset=UTF-8"); 
		$bm = M('banmatch');
		$arr = array();
		$mid = I('param.mid','','htmlspecialchars'); //场次ID
		$isban = I('param.isban','','htmlspecialchars'); //是否允许匹配
		$matchtime = I('param.matchtime','','htmlspecialchars'); //比赛时间
		$league = I('param.league','','htmlspecialchars'); //联赛
		$team = I('param.team','','htmlspecialchars'); //竞彩对阵
		$oteam = I('param.oteam','','htmlspecialchars'); //外围对阵
		$uptime = date('Y-m-d H:i:s');
		$arr = array(
			'mid' => $mid,
			'isban' => $isban,
			'matchtime' => $matchtime,
			'simpleleague' => $league,
			'team' => $team,
			'oteam' => $oteam,
			'uptime' => $uptime,
		);
		if(!$bm->save($arr)){
			$r = $bm->data($arr)->add();
			if($r) {
				$this->out['code'] = 100;
				$this->out['msg'] = '添加成功';
			}else{
				$this->out['code'] = -100;
				$this->out['msg'] = '添加失败';	
			}
		}else{
			$this->out['code'] = 100;
			$this->out['msg'] = '保存成功';
		}				
		$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$n);		
		echo json_encode($this->out); exit;
	}
	//批量更新球队名匹配
	public function teamUpAll(){
		header("Content-type:text/html;charset=UTF-8");
		//获取数据库信息
		$m = M('match');
		$o = M('odds');
		$t = M('team');
		//获取竞彩对阵信息
		$mInfo = $m->getField('id,homeid,homename,awayid,awayname');
		//获取外围场次信息
		//$map['urlty&oddty'] =array('qiutan','liji','_multi'=>true);
		$map['urlty'] = 'fun88';
		$oddInfo = $o->field('hname,aname')->where($map)->select();
		$team = array();
		$i = 0;
		foreach($mInfo as $val){
			foreach($oddInfo as $v){
				if($val['homename'] == $v['hname']){
					$team[$i]['tid'] = $val['homeid'];
					$team[$i]['tname'] = $val['homename'];
					$team[$i]['oname'] = $v['hname'];
					$team[$i]['uptime'] = date('Y-m-d H:i:s');
					$r = $t->data($team[$i])->add();
					if($r){
						$i++;
					}					
				}
				if($val['awayname'] == $v['aname']){
					$team[$i]['tid'] = $val['awayid'];
					$team[$i]['tname'] = $val['awayname'];
					$team[$i]['oname'] = $v['aname'];
					$team[$i]['uptime'] = date('Y-m-d H:i:s');
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
	//更新竞彩、外围主客队匹配数据
	public function teamUp(){
		header("Content-type:text/html;charset=UTF-8"); 
		$t = M('team');
		$arr = array();
		$mod = I('param.mod','','htmlspecialchars'); //场次ID
		$i = $n = 0;
		if($mod){
			$arr_t = explode(';',$mod);
			if($arr_t && is_array($arr_t)){
				foreach($arr_t as $k => $v){
					$arr_v = explode(':',$v);
					if(trim($arr_v[1]) != '' && trim($arr_v[2]) != ''){
						$arr[$i]['tid'] = $arr_v[0];
						$arr[$i]['tname'] = urldecode($arr_v[1]);
						$arr[$i]['oname'] = urldecode($arr_v[2]);
						$arr[$i]['uptime'] = date('Y-m-d H:i:s');
						if(!$t->save($arr[$i])){
							$r = $t->data($arr[$i])->add();
							if($r) $n++;
						}else{
							$n++;
						}						
						$i++;
					}
				}
			}		
		}
		$this->out['code'] = 100;
		$this->out['msg'] = 'suc';
		$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$n);		
		echo json_encode($this->out); exit;
	}
	//更新匹配队名
	public function modteamUp(){
		header("Content-type:text/html;charset=UTF-8"); 
		$t = M('team');
		$arr = array();
		$tid = I('param.tid','','htmlspecialchars'); //队名ID
		$team = I('param.team','','htmlspecialchars'); //队名
		$arr['tid'] = $tid;
		$arr['oname'] = $team;
		$arr['uptime'] = date('Y-m-d H:i:s');
		$r = $t->save($arr);
		if($r === false){
			$this->out['msg'] = '修改队名失败！';
		}else{
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$r);
		}
		echo json_encode($this->out); exit;
	}
	//添加匹配队名
	public function addteamUp(){
		header("Content-type:text/html;charset=UTF-8"); 
		$t = M('team');
		$arr = array();
		$team = $_POST;
		if($team){
			foreach($team as $key => $val){
				$j = 0;
				foreach($val as $k => $v){
					$arr[$j][$key] = $v;
					$arr[$j]['uptime'] = date('Y-m-d H:i:s');
					$j++;
				}
			}
		}
		$r = $t->addAll($arr);
		if($r === false){
			$this->out['msg'] = '添加出错！';
		}else{
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$r);
		}
		echo json_encode($this->out); exit;	
	}
	//添加匹配队名
	public function delteamUp(){
		header("Content-type:text/html;charset=UTF-8"); 
		$t = M('team');
		$arr = array();
		$tid = I('param.tid','','htmlspecialchars'); //队名ID		
		$r = $t->where(array('tid'=>$tid))->delete();
		if($r === false){
			$this->out['msg'] = '添加出错！';
		}else{
			$this->out['code'] = 100;
			$this->out['msg'] = 'suc';
			$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$r);
		}
		echo json_encode($this->out); exit;	
	}
	//根据队名ID获取队名信息$hid主队ID,$aid客队ID
	public function getTeamById($arr){
		$teamArr = array();
		$t = M('team');
		$map['tid']  = array('in',$arr);
		$team = $t->field('tid,oname')->where($map)->select();
		foreach($team as $val){
			$teamArr[$val['tid']] = $val['oname'];
		}
		return $teamArr;
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
	//乐天堂 赔率组合函数
	public function getOddsArr($odd){
		header("Content-type:text/html;charset=UTF-8");
		$odds = array();
		$ptr = '/Date\((.*)\)/';
		if($odd){
			foreach($odd as $key=>$val){
				$match = $val[4];
				if($match){
					foreach($match as $k=>$v){
						foreach($v[10] as $m){
							$id = $v[0];
							$odds[$id]['oid'] = $v[0];
							$odds[$id]['league'] = trim($val[1][1]);							
							$odds[$id]['hname'] = $this->getTeam($v[5][1]);
							$odds[$id]['aname'] = $this->getTeam($v[6][1]);
							preg_match($ptr,$v[7],$matchtime);
							$odds[$id]['matchtime'] = date('Y-m-d H:i:s',substr($matchtime[1],0,10));
							$odds[$id]['fun88'] = $m[6][2].','.$m[6][4].','.$m[6][3];
							$odds[$id]['urlty'] = 'fun88';
							$odds[$id]['uptime'] = date('Y-m-d H:i:s');
						}
					}
				}
			}
		}
		return $odds;
	}
	//抓取主客队名称过滤
	public function getTeam($name){
		//普马斯吉内拉雷拿 (中)
		preg_match('/(.*)\((.*)\)/',$name,$team1); 
		if(isset($team1[1])&&$team1[1]){
			$name = trim($team1[1]);
		}
		//普马斯吉内拉雷拿 -(中)
		preg_match('/(.*)\-(.*)/',$name,$team2); 
		if(isset($team2[1])&&$team2[1]){
			$name = trim($team2[1]);
		}
		return $name;
	}
}