<?php
//对阵处理类文件
namespace Home\Controller;
use Think\Controller;

header("Content-type:text/html;charset=UTF-8");
import('Libs.Public.Function');//公用函数

class MatchController extends Controller {
	public $out = array("code"=>-100,"msg"=>"");
	/*{{{显示页面*/
	//对阵管理页面
	public function index(){
		checklogin();//检测登录 
		$m = M('match');
		$t = M('team');
		$h = $m->getField('homeid',true);
		$a = $m->getField('awayid',true);
		$rsMat = $m->alias('m')->field('m.id,m.matchnum,m.homeid,m.homename,m.awayid,m.awayname,m.matchtime,m.endtime,m.simpleleague,m.homename,m.awayname,p.sp,p.fun88,p.rq,p.isend,p.uptime,bm.isban')->join('LEFT JOIN __PL__ p ON m.id = p.id LEFT JOIN __BANMATCH__ bm ON m.id = bm.mid')->order('m.matchtime')->select();
		$rsTeam = $this->getTeamById(array_merge($h,$a));
		$this->assign('rsTeam',$rsTeam); 
        $this->assign('rsMat',$rsMat);
        $this->display();
	}
	//外围赔率显示页面
	public function odds(){
		$o = M('odds');		
		$odds = $o->order('matchtime')->select();
		$this->assign('odds',$odds); 
        $this->display();
	}
	//主客队匹配显示页面
	public function team(){
		$t = M('team');
		$team = $t->select();
		$this->assign('team',$team); 
        $this->display();
	}
	//查看禁止匹配列表
	public function showblist(){
		//禁止匹配场次（该场所有匹配禁止）
		$bm = M('banmatch');
		$banmatch = $bm->alias('bm')->field('bm.mid,bm.matchtime,bm.simpleleague,bm.team,bm.oteam,bm.isban,bm.uptime,p.sp,p.fun88')->join('LEFT JOIN __PL__ p ON bm.mid = p.id')->order('bm.mid')->select();
		$this->assign('banmatch',$banmatch); 
		//禁止匹配，配对场次（该匹配场次禁止）
		$lb = M('listban');
		$m = M('match');
		$p = M('pl');
		$lbarr = $lb->select();
		$listban = $midArr = array();
		if($lbarr){
			foreach($lbarr as $val){
				$midArr[] = $val['m1id'];
				$midArr[] = $val['m2id'];
			}
		}
		$map['id']  = array('in',$midArr);
		$match = $m->where($map)->getField('id,homename,awayname,matchtime,simpleleague');
		$pl = $p->where($map)->getField('id,sp,fun88');
		if($lbarr){
			foreach($lbarr as $key=>$val){
				$listban[$key]['m1'] = $match[$val['m1id']] + $pl[$val['m1id']];
				$listban[$key]['m2'] = $match[$val['m2id']] + $pl[$val['m2id']];		
			}
		}
		$this->assign('listban',$listban);
        $this->display();
	}
	/*}}}*/
	/*{{{获取赔率*/
	//获取初始xml数据
	public function curlXml(){
		import('Libs.Trade.Jcpublic');//公用函数
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
	//获取中国竞彩网初始数据(中国竞彩网)
	public function curlJcXml(){
		import('Libs.Trade.Jcpublic');//公用函数
        $jc = new \Jcpublic();
        $match = $jc->getJcMatchData();
		if(!empty($match)){
			$m = M('match');
			$p = M('pl');
			$m->where('1')->delete();
			$rs = $m->addAll($match['match']);
			if($rs){
				$p->where('1')->delete();
				$p->field('id,rq,sp,isend')->addAll($match['match']);
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
	//获取外围赔率 乐天堂 体育
	public function curlOdds(){	
		import('Libs.Trade.Jcpublic');//公用函数
		$jc = new \Jcpublic();
		/*{{{设置cookie*/
		$url = 'http://sports.fun166.com/vender.aspx?lang=cs&act=sportsbook&menutype=0&market=T';
		$jc->setCookie($url);
		/*}}}*/
		/*{{{获取返回*/
		$urls = array();
		//乐天堂体育
		$fun_sp_url_1 = 'http://sports.fun166.com/1X2_data.aspx?Sport=1&Market=t&RT=W&CT=&Game=0&OrderBy=0';//今日		
		$fun_sp_url_2 = 'http://sports.fun166.com/1X2_data.aspx?Sport=1&Market=e&RT=W&CT=&Game=0&OrderBy=0';//早盘
		$urls = array($fun_sp_url_1,$fun_sp_url_2);
		$time0 = microtime(true);
		$content = $jc->curlMultiOdds($urls);
		//获取数据库结果
		$pl_odds = array();
		$time1 = microtime(true);
		foreach($content as $key=>$ntstring){
			preg_match_all("/Nt\[\d+\]=\[(.*?)\]/",$ntstring,$match);
			
			//Nt[0]=[];
			var_dump($match[$key]);exit;
		}
		
		/*}}}*/
		
	}
	//获取外围赔率 乐天堂 IM体育
	public function curlOddsIM(){
		import('Libs.Trade.Jcpublic');//公用函数
		$jc = new \Jcpublic();
		//乐天堂IM体育
		$fun_im_url_1 = 'http://sports1.im.fun166.com/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=0&LeagueIdList=-1&SortingType=0&OddsType=1&UserTimeZone=-480&Language=1&FilterDay=1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=0&OddsPageCode=1&ViewType=0&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0';//今日
		$fun_im_url_2 = 'http://sports1.im.fun166.com/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=2&LeagueIdList=-1&SortingType=0&OddsType=0&UserTimeZone=-480&Language=1&FilterDay=-1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=2&OddsPageCode=1&ViewType=0&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0';//早盘
		$urls = array($fun_im_url_1,$fun_im_url_2);
		//获取返回
		$content_IM = $jc->curlMultiOddsIM($urls); 
		//获取数据库结果
		$pl_odds = array();
		$time1 = microtime(true);
		foreach($content_IM as $key=>$spJson){
			$spArr = (array)json_decode($spJson);
			$pl_odds += $this->getOddsIMArr($spArr['d']);		
		}
		$time3 = microtime(true);
		$o_im = M('odds_im');
		if($pl_odds){
			$o_im->where('1')->delete(); 
			$rs = $o_im->addAll(array_values($pl_odds));
			$time4 = microtime(true);
			if($rs){
				$this->out['code'] = 100;
				$this->out['msg'] = 'suc';
				$this->out['info'] = array('uptime'=>date('Y-m-d H:i:s'),'num'=>$rs,'oddscost1'=>($time2-$time1),'oddscost2'=>($time3-$time2),'addcost'=>($time4-$time3));
			}else{
				$this->out['msg'] = '获取IM赔率失败！';
			}
		}else{
			$this->out['msg'] = '获取IM数据为空！';
		}
		echo json_encode($this->out);
		exit;
	}	
	//更新赔率
	public function getPl(){
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
		$mInfo = $m->getField('id,rq,homeid,homename,awayid,awayname,matchtime,endtime');
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
				if(strtotime($val['endtime']) < strtotime("+10 minutes")){				
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
	//获取中国竞彩网初始数据(中国竞彩网)
	public function getJcPl(){
		$newplArr = array();
		//获取数据库信息
		$m = M('match');
		$o_im = M('odds_im');
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
		$oInfo = $o_im->field('oid,hname,aname,fun88,matchtime')->where($map)->select(); 
		$time2_o = microtime(true);
		//获取对阵信息
		$mInfo = $m->getField('id,rq,homeid,homename,awayid,awayname,matchtime,endtime');
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
				//比赛已经截止 不抓赔率 (竞彩官网提前10分钟截止)
				if(strtotime($val['endtime']) < strtotime("+10 minutes")){				
					$newplArr[$i]['isend'] = 1;
				}else{
					//乐天堂对应队名
					$fun_hname = isset($mTeam[$val['homeid']])?$mTeam[$val['homeid']]:''; //主队
					$fun_aname = isset($mTeam[$val['awayid']])?$mTeam[$val['awayid']]:''; //客队
					foreach($oInfo as $k=>$v){
						//匹配对应场次，首先根据日期匹配，其次根据主客队名匹配
						//两场比赛时间差允许超过一小时
						if(abs(strtotime($val['matchtime']) - strtotime($v['matchtime'])) > 1*60*60) continue;
						if($fun_hname == $v['hname'] && $fun_aname == $v['aname']){						
							$newplArr[$i]['fun88'] = $v['fun88'];
							$newplArr[$i]['ismat'] = 1; //是否匹配
							break;
						}
					}
				}
				$newplArr[$i]['uptime'] = date('Y-m-d H:i:s');
				$rr = $p->field('id,rq,fun88,ismat,uptime')->save($newplArr[$i]);
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
	/*}}}*/
	/*{{{操作*/
	//添加禁止匹配对阵列表
	public function listBan(){
		$lb = M('listban');
		$arr = array();
		$m1id = I('param.m1id','','htmlspecialchars'); //场次ID
		$m2id = I('param.m2id','','htmlspecialchars'); //场次ID
		$uptime = date('Y-m-d H:i:s');
		$arr = array(
			'm1id' => $m1id,
			'm2id' => $m2id,
			'uptime' => $uptime,
		);
		$r = $lb->data($arr)->add();
		$this->out['code'] = 100;
		$this->out['msg'] = $r;			
		$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$r);		
		echo json_encode($this->out); exit;
	}
	//切换匹配状态
	public function teamBan(){
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
	//删除 禁止匹配场次（该场所有匹配禁止）
	public function delBanmatch(){
		$bm = M('banmatch');
		$mid = I('param.id','','htmlspecialchars'); //场次ID
		$map['mid']  = $mid;
		$rs = $bm->where($map)->delete(); 
		if($rs >= 0){
			$this->out['code'] = 100;
			$this->out['msg'] = '删除成功';
		}else{
			$this->out['code'] = -100;
			$this->out['msg'] = '删除失败，请稍后再试';	
		}
		$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$rs);		
		echo json_encode($this->out); exit;	
	}
	//删除禁止匹配，配对场次（该匹配场次禁止）	
	public function delListban(){
		$lb = M('listban');
		$m1id = I('param.m1id','','htmlspecialchars'); //场次ID
		$m2id = I('param.m2id','','htmlspecialchars'); //场次ID
		$map['m1id']  = $m1id;
		$map['m2id']  = $m2id;
		$rs = $lb->where($map)->delete(); 
		if($rs >= 0){
			$this->out['code'] = 100;
			$this->out['msg'] = '删除成功';
		}else{
			$this->out['code'] = -100;
			$this->out['msg'] = '删除失败，请稍后再试';	
		}
		$this->out['info'] = array('time'=>date('Y-m-d H:i:s'),'num'=>$rs);		
		echo json_encode($this->out); exit;	
	}
	//批量更新球队名匹配
	public function teamUpAll(){
		//获取数据库信息
		$m = M('match');
		$o_im = M('odds_im');
		$t = M('team');
		//获取竞彩对阵信息
		$mInfo = $m->getField('id,homeid,homename,awayid,awayname');
		//获取外围场次信息		
		$map['urlty'] = 'fun88';
		$oddInfo = $o_im->field('hname,aname')->where($map)->select();
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
	/*}}}*/
	/*{{{公用函数*/
	//乐天堂 赔率组合函数
	public function getOddsIMArr($odd){
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
	/*}}}*/
}