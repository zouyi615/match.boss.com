<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	header("Content-type:text/html;charset=UTF-8");
    	import('Org.JAE.QueryList');
		
		
		//采集OSC的代码分享列表，标题 链接 作者
        $url = "http://www.okooo.com/livecenter/football/";
        $reg = array(
					"matchid"=>array("tr.each_match","matchid"),
					"home"=>array("td>a.ctrl_homename","text"),
				);
        $rang = "#livescore_table tr.each_match";
        //使用curl抓取源码并以GB2312编码格式输出
        $hj = new \QueryList($url,$reg,$rang,'curl','UTF-8');
        $arr = $hj->jsonArr;
        echo "<pre>";
        var_dump($arr);
        echo "</pre>------------<hr/>";
    	exit;
		
		
    	//采集OSC的代码分享列表，标题 链接 作者
        $url = "http://www.oschina.net/code/list";
        $reg = array("title"=>array(".code_title a:eq(0)","html"),"url"=>array(".code_title a:eq(0)","href"),"author"=>array("img","title"));
        $rang = ".code_list li";
        //使用curl抓取源码并以GB2312编码格式输出
        $hj = new \QueryList($url,$reg,$rang,'curl','UTF-8');
        $arr = $hj->jsonArr;
        echo "<pre>";
        var_dump($arr);
        echo "</pre>------------<hr/>";

        //如果还想采当前页面右边的 TOP40活跃贡献者 图像，得到JSON数据,可以这样写
        $reg = array("portrait"=>array(".hot_top img","src"));
        $hj->setQuery($reg);
        $json = $hj->getJSON();
        echo $json . "<hr/>";

        //采OSC内容页内容
        $url = "http://www.oschina.net/code/snippet_186288_23816";
        $reg = array("title"=>array(".QTitle h1","text"),"con"=>array(".Content","html"));
        $hj = new \QueryList($url,$reg);
        $arr = $hj->jsonArr;
        echo "<pre>";
        print_r($arr);
        echo "</pre><hr/>";

    }
}