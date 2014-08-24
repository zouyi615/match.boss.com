//定义Config
var Config = new Object();
Config.language = null;
Config.rank = 0;
Config.soundCheck = 0;

Config.getCookie = function() {
    var Cookie = getCookie("Cookie");
    if (Cookie == null) Cookie = "";
    var Cookie = Cookie.split("^");
    if (Cookie.length != 3) writeCookie("Cookie", null);
    else {
        this.language = parseInt(Cookie[0]);
        this.rank = parseInt(Cookie[1]);
        this.soundCheck = parseInt(Cookie[2]);
    }
    Config.setStates();
}
Config.setStates = function() {
    try {
//        document.getElementById("Language" + Config.language).className = "selected";
        if (this.rank == 1) document.getElementById("chec_sort").checked = true;
        if (this.soundCheck == 1) document.getElementById("chec_Sound").checked = true;       
    }
    catch (e) { }
}
Config.writeCookie = function() {
    var value = this.language + "^" + this.rank + "^" + this.soundCheck;
    writeCookie("Cookie", value);
}

var zXml = {
	useActiveX: (typeof ActiveXObject != "undefined"),
	useXmlHttp: (typeof XMLHttpRequest != "undefined")
};
zXml.ARR_XMLHTTP_VERS = ["MSXML2.XmlHttp.6.0","MSXML2.XmlHttp.3.0"];
function zXmlHttp() {}
zXmlHttp.createRequest = function ()
{
	if (zXml.useXmlHttp)  return new XMLHttpRequest(); 
	if(zXml.useActiveX)  //IE < 7.0 = use ActiveX
	{  
		if (!zXml.XMLHTTP_VER) {
			for (var i=0; i < zXml.ARR_XMLHTTP_VERS.length; i++) {
				try {
					new ActiveXObject(zXml.ARR_XMLHTTP_VERS[i]);
					zXml.XMLHTTP_VER = zXml.ARR_XMLHTTP_VERS[i];
					break;
				} catch (oError) {}
			}
		}		
		if (zXml.XMLHTTP_VER) return new ActiveXObject(zXml.XMLHTTP_VER);
	} 
	alert("Sorry，XML object unsupported by your computer,please setup XML object or change explorer.");
};
function Hashtable2() {
    this._hash = new Object();
    this.add = function(key, value) {
        if (typeof (key) != "undefined") {
            this._hash[key] = typeof (value) == "undefined" ? null : value;
            return true;
        }
        else
            return false;
    }
    this.remove = function(key) { delete this._hash[key]; }
    this.keys = function() {
        var keys = new Array();
        for (var key in this._hash) {
            keys.push(key);
        }
        return keys;
    }
    this.count = function() { var i = 0; for (var k in this._hash) { i++; } return i; }
    this.items = function(key) { return this._hash[key]; }
    this.contains = function(key) {
        return typeof (this._hash[key]) != "undefined";
    }
    this.clear = function() { for (var k in this._hash) { delete this._hash[k]; } }
}
var GoalCn = ["0", "0/0.5", "0.5", "0.5/1", "1", "1/1.5", "1.5", "1.5/2", "2", "2/2.5", "2.5", "2.5/3", "3", "3/3.5", "3.5", "3.5/4", "4", "4/4.5", "4.5", "4.5/5", "5", "5/5.5", "5.5", "5.5/6", "6", "6/6.5", "6.5", "6.5/7", "7", "7/7.5", "7.5", "7.5/8", "8", "8/8.5", "8.5", "8.5/9", "9", "9/9.5", "9.5", "9.5/10", "10", "10/10.5", "10.5", "10.5/11", "11", "11/11.5", "11.5", "11.5/12", "12", "12/12.5", "12.5", "12.5/13", "13", "13/13.5", "13.5", "13.5/14", "14" ];
var GoalCn2 = ["0", "0/-0.5", "-0.5", "-0.5/-1", "-1", "-1/-1.5", "-1.5", "-1.5/-2", "-2", "-2/-2.5", "-2.5", "-2.5/-3", "-3", "-3/-3.5", "-3.5", "-3.5/-4", "-4", "-4/-4.5", "-4.5", "-4.5/-5", "-5", "-5/-5.5", "-5.5", "-5.5/-6", "-6", "-6/-6.5", "-6.5", "-6.5/-7", "-7", "-7/-7.5", "-7.5", "-7.5/-8", "-8", "-8/-8.5", "-8.5", "-8.5/-9", "-9", "-9/-9.5", "-9.5", "-9.5/-10", "-10" ];
var week= new Array("(日)", "(一)", "(二)", "(三)", "(四)", "(五)", "(六)");

