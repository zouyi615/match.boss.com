<?php
class Jcpublic{
	public function getMatchData($playtype='',$sdate='',$gggroup=1){
		$ret = array('match'=>array(), 'league'=>array(), 'count'=>array('all'=>0, 'end'=>0, 'rq'=>0, 'norq'=>0));
		$count_end  = 0; //已截止场数
		$count_rq   = 0; //让球场数
		$count_norq = 0;

		if(empty($sdate)){
		    $now = true;
		    $fn = 'http://trade.500.com/static/public/jczq/xml/match/match.xml'; //当前赛程
		}else{
		    $now = false;
		    $fn = 'http://trade.500.com/static/public/jczq/xml/hisdata/'.date('Y/md',strtotime($sdate)).'/match.xml'; //历史赛程
		}

		$content = @file_get_contents($fn);
		$xml = @simplexml_load_string($content);
		if($xml){
	    	$lea = $xml->xpath('//leagues/league');
		    foreach($lea as $l){
		        $ret['league'][] = $l['name'];
		    }
		    $matchdates = $xml->xpath('//matches/matchdate');
			$count_all = count($matchdates);
			//$arr_endtime = getVsEndTime($sdate,$gggroup);
			$k=0;
			foreach($matchdates as $key=>$date){
				$k = date('Ymd',strtotime($date['date']));
				$dat = $date->xpath('match');
				$ret['match'][$k]['title'] = $date['date'].' '.$date['dayofweek'];
				$ret['match'][$k]['date'] = substr($ret['match'][$k]['title'],0,10);
	            $ret['match'][$k]['show'] = 1;
				$ret['match'][$k]['data'] = array();			
				$count_dayend = 0;
	            $count_active = 0;

	            foreach($dat as $da){
	            	$id = intval($da['id']);
	            	$isshow = $da['isshow'];
	            	if($isshow || !$now){
				    	$count_active++;	
				    	$rangqiu = isset($da['rangqiu'])?$da['rangqiu']:0;
				    	$rq = intval(strval($rangqiu));
				    	$matchnum = isset($da['matchnum'])?$da['matchnum']:'';
				    	$processname = $this->changweekstr($matchnum);
				    	$processdate = isset($da['matchnumdate'])?$da['matchnumdate']:'';
						$ret['match'][$k]['data'][$id] = $da;
						$ret['match'][$k]['data'][$id]['rangqiu'] = $rq;
					    $ret['match'][$k]['data'][$id]['isshow'] = (string)$isshow;
					    $ret['match'][$k]['data'][$id]['matchnum'] = (string)$matchnum;
					    $ret['match'][$k]['data'][$id]['processname'] = (string)$processname;						
					    $ret['match'][$k]['data'][$id]['processdate'] = (string)$processdate;
					    $ret['match'][$k]['data'][$id]['matchtime'] = $da['matchdate'].' '.$da['matchtime'];					    
					    if($now && strtotime($ret['match'][$k]['data'][$id]['matchtime'])<time()){ //已截止
					        $count_dayend++;
					        $count_end++;
					        $ret['match'][$k]['data'][$id]['end'] = 1;
					    }else{
					        $ret['match'][$k]['data'][$id]['end'] = 0;
					        if($rq==0){
					            $count_norq++;
					        }else{
					            $count_rq++;
					        }
					    }
				    }
	            }
	            $allend = 0;
				if($count_active == $count_dayend){
				    $allend = 1;
				    $count_end = $count_end-$count_dayend;
				}
				$ret['match'][$k]['allend'] = $allend;
				$ret['match'][$k]['show'] = $ret['match'][$k]['allend'] == 1?0:1;
				$ret['match'][$k]['count_dayend'] = $count_dayend;
			    if(!$ret['match'][$k]['data']){
			        unset($ret['match'][$k]);
			    }
			}

			//如果所有天的场次都截止了，打开最后一天的场次
			$isallend = 1;
			if($ret['match']){
				foreach($ret['match'] as $kk=>$v){
					if($v['allend'] == 0){
						$isallend = 0;
						break;
					}
			    }
			    if($isallend == 1){
			    	$ret['match'][$kk]['show'] = 1;
			    }
			    
			    $ret['count'] = array('all'=>$count_all,'end'=>$count_end,'rq'=>$count_rq,'norq'=>$count_norq);
			}			
		}
		$today = date("Y-m-d",time());
		ksort($ret['match']);
		return $ret;
	}



	/**
	 * 2022换成周二022
	 */
	function changstrweek($str){
		$weekstr = "";
		$n = substr($str,0,1);
		switch($n){
			case 1:
				$weekstr = "周一";
				break;
			case 2:
				$weekstr = "周二";
				break;
			case 3:
				$weekstr = "周三";
				break;
			case 4:
				$weekstr = "周四";
				break;
			case 5:
				$weekstr = "周五";
				break;
			case 6:
				$weekstr = "周六";
				break;
			case 0:	
			case 7:
				$weekstr = "周日";
				break;
		}
		$newstr = $weekstr.substr($str,1,3);
		return $newstr;
	}

	/**
	 * 周二022换成2022
	 */
	function changweekstr($week){
		$weekstr = "";
		$n = mb_substr($week,0,2,'utf-8');
		switch($n)
		{
			case "周一":
				$weekstr = 1;
				break;
			case "周二":
				$weekstr = 2;
				break;
			case "周三":
				$weekstr = 3;
				break;
			case "周四":
				$weekstr = 4;
				break;
			case "周五":
				$weekstr = 5;
				break;
			case "周六":
				$weekstr = 6;
				break;
			case "周日":	
				$weekstr = 7;
				break;
		}
		$newstr = $weekstr.mb_substr($week,2,5,'utf-8');
		return $newstr;
	}
}
?>