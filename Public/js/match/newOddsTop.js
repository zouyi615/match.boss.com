sfHover = function() {
	var sfEls = document.getElementById("web_nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className = (this.className ? this.className + " " : "") + "sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className = this.className.replace(/\s*?\bsfhover\b/, "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
var homePage = "http://odds.zqsos.com/";
var enUrl = '<a href="http://www.nowgoal.com/Comp.htm" style="color:green;" target="_blank">EN</a>';
var name = "足球指数";
try {
    if (t == 2) {
        homePage = "http://nba.win007.com/odds/index.aspx";
        enUrl = '<a href="http://data.nowgoal.com/nba/comp.htm" style="color:green;" target="_blank">EN</a>';
        name = "篮球指数";
    }
    else if (t == 3) {
        homePage = "http://61.143.225.173:88/champion/index.aspx";
        enUrl = '<a href="javascript:SetLanguage(2);" style="color:green;">EN</a>';
        name = "冠军指数";
    }
}
catch (e)
{ }

if(window.location.href.toLowerCase().indexOf("am.")<0) 
{
if (ShowAd)
document.writeln("<div id='ad'>" + topImgAd[0] + topImgAd[1] + "</div>");
}
//document.writeln("<div id='ad'><a href='http://www.bet017.com/' target=_blank><img src='http://img2.win007.com/image/2ddfrt2.gif' width='470' height='48' /></a> <a href='http://www.a3322.net/' target=_blank><img src='http://img2.win007.com/image/a3322.gif' width='470' height='48' /></a></div>");

document.write('<div id="web_top">');
document.write('  <div id="web_bet"></div>');
document.write('  <ul id="web_nav">');
document.write('    <li><span><a href="http://www.win007.com/">首页</a></span>');
//document.write('        <UL style="WIDTH: 160px" class="nav2">');       
//document.write('    <LI><A href="http://www.city007.net/serviceorder.aspx" target="_blank">擂台VIP</A></LI>');
//document.write('    <LI><A href="http://www.win007.com/member.htm" target="_blank">指数VIP</A></LI>');
//document.write('    <LI><A href="http://sms.city007.net/" target="_blank">短信VIP</A></LI>');
//document.write('	<LI><A href="http://wap.win007.com/wap.htm" target="_blank">手机上网</A></LI>');
//document.write('    <LI><A href="http://bf.win007.com/free.aspx" target="_blank">比分调用 </A></LI>');
//document.write('    <LI><A href="http://bf.win007.com/oddsfree.aspx" target="_blank">赔率调用</A></LI>');
//document.write('    <LI><A href="http://ads.win007.com/Market/Index.aspx" target="_blank">营销合作</A></LI>');
//document.write('    <LI><!--A href="http://http://ads.win007.com/Market/MarketAdvertisingList.aspx/" target="_blank"-->广告合作</A></LI>');
//document.write('    </UL>');
document.write('    </li>');
document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://live.win007.com/" target="_blank" >即时比分</a></span>');
document.write('     <UL style="WIDTH: 160px">');
document.write('    <LI><A href="http://live.win007.com/" target="_blank">足球</A></LI>');
document.write('    <LI><A href="http://basket.win007.com/nba.htm" target="_blank">篮球</A></LI>');
document.write('    <LI><A href="http://bf.win007.com/tennis.htm" target="_blank">网球</A></LI>');
document.write('    <LI><A href="http://f1.win007.com/f1_bf.aspx" target="_blank">赛车</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/vollyball.aspx" target="_blank">排球</A></LI> ');
document.write('    <LI><A href="http://sports.win007.com/baseball.aspx" target="_blank">棒球</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/pingpong.aspx" target="_blank">乒乓球</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/shuttlecock.aspx" target="_blank">羽毛球</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/snooker.htm" target="_blank">斯诺克</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/football.aspx" target="_blank">橄榄球</A></LI>');
//document.write('    <LI><A href="http://golf.win007.com/golf_bf.aspx" target="_blank">高尔夫</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/hockey.aspx" target="_blank">冰球</A></LI>');
document.write('    <LI><A href="http://bf.win007.com/TextLive.htm" target="_blank">文字直播</A></LI>');
//document.write('    <LI><A href="http://article.win007.com/Topic/bf/kuize.htm" target="_blank">竞赛规则</A></LI>');
document.write('    </UL>');
document.write('    </li>');
document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://odds.zqsos.com/" target="_blank">指数</a></span>');
document.write('    <UL style="WIDTH: 160px">');
document.write('    <LI><A href="http://odds.zqsos.com/" target="_blank">足球指数</A></LI>');
document.write('    <LI><A href="http://nba.win007.com/odds/index.aspx" target="_blank">篮球指数</A></LI>');
document.write('    <LI><A href="http://odds.zqsos.com/betfa/index.aspx" target="_blank">必发指数</A></LI>');
document.write('    <LI><A href="http://am.win007.com/" target="_blank">澳彩原版</A></LI>');
document.write('    <LI><A href="http://1x2.win007.com/" target="_blank">足球百家</A></LI>');
document.write('    <LI><A href="http://nba.win007.com/1x2/" target="_blank">篮球百家</A></LI>');
document.write('    <LI><A href="http://info.win007.com/cn/LletGoal/36.html" target="_blank">让球盘路</A></LI>');
document.write('    <LI><A href="http://61.143.225.173:88/champion/index.aspx" target="_blank">冠军指数</A></LI>');
document.write('    </UL>');
document.write('    </li>');
document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://info.win007.com/" target="_blank">资料库</a></span>');
document.write('    <UL style="WIDTH: 160px">');           
document.write('    <LI><A href="http://info.win007.com/info/index.htm" target="_blank">足球资料库</A></LI>');
document.write('    <LI><A href="http://nba.win007.com/" target="_blank">篮球资料库</A></LI>');
//document.write('    <LI><A href="http://golf.win007.com/sclass/schedule2009_3.html" target="_blank">高尔夫</A></LI>');
document.write('    <LI><A href="http://f1.win007.com/Result.aspx" target="_blank">F1赛车</A></LI>');
document.write('    <LI><A href="http://tennis.win007.com" target="_blank">网球</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/SnookerDB.aspx" target="_blank">斯诺克</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/BB_Default.aspx?SclassID=1" target="_blank">棒球</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/Default.aspx?SclassID=187" target="_blank">冰球</A></LI>');
document.write('    <LI><A href="http://sports.win007.com/FB_Default.aspx?SclassID=1" target="_blank">美式足球</A></LI>');
document.write('    <LI><A href="http://info.win007.com/league_match/league_vs/2011-2012/36.htm" target="_blank">英超</A></LI>');
document.write('    <LI><A href="http://info.win007.com/league_match/league_vs/2011-2012/34.htm" target="_blank">意甲</A></LI>');
document.write('    <LI><A href="http://info.win007.com/league_match/league_vs/2011-2012/8.htm" target="_blank">德甲</A></LI>');
document.write('    <LI><A href="http://info.win007.com/league_match/league_vs/2011-2012/31.htm" target="_blank">西甲</A></LI>');
document.write('    <LI><A href="http://info.win007.com/league_match/league_vs/2011-2012/11.htm" target="_blank">法甲</A></LI>');
document.write('    <LI><A href="http://info.win007.com/cup_match/2011-2012/cupmatch_vs/cupmatch_103.htm" target="_blank">欧冠杯</A></LI>');
document.write('    <LI><A href="http://nba.win007.com/League/#http://nba.win007.com/League/Schedule/1/" target="_blank">NBA</A></LI>');
//document.write('    <LI><A href="http://info.win007.com/score/2010-2011/36.htm" target="_blank">积分</A></LI>');
document.write('    <LI><A href="http://info.win007.com/cn/LletGoal/36.html" target="_blank">盘路</A></LI>');
document.write('    <LI><A href="http://info.win007.com/cn/aspx/sclassZh.aspx" target="_blank">转会记录</A></LI>');
document.write('    <LI><A href="http://info.win007.com/aspx/fifa.aspx" target="_blank">世界排名</A></LI>');
document.write('    <LI><A href="http://nba.win007.com/tv.aspx" target="_blank">电视直播表</A></LI>');
document.write('    </UL>');
document.write('    </li>');
document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://news.win007.com/football.html" target="_blank">前瞻</a></span>');
document.write('    <UL style="WIDTH: 160px">');
document.write('    <LI><A href="http://news.win007.com/football.html" target="_blank">足球前瞻</A></LI>');
document.write('    <LI><A href="http://news.win007.com/basketball.html" target="_blank">篮球前瞻</A></LI>');
document.write('    </UL>');
document.write('    </li>');

document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://cp.win007.com/" target="_blank">购彩</a></span>');
document.write('    </li>');

document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://www.310tv.com/" target="_blank">直播</a></span>');
document.write('    </li>');

document.write('    <li class="d_l"></li>'); 
document.write('    <li><span><a href="http://ba.win007.com/" target="_blank">球吧</a></span><div style="position:absolute;left:520px;top:-7px;"><img src="http://bf.win007.com/image/cj_new.gif" width="16" height="17" /></div>');
document.write('    </li>');

document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://guess.win007.com/" target="_blank">亚盘王</a></span><div style="position:absolute;left:590px;top:-7px;"><img src="http://bf.win007.com/image/cj_new.gif" width="16" height="17" /></div>');
document.write('    </li>');

document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://www.edewin.com/" target="_blank">德州</a></span><div style="position:absolute;left:650px;top:-7px;"><img src="http://guess.win007.com/Images/jc/cj_hot.gif" width="16" height="17" /></div>');
document.write('    </li>');

document.write('    <li class="d_l"></li>');
document.write('    <li><span><a href="http://forum.win007.com/" target="_blank">社区</a></span>');
/*document.write('     <UL  style="WIDTH: 160px;MARGIN-LEFT: -100px;">');
document.write('    <LI><A href="http://forum.win007.com/" target="_blank">论坛首页</A></LI>');
document.write('    <LI><A href="http://forum.win007.com/?showforum-2.html" target="_blank">足球心水</A></LI>');
document.write('    <LI><A href="http://forum.win007.com/?showforum-4.html" target="_blank">篮球心水</A></LI>');
document.write('    <LI><A href="http://forum.win007.com/?showforum-440.html" target="_blank">综合心水</A></LI>');
document.write('    <LI><A href="http://forum.win007.com/?showforum-459.html" target="_blank">体育花边</A></LI>');
document.write('    <LI><A href="http://forum.win007.com/?showforum-183.html" target="_blank">宽频影院</A></LI>');
document.write('    <LI><A href="http://forum.win007.com/?showforum-59.html" target="_blank">赛事论坛</A></LI>');
document.write('    <LI><A href="http://forum.win007.com/?showforum-22.html" target="_blank">校园社区</A></LI>');
document.write('    </UL>');*/
document.write('    </li>');
document.write('    </ul>');
document.write('  <div style="clear:both"></div></div>');
document.write('  <div style="clear:both"></div>');
document.write('</div>');

document.write('<div style="text-align:center;font-size:12px;line-height:20px;width:950px; background-color:white;height:20px;">本频道资讯转载于各大门户网站、体育网、报刊，仅供购买中国足彩单场彩游戏作指数对比及回查分析之用 &nbsp; &nbsp; &nbsp; &nbsp;<a href="http://www.win007.com/app/" target="_blank" style="color:Red">比分客户端下载</a>&nbsp; &nbsp; &nbsp; &nbsp;<a href="http://61.143.225.173:88/help.htm" target="_blank" style="color:Red">使用说明</a> | <a href="http://bf.win007.com/oddsfree.aspx" target="_blank" style="color:Red">调用</a><!-- <b style="color:red">快速购彩：<a href="http://www.310win.com/buy/jingcai.aspx?typeID=101&oddstype=2" target=_blank style="color:blue"><u>竞彩足球</u></a> &nbsp; <a href="http://www.310win.com/buy/JingCaiBasket.aspx?typeID=112" target=_blank style="color:blue"><u>竞彩篮球</u></a> &nbsp; <a href="http://www.310win.com/buy/JingCaiBasket.aspx?typeID=112" target=_blank style="color:blue"><u>北京单场</u></a></b>--></div>');


if(window.location.href.toLowerCase().indexOf("am.")<0) 
{
if (ShowAd&& topImgAd[2]!="")
	document.writeln("<div id='ad' style='padding-bottom:3px;'>"+ topImgAd[2] + "</div>");
}




function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function getCookie(name){
	var cname = name + "=";
	var dc = document.cookie;
	if (dc.length > 0){
		begin = dc.indexOf(cname);
		if (begin != -1){
			begin += cname.length;
			end = dc.indexOf(";", begin);
			if (end == -1) end = dc.length;
			return dc.substring(begin, end);
		}
	}
	return null;
}
function writeCookie(name, value) 
{ 
	var expire = ""; 
	var hours = 365;
	expire = new Date((new Date()).getTime() + hours * 3600000); 
	expire = ";path=/;expires=" + expire.toGMTString(); 
	document.cookie = name + "=" + value + expire; 
}

function EuropeOdds(ID) {
var theURL='http://1x2.win007.com/oddslist/'+ID+'.htm';
window.open(theURL,'','');}

function AsianOdds(ID) {
var theURL='http://vip.win007.com/AsianOdds_n.aspx?id='+ID;
window.open(theURL,'','');}

function analysis(ID){
var theURL='http://info.win007.com/analysis/'+ID+'.htm';
window.open(theURL,'','');
}
function Panlu(ID){
var theURL='http://bf.win007.com/panlu/'+ID+'.htm';
window.open(theURL,'','');
}


function dxq(ID,t1,t2){
var theURL='http://vip.win007.com/OverDown_n.aspx?id='+ID+'&team1=' + t1 +' &team2='+ t2;
window.open(theURL,'','');}

function qb(ID){
window.open('http://news.win007.com/UserWeb/LiveInformation.aspx?ID='+ID,'','');
}
function showgoallist(ID)
{
	window.open("http://bf.win007.com/detail/" + ID +".htm", "","scrollbars=yes,resizable=yes,width=668, height=720");
}
function oddsDetail(ID,cId)
{
	window.open("http://vip.win007.com/changeDetail/handicap.aspx?id=" + ID +"&companyID="+ cId, "","");
}