function Goal2GoalCn(goal){
	if (goal=="")
		return "";
	else{
		if(goal>=0)  return GoalCn[parseInt(goal*4)];
		else return GoalCn2[Math.abs(parseInt(goal*4))];
	}
}
function BgColor(odds1,odds2){
	var bg="normal";
	if(odds1<odds2) bg="up";
	if(odds1>odds2) bg="down";
	return bg;
}
function TdBgColor(odds1,odds2){
	var bg="";
	if(odds1<odds2) bg="#ff8888";
	if(odds1>odds2) bg="#88ff88";
	return bg;
}
var ua = navigator.userAgent.toLowerCase();
var ieNum = 0;
try {
    //    if (document.all && typeof (document.documentMode) != "undefined")
    //        ieNum = document.documentMode;
    if (window.ActiveXObject)
        ieNum = ua.match(/msie ([\d.]+)/)[1];
}
catch (e) {
    ieNum = 0;
}
var state_ch=Array(18);
state_ch[0]="推迟,推遲,Postp.";
state_ch[1]="中断,中斷,Pause";
state_ch[2]="腰斩,腰斬,Abd";
state_ch[3]="待定,待定,Pending";
state_ch[4]="取消,取消,Cancel";
state_ch[13]="<font color=red>完</font>,<font color=red>完</font>,<font color=red>Ft</font>";
state_ch[14]=",,";
state_ch[15]="上,上,Part1";
state_ch[16]="<font color=blue>中</font>,<font color=blue>中</font>,<font color=blue>HT</font>";
state_ch[17]="下,下,Part2";
state_ch[18]="加,加,Ot";


var company=new Array(40);
company[0] = "足彩,足彩";
company[1] = "澳彩,澳彩";
company[2] = "波音,波音";
company[3] = "ＳＢ,ＳＢ";
company[4] = "立博,立博";
company[5] = "云鼎,云鼎";
company[7] = "SNAI,SNAI";
company[8] = "Bet365,Bet365";
company[9] = "威廉,威廉";
company[12] = "易胜博,易勝博";
company[14] = "韦德,韋德";
company[15] = "SSP,SSP";
company[17] = "明陞,明陞";
company[18] = "Eurobet,Eurobet";
company[19] = "Interwetten,Interwetten";
company[22] = "10Bet,10Bet";
company[23] = "金宝博,金寶博";
company[24] = "12Bet,12Bet";
company[29] = "乐天堂,樂天堂";
company[31] = "利记,利記";
company[33] = "永利高,永利高"; 
//company[35]="<a href='http://www.wewbet.net/proxy.htm?username=adwctt13' target='_blank' style='color:Red'>盈禾</a>";
company[35] = "盈禾,盈禾";  

var riseColor="#FFB0B0";
var fallColor="#00FF44";
var changePkColor="#D06666";
var nofityTimer="";
var oldLevel=-1;
var selDate="";
var matchType = 0;
var redcard = 1;
var strDataList = "";
var hiddenID;
var strZuodiList = ",", strRunList = ",", strNotOpenList = ",";
var sclassSelectNum = 0;
function isMulti() {
    var url = location.href.toLowerCase();
    if (url.indexOf("aspx") == -1 || url.indexOf("multi") != -1)
        return true;
    else
        return false;
}
function isCompany() {
    var url = location.href.toLowerCase();
    if (url.indexOf("company") != -1)
        return true;
    else
        return false;
}
//定义namespace
var _glodds = new Object();
//公共变量
_glodds.SplitDomain = "$";
_glodds.SplitRecord = ";";
_glodds.SplitColumn = ",";


