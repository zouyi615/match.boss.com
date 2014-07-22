<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
	
    	$collect=D('collect');
    	$volist=$collect->select();
    	$this->assign('volist',$volist);
	 $this->display();
    }

    function add(){
    	if (IS_POST) {
    		
    		$collect=D('collect');
    		$_POST['createtime']=mktime();
    		$_POST['updatetime']=mktime();
    		$val=$collect->add($_POST);
    		if ($val) {
    			$this->success('添加采集成',U('Index/index'));
    		}else{
    			$this->error('添加失败');
    		}
    	}else{
    		$this->display();	
    	}
    	
    }
    function collect(){
		
		$collect=D('collect');
		$id=$_GET['id'];
		$vo=$collect->where("id = $id")->find();
		if ($vo['charset']=="UTF-8") {
			 header("Content-type: text/html; charset=utf-8");
		}else{
			 header("Content-type: text/html; charset=GB2312");
		}
		set_time_limit(0);
		import ( "@.ORG.QueryList" );

	    $url=$vo['url'];
	    $title=$vo['list_title'];
	    $href=$vo['list_url'];
		$reg = array("title"=>array($title,"text"),"url"=>array($href,"href"));
		$rang=$vo['list_list'];
		$hj = new QueryList($url,$reg,$rang);
		$arr = $hj->jsonArr;
		foreach ($arr as $k => $v) {
			if(substr($val['url'],0,7) != 'http://'){
				$arr[$k]['url'] = $vo['site'].$v['url'];
			}
			unset($v); // 最后取消掉引用
		}

		array_splice($arr, 10); 
		$doc = phpQuery::newDocument("<div/>");


		$doc["div"]->append("<ul><li>新闻标题</li><li>新闻地址</li></ul>");
		foreach($arr as $key=>$product) {
		    $doc["div ul"]->append("<li>$product[title]</li><li><a href='$product[url]'>$product[url]</a></li>");
		}
		$doc["div"]->attr('style',' text-align:center;width:100%;float:left;border:1px solid #96c2f1;background:#eff7ff;margin-bottom:20px;');
		$doc["div ul"]->find("li:even")->attr("style","width:48%; float:left; padding:5px; list-style:none;");
		$doc["div ul"]->find("li:odd")->attr("style","width:50%; text-align:center; float:left; padding:5px; list-style:none;");

		$this->assign('doc',$doc);

		$curl = $arr[0]['url'];
		$list_content=$vo['list_content'];

		$reg = array("title"=>array(".detail-hd h2","text"),"con"=>array($list_content,"html"));
		$hj = new QueryList($curl,$reg);
		$val = $hj->jsonArr;
		$this->assign('val',$val);


    	$this->display();
    }





}