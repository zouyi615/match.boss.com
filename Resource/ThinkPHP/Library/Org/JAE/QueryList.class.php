<?php
	/**
	 * QueryList
	 * 一个基于phpQuery的通用列表采集类   
	 */
	require('phpQuery/phpQuery.php');
	class QueryDomcument{		
		private $url;
		private $tags = array();
		public  $jsonarr = array();
		public  $jsonstr = '';
		private $block;
		private $html;
		private $basecoding;
		private $encoding;
		/**
		 * 构造函数
		 * @param string $url          要抓取的网页URL地址(支持https);或者是html源代码
		 * @param string $block       【块选择器】：指 先按照规则 选出 几个大块 ，然后再分别再在块里面 进行相关的选择
		 * @param array  $tags        【块元素选择器】说明：格式array("名称"=>array("选择器","返回类型"),.......),【类型】说明：值 "text" ,"html" ,"属性" 		 
		 * @param string $filetype    【源码获取方式】指是通过curl抓取源码，还是通过file_get_contents抓取源码
		 * @param string $encoding    【输出编码格式】指要以什么编码输出(UTF-8,GB2312,.....)，防止出现乱码,如果设置为 假值 则不改变原字符串编码
		 */
		public function QueryList($url,$block="body",$tags=array(),$encoding="utf-8"){
			$this->encoding = $encoding;
			$this->block = $block;
			$this->tags = $tags;
			if($this->isURL($url)){
				$this->url = $url;
				//if(strpos($url,'http://') === 0){
				if(true){
		       	 	//为了能获取https
					set_time_limit(0);         
					$HTTP_SESSION = $this->_rand();
				   	$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$this->url); // 要访问的地址
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // 对认证证书来源的检查
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // 获取的信息以文件流的形式返回					
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);// 使用自动跳转	
					curl_setopt($ch, CURLOPT_HEADER, 0);  // 显示返回的Header区域内容	
					curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");   // 模拟用户使用的浏览器
					/*curl_setopt($ch,CURLOPT_HTTPHEADER,array(
					         "User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; TheWorld)",
					         "Accept-Language: en",
					         "Host:sports1.im.fun88.com"
					    ));	*/		
					curl_setopt($ch,CURLOPT_HTTPHEADER,array("Host:sports1.im.fun88.com"));	
					curl_setopt($ch, CURLOPT_REFERER, "http://sports1.im.fun88.com");  	
					curl_setopt($ch,CURLOPT_COOKIE,$HTTP_SESSION);
    					
					$this->html = curl_exec($ch);				
	               		curl_close($ch);
	               		echo $this->html;exit;
		        }else{
		       		$this->html = file_get_contents($this->url);
		       		$this->html = iconv("gb2312","utf-8",$this->html);		       		
		        }
		 	}else{
		 		$this->html = $url;
		 	}
	       	if($this->html){
			   	//获取编码格式
			   	$this->basecoding = $this->getEncode($this->html);
				if(!empty($tags)){
					return $this->getList();
				}else{
					return $this->jsonstr;
				}
			}else{
				return $this->jsonstr;
			}
		}

		public function setQuery($regArr,$regRange='')
		 {
			 $this->jsonarr=array();
			 $this->regArr = $regArr;
			 $this->regRange = $regRange;
			 $this->getList();
	     }


	    private function getList(){
	    	//phpQuery::$defaultCharset = "GBK";
	    	//$this->html = mb_convert_encoding($this->html ,"UTF-8","GBK");
	    	echo $this->html; exit; 
           	$obj = phpQuery::newDocumentHTML($this->html);
           	
           	//$robj = pq('#livescore_table')->html();
           	$robj = pq($obj)->find($this->block);
           	
           	//$this->block 不允许为空，一定是某一块的元素内容
		  	$i=0;
		 	foreach($robj as $item){

			 	while(list($key,$value) = each($this->tags)){				 		
				 	$iobj = pq($item)->find($value[0]);					
				   	switch($value[1]){
					   	case 'text':
					   		$this->jsonarr[$i][$key] = $this->convertEncoding(pq($iobj)->text());
							break;
			           	case 'html':
					  		$this->jsonarr[$i][$key] = $this->convertEncoding(pq($iobj)->html());
							break;
					   	default:
					   		$this->jsonarr[$i][$key] = $this->convertEncoding(pq($iobj)->attr($value[1]));
							break;						   
					}
				}
			 	//重置数组指针
			 	reset($this->tags);
			 	$i++;
		  	}		  	
			//编码转换
			//$this->jsonarr = $this->array_convert_encoding($this->jsonarr,$this->basecoding,$this->encoding);
			return $this->jsonarr;
		 }	
		public function getJSON()
		 {
			 return json_encode($this->jsonArr);
		 } 
		/**
		 * 获取文件编码
		 * @param $string
		 * @return string
		 */
		private function getEncode($string){
			//return mb_detect_encoding($string,auto);
		    return mb_detect_encoding($string, array('ASCII','GB2312','GBK','UTF-8')); 
		}

		/**
		 * 转换输出编码编码格式固定utf-8
		 * @param  array $arr           
		 * @param  string $to_encoding   
		 * @param  string $from_encoding 
		 * @return array                
		 */
		private function convertEncoding($str,$to_encoding="utf-8",$from_encoding=""){
			$from_encoding = strtolower($this->basecoding);
			$to_encoding = strtolower($this->encoding);			
			if($from_encoding != "utf-8"){
				$str = mb_convert_encoding($str,$to_encoding,$from_encoding);

			}		
		    return $str;
		}

		/**
		 * 简单的判断一下参数是否为一个URL链接
		 * @param  string  $str 
		 * @return boolean      
		 */
		private function isURL($str){
			if(preg_match('/^http(s)?:\/\/.+/', $str)){
				return true;
			}
			return false;
		}

		function _rand() {
			$length=26;        
			$chars = "0123456789abcdefghijklmnopqrstuvwxyz";        
		    	$max = strlen($chars) - 1;        
		    	mt_srand((double)microtime() * 1000000);        
		    	$string = '';        
		    	for($i = 0; $i < $length; $i++) {        
		        	$string .= $chars[mt_rand(0, $max)];        
		    	}        
		   	return $string;        
		}        
		
}