//通用列表类
_glodds.List = function() {
    this.items = new Array();
    this.keys = new Object();

    this.Add = function(key, value) {
        if (typeof (key) != "undefined") {
            var vv = typeof (value) == "undefined" ? null : value;
            var idx = this.keys[key];
            if (idx == null) {
                idx = this.items.length;
                this.keys[key] = idx;
            }
            this.items[idx] = vv;
        }
    }

    this.Get = function(key) {
        var idx = this.keys[key];
        if (idx != null)
            return this.items[idx];
        return null;
    }
    if (isMulti()) {
        this.GetMaxNum = function(key) {
            var num = 1;
            var count = 0;
            for (var k in this.keys) {
                if (k.indexOf(key) != -1) {
                    var idx = this.keys[k];
                    if (idx != null) {
                        count++;
                        var item = this.items[idx];
                        var num2 = parseInt(item.num);
                        if (num2 > num)
                            num = num2;
                    }
                    else if (count > 0)
                        break;
                }
            }
            return num;
        }
        this.getSumNum = function(key) {
            var hsNum = new Hashtable2();
            var sum = 0;
            var count = 0;
            for (var k in this.keys) {
                if (k.indexOf(key) != -1) {
                    var arrK = k.split('_');
                    var companyID = arrK[1];
                    var idx = this.keys[k];
                    if (idx != null) {
                        var item = this.items[idx];
                        var num2 = parseInt(item.num);
                        if (hsNum.contains(companyID)) {
                            var num = parseInt(hsNum.items(companyID));
                            if (num < num2)
                                hsNum.add(companyID, num2);
                        }
                        else
                            hsNum.add(companyID, num2);
                    }
                }
            }
            for (var j = 0; j < hsNum.keys().length; j++) {
                count++;
                sum += parseInt(hsNum.items(hsNum.keys()[j]));
            }
            return sum + (SelCompany.length - count);
        }
    }
    this.Clear = function() {
        for (var k in this.keys) {
            delete this.keys[k];
        }
        delete this.keys;
        this.keys = null;
        this.keys = new Object();

        for (var i = 0; i < this.items.length; i++) {
            delete this.items(i);
        }
        delete this.items;
        this.items = null;
        this.items = new Array();
    }
}


//联赛项类
_glodds.League = function(infoStr) {
    var infoArr = infoStr.split(_glodds.SplitColumn);
    this.lId = infoArr[0];
    this.type = infoArr[1];
    this.color = infoArr[2];
    this.cnName = infoArr[3];
    this.trName = infoArr[4];
    this.enName = infoArr[5];
    this.url = infoArr[6];
    this.important = infoArr[7];
    this.matchNum = 0;
    this.show = true;
    this.showNum = 0;
    this.getName = function() {
        if (Config.language == 2)
            return this.enName;
        else if (Config.language == 1)
            return this.trName;
        else
            return this.cnName;
    }
}


//比赛项类
_glodds.Match = function(infoStr) {
    var infoArr = infoStr.split(_glodds.SplitColumn); //265454,539,2009-5-6 23:00:00,,6734,学生体育,學生體育,Sportul Studentesc,14,6730,德尔塔,德爾塔,Delta Tulcea,2,0,0,0,,False;
    this.mId = infoArr[0];
    this.lId = infoArr[1];
    //	this.time = new Date(parseInt(infoArr[2]));
    this.time = AmountTimeDiff(infoArr[2]);
    var d = AmountTimeDiff(infoArr[2]);
    d.setTime(d.getTime() - 8 * 3600 * 1000); //方便当天4点后的显示到前一天的页面
    var strD = _oddsUitl.getOnlyDate(d);
    if (selDate == "") selDate = _oddsUitl.getDate(strD);
    if (strDataList.indexOf(strD) == -1)
        strDataList += strD + ",";
    //    if (infoArr[3] != "") this.time2 = new Date(parseInt(infoArr[3]));
    if (infoArr[3] != "") this.time2 = AmountTimeDiff(infoArr[3]);
    this.t1Id = infoArr[4];
    this.t1CnName = infoArr[5];
    this.t1TrName = infoArr[6];
    this.t1EnName = infoArr[7];
    this.t1Position = "<span id='ht_" + infoArr[0] + "' style='display:" + (Config.rank == 1 ? "" : "none") + ";'>" + (infoArr[8] != "" ? "[" + infoArr[8] + "]" : "") + "</span>";
    this.t2Id = infoArr[9];
    this.t2CnName = infoArr[10];
    this.t2TrName = infoArr[11];
    this.t2EnName = infoArr[12];
    this.t2Position = "<span id='gt_" + infoArr[0] + "' style='display:" + (Config.rank == 1 ? "" : "none") + ";'>" + (infoArr[13] != "" ? "[" + infoArr[13] + "]" : "") + "</span>";
    this.state = infoArr[14];
    this.homeScore = infoArr[15];
    this.guestScore = infoArr[16];
    this.tv = infoArr[17];
    this.flag = "";
    if (infoArr[18] == "True") this.flag = "(中)";
    this.level = infoArr[19];
    if (!isCompany()) {
        this.h_redcard = infoArr[20];
        this.g_redcard = infoArr[21];
        this.h_yellow = infoArr[22];
        this.g_yellow = infoArr[23];
        if (infoArr[20] != "0") this.H_redcard = "<img src='images/redcard" + infoArr[20] + ".gif'>"; else this.H_redcard = "";
        if (infoArr[21] != "0") this.G_redcard = "<img src='images/redcard" + infoArr[21] + ".gif'>"; else this.G_redcard = "";
        if (infoArr[22] != "0") this.H_yellow = "<img src='images/yellow" + infoArr[22] + ".gif'>"; else this.H_yellow = "";
        if (infoArr[23] != "0") this.G_yellow = "<img src='images/yellow" + infoArr[23] + ".gif'>"; else this.G_yellow = "";
        this.matchCenter = infoArr[24];
    }
    this.getT1Name = function() {
        if (Config.language == 2)
            return this.t1EnName;
        else if (Config.language == 1)
            return this.t1TrName;
        else
            return this.t1CnName;
    }

    this.getT2Name = function() {
        if (Config.language == 2)
            return this.t2EnName;
        else if (Config.language == 1)
            return this.t2TrName;
        else
            return this.t2CnName;
    }
}


