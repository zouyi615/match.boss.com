<?php
class Jcpublic{	
	//获取竞彩xml
	public function getMatchData($playtype='spf',$ggtype='2'){
		header("content-type:text/html; charset=utf-8");
		$ret = array('match'=>array(), 'league'=>array());
		$count_end  = 0; //已截止场数
		$count_rq   = 0; //让球场数
		$count_norq = 0;
		$url = 'http://trade.500.com/static/public/jczq/xml/match/match.xml';
		$content = @file_get_contents($url);
		$xml = @simplexml_load_string($content);
		if($xml){	    	
		    $matchdates = $xml->xpath('//matches/matchdate');
			$i = 0;
			foreach($matchdates as $key=>$date){
				$dat = $date->xpath('match');				
				$date = date('Ymd',strtotime($date['date']));
	            foreach($dat as $da){
	            	$id = isset($da['id'])?strval($da['id']):'';
	            	$isshow = isset($da['isshow'])?(string)$da['isshow']:'';
	            	if($isshow){
				    	$count_active++;	
				    	$rq = isset($da['rangqiu'])?strval($da['rangqiu']):0;
						if(abs($rq) != 1) continue; //只获取让1球的比赛
				    	$matchnum = isset($da['matchnum'])?strval($da['matchnum']):'';
						$league = isset($da['league'])?strval($da['league']):'';
						$simpleleague = isset($da['simpleleague'])?strval($da['simpleleague']):'';
						$homeid = isset($da['homeid'])?strval($da['homeid']):''; 
						$homename = isset($da['homename'])?strval($da['homename']):'';
						$homesxname = isset($da['homesxname'])?strval($da['homesxname']):'';
						$awayid = isset($da['awayid'])?strval($da['awayid']):''; 						
						$awayname = isset($da['awayname'])?strval($da['awayname']):'';
						$awaysxname = isset($da['awaysxname'])?strval($da['awaysxname']):'';
				    	$processname = $this->changweekstr($matchnum);
						$matchdate = isset($da['matchdate'])?strval($da['matchdate']):'';
						$matchtime = isset($da['matchtime'])?strval($da['matchtime']):'';
						$endtime = isset($da['endtime'])?strval($da['endtime']):'';
						$ret['match'][$i]['id'] = $id;
						$ret['match'][$i]['rq'] = $rq;
					    $ret['match'][$i]['isshow'] = $isshow;
					    $ret['match'][$i]['matchnum'] = $matchnum;
						$ret['match'][$i]['league'] = $league;
						$ret['match'][$i]['simpleleague'] = $simpleleague;
						$ret['match'][$i]['homeid'] = $homeid;
						$ret['match'][$i]['homename'] = $homename;
						$ret['match'][$i]['homesxname'] = $homesxname;
						$ret['match'][$i]['awayid'] = $awayid;
						$ret['match'][$i]['awayname'] = $awayname;
						$ret['match'][$i]['awaysxname'] = $awaysxname;
					    $ret['match'][$i]['processname'] = $processname;
						$ret['match'][$i]['matchdate'] = $matchdate;
						$ret['match'][$i]['matchtime'] = $matchdate.' '.$matchtime;
						$ret['match'][$i]['endtime'] = $endtime;
					    if(strtotime($ret['match'][$i]['matchtime']) < strtotime("+10 minutes")){ //比赛前10分钟截止
					        $ret['match'][$i]['isend'] = 1;
					    }else{
					        $ret['match'][$i]['isend'] = 0;
					    }
						$ret['match'][$i]['uptime'] = date('Y-m-d H:i:s');
						$i++;
				    }
	            }
			    if(!$ret['match']){
			        unset($ret['match']);
			    }
			}			
		}
		$today = date("Y-m-d",time());
		ksort($ret['match']);
		return $ret;
	}
	/**
	 * 获取所有比赛最新赔率
	 */
	public function getSp($playType='spf',$ggType=2){		
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
		return $peilvs;
	}	
	/**
	 * 获取500欧赔赔率
	 */
	public function getOdds500(){
		$pl_odds = array();
		$fn = 'http://trade.500.com/static/public/jczq/xml/odds/odds.xml';
		$xml = @simplexml_load_string(@file_get_contents($fn));		
		if($xml){
			$match = $xml->matches;
			if($match){
				$odds = $match->xpath('//match');
				foreach($odds as $d){
					$id = intval($d['id']);
					$pl_odds[$id]['wl'] = $d->europe['wl'];
					$pl_odds[$id]['hg'] = $d->europe['hg'];					
				}
			}
		}
		return $pl_odds;
	}
	/**
	 * 获取球探网欧赔赔率(利记31,明陞17,金宝博23)
	 */
	public function getOddsQt(){
		//公共变量
		$splitDomain = "$";
		$splitRecord = ";";
		$splitColumn = ",";
		$pl_odds = $match = $msheng_odds = array(); 
		//抓取利记(31),明陞(17)
		$ty = array('jinbb'=>23,'msheng'=>17);
		$url_jinbb = "http://61.143.225.74:88/xml/Odds2.aspx?companyid=23&".time();
		$url_msheng = "http://61.143.225.74:88/xml/Odds2.aspx?companyid=17&".time();
		$host = "61.143.225.74:88";
		$time1 = microtime(true);
		$str_jinbb = $this->curl($url_jinbb,$host); 
		$str_msheng = $this->curl($url_msheng,$host);
		$time2 = microtime(true);
		//明陞
		if($str_jinbb){
			$domains = explode($splitDomain,$str_jinbb); 
			//赔率，数据重组
			$oddsDomain = explode($splitRecord,$domains[3]);
			for($i = 0; $i < count($oddsDomain); $i++){
				$infoArr = explode($splitColumn,$oddsDomain[$i]);
				$id	= $infoArr[0];
				$cId = $infoArr[1];
				if($cId == $ty['jinbb']){
					$jinbb_odds[$id]['jinbb'] = $infoArr[5].','.$infoArr[6].','.$infoArr[7];
				}
			}
		}
		$time3 = microtime(true);
		//利记
		if($str_msheng){
			$domains = explode($splitDomain,$str_msheng); 
			//联赛
			$leagueDomain = explode($splitRecord,$domains[0]);
			for($i = 0; $i < count($leagueDomain); $i++){
				$infoArr = explode($splitColumn,$leagueDomain[$i]);
				$id = $infoArr[0];
				$league[$id] = $infoArr[3];
			}
			$time4 = microtime(true);
			//队名
			$matchDomain = explode($splitRecord,$domains[1]);
			for($i = 0; $i < count($matchDomain); $i++){
				$infoArr = explode($splitColumn,$matchDomain[$i]);
				$id = $infoArr[0];
				$match[$id]['time'] = date('Y-m-d H:i:s',substr($infoArr[2],0,10));
				$match[$id]['league'] = $league[$infoArr[1]];
				$match[$id]['hname'] = $infoArr[5];
				$match[$id]['aname'] = $infoArr[10];	
			}
			$time5 = microtime(true);
			//赔率，数据重组
			$oddsDomain = explode($splitRecord,$domains[3]); 
			for($i = 0; $i < count($oddsDomain); $i++){
				$infoArr = explode($splitColumn,$oddsDomain[$i]);
				$id	= $infoArr[0];
				$cId = $infoArr[1];
				if($cId == $ty['msheng']){
					$pl_odds[$id]['oid'] = $infoArr[0];
					$pl_odds[$id]['matchtime'] = $match[$id]['time'];					
					$pl_odds[$id]['league'] = $match[$id]['league'];
					$pl_odds[$id]['hname'] = $match[$id]['hname'];
					$pl_odds[$id]['aname'] = $match[$id]['aname'];
					$pl_odds[$id]['msheng'] = $infoArr[5].','.$infoArr[6].','.$infoArr[7];
					$pl_odds[$id]['jinbb'] = isset($jinbb_odds[$id]['jinbb'])?$jinbb_odds[$id]['jinbb']:'';					
					$pl_odds[$id]['urlty'] = 'qiutan';
					$pl_odds[$id]['uptime'] = date('Y-m-d H:i:s');					
				}elseif(isset($jinbb_odds[$id]['jinbb'])){
					if(isset($pl_odds[$id]['oid'])) continue;
					$pl_odds[$id]['oid'] = $infoArr[0];
					$pl_odds[$id]['matchtime'] = $match[$id]['time'];					
					$pl_odds[$id]['league'] = $match[$id]['league'];
					$pl_odds[$id]['hname'] = $match[$id]['hname'];
					$pl_odds[$id]['aname'] = $match[$id]['aname'];
					$pl_odds[$id]['msheng'] = '';
					$pl_odds[$id]['jinbb'] = $jinbb_odds[$id]['jinbb'];					
					$pl_odds[$id]['urlty'] = 'qiutan';
					$pl_odds[$id]['uptime'] = date('Y-m-d H:i:s');
				}
			}
			$time6 = microtime(true);
		}
		//echo json_encode(array('geturl'=>($time2-$time1),'getmsheng'=>($time3-$time2),'league'=>($time4-$time3),'match'=>($time5-$time4),'odds'=>($time6-$time5)));
		return $pl_odds;
	}
	//从n个字符串中取m个字符的所有组合
	public function getCombine($arr,$m = 2){
		$result = array();
		if($m ==1){
		   return $arr;
		}
		if(empty($arr)){
			return $arr;
		}
		if($m == count($arr)){
			$result[] = implode(',' , $arr);
			return $result;
		}
		$temp_firstelement = $arr[0];
		unset($arr[0]);
		$arr = array_values($arr);
		$temp_list1 = $this->getCombine($arr, ($m-1));
		foreach ($temp_list1 as $s){
			$s = $temp_firstelement.','.$s;
			$result[] = $s; 
		}
		unset($temp_list1);
		$temp_list2 = $this->getCombine($arr, $m);
		foreach($temp_list2 as $s){
			$result[] = $s;
		}    
		unset($temp_list2);
		return $result;
	}

