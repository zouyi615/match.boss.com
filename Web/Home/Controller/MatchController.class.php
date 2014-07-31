<?php
//对阵处理类文件
namespace Home\Controller;
use Think\Controller;
class MatchController extends Controller {
	//参数
	public $xmlUrl = 'http://trade.500.com/static/public/jczq/xml/match/match.xml'; //对阵xml
	public $xmlspfpl = 'http://trade.500.com/static/public/jczq/xml/pl/pl_spf_2.xml'; //让球胜平负赔率
	public $spUrl = 'http://sb.imsportsbook.com/Fun88/OddsDisplay/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=0&LeagueIdList=-1&SortingType=0&OddsType=1&UserTimeZone=-480&Language=1&FilterDay=1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=1&OddsPageCode=0&ViewType=0&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0'; //外围网站赔率
	public $spHost = 'sb.imsportsbook.com'; //抓取赔率域名
	//处理函数
	public function index(){
		///Date(1406815200000)/
		$ptn = '/Date\((.*)\)/';
		$str = '/Date(1406815200000)/';
		preg_match($ptn,$str,$match);
		var_dump($match);
	}
	//获取初始xml数据
	public function getXml(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
        $match = $jc->getMatchData();
		if($match){
			$m = M('match');
			$m->where('1')->delete();
			$rs = $m->addAll($match['match']);	
			if($rs){
				$pl_tab = array();
				foreach($match['match'] as $key=>$val){
					$pl_tab[$key]['id'] = $val['id'];
					$pl_tab[$key]['rq'] = $val['rangqiu'];
					$pl_tab[$key]['win'] = $val['win'];
					$pl_tab[$key]['date'] = $val['matchtime'];
				}
				if($pl_tab){
					$p = M('peilv');
					$p->where('1')->delete();
					$re = $p->addAll($pl_tab);
				}
				echo "队阵保存成功！";				
			}else{
				echo "对阵保存失败！";
			}
		}
		exit;
		//var_dump(strtotime('2014-07-30 01:30'));
	}
	//更新赔率
	public function getPl(){
		header("Content-type:text/html;charset=UTF-8");
		$newplArr = array();
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
		//获取竞彩赔率
		$plArr = $jc->getPL();
		//获取外围赔率
		$plArr_sp = $this->getSp();
		//获取数据库信息
		$m = M('match');
		$ms = M('match_sp');
		$p = M('peilv');
		$mInfo = $m->getField('id,rangqiu,league,homename,awayname,matchtime');
		$i = 0;
		if($mInfo){
			foreach($mInfo as $key=>$val){
				$newplArr[$i]['id'] = $val['id'];
				if($val['rangqiu'] == "1"){
					$newplArr[$i]['win'] = isset($plArr[$val['id']]['lost'])?strval($plArr[$val['id']]['lost']):'';
				}elseif($val['rangqiu'] == "-1"){
					$newplArr[$i]['win'] = isset($plArr[$val['id']]['win'])?strval($plArr[$val['id']]['win']):'';
				}
				if($newplArr[$i]['win']){
					$p->field(array('id','win'))->save($newplArr[$i]);
				}
				$newplArr[$i]['issp'] = 0;//判断是否有外围赔率
				//匹配外围赔率
				foreach($plArr_sp as $val_sp){
					if($val_sp['matchtime'] == strtotime($val['matchtime'])){
						$newplArr[$i]['issp'] = 1;//有外围赔率,标记为1
						$newplArr[$i]['sid'] = $val_sp['sid'];
						$newplArr[$i]['sp'] = $val_sp['sp'];
						$newplArr[$i]['leagueEn'] = $val_sp['legEn'];
						$newplArr[$i]['leagueCh'] = $val_sp['legCh'];
						$newplArr[$i]['homenameEn'] = $val_sp['homenameEn'];
						$newplArr[$i]['homenameCh'] = $val_sp['homenameCh'];
						$newplArr[$i]['awaynameEn'] = $val_sp['awaynameEn'];
						$newplArr[$i]['awaynameCh'] = $val_sp['awaynameCh'];
						$newplArr[$i]['rangqi'] = $val_sp['rq'];
						$newplArr[$i]['matchtime'] = $val_sp['matchtime'];
						$p->field(array('id','sp'))->save($newplArr[$i]);
						$ms->field(array('sid','rangqi','leagueEn','leagueCh','homenameEn','homenameCh','awaynameEn','awaynameCh','sp','matchtime'))->save($newplArr[$i]);
					}
				}
				$i++;
			}
		}
		//foreach()
		
		var_dump($newplArr);
		//获取外围赔率
		
	}

	//获取外围赔率
	public function getSp(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
		$jc = new \Jcpublic();		
		$spJson = $jc->curl($this->spUrl,$this->spHost);
		$spArr = (array)json_decode($spJson);
		$legEn = $legCh = $homename = $awayname = $sp = $matchtime = '';
		$ptr = '/Date\((.*)\)/';		
		$spMatch = array();
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
								$spMatch[$i]['legEn'] = $val[1][0];
								$spMatch[$i]['legCh'] = $val[1][1];
								$spMatch[$i]['homenameEn'] = $v[5][0];
								$spMatch[$i]['homenameCh'] = $v[5][1];
								$spMatch[$i]['awaynameEn'] = $v[6][0];
								$spMatch[$i]['awaynameCh'] = $v[6][1];
								preg_match($ptr,$v[7],$matchtime);
								$spMatch[$i]['matchtime'] = intval(substr($matchtime[1],0,10));
								$spMatch[$i]['sp'] = $m[6][4];
								$spMatch[$i]['rq'] = 0;
								$i++;
							}else{
								continue;
							}
						}						
					}
				}						
			}		
		}
		//var_dump($spMatch); 
		return $spMatch;
	}
	
}