//亚赔信息
_glodds.OddsAsian = function(infoStr) {
    var infoArr = infoStr.split(_glodds.SplitColumn); //711286,12,1,1.15,0.80,1,1.15,0.80,False,False,1;
    this.mId = infoArr[0];
    this.cId = infoArr[1];
    this.goalF = infoArr[2];
    this.homeF = infoArr[3];
    this.awayF = infoArr[4];
    this.goal = infoArr[5];
    this.home = infoArr[6];
    this.away = infoArr[7];
    this.close = infoArr[8];
    this.zoudi = infoArr[9];
    if (isMulti()) {
        this.num = infoArr[10];
        this.maxNum = infoArr[11];
    }
}
//欧赔信息
_glodds.Odds1x2 = function(infoStr) {
    var infoArr = infoStr.split(_glodds.SplitColumn); //711286,12,1.55,3.75,5.30,1.55,3.75,5.30,1;
    this.mId = infoArr[0];
    this.cId = infoArr[1];
    this.hwF = infoArr[2];
    this.stF = infoArr[3];
    this.awF = infoArr[4];
    this.hw = infoArr[5];
    this.st = infoArr[6];
    this.aw = infoArr[7];
    if (isMulti()) 
        this.num = infoArr[8];
}
//大小赔率信息
_glodds.OddsOU = function(infoStr) {
    var infoArr = infoStr.split(_glodds.SplitColumn); //711286,12,2.75,0.85,0.95,2.75,0.85,0.95,1;
    this.mId = infoArr[0];
    this.cId = infoArr[1];
    this.goalF = infoArr[2];
    this.overF = infoArr[3];
    this.underF = infoArr[4];
    this.goal = infoArr[5];
    this.over = infoArr[6];
    this.under = infoArr[7];
    if (isMulti())
        this.num = infoArr[8];
}
//OddsAsian HT
_glodds.OddsAsian_HT = function(infoStr) {
    var infoArr = infoStr.split(_glodds.SplitColumn); //209092,8,0.5,0.95,0.95,0.5,1.025,0.875;
    this.mId = infoArr[0];
    this.cId = infoArr[1];
    this.goalF = infoArr[2];
    this.homeF = infoArr[3];
    this.awayF = infoArr[4];
    this.goal = infoArr[5];
    this.home = infoArr[6];
    this.away = infoArr[7];
}

//OddsOU HT
_glodds.OddsOU_HT = function(infoStr) {
    var infoArr = infoStr.split(_glodds.SplitColumn); //209092,8,0.5,0.95,0.95,0.5,1.025,0.875
    this.mId = infoArr[0];
    this.cId = infoArr[1];
    this.goalF = infoArr[2];
    this.overF = infoArr[3];
    this.underF = infoArr[4];
    this.goal = infoArr[5];
    this.over = infoArr[6];
    this.under = infoArr[7];
}

var _oddsUitl = new Object();
	var matchdata = new Object();

_oddsUitl.getDayStr = function(dt) {
  return (dt.getMonth()+1)+"-"+dt.getDate();
}
_oddsUitl.getOnlyDate = function(dt) {
    return dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
}
_oddsUitl.getTimeStr = function(dt) {
  return dt.getHours()+":"+(dt.getMinutes()<10?"0":"")+dt.getMinutes();
}

_oddsUitl.getDtStr = function(dt) {
  return (dt.getMonth()+1)+"-"+dt.getDate()+" "+(dt.getHours()<10?"0":"")+dt.getHours()+":"+(dt.getMinutes()<10?"0":"")+dt.getMinutes();
}