	//获取时间到毫秒
	function mic_time(){
		$mictime = microtime();
		$arr_time = explode(' ', $mictime);
		$mtime = intval($arr_time[0]*1000);
		return date("mdHis").$mtime;
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
	//获取最小值
	public function getMin($str){		
		$array = explode(',',$str);
		return min($array);
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
	
	//curl请求
	public function curlget($url,$host = ""){
        set_time_limit(0);         
        $ch = curl_init();
		$headers['CLIENT-IP'] = '61.143.225.74:88'; 
		$headers['X-FORWARDED-FOR'] = '61.143.225.74:88';

		$headerArr = array(); 
		foreach( $headers as $n => $v ) { 
			$headerArr[] = $n .':' . $v;  
		}
        curl_setopt($ch, CURLOPT_URL,$url); // 要访问的地址
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // 获取的信息以文件流的形式返回                    
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);// 使用自动跳转    
        curl_setopt($ch, CURLOPT_HEADER, 0);  // 显示返回的Header区域内容    
		//curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );  // Header区域内容    
        //curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");   // 模拟用户使用的浏览器
       curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            "Accept:*/*",
			//"Accept-Encoding:gzip,deflate,sdch",
			//"Accept-Language:zh-CN,zh;q=0.8",
			"Cache-Control:max-age=0",
			"Connection:keep-alive",
			"Cookie:cck_lasttime=1408724480954; cck_count=0; Cookie=0^0^0",
			"Host:61.143.225.74:88",
			"Referer:http://61.143.225.74:88/company.aspx?id=31",
			"User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36"
        ));
        curl_setopt($ch, CURLOPT_REFERER, "http://".$host);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}
?>