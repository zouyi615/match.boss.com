<?php
//对阵处理类文件
namespace Home\Controller;
use Think\Controller;
class MatchController extends Controller {
	//参数
	public $xmlUrl = 'http://trade.500.com/static/public/jczq/xml/match/match.xml'; //对阵xml
	public $xmlspfpl = 'http://trade.500.com/static/public/jczq/xml/pl/pl_spf_2.xml'; //让球胜平负赔率
	//处理函数
	public function index(){
		var_dump($this->xmlUrl);
		$this->getXml();
	}
	//获取xml数据
	public function getXml(){
		import('Libs.Trade.Jcpublic');
        $jc = new \Jcpublic();
        $xml = $jc->getMatchData();	
		var_dump($xml);
	}

}

/*http://sports1.im.fun88.com/OddsDisplay/websync?token=13868823&src=js&AspxAutoDetectCookieSupport=1
http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsDataByMatchIds?PageSportIds=0&PageMarket=0&LeagueIdList=-1&SortingType=0&OddsType=0&UserTimeZone=-480&Language=1&FilterDay=1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=1&OddsPageCode=0&ViewType=2&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0&MatchIds=1807356&MatchIds=1807359&LastRefreshTime=
http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=0&LeagueIdList=-1&SortingType=0&OddsType=0&UserTimeZone=-480&Language=1&FilterDay=1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=1&OddsPageCode=0&ViewType=2&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0
http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetOddsData2?PageSportIds=0&PageMarket=0&LeagueIdList=-1&SortingType=0&OddsType=0&UserTimeZone=-480&Language=1&FilterDay=1&OpenParlay=0&Theme=Fun88&ShowStatistics=1&IsUserLogin=false&ExtraFilter=&SportId=0&Market=0&OddsPageCode=0&ViewType=2&MatchIdList=-1&ActiveMatchFilter=false&Token=&SMVUpcomingLimit=0

http://sports1.im.fun88.com/OddsDisplay/Sportsbook/GetTemplate2	*/