_oddsUitl.getDateTimeStr = function(dt) {
  return dt.getFullYear()+"-"+(dt.getMonth()+1)+"-"+dt.getDate()+" "+(dt.getHours()<10?"0":"")+dt.getHours()+":"+(dt.getMinutes()<10?"0":"")+dt.getMinutes();
}
_oddsUitl.getDate = function(str) {
  var p = str.split("-");
  return new Date(p[0], parseInt(p[1],10)-1, p[2]);
}
var xmlBf = zXmlHttp.createRequest();
var oldBfXML = ""
function getbfxml()
{
	xmlBf.open("get","xml/change.xml?" + Date.parse(new Date()),true);
	xmlBf.onreadystatechange = bfRefresh;			
	xmlBf.send(null);
	window.setTimeout("getbfxml()",6000);
}
function bfRefresh() {
    if (xmlBf.readyState != 4 || (xmlBf.status != 200 && xmlBf.status != 0)) return;
    if (oldBfXML == xmlBf.responseText || xmlBf.responseText == "") return
    oldBfXML = xmlBf.responseText;
    var root = xmlBf.responseXML.documentElement;

    var D = new Array();
    var matchindex, score1change, score2change, scorechange;
    var goTime, hometeam, guestteam, sclassname, score1, score2, tr;
    var matchNum = 0;
    var notify = document.getElementById("notify").innerHTML;

    for (var i = 0; i < root.childNodes.length; i++) {
        D = root.childNodes[i].childNodes[0].nodeValue.split("^"); //0:ID,1:state,2:score1,3:score2,4:half1,5:half2,6:card1,7:card2,8:time1,9:time2,10:explain,11:lineup		

        matchItem = matchdata.MatchList.Get(D[0]);
        if (matchItem == null) continue;
        if (document.getElementById("table_" + D[0]) == null) continue;
        score1change = false;
        if (matchItem.homeScore != D[2]) {
            matchItem.homeScore = D[2];
            score1change = true;
            document.getElementById("hs_" + matchItem.mId).innerHTML = D[2];
            document.getElementById("home_" + matchItem.mId).style.backgroundColor = "red";
        }
        score2change = false;
        if (matchItem.guestScore != D[3]) {
            matchItem.guestScore = D[3];
            score2change = true;
            document.getElementById("gs_" + matchItem.mId).innerHTML = D[3];
            document.getElementById("guest_" + matchItem.mId).style.backgroundColor = "red";
        }
        scorechange = score1change || score2change;
        if (!isCompany()) {
            //红牌变化了
            if (D[6] != matchItem.h_redcard) {
                matchItem.h_redcard = D[6];
                if (D[6] == "0")
                    document.getElementById("redcard1_" + D[0]).innerHTML = "";
                else
                    document.getElementById("redcard1_" + D[0]).innerHTML = "<img src=images/redcard" + D[6] + ".gif border='0'> ";
                if (redcard) {
                    document.getElementById("home_" + matchItem.mId).style.backgroundColor = "#ff8888";
                    //				window.setTimeout("timecolors(" + D[0] +","+ matchindex + ")",12000);
                    window.setTimeout("bfcolors_water(" + D[0] + ")", 12000);
                }
            }
            if (D[7] != matchItem.g_redcard) {
                matchItem.g_redcard = D[7];
                if (D[7] == "0")
                    document.getElementById("redcard2_" + D[0]).innerHTML = "";
                else
                    document.getElementById("redcard2_" + D[0]).innerHTML = "<img src=images/redcard" + D[7] + ".gif border='0'> ";
                if (redcard) {
                    document.getElementById("guest_" + matchItem.mId).style.backgroundColor = "#ff8888";
                    //				window.setTimeout("timecolors(" + D[0] +","+ matchindex + ")",12000);
                    window.setTimeout("bfcolors_water(" + D[0] + ")", 12000);
                }
            }

            //黄牌变化了
            if (D[12] != matchItem.h_yellow) {
                matchItem.h_yellow = D[12];
                if (D[12] == "0")
                    document.getElementById("yellow1_" + D[0]).innerHTML = "";
                else
                    document.getElementById("yellow1_" + D[0]).innerHTML = "<img src=images/yellow" + D[12] + ".gif border='0'> ";
            }
            if (D[13] != matchItem.g_yellow) {
                matchItem.g_yellow = D[13];
                if (D[13] == "0")
                    document.getElementById("yellow2_" + D[0]).innerHTML = "";
                else
                    document.getElementById("yellow2_" + D[0]).innerHTML = "<img src=images/yellow" + D[13] + ".gif border='0'> ";
            }
        }
        //开赛时间
        //if(matchItem.time!=D[8]) document.getElementById("mt_"+ matchItem.mId).innerHTML=D[8];
        //matchItem.time=D[8];
        //		var t = D[9].split(",");
        //		matchItem.time2= new Date(t[0],t[1],t[2],t[3],t[4],t[5]);
        matchItem.time2 = AmountTimeDiff2(D[9]);

        //状态
        if (matchItem.state != D[1]) {
            matchItem.state = D[1];
            switch (matchItem.state) {
                case "0":
                    document.getElementById("hs_" + matchItem.mId).innerHTML = "";
                    document.getElementById("time_" + matchItem.mId).innerHTML = "";
                    document.getElementById("gs_" + matchItem.mId).innerHTML = "";
                    break;
                case "1":
                    document.getElementById("hs_" + matchItem.mId).innerHTML = D[2];
                    document.getElementById("gs_" + matchItem.mId).innerHTML = D[3];
                    goTime = Math.floor((new Date() - matchItem.time2 - difftime) / 60000);
                    if (goTime > 45) goTime = "45+"
                    if (goTime < 1) goTime = "1";
                    document.getElementById("time_" + matchItem.mId).innerHTML = goTime + "<img src='images/in.gif'>";
                    //                    if (matchType == 1 && level != 0) MoveToBottom(D[0]); //开场隐藏
                    break;
                case "2":
                case "4":
                    document.getElementById("time_" + matchItem.mId).innerHTML = state_ch[parseInt(D[1]) + 14].split(",")[Config.language];
                    break;
                case "3":
                    goTime = Math.floor((new Date() - matchItem.time2 - difftime) / 60000) + 46;
                    if (goTime > 90) goTime = "90+";
                    if (goTime < 46) goTime = "46";
                    document.getElementById("time_" + matchItem.mId).innerHTML = goTime + "<img src='images/in.gif'>";
                    break;
                case "-1":
                    document.getElementById("time_" + matchItem.mId).innerHTML = state_ch[parseInt(D[1]) + 14].split(",")[Config.language];
                    window.setTimeout("MoveToBottom(" + D[0] + ")", 30000);
                    break;
                default:
                    document.getElementById("time_" + matchItem.mId).innerHTML = state_ch[parseInt(D[1]) + 14].split(",")[Config.language];
                    MoveToBottom(D[0]);
                    break;
            }
        }


        if (scorechange) {
            hometeam = matchItem.getT1Name();
            score1 = D[2];
            score2 = D[3];
            guestteam = matchItem.getT2Name();
            if (score1change) {
                hometeam = "<font color=red>" + matchItem.getT1Name() + "</font>";
                score1 = "<font color=red>" + D[2] + "</font>";
            }
            if (score2change) {
                guestteam = "<font color=red>" + matchItem.getT2Name() + "<font>";
                score2 = "<font color=red>" + D[3] + "</font>";
            }
            window.clearTimeout(nofityTimer);
            if (notify == "") notify = "<font color=#6666FF><B>入球提示：</b></font>";
            notify += hometeam + " <font color=blue>" + score1 + "-" + score2 + "</font> " + guestteam + " &nbsp; ";
            nofityTimer = window.setTimeout("clearNotify()", 20000);

            window.setTimeout("bfcolors_water('" + matchItem.mId + "')", 30000);
            if (Config.soundCheck) ShowSound("images/sound.swf");
        }
    }
    if (notify != "") document.getElementById("notify").innerHTML = notify;
}
function ShowSound(name) {
    if (ieNum > 0 && ieNum < 6)
        document.getElementById("sound").innerHTML = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' width='1' height='1'><param name='movie' value='" + name + "'><param name='quality' value='high'><param name='wmode' value='transparent'><embed src='" + name + "' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='1' height='1'></embed></object>";
    else
        document.getElementById("sound").innerHTML = "<embed src='" + name + "' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='1' height='1'></embed>";
}

