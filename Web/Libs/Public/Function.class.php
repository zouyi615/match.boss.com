<?php
/**
 * 获取IP
 * @return 真实IP地址
 */
function getIP(){
	if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ips = preg_split('/,|\s+/', trim($_SERVER["HTTP_X_FORWARDED_FOR"]));
		if(preg_match('/^(?:\d{1,3}\.){3}\d{1,3}$/',$ips[0]))
		return $ips[0];
	}elseif(isset($_SERVER["HTTP_X_REAL_IP"])){
		if(preg_match('/^(?:\d{1,3}\.){3}\d{1,3}$/',$_SERVER["HTTP_X_REAL_IP"]))
		return $_SERVER["HTTP_X_REAL_IP"];
	}
	return $_SERVER["REMOTE_ADDR"];
}
/*
*设置session过期时间（单位：s）
*/
function start_session($expire = 0){
    if($expire == 0){
        $expire = ini_get('session.gc_maxlifetime');
    }else{
        ini_set('session.gc_maxlifetime', $expire);
    }
    if(empty($_COOKIE['PHPSESSID'])){
        session_set_cookie_params($expire);
        session_start();
    }else{
        session_start();
        setcookie('PHPSESSID', session_id(), time() + $expire);
    }
}
/*
* 获取登录信息
*/
function logstate(){	
	$ret = array('islogin'=>false,'isadmin'=>false, 'func'=>'', 'info'=>'');
	if(session('name')){
		$ckstr = RC4('de@ck',session('ck'));
		list($userid,$username,$userstate,$usertype) = explode('_',$ckstr);
		$ret['islogin'] = true;
		$ret['info'] = $ckstr;
		//管理员用户
		$ret['func'] = 'redirect("/Home/Index/index");';	
	}else{
		$ret['func'] = '';		
	}
	return $ret;
}
/*
*检测登录
*/
function checklogin($type="user"){
	$ret = logstate();	
	if($ret['islogin']){
		if($type == "admin" && !$ret['isadmin']){
			reload('/Home/Index/index');
		}
	}else{
		reload('/Qingworld/Index/login');
	}
}
/*
*获取当前url路径地址
*/
function setUrlCookie(){
	list($m,$a) = explode('/',$_SERVER['PATH_INFO']);
	setcookie("path[m]",$m);
	setcookie("path[a]",$a);
}

/*
*重定向函数
*/
function reload($url){
	header("Location:".$url);
}
/*
*RC4加密解密
*/
function RC4($keystr,$data){
	import('Libs.Public.RC4');
	$rc4 = new \RC4();
	$ret = '';
	list($type,$key) = explode('@',$keystr);
	if($type == 'en'){
		$ret = $rc4->rc4_encode($key,$data);
	}elseif($type == 'de'){
		$ret = $rc4->rc4_decode($key,$data);
	}
	return $ret;
}

/*
* 获取服务器内存使用情况
*/
function get_used_status(){
    $fp = popen('top -b -n 2 | grep -E "^(Cpu|Mem|Tasks)"',"r");//获取某一时刻系统cpu和内存使用情况
    $rs = "";
    while(!feof($fp)){
        $rs .= fread($fp,1024);
    }
    pclose($fp);
    $sys_info = explode("\n",$rs);
    $tast_info = explode(",",$sys_info[3]); //进程 数组
    $cpu_info = explode(",",$sys_info[4]);  //CPU占有量  数组
    $mem_info = explode(",",$sys_info[5]); //内存占有量 数组
    //正在运行的进程数
    $tast_running = trim(trim($tast_info[1],'running')); 
    var_dump($tast_running);
    //CPU占有量
    $cpu_usage = trim(trim($cpu_info[0],'Cpu(s): '),'%us');  //百分比
    //内存占有量
    $mem_total = trim(trim($mem_info[0],'Mem: '),'k total');  
    $mem_used = trim($mem_info[1],'k used');
    $mem_usage = round(100*intval($mem_used)/intval($mem_total),2);  //百分比
    /*硬盘使用率 begin*/
    $fp = popen('df -lh | grep -E "^(/)"',"r");
    $rs = fread($fp,1024);
    pclose($fp);
    $rs = preg_replace("/\s{2,}/",' ',$rs);  //把多个空格换成 “_”
    $hd = explode(" ",$rs);
    $hd_avail = trim($hd[3],'G'); //磁盘可用空间大小 单位G
    $hd_usage = trim($hd[4],'%'); //挂载点 百分比
    //print_r($hd);
    /*硬盘使用率 end*/  
    //检测时间
    $fp = popen("date +\"%Y-%m-%d %H:%M\"","r");
    $rs = fread($fp,1024);
    pclose($fp);
    $detection_time = trim($rs);
    /*获取IP地址  begin*/
    /*
    $fp = popen('ifconfig eth0 | grep -E "(inet addr)"','r');
    $rs = fread($fp,1024);
    pclose($fp);
    $rs = preg_replace("/\s{2,}/",' ',trim($rs));  //把多个空格换成 “_”
    $rs = explode(" ",$rs);
    $ip = trim($rs[1],'addr:');
    */
    /*获取IP地址 end*/
    /*
    $file_name = "/tmp/data.txt"; // 绝对路径: homedata.dat  
    $file_pointer = fopen($file_name, "a+"); // "w"是一种模式，详见后面 
    fwrite($file_pointer,$ip); // 先把文件剪切为0字节大小， 然后写入 
    fclose($file_pointer); // 结束
    */
    return array('cpu_usage'=>$cpu_usage,'mem_usage'=>$mem_usage,'hd_avail'=>$hd_avail,'hd_usage'=>$hd_usage,'tast_running'=>$tast_running,'detection_time'=>$detection_time);
}
?>