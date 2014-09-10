<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function test(){
		header("Content-type:text/html;charset=UTF-8");
		$str = '普马斯吉内拉雷拿 (中)';
		$pt = '/(.*)\-\((.*)\)/';
		preg_match($pt,$str,$team);
		var_dump($team,trim($team[1]));
	}
	//首页加载匹配对阵
    public function index(){
        header("Content-type:text/html;charset=UTF-8");  	
		$match = $this->queryMatch(); 
		$match = $this->array2_sort($match,'rate',SORT_DESC,SORT_STRING); //二维数组排序
        $this->assign('match',$match);
        $this->display('index');
    }	
	//查询数据库获取匹配match
	public function queryMatch(){
		header("Content-type:text/html;charset=UTF-8");   
		$p = M('pl');
		$match = array();
		$rs = $p->alias('p')->field('m.id,m.matchtime,m.simpleleague,m.homename,m.awayname,p.rq,p.sp,p.fun88,p.uptime')->join('LEFT JOIN __MATCH__ m ON p.id = m.id')->where('p.ismat=1 and p.isend=0')->select();	
		if($rs){
			foreach($rs as $key=>$val){
				$sp = '';
				$wl_r = $hg_r = 0;
				$id = $val['id'];
				$rq = $val['rq'];
				$spA = isset($val['sp'])?explode(',',$val['sp']):array();
				if($rq == "-1"){
					$sp = isset($spA[2])?$spA[2]:'';
				}elseif($rq == "1"){
					$sp = isset($spA[0])?$spA[0]:'';
				}
				if(!$sp) continue;
				$fun88 = $this->getMin($val['fun88']);  //利记赔率最小值
				if(!$fun88) continue;				
				$rate = sprintf("%.6f",1/(1/$fun88+1/$sp)); //计算匹配回报率(乐天堂)				
				$match[$id] = $val;
				$match[$id]['w'] = $sp; //竞彩受让方赔率
				$match[$id]['fun'] = $fun88;
				$match[$id]['rate'] = $rate; //匹配回报率
			}
		}		
		return $match;
	}
	//计算匹配
    public function getMatch(){
		header("Content-type:text/html;charset=UTF-8");
		import('Libs.Trade.Jcpublic');
		$jc = new \Jcpublic();
		$irate = I('param.rnrate','','htmlspecialchars'); //用户设置赔率
		$topnum = I('param.topnum','0','htmlspecialchars'); //获取最大显示数目		
		$match = $comMatchArr = array(); 
		$match = $this->queryMatch();  
		$midArr = array();
		foreach($match as $key=>$val){
			$midArr[] = $val['id'];
		}
		$rscom = $jc->getCombine($midArr,2);
		$i = 0;
		foreach($rscom as $key=>$val){
			$v = explode(',',$val);
			$m1 = $v[0]; $m2 = $v[1];
			$timediff = abs(strtotime($match[$m2]['matchtime']) - strtotime($match[$m1]['matchtime'])); //两场比赛时间差
			//两场比赛时间间隔>6小时
			if($timediff < 6*60*60){
				continue;
			}
			$rnrate = strval(sprintf("%.6f",$match[$m1]['rate']+$match[$m2]['rate'])); //bet365返还率
			if($rnrate < $irate) continue; //计算返还率<设置赔率值
			$comMatchArr[$i]['rnrate'] = $rnrate; //返还率
			$comMatchArr[$i]['m1']['id'] = $match[$m1]['id'];
			$comMatchArr[$i]['m1']['matchtime'] = $match[$m1]['matchtime'];
			$comMatchArr[$i]['m1']['simpleleague'] = $match[$m1]['simpleleague'];
			$comMatchArr[$i]['m1']['homename'] = $match[$m1]['homename'];
			$comMatchArr[$i]['m1']['awayname'] = $match[$m1]['awayname'];
			$comMatchArr[$i]['m1']['w'] = $match[$m1]['w'];
			$comMatchArr[$i]['m1']['fun'] = $match[$m1]['fun'];
			$comMatchArr[$i]['m1']['rate'] = $match[$m1]['rate'];
			$comMatchArr[$i]['m2']['id'] = $match[$m2]['id'];
			$comMatchArr[$i]['m2']['matchtime'] = $match[$m2]['matchtime'];
			$comMatchArr[$i]['m2']['simpleleague'] = $match[$m2]['simpleleague'];
			$comMatchArr[$i]['m2']['homename'] = $match[$m2]['homename'];
			$comMatchArr[$i]['m2']['awayname'] = $match[$m2]['awayname'];
			$comMatchArr[$i]['m2']['w'] = $match[$m2]['w'];
			$comMatchArr[$i]['m2']['fun'] = $match[$m2]['fun'];
			$comMatchArr[$i]['m2']['rate'] = $match[$m2]['rate'];
			$i++;			
		}
		$comMatchArr = $this->array2_sort($comMatchArr,'rnrate',SORT_DESC,SORT_STRING);
		return $comMatchArr;
    }
	//加载匹配对阵
	public function matching(){
		header("Content-type:text/html;charset=UTF-8");
		$irate = I('param.rnrate','','htmlspecialchars'); //用户设置赔率
		$betmoney = I('param.betmoney','','htmlspecialchars'); //用户下注金额
		$rebate = I('param.rebate','','htmlspecialchars'); //用户返还金额
		$comMatchArr = $this->getMatch(); //获取对阵数据
		$this->assign('comMatchArr',$comMatchArr);
		$this->assign('irate',$irate);
		$this->assign('betmoney',$betmoney);
		$this->assign('rebate',$rebate);
		$this->display('matching');
	}
	//ajax加载匹配对阵
	public function getAjaxMatch(){
		header("Content-type:text/html;charset=UTF-8");
		$comMatchArr = $this->getMatch(); //获取对阵数据
		echo json_encode($comMatchArr);
	}	
	
	//获取最小值
	public function getMin($str){		
		$array = explode(',',$str);
		return min($array);
	}
	//二维数组排序
	function array2_sort($arr,$key,$order=SORT_ASC,$type=SORT_REGULAR){		
		foreach ($arr as $kk => $vv){
			$data[$kk] = $vv[$key];			
		}
		array_multisort($data,$order,$type,$arr);
		return $arr;
	}
	//三维数组排序	
	function array3_sort($arr,$key,$order=SORT_ASC,$type=SORT_REGULAR){		
		$karr1 = explode('|',$key);
		$karr2 = explode('/',$karr1[1]);
		$key1 = $karr1[0];
		$key2 = $karr2[0];
		$key3 = $karr2[1];	
		foreach ($arr as $k0 => $v0){
			foreach($v0[$key2] as $k1=>$v1){
				$data[$k1] = $v1[$key3];
			}
			array_multisort($data,$order,$type,$v0[$key2]);
			$arr[$k0][$key2] = $v0[$key2];
			$date[$k0] = $v0[$key1];
		}
		array_multisort($date,$order,$type,$arr);
		return $arr;
	}
    public function getOdds(){
        $url = "http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsData2?Market=0";
        $host = "sports1.im.fun88.com";
        $str = $this->getCurl($url,$host);
        $matcharr = (array)json_decode($str);
        $matcharr = $matcharr['d'];
        $data = array();
        foreach($matcharr as $key=>$val){
            
            $lid = $val[0]; //联赛ID
            $ls = $val[1][1]; //联赛名称(取简体中文)
            $match = $val[4];
            foreach ($match as $kk => $vv) {
                $mid = $vv[0]; //场次ID
                $homesxname = $vv[5][1]; //主队名称
                $awaysxname = $vv[6][1]; //客队名称
                $matchtime = $vv[10][0][3]; //比赛时间
                $betodds = array(
                    //赔率$vv[10][6]
                    'rq'=>array($vv[10][0][6][2],$vv[10][0][6][4],$vv[10][0][6][6]),
                    'dx'=>array($vv[10][0][7][2],$vv[10][0][7][4],$vv[10][0][7][6]),
                    //'rq'=>array($vv[10][6][2],$vv[10][6][4],$vv[10][6][6])
                );
                //若该场比赛不属于对应联赛则跳出
                if($lid != $vv[1]){ 
                    continue;
                }
                $data[$mid]['mid'] = $mid;
                $data[$mid]['ls'] = $ls;
                $data[$mid]['homesxname'] = $homesxname;
                $data[$mid]['awaysxname'] = $awaysxname;
                $data[$mid]['matchtime'] = $matchtime;
                $data[$mid]['betodds'] = $betodds;
            }
        }

        $this->assign('data',$data);
        $this->display('index');
        
        //http://match.boss.com/index.php/Home/Index/getOdds    	
    }


    public function getCurl($url,$host){
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