function clearNotify(){
	document.getElementById("notify").innerHTML="";
}
function bfcolors_water(ID){
	try{
		document.getElementById("home_" +  ID).style.backgroundColor="";
		document.getElementById("guest_" +  ID).style.backgroundColor="";
	}catch(e){}
}
function MoveToBottom(id){
	try{
		//document.getElementById("table_" +  id).parentElement.insertAdjacentElement("BeforeEnd",document.getElementById("table_" +  id));
	   	document.getElementById("table_" +  id).style.display="none";
	}catch(e){}
}


function CheckLeague(obj){
	if(obj.checked)
		obj.parentElement.style.backgroundColor="#ffeeee";
	else
		obj.parentElement.style.backgroundColor="white";
}

function SelectAll(value){
	var i,inputs;
	inputs=document.getElementById("league").getElementsByTagName("input");
	for(var i=0; i<inputs.length;i++){
		if(inputs[i].type!="checkbox") continue;
		inputs[i].checked=value;
		if(inputs[i].checked){
			inputs[i].parentElement.style.backgroundColor="#ffeeee";
		}
		else{
			inputs[i].parentElement.style.backgroundColor="white";
		}
	}		
}

function SelectOK() {
    var i, j, inputs;
    inputs = document.getElementById("league").getElementsByTagName("input");
    hiddenID = "_";
    if (level == 1) level = 2;
    var IdList = (sclassSelectNum == 1 ? strZuodiList : sclassSelectNum == 2 ? strNotOpenList : sclassSelectNum == 3 ? strRunList : "");
    var legList = ",";
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type != "checkbox") continue;
        if (inputs[i].checked)
            legList += inputs[i].value + ",";
    }
    for (var i = 0; i < matchdata.LeagueNum; i++) {
        leagueItem = matchdata.LeagueList.items[i];
        if (legList.indexOf("," + leagueItem.lId + ",") != -1) {
            for (var j = 0; j < matchdata.MatchNum; j++) {
                matchItem = matchdata.MatchList.items[j];
                if (matchItem.lId == leagueItem.lId) {
                    if (IdList != "" && IdList.indexOf("," + matchItem.mId + ",") == -1) {
                        hiddenID += matchItem.mId + "_";
                    }
                }
            }
        }
        else {
            for (var j = 0; j < matchdata.MatchNum; j++) {
                matchItem = matchdata.MatchList.items[j];
                if (matchItem.mId == "876287") {
                    var ss = "1";
                }
                if (matchItem.lId == leagueItem.lId) {
                    hiddenID += matchItem.mId + "_";
                }
            }
        }
    }
//    if (document.location.href.toLocaleLowerCase().indexOf("company") == -1)
        writeCookie("Bet007Odds_hiddenID", hiddenID);
    makeTable(1);
}
var hsLeagueCount = new Hashtable2();
function changeSclassSelect(t) {
    var strLeagueList = getLegList(t)
    sclassSelectNum = t;   
    createLeague(t, strLeagueList);
}
function getLegList(t) {
    hsLeagueCount = new Hashtable2();
    var strLeagueList = ",";
    for (var i = 0; i < matchdata.MatchNum; i++) {
        matchItem = matchdata.MatchList.items[i];
        if (t == 1 && strZuodiList.indexOf("," + matchItem.mId + ",") != -1) {
            if (hsLeagueCount.contains(matchItem.lId)) {
                var num = parseInt(hsLeagueCount.items(matchItem.lId)) + 1;
                hsLeagueCount.add(matchItem.lId, num);
            }
            else
                hsLeagueCount.add(matchItem.lId, 1);
            if (strLeagueList.indexOf("," + matchItem.mId + ",") == -1)
                strLeagueList += matchItem.lId + ",";
        }
        else if (t == 2 && strNotOpenList.indexOf("," + matchItem.mId + ",") != -1) {
            if (hsLeagueCount.contains(matchItem.lId)) {
                var num = parseInt(hsLeagueCount.items(matchItem.lId)) + 1;
                hsLeagueCount.add(matchItem.lId, num);
            }
            else
                hsLeagueCount.add(matchItem.lId, 1);
            if (strLeagueList.indexOf("," + matchItem.mId + ",") == -1)
                strLeagueList += matchItem.lId + ",";
        }
        else if (t == 3 && strRunList.indexOf("," + matchItem.mId + ",") != -1) {
            if (hsLeagueCount.contains(matchItem.lId)) {
                var num = parseInt(hsLeagueCount.items(matchItem.lId)) + 1;
                hsLeagueCount.add(matchItem.lId, num);
            }
            else
                hsLeagueCount.add(matchItem.lId, 1);
            if (strLeagueList.indexOf("," + matchItem.mId + ",") == -1)
                strLeagueList += matchItem.lId + ",";
        }
    }
    return strLeagueList;
}
function createLeague(t, strLeagueList) {
    html = new Array();
    html.push("<ul>");
    var j = 0;
    for (var i = 0; i < matchdata.LeagueNum; i++) {
        leagueItem = matchdata.LeagueList.items[i];
        if (strLeagueList.indexOf("," + leagueItem.lId + ",") != -1 || t == 0) {
            if (leagueItem.matchNum > 0) {
                if (leagueItem.showNum > 0)
                    html.push("<li style='background-color:#fff0f0'><input onclick='CheckLeague(this)' checked type=checkbox id='myleague_" + i + "' value='" + leagueItem.lId + "'><label style='cursor:pointer;color:" + (leagueItem.important == "1" ? "red" : "black") + "' for='myleague_" + i + "'>" + leagueItem.getName() + "[" + (t == 0 ? leagueItem.matchNum : hsLeagueCount.items(leagueItem.lId)) + "]</label></li>");
                else
                    html.push("<li style='background-color:#fff0f0'><input onclick='CheckLeague(this)'  type=checkbox id='myleague_" + i + "' value='" + leagueItem.lId + "'><label style='cursor:pointer;color:" + (leagueItem.important == "1" ? "red" : "black") + "' for='myleague_" + i + "'>" + leagueItem.getName() + "[" + (t == 0 ? leagueItem.matchNum : hsLeagueCount.items(leagueItem.lId)) + "]</label></li>");
            }
        }
    }
    html.push("</ul>");
    document.getElementById("league").innerHTML = html.join("");
}
function getImportant() {
  var  inputs = document.getElementById("league").getElementsByTagName("input");
  for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].type != "checkbox") continue;
      leagueItem = matchdata.LeagueList.Get(inputs[i].value);
      if (leagueItem.important == "1")
          inputs[i].checked = true;
      else
          inputs[i].checked = false;
  }
}
function hidematch(id){
	document.getElementById("table_" +  id).style.display="none";
	document.getElementById("hiddenCount").innerHTML=parseInt(document.getElementById("hiddenCount").innerHTML)+1;
	hiddenID+= id + "_";
	writeCookie("Bet007Odds_hiddenID", hiddenID);
}

