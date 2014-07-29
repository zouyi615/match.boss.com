<?php
class Jcpublic{
	
	public function getMatchData($playtype='spf',$ggtype='2'){
		header("content-type:text/html; charset=utf-8");
		$ret = array('match'=>array(), 'league'=>array());
		$count_end  = 0; //已截止场数
		$count_rq   = 0; //让球场数
		$count_norq = 0;
		$url = $url?$url:'http://trade.500.com/static/public/jczq/xml/match/match.xml';
		$content = @file_get_contents($url);
		$xml = @simplexml_load_string($content);
		if($xml){
	    	$lea = $xml->xpath('//leagues/league');
		    foreach($lea as $l){
		        $ret['league'][] = $l['name'];
		    }
		    $matchdates = $xml->xpath('//matches/matchdate');
			$count_all = count($matchdates);
			$arrPl = $this->getPL($playtype,$ggtype);
			foreach($matchdates as $key=>$date){
				$dat = $date->xpath('match');				
				$title = $date['date'].' '.$date['dayofweek'];
				$date = date('Ymd',strtotime($date['date']));
	            foreach($dat as $da){
	            	$id = isset($da['id'])?strval($da['id']):'';
	            	$isshow = isset($da['isshow'])?(string)$da['isshow']:'';
	            	if($isshow || !$now){
				    	$count_active++;	
				    	$rq = isset($da['rangqiu'])?strval($da['rangqiu']):0;
						if($rq != 1) continue; //只获取让1球的比赛
				    	$matchnum = isset($da['matchnum'])?strval($da['matchnum']):'';
						$league = isset($da['league'])?strval($da['league']):'';
						$simpleleague = isset($da['simpleleague'])?strval($da['simpleleague']):'';
						$homename = isset($da['homename'])?strval($da['homename']):'';
						$homesxname = isset($da['homesxname'])?strval($da['homesxname']):'';						
						$awayname = isset($da['awayname'])?strval($da['awayname']):'';
						$awaysxname = isset($da['awaysxname'])?strval($da['awaysxname']):'';
				    	$processname = $this->changweekstr($matchnum);
				    	$processdate = isset($da['matchnumdate'])?strval($da['matchnumdate']):'';
						$matchdate = isset($da['matchdate'])?strval($da['matchdate']):'';
						$matchtime = isset($da['matchtime'])?strval($da['matchtime']):'';
						$endtime = isset($da['endtime'])?strval($da['endtime']):'';
						$matchnumdate = isset($da['matchnumdate'])?strval($da['matchnumdate']):'';
						//$ret['match'][$k][$id] = $da;
						$ret['match'][$id]['id'] = $id;
						$ret['match'][$id]['rangqiu'] = $rq;
					    $ret['match'][$id]['isshow'] = $isshow;
					    $ret['match'][$id]['matchnum'] = $matchnum;
						$ret['match'][$id]['league'] = $league;
						$ret['match'][$id]['simpleleague'] = $simpleleague;
						$ret['match'][$id]['homename'] = $homename;
						$ret['match'][$id]['homesxname'] = $homesxname;
						$ret['match'][$id]['awayname'] = $awayname;
						$ret['match'][$id]['awaysxname'] = $awaysxname;
					    $ret['match'][$id]['processname'] = $processname;						
					    $ret['match'][$id]['processdate'] = $processdate;
						$ret['match'][$id]['matchdate'] = $matchdate;
						$ret['match'][$id]['matchtime'] = $matchdate.' '.$matchtime;
						$ret['match'][$id]['endtime'] = $endtime;
						$ret['match'][$id]['matchnumdate'] = $matchnumdate;	
						$ret['match'][$id]['title'] = $title;	
						$ret['match'][$id]['date'] = $date;								
					    if($now && strtotime($matchdate.$matchtime)<time()){ //已截止
					        $ret['match'][$id]['end'] = 1;
					    }else{
					        $ret['match'][$id]['end'] = 0;
					    }
				    }					
	            }
			    if(!$ret['match']){
			        unset($ret['match']);
			    }
			}			
		}
		$today = date("Y-m-d",time());
		ksort($ret['match']);
		var_dump($ret['match']);
		//return $ret;
	}

	/**
	 * 获取所有比赛最新赔率
	 */
	public function getPL($playType='spf',$ggType=2){		
		$peilvs = array();
		$fn = 'http://trade.500.com/static/public/jczq/xml/pl/pl_'.$playType.'_'.$ggType.'.xml';
		$xml = @simplexml_load_string(@file_get_contents($fn));
		if($xml){
			if(in_array($playType,array('spf','nspf'))){
				$ms = $xml->xpath('//m');
				foreach($ms as $m){
					$id = intval($m['id']);
					$peilvs[$id] = $m->row[0];
				}
			}else{
				$ms = $xml->xpath('//m');
				foreach($ms as $m){
					$tmparr = array();
					foreach($nodes as $n){
						$tmparr[] = floatval(strval($m[$n]));
					}
					$id = intval($m['id']);
					$peilvs[$id] = $m;
					$peilvs[$id]['odds'] = implode(',',$tmparr);
				}
			}
		}
		var_dump($peilvs);
		return $peilvs;
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
	//curl请求
	public function curl($url,$host = ""){
        set_time_limit(0);         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url); // 要访问的地址
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // 获取的信息以文件流的形式返回                    
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);// 使用自动跳转    
        curl_setopt($ch, CURLOPT_HEADER, 0);  // 显示返回的Header区域内容    
        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");   // 模拟用户使用的浏览器
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            "User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; TheWorld)",
            "Accept-Language: en",
            "Host:".$host
        ));
        curl_setopt($ch, CURLOPT_REFERER, "http://".$host);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}
?>