function ShowAllMatch() {
    sclassSelectNum = 0;
    document.getElementById("rb0").checked = true;
    document.getElementById("rb1").checked = false;
    document.getElementById("rb2").checked = false;
    document.getElementById("rb3").checked = false;
    createLeague(0, "");
    SelectAll(true);
    SelectOK();
}
function SetLevel(l, m) {
    level = l;
    matchType = m;
    LoadData();
//    setSortShowOrHidden();
    writeCookie("level", level);
}
function SetDate(data) {
    var arrD = data.split('-');
    var y = arrD[0];
    var m = arrD[1];
    var d = arrD[2];
	selDate=new Date(y,m-1,d);
	LoadData();
}

function setMatchTime() {
    var matchItem, goTime;
    for (var j = 0; j < matchdata.MatchNum; j++) {
        try {
            matchItem = matchdata.MatchList.items[j];
            if (matchItem.state == "1") {  //part 1			
                goTime = Math.floor((new Date() - matchItem.time2 - difftime) / 60000);
                if (goTime > 45) goTime = "45+";
                if (goTime < 1) goTime = "1";
                document.getElementById("time_" + matchItem.mId).innerHTML = goTime + "<img src='images/in.gif' border=0>";
            }
            if (matchItem.state == "3") {  //part 2		
                goTime = Math.floor((new Date() - matchItem.time2 - difftime) / 60000) + 46;
                if (goTime > 90) goTime = "90+";
                if (goTime < 46) goTime = "46";
                document.getElementById("time_" + matchItem.mId).innerHTML = goTime + "<img src='images/in.gif' border=0>";
            }
        } catch (e) { }
    }
    runtimeTimer = window.setTimeout("setMatchTime()", 30000);
}
var showSort = false;
function changeSort() {
    Config.rank = Config.rank == 0 ? 1 : 0;
    Config.writeCookie();
    makeTable(1);
//    setSortShowOrHidden();
}
function setSound() {
    Config.soundCheck = Config.soundCheck == 0 ? 1 : 0;
    Config.writeCookie();
}
function setSortShowOrHidden() {
    for (var j = 0; j < matchdata.MatchNum; j++) {
        matchItem = matchdata.MatchList.items[j];
        var obj = document.getElementById("ht_" + matchItem.mId);
        if (obj != null) {
            document.getElementById("ht_" + matchItem.mId).style.display = (Config.rank ==1? "" : "none");
            document.getElementById("gt_" + matchItem.mId).style.display = (Config.rank==1 ? "" : "none");
        }
    }
}
function getPageStr(total, page) {
    var str = '';
    str = '<div style="padding:5px 0 5px 0;float:right;">';
    str += '<ul class="a_page">';
    str += '<div style="float:left; padding:3px 10px 0 0">[ 当前第 <b>' + page + '</b> 页,共' + total + ' ]页</div>';
    for (var i = 1; i <= total; i++) {
        str += '<li' + (page == i ? ' class="p_on"' : '') + '><a href="javascript(0)" onclick="makeTable(' + i + ');return false;">' + i + '</a></li>';
    }
    str += '</ul></div>';
    return str;
}