function selCompany(ID) {
    document.getElementById("loading").style.display = "";
    document.getElementById("odds").innerHTML = "";
    try {
        if (companyID != ID) document.getElementById("net" + companyID).className = "";
        //document.getElementById("net"+ID).className="nav_on";
    }
    catch (e) { }
    try {
        //if(companyID!=ID)	document.getElementById("net"+ companyID).className="";
        document.getElementById("net" + ID).className = "nav_on";
    }
    catch (e) { }
    companyID = ID;
    window.setTimeout("loadodds()", 10);
    window.setTimeout("setSortShowOrHidden()", 12);
}
var oldXML = "";
var leaguecount, boolshow, oddsItem;
var state = ["推迟", "中断", "腰斩", "待定", "取消", "", "", "", "", "", "", "", "", "<font color=red>完</font>", "", "上", "中", "下", "加"];
var companyID = 3, fullxmlfile, chxmlfile, level = 2; 
if (window.location.href.indexOf("?id=") > 0) companyID = window.location.href.substring(window.location.href.indexOf("?id=") + 4);
var hasHalfOdds = false;
var nofityTimer = "";
var oldLevel = -1;
var selDate = "";
var matchType = 0;
var sclassid = ",";
function SetLanguage(l) {
    var oldLang = Config.language;
    Config.language = l;
    if (oldLang != Config.language)
        changeUrl(Config.language);
    Config.writeCookie(); 
}
matchdata.LeagueList = new _glodds.List();
matchdata.MatchList = new _glodds.List();
matchdata.CompanyList = new _glodds.List();
matchdata.Odds1List = new _glodds.List();
matchdata.Odds2List = new _glodds.List();
matchdata.Odds3List = new _glodds.List();
matchdata.Odds4List = new _glodds.List();
matchdata.Odds5List = new _glodds.List();
var oddsDomain;
function loadodds() {
    //	if(lang!=lang)	writeCookie("Bet007_odds_SelLanguage", lang);
    //	lang=lang;
    strZuodiList = ","; strRunList = ","; strNotOpenList = ",";
    hasHalfOdds = false;
    if (companyID == 3 || companyID == 24 || companyID == 31 || companyID == 12) hasHalfOdds = true;
    document.getElementById("loading").style.display = "";
    document.getElementById("odds").innerHTML = "";

    var oXmlHttp = zXmlHttp.createRequest();
    oXmlHttp.open("get", "xml/Odds2.aspx?companyid=" + companyID + "&" + Date.parse(new Date()), false);

    oXmlHttp.send(null);
    var data = oXmlHttp.responseText;
    matchdata.LeagueList = new _glodds.List();
    matchdata.MatchList = new _glodds.List();
    matchdata.CompanyList = new _glodds.List();
    matchdata.Odds1List = new _glodds.List();
    matchdata.Odds2List = new _glodds.List();
    matchdata.Odds3List = new _glodds.List();
    matchdata.Odds4List = new _glodds.List();
    matchdata.Odds5List = new _glodds.List();


    matchdata.CTypeNum = new Object();

    //split data
    var domains = data.split(_glodds.SplitDomain);
    var leagueItem, oddsItem, matchItem, companyItem, nd;

    //get league data
    var leagueDomain = domains[0].split(_glodds.SplitRecord);
    matchdata.LeagueNum = leagueDomain.length;
    for (var i = 0; i < leagueDomain.length; i++) {
        leagueItem = new _glodds.League(leagueDomain[i]);
        matchdata.LeagueList.Add(leagueItem.lId, leagueItem);
    }

    //get OddsAsian data
    var oddsDomain = domains[2].split(_glodds.SplitRecord);
    for (var i = 0; i < oddsDomain.length; i++) {
        oddsItem = new _glodds.OddsAsian(oddsDomain[i]);
        matchdata.Odds1List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
    }
    //get Odds1x2 data
    var oddsDomain = domains[3].split(_glodds.SplitRecord);
    for (var i = 0; i < oddsDomain.length; i++) {
        oddsItem = new _glodds.Odds1x2(oddsDomain[i]);
        matchdata.Odds2List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
    }

    //get OddsOU data
    var oddsDomain = domains[4].split(_glodds.SplitRecord);
    for (var i = 0; i < oddsDomain.length; i++) {
        oddsItem = new _glodds.OddsOU(oddsDomain[i]);
        matchdata.Odds3List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
    }

    //get OddsAsian_HT data
    var oddsDomain = domains[6].split(_glodds.SplitRecord);
    for (var i = 0; i < oddsDomain.length; i++) {
        oddsItem = new _glodds.OddsAsian_HT(oddsDomain[i]);
        matchdata.Odds4List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
    }

    //get OddsOU_HT data
    var oddsDomain = domains[7].split(_glodds.SplitRecord);
    for (var i = 0; i < oddsDomain.length; i++) {
        oddsItem = new _glodds.OddsOU_HT(oddsDomain[i]);
        matchdata.Odds5List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
    }

    //get match data
    matchDomain = domains[1].split(_glodds.SplitRecord);
    makeTable(1);
}
function makeTable(page) {
    var hh = 0;
    hiddenID = getCookie("Bet007Odds_hiddenID");
    if (hiddenID == null) hiddenID = "_";
    var ArrayHiddenID = hiddenID.split("_");
    matchdata.MatchNum = 0;
    var goal_cn, goal_cn2;
    var oldmatch_type = "";
    boolshow = new Array(matchDomain.length);
    var html = new Array();
    html.push("<table width='690'  border=0 align=center cellpadding=2 cellspacing=1 class=b_tab_old>");
    html.push("<tr bgcolor=#DDDDDD align=center class=\"stit\"><td width=4%> </td><td width=7%>" + (Config.language == 0 ? "时间" : "時間") + "</td><td width=20% align=left>" + (Config.language == 0 ? "对阵" : "對陣") + "</td>");

    if (hasHalfOdds)
        html.push("<td width=7%>比分</td><td width=8%>" + (Config.language == 0 ? "独赢" : "獨贏") + "</td><td width=13%>" + (Config.language == 0 ? "让" : "讓") + "球</td><td width=14%>大小</td><td width=13% style=\"background:#32ACEB\">半" + (Config.language == 0 ? "场" : "場") + (Config.language == 0 ? "让" : "讓") + "球</td><td width=14% style=\"background:#32ACEB\">半" + (Config.language == 0 ? "场" : "場") + "大小</td></tr></table>");
    else
        html.push("<td width=8%>" + (Config.language == 0 ? "独赢" : "獨贏") + "</td><td width=13%>" + (Config.language == 0 ? "让" : "讓") + "球</td><td width=14%>大小</td></tr></table>");


    for (var i = 0; i < matchDomain.length; i++) {
        matchItem = new _glodds.Match(matchDomain[i]);       
        var haveOdds = false;
        var hasZuodi = false;
        var oddsItem = matchdata.Odds1List.Get(matchItem.mId + "_" + companyID);
        if (oddsItem != null) {
            haveOdds = true;
            if (!hasZuodi)
                hasZuodi = oddsItem.zoudi == "True";
        } 
        if (matchdata.Odds2List.Get(matchItem.mId + "_" + companyID) != null) haveOdds = true;
        if (matchdata.Odds3List.Get(matchItem.mId + "_" + companyID) != null) haveOdds = true;
        if (matchItem.mId == 908399) {
            var ss = "11";
        }
        if (!haveOdds) continue;
        if (matchItem.state == 0)
            strNotOpenList += matchItem.mId + ",";
        else if (matchItem.state > 0)
            strRunList += matchItem.mId + ",";
        if (hasZuodi)
            strZuodiList += matchItem.mId + ",";        
        oddsA = matchdata.Odds1List.Get(matchItem.mId + "_" + companyID);
        oddsO = matchdata.Odds2List.Get(matchItem.mId + "_" + companyID);
        oddsD = matchdata.Odds3List.Get(matchItem.mId + "_" + companyID);
        oddsA_HT = matchdata.Odds4List.Get(matchItem.mId + "_" + companyID);
        oddsD_HT = matchdata.Odds5List.Get(matchItem.mId + "_" + companyID);
        if (matchItem.state != "0" && (companyID == 1 || companyID == 4 || companyID == 8 || companyID == 12 || companyID == 14 || companyID == 17 || oddsA == null || oddsA.zoudi == "False")) continue;

        matchdata.MatchNum++;
        matchdata.MatchList.Add(matchItem.mId, matchItem);   
        leagueItem = matchdata.LeagueList.Get(matchItem.lId);
        leagueItem.matchNum++;
        if (hiddenID != "_" && hiddenID.indexOf("_" + matchItem.mId + "_") != -1) {
            hh++;
            continue;
        }            
        sclassid += matchItem.lId + ",";
        boolshow[matchdata.MatchNum - 1] = true;
        leagueItem.showNum++;
        if (oldmatch_type != leagueItem.enName) {
            html.push('<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="b_tab_old">');
            html.push("<tr><td width=\"100%\" height=\"24\" align=\"left\" bgcolor=\"" + leagueItem.color + "\" style=\"padding:0 8px; line-height:24px\"><font color=\"#FFFFFF\"><b>" + leagueItem.getName(Config.language) + "</b></font></td></tr>");
            html.push("</table>");
            oldmatch_type = leagueItem.enName;
        }
        html.push("<table width='100%' border=0 align=center cellpadding=2 cellspacing=1 class=b_tab_old id='table_" + matchItem.mId + "' index=" + (matchdata.MatchNum - 1) + ">");
        html.push("<tr class=b_cen id='tr_" + matchItem.mId + "'><td rowspan=3 width=4%><img src=\"/images/close.gif\" width=\"15\" height=\"15\" onclick='hidematch(" + matchItem.mId + ")'/></td>");

        html.push("<td rowSpan=3 width=7%><span id='t_" + matchItem.mId + "'>" + formatTime(matchItem.time));
        if (oddsA != null && oddsA.zoudi == "True") html.push("<br><img src=\"/images/t3.gif\" width=\"10\" height=\"10\" />");
        html.push("</span></td>");

        if (matchItem.flag != "")
            html.push("<td align=left width=20% id='home_" + matchItem.mId + "'><a  href='javascript:TeamPanlu_10(" + matchItem.mId + ")'>" + matchItem.getT1Name(Config.language) + "(中)" + matchItem.t1Position + "</a></td>");
        else
            html.push("<td align=left width=20% id='home_" + matchItem.mId + "'><a  href='javascript:TeamPanlu_10(" + matchItem.mId + ")'>" + matchItem.getT1Name(Config.language) + "(主)" + matchItem.t1Position + "</a></td>");

        if (hasHalfOdds) {
            if (matchItem.state == "0")//未开场
                html.push("<td width=7% rowspan=3><span id=hs_" + matchItem.mId + " class=score></span><BR><a href=\"javascript:scoreDetail(" + matchItem.mId + ")\" target=_self><span id=time_" + matchItem.mId + "></span></a><BR><span id=gs_" + matchItem.mId + " class=score></span></td>");
            else
                html.push("<td width=7% rowspan=3><span id=hs_" + matchItem.mId + " class=score>" + matchItem.homeScore + "</span><BR><a href=\"javascript:scoreDetail(" + matchItem.mId + ")\" target=_self><span id=time_" + matchItem.mId + ">" + state[parseInt(matchItem.state) + 14] + "</span></a><BR><span id=gs_" + matchItem.mId + " class=score>" + matchItem.guestScore + "</span></td>");
        }
        html.push("<td width=8%><a href=\"javascript:ChangeDetail_s(" + matchItem.mId + ")\" class=sb id='HomeWin_" + matchItem.mId + "'>" + (oddsO == null ? "" : oddsO.hw) + "</a></td>");

        goal_cn = "";
        goal_cn2 = "";
        if (oddsA != null && oddsA.goal != "") goal_cn = Goal2GoalCn(oddsA.goal);
        if (oddsA_HT != null && oddsA_HT.goal != "") goal_cn2 = Goal2GoalCn(oddsA_HT.goal);

        html.push("<td width=13% align=right><a href=\"javascript:ChangeDetail(" + matchItem.mId + ")\" class=pk id='goal_" + matchItem.mId + "'>" + goal_cn + "</a> &nbsp;<a href=\"javascript:ChangeDetail(" + matchItem.mId + ")\" class=sb id='upodds_" + matchItem.mId + "'>" + (oddsA == null ? "" : oddsA.home) + "</a></td>");

        if (oddsD == null || oddsD.goal == "")
            html.push("<td align=right width=14%>大<a href=\"javascript:ChangeDetail_t(" + matchItem.mId + ")\" class=pk id='goal_t1_" + matchItem.mId + "'></a>");
        else
            html.push("<td align=right width=14%>大<a href=\"javascript:ChangeDetail_t(" + matchItem.mId + ")\" class=pk id='goal_t1_" + matchItem.mId + "'>" + Goal2GoalCn(oddsD.goal) + "</a>");
        html.push(" <a href=\"javascript:ChangeDetail_t(" + matchItem.mId + ")\" class=sb id='upodds_t_" + matchItem.mId + "'>" + (oddsD == null ? "" : oddsD.over) + "</a> </td>");

        if (hasHalfOdds) {
            html.push("<td width=13% align=right><a href=\"javascript:ChangeDetail2(" + matchItem.mId + ")\" class=pk id='goal2_" + matchItem.mId + "'>" + goal_cn2 + "</a> &nbsp;<a href=\"javascript:ChangeDetail2(" + matchItem.mId + ")\" class=sb id='upodds2_" + matchItem.mId + "'>" + (oddsA_HT == null ? "" : oddsA_HT.home) + "</a></td>");

            if (oddsD_HT == null || oddsD_HT.goal == "")
                html.push("<td align=right width=14%>大<a href=\"javascript:ChangeDetail_t2(" + matchItem.mId + ")\" class=pk id='goal_t12_" + matchItem.mId + "'></a>");
            else
                html.push("<td align=right width=14%>大<a href=\"javascript:ChangeDetail_t2(" + matchItem.mId + ")\" class=pk id='goal_t12_" + matchItem.mId + "'>" + Goal2GoalCn(oddsD_HT.goal) + "</a>");
            html.push(" <a href=\"javascript:ChangeDetail_t2(" + matchItem.mId + ")\" class=sb id='upodds_t2_" + matchItem.mId + "'>" + (oddsD_HT == null ? "" : oddsD_HT.over) + "</a> </td>");
        }

        html.push("</tr><tr class=b_cen id='tr2_" + matchItem.mId + "'><td align=left id='guest_" + matchItem.mId + "'><a href='javascript:TeamPanlu_10(" + matchItem.mId + ")'>" + matchItem.getT2Name(Config.language) + matchItem.t2Position + "</a></td>");
        html.push("<td><a href=\"javascript:ChangeDetail_s(" + matchItem.mId + ")\" class=sb id='GuestWin_" + matchItem.mId + "'>" + (oddsO == null ? "" : oddsO.aw) + "</a></td>");

        html.push("<td align=right><a href=\"javascript:ChangeDetail(" + matchItem.mId + ")\" class=sb id='downodds_" + matchItem.mId + "'>" + (oddsA == null ? "" : oddsA.away) + "</a></td>");

        if (oddsD == null || oddsD.goal == "")
            html.push("<td align=right>小<a href=\"javascript:ChangeDetail_t(" + matchItem.mId + ")\" class=pk id='goal_t2_" + matchItem.mId + "'> </a>  <a href=\"javascript:ChangeDetail_t(" + matchItem.mId + ")\" class=sb><span id='downodds_t_" + matchItem.mId + "'>" + (oddsD == null ? "" : oddsD.under) + "</span></a> </td>");
        else
            html.push("<td align=right>小<a href=\"javascript:ChangeDetail_t(" + matchItem.mId + ")\" class=pk id='goal_t2_" + matchItem.mId + "'>" + Goal2GoalCn(oddsD.goal) + "</a>  <a href=\"javascript:ChangeDetail_t(" + matchItem.mId + ")\" class=sb id='downodds_t_" + matchItem.mId + "'>" + (oddsD == null ? "" : oddsD.under) + "</a> </td>");

        if (hasHalfOdds) {
            html.push("<td align=right><a href=\"javascript:ChangeDetail2(" + matchItem.mId + ")\" class=sb id='downodds2_" + matchItem.mId + "'>" + (oddsA_HT == null ? "" : oddsA_HT.away) + "</a></td>");

            if (oddsD_HT == null || oddsD_HT.goal == "")
                html.push("<td align=right>小<a href=\"javascript:ChangeDetail_t2(" + matchItem.mId + ")\" class=pk id='goal_t22_" + matchItem.mId + "'> </a>  ");
            else
                html.push("<td align=right>小<a href=\"javascript:ChangeDetail_t2(" + matchItem.mId + ")\" class=pk id='goal_t22_" + matchItem.mId + "'>" + Goal2GoalCn(oddsD_HT.goal) + "</a>  ");
            html.push("<a href=\"javascript:ChangeDetail_t2(" + matchItem.mId + ")\" class=sb id='downodds_t2_" + matchItem.mId + "'>" + (oddsD_HT == null ? "" : oddsD_HT.under) + "</span></a> </td>");
        }

        html.push("</tr><tr class=b_cen id='tr3_" + matchItem.mId + "'><td align=left>和局</td>");
        html.push("<td><a href=\"javascript:ChangeDetail_s(" + matchItem.mId + ")\" class=sb id='Standoff_" + matchItem.mId + "'>" + (oddsO == null ? "" : oddsO.st) + "</a></td>");
        html.push("<td colSpan=" + (hasHalfOdds ? 4 : 2) + " align=right>");

        if (oddsA != null && oddsA.goal != oddsA.goalF)
            html.push("<span title='" + (Config.language == 0 ? "亚指初盘" : "亞指初盤") + "'><font color=#888888>初" + (Config.language == 0 ? "盘" : "盤") + "：" + Goal2GoalCn(oddsA.goalF) + "</font></span> &nbsp; &nbsp;");
        html.push("<a href=\"javascript:AsianOdds(" + matchItem.mId + ")\" style='color:#000000'>" + (Config.language == 0 ? "亚" : "亞") + "指</A> &nbsp; <A href=\"javascript:EuropeOdds(" + matchItem.mId + ")\" target=_self style='color:#000000'>" + (Config.language == 0 ? "欧" : "歐") + "指</A> &nbsp; <A href=\"javascript:dxq(" + matchItem.mId + ",'','')\" style='color:#000000'>大小</A> &nbsp; <A href=\"javascript:analysis(" + matchItem.mId + ")\" style='color:#000000'>分析</A> &nbsp; <A href=\"javascript:showgoallist(" + matchItem.mId + ")\" style='color:#000000'>现" + (Config.language == 0 ? "场" : "場") + "</A> &nbsp; <A href=\"javascript:advices(" + matchItem.mId + ")\" style='color:#000000'>情" + (Config.language == 0 ? "报" : "報") + "</A></td></tr></table>");

        if (matchdata.MatchNum - 1 < Adcount) {
            html.push("<div class='ad_tab' id='tr_ad" + (matchdata.MatchNum - 1) + "'>" + (Config.language == 0 ? "广告" : "廣告") + "：<a href='" + adinfo1[matchdata.MatchNum - 1] + "' target=_blank>" + adinfo2[(matchdata.MatchNum - 1)] + "</a></div>");
        }
        if (matchdata.MatchNum > Adcount && matchdata.MatchNum <= Adcount + imgad2.length) {
            html.push("<div class='ad_tab'>" + imgad2[matchdata.MatchNum - Adcount - 1] + "</div>");
        }
    }
    document.getElementById("hiddenCount").innerHTML = hh;
    document.getElementById("odds").innerHTML = html.join("");
    var strLeaguList = getLegList(sclassSelectNum);
    createLeague(sclassSelectNum, strLeaguList);
    //document.getElementById("hiddenCount").innerHTML = 0;
    document.getElementById("loading").style.display = "none";
}

var xmlOdds = zXmlHttp.createRequest();
function getxml() {
    try {
        xmlOdds.open("get", "xml/ch_odds.xml?" + Date.parse(new Date()), true);
        xmlOdds.onreadystatechange = refresh;
        xmlOdds.send(null);
    }
    catch (e) { }
    window.setTimeout("getxml()", 6000);
}

function refresh() {
    if (xmlOdds.readyState != 4 || (xmlOdds.status != 200 && xmlOdds.status != 0)) return;
    if (oldXML == xmlOdds.responseText) {
        oldXML = xmlOdds.responseText;
        return;
    }
    oldXML = xmlOdds.responseText;

    var hasHalfOdds = false;
    if (companyID == 3 || companyID == 24 || companyID == 31 || companyID == 12) hasHalfOdds = true;


    var i, j;
    var match_id;
    var matchtime;
    var match_oddsid;
    var match_shangpan;
    var match_goal, match_upodds, match_downodds;
    var oddschange;
    var obj, root, node;
    var root = xmlOdds.responseXML.documentElement.childNodes[0];

    //oddsA
    for (i = 0; i < root.childNodes.length; i++) {
        var node = root.childNodes[i].childNodes[0].nodeValue.split(","); //matchid,companyid,goal,over,under,close,zoudi
        if (node[1] != companyID) continue;

        match_id = node[0];
        match_goal = node[2]; //盘口
        match_upodds = node[3]; //上盘水位
        match_downodds = node[4]; // 下盘水位

        oddsItem = matchdata.Odds1List.Get(match_id + "_" + companyID);

        var obj = document.getElementById("table_" + match_id);
        if (obj == null) continue;
        match_index = obj.attributes["index"].value;
        obj = obj.ownerDocument;
        oddschange = false;

        if (oddsItem != null) {
            //letgoal up
            if (oddsItem.home != match_upodds) {
                if (oddsItem.home > match_upodds)
                    obj.getElementById("upodds_" + match_id).style.backgroundColor = fallColor;
                else
                    obj.getElementById("upodds_" + match_id).style.backgroundColor = riseColor;
                obj.getElementById("upodds_" + match_id).innerHTML = match_upodds;
                oddsItem.home = match_upodds;
                oddschange = true;
            }
            //letgoal down
            if (oddsItem.away != match_downodds) {
                if (oddsItem.away > match_downodds)
                    obj.getElementById("downodds_" + match_id).style.backgroundColor = fallColor;
                else
                    obj.getElementById("downodds_" + match_id).style.backgroundColor = riseColor;
                obj.getElementById("downodds_" + match_id).innerHTML = match_downodds;
                oddsItem.away = match_downodds;
                oddschange = true;
            }

            //goal
            if (oddsItem.goal != match_goal) {
                if (parseFloat(oddsItem.goal) < parseFloat(match_goal))
                    obj.getElementById("goal_" + match_id).innerHTML = "<img src='images/odds_up.gif' width=12 height=11 border=0>" + Goal2GoalCn(match_goal);
                else
                    obj.getElementById("goal_" + match_id).innerHTML = Goal2GoalCn(match_goal) + "<img src='images/odds_down.gif' width=12 height=11 border=0>";
                oddsItem.goal = match_goal;
                oddschange = true;
            }
        }
        else {
            var tmp = node[0] + "," + node[1] + "," + node[2] + "," + node[3] + "," + node[4] + "," + node[2] + "," + node[3] + "," + node[4] + "," + node[5] + "," + node[6];
            oddsItem = new _glodds.OddsAsian(tmp);
            matchdata.Odds1List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
        }

        if (oddschange) Ch_SB_odds(match_id, hasHalfOdds); //sound
    }


    //oddsO
    root = xmlOdds.responseXML.documentElement.childNodes[1];
    for (i = 0; i < root.childNodes.length; i++) {
        var node = root.childNodes[i].childNodes[0].nodeValue.split(","); //matchid,companyid,homewin,Standoff,guestwin
        if (node[1] != companyID) continue;

        match_id = node[0];
        homewin = node[2]; //主胜
        Standoff = node[3]; //和局
        guestwin = node[4]; // 客胜


        oddsItem = matchdata.Odds2List.Get(match_id + "_" + companyID);

        var obj = document.getElementById("table_" + match_id);
        if (obj == null) continue;
        match_index = obj.attributes["index"].value;
        obj = obj.ownerDocument;
        oddschange = false;

        if (oddsItem != null) {
            //homewin
            if (oddsItem.hw != homewin) {
                if (oddsItem.hw > homewin)
                    obj.getElementById("HomeWin_" + match_id).style.backgroundColor = fallColor;
                else
                    obj.getElementById("HomeWin_" + match_id).style.backgroundColor = riseColor;
                obj.getElementById("HomeWin_" + match_id).innerHTML = homewin;
                oddsItem.hw = homewin;
                oddschange = true;
            }

            //guestwin
            if (oddsItem.aw != guestwin) {
                if (oddsItem.aw > guestwin)
                    obj.getElementById("GuestWin_" + match_id).style.backgroundColor = fallColor;
                else
                    obj.getElementById("GuestWin_" + match_id).style.backgroundColor = riseColor;
                obj.getElementById("GuestWin_" + match_id).innerHTML = guestwin;
                oddsItem.aw = guestwin;
                oddschange = true;
            }
            //standoff
            if (oddsItem.st != Standoff) {
                if (oddsItem.st > Standoff)
                    obj.getElementById("Standoff_" + match_id).style.backgroundColor = fallColor;
                else
                    obj.getElementById("Standoff_" + match_id).style.backgroundColor = riseColor;
                obj.getElementById("Standoff_" + match_id).innerHTML = Standoff;
                oddsItem.st = Standoff;
                oddschange = true;
            }
        } else {
            var tmp = node[0] + "," + node[1] + "," + node[2] + "," + node[3] + "," + node[4] + "," + node[2] + "," + node[3] + "," + node[4];
            oddsItem = new _glodds.Odds1x2(tmp);
            matchdata.Odds2List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
        }

        if (oddschange) Ch_SB_odds(match_id, hasHalfOdds); //sound
    }
    //oddsD
    root = xmlOdds.responseXML.documentElement.childNodes[2];
    for (i = 0; i < root.childNodes.length; i++) {
        var node = root.childNodes[i].childNodes[0].nodeValue.split(","); //matchid,companyid,goal,over,under
        if (node[1] != companyID) continue;

        match_id = node[0];
        match_goal_t = node[2]; //让球
        match_upodds_t = node[3]; //主队
        match_downodds_t = node[4]; // 客队


        oddsItem = matchdata.Odds3List.Get(match_id + "_" + companyID);

        var obj = document.getElementById("table_" + match_id);
        if (obj == null) continue;
        match_index = obj.attributes["index"].value;
        obj = obj.ownerDocument;
        oddschange = false;

        if (oddsItem != null) {
            //over
            if (oddsItem.over != match_upodds_t) {
                if (oddsItem.over > match_upodds_t)
                    obj.getElementById("upodds_t_" + match_id).style.backgroundColor = fallColor;
                else
                    obj.getElementById("upodds_t_" + match_id).style.backgroundColor = riseColor;

                obj.getElementById("upodds_t_" + match_id).innerHTML = match_upodds_t;
                oddsItem.over = match_upodds_t;
                oddschange = true;
            }

            //under
            if (oddsItem.under != match_downodds_t) {
                if (oddsItem.under > match_downodds_t)
                    obj.getElementById("downodds_t_" + match_id).style.backgroundColor = fallColor;
                else
                    obj.getElementById("downodds_t_" + match_id).style.backgroundColor = riseColor;
                obj.getElementById("downodds_t_" + match_id).innerHTML = match_downodds_t;
                oddsItem.under = match_downodds_t;
                oddschange = true;
            }

            //o/u
            if (oddsItem.goal != match_goal_t) {
                if (parseFloat(oddsItem.goal) < parseFloat(match_goal_t)) {//up
                    obj.getElementById("goal_t1_" + match_id).innerHTML = "<img src='images/odds_up.gif' width=12 height=11 border=0>" + Goal2GoalCn(match_goal_t);
                    obj.getElementById("goal_t2_" + match_id).innerHTML = "<img src='images/odds_up.gif' width=12 height=11 border=0>" + Goal2GoalCn(match_goal_t);
                }
                else {
                    obj.getElementById("goal_t1_" + match_id).innerHTML = Goal2GoalCn(match_goal_t) + "<img src='images/odds_down.gif' width=12 height=11 border=0>";
                    obj.getElementById("goal_t2_" + match_id).innerHTML = Goal2GoalCn(match_goal_t) + "<img src='images/odds_down.gif' width=12 height=11 border=0>";
                }

                oddsItem.goal = match_goal_t;
                goalchange_t = true;
            }
        }
        else {
            var tmp = node[0] + "," + node[1] + "," + node[2] + "," + node[3] + "," + node[4] + "," + node[2] + "," + node[3] + "," + node[4];
            oddsItem = new _glodds.OddsOU(tmp);
            matchdata.Odds3List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
        }

        if (oddschange) Ch_SB_odds(match_id, hasHalfOdds); //sound
    }

    root = xmlOdds.responseXML.documentElement.childNodes[3];

    //oddsA_HT
    for (i = 0; i < root.childNodes.length; i++) {
        var node = root.childNodes[i].childNodes[0].nodeValue.split(","); //matchid,companyid,goal,over,under
        if (node[1] != companyID) continue;

        match_id = node[0];
        match_goal = node[2]; //盘口
        match_upodds = node[3]; //上盘水位
        match_downodds = node[4]; // 下盘水位

        oddsItem = matchdata.Odds4List.Get(match_id + "_" + companyID);

        var obj = document.getElementById("table_" + match_id);
        if (obj == null) continue;
        match_index = obj.attributes["index"].value;
        obj = obj.ownerDocument;
        oddschange = false;

        if (oddsItem != null) {
            if (hasHalfOdds) { //半场赔率

                //up
                if (oddsItem.homeF != match_upodds) {
                    if (oddsItem.homeF > match_upodds)
                        obj.getElementById("upodds2_" + match_id).style.backgroundColor = fallColor;
                    else
                        obj.getElementById("upodds2_" + match_id).style.backgroundColor = riseColor;
                    obj.getElementById("upodds2_" + match_id).innerHTML = match_upodds;
                    oddsItem.homeF = match_upodds;
                    oddschange = true;
                }

                //down
                if (oddsItem.awayF != match_downodds) {
                    if (oddsItem.awayF > match_downodds)
                        obj.getElementById("downodds2_" + match_id).style.backgroundColor = fallColor;
                    else
                        obj.getElementById("downodds2_" + match_id).style.backgroundColor = riseColor;
                    obj.getElementById("downodds2_" + match_id).innerHTML = match_downodds;
                    oddsItem.awayF = match_downodds;
                    oddschange = true;
                }

                //goal
                if (oddsItem.goalF != match_goal) {
                    if (parseFloat(oddsItem.goalF) < parseFloat(match_goal))
                        obj.getElementById("goal2_" + match_id).innerHTML = "<img src='images/odds_up.gif' width=12 height=11 border=0>" + Goal2GoalCn(match_goal);
                    else
                        obj.getElementById("goal2_" + match_id).innerHTML = Goal2GoalCn(match_goal) + "<img src='images/odds_down.gif' width=12 height=11 border=0>";
                    oddsItem.goalF = match_goal;
                    goalchange = true;
                }

            }
        }
        else {
            var tmp = node[0] + "," + node[1] + "," + node[2] + "," + node[3] + "," + node[4] + "," + node[2] + "," + node[3] + "," + node[4];
            oddsItem = new _glodds.OddsAsian_HT(tmp);
            matchdata.Odds4List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
        }

        if (oddschange) Ch_SB_odds(match_id, hasHalfOdds); //sound
    }

    //oddsD_HT
    root = xmlOdds.responseXML.documentElement.childNodes[4];
    for (i = 0; i < root.childNodes.length; i++) {
        var node = root.childNodes[i].childNodes[0].nodeValue.split(","); //matchid,companyid,goal,over,under
        if (node[1] != companyID) continue;

        match_id = node[0];
        match_goal_t = node[2]; //让球
        match_upodds_t = node[3]; //主队
        match_downodds_t = node[4]; // 客队


        oddsItem = matchdata.Odds5List.Get(match_id + "_" + companyID);

        var obj = document.getElementById("table_" + match_id);
        if (obj == null) continue;
        match_index = obj.attributes["index"].value;
        obj = obj.ownerDocument;
        oddschange = false;

        if (oddsItem != null) {
            if (hasHalfOdds) { //半场赔率

                //over
                if (oddsItem.overF != match_upodds_t) {
                    if (oddsItem.overF > match_upodds_t)
                        obj.getElementById("upodds_t2_" + match_id).style.backgroundColor = fallColor;
                    else
                        obj.getElementById("upodds_t2_" + match_id).style.backgroundColor = riseColor;
                    obj.getElementById("upodds_t2_" + match_id).innerHTML = match_upodds_t;
                    oddsItem.overF = match_upodds_t;
                    oddschange = true;
                }

                //under
                if (oddsItem.underF != match_downodds_t) {
                    if (oddsItem.underF > match_downodds_t)
                        obj.getElementById("downodds_t2_" + match_id).style.backgroundColor = fallColor;
                    else
                        obj.getElementById("downodds_t2_" + match_id).style.backgroundColor = riseColor;
                    obj.getElementById("downodds_t2_" + match_id).innerHTML = match_downodds_t;
                    oddsItem.underF = match_downodds_t;
                    oddschange = true;
                }
                //ou
                if (oddsItem.goalF != match_goal_t) {
                    if (parseFloat(oddsItem.goalF) < parseFloat(match_goal_t)) {
                        obj.getElementById("goal_t12_" + match_id).innerHTML = "<img src='images/odds_up.gif' width=12 height=11 border=0>" + Goal2GoalCn(match_goal_t);
                        obj.getElementById("goal_t22_" + match_id).innerHTML = "<img src='images/odds_up.gif' width=12 height=11 border=0>" + Goal2GoalCn(match_goal_t);
                    }
                    else {
                        obj.getElementById("goal_t12_" + match_id).innerHTML = Goal2GoalCn(match_goal_t) + "<img src='images/odds_down.gif' width=12 height=11 border=0>";
                        obj.getElementById("goal_t22_" + match_id).innerHTML = Goal2GoalCn(match_goal_t) + "<img src='images/odds_down.gif' width=12 height=11 border=0>";
                    }
                    oddsItem.goalF = match_goal_t;
                    goalchange = true;
                }
            }
        }
        else {
            var tmp = node[0] + "," + node[1] + "," + node[2] + "," + node[3] + "," + node[4] + "," + node[2] + "," + node[3] + "," + node[4];
            oddsItem = new _glodds.OddsOU_HT(tmp);
            matchdata.Odds5List.Add(oddsItem.mId + "_" + oddsItem.cId, oddsItem);
        }

        if (oddschange) Ch_SB_odds(match_id, hasHalfOdds); //sound
    }

}

function Ch_SB_odds(m) {
    if (Config.soundCheck && document.getElementById("table_" + m).style.display != "none")
        ShowSound("images/oddssound.swf");
//        document.getElementById("sound").innerHTML = flash_Odds;
    window.setTimeout("ComebackSBOddsColor(" + m + ")", 60000);
}

function ComebackSBOddsColorBak(matchid, hasHalfOdds) {  //恢复背景颜色
    document.getElementById("upodds_" + matchid).style.backgroundColor = "";
    document.getElementById("downodds_" + matchid).style.backgroundColor = "";
    document.getElementById("upodds_t_" + matchid).style.backgroundColor = "";
    document.getElementById("downodds_t_" + matchid).style.backgroundColor = "";
    document.getElementById("homewin_" + matchid).style.backgroundColor = "";
    document.getElementById("guestwin_" + matchid).style.backgroundColor = "";
    document.getElementById("standoff_" + matchid).style.backgroundColor = "";
    document.getElementById("goal_" + matchid).innerHTML = document.getElementById("goal_" + matchid).innerHTML.toLowerCase().replace(/<img.*?>/g, "");
    document.getElementById("goal_t1_" + matchid).innerHTML = document.getElementById("goal_t1_" + matchid).innerHTML.toLowerCase().replace(/<img.*?>/g, "");
    document.getElementById("goal_t2_" + matchid).innerHTML = document.getElementById("goal_t2_" + matchid).innerHTML.toLowerCase().replace(/<img.*?>/g, "");
    if (hasHalfOdds) {
        document.getElementById("upodds2_" + matchid).style.backgroundColor = "";
        document.getElementById("downodds2_" + matchid).style.backgroundColor = "";
        document.getElementById("upodds_t2_" + matchid).style.backgroundColor = "";
        document.getElementById("downodds_t2_" + matchid).style.backgroundColor = "";
        document.getElementById("goal2_" + matchid).innerHTML = document.getElementById("goal2_" + matchid).innerHTML.toLowerCase().replace(/<img.*?>/g, "");
        document.getElementById("goal_t12_" + matchid).innerHTML = document.getElementById("goal_t12_" + matchid).innerHTML.toLowerCase().replace(/<img.*?>/g, "");
        document.getElementById("goal_t22_" + matchid).innerHTML = document.getElementById("goal_t22_" + matchid).innerHTML.toLowerCase().replace(/<img.*?>/g, "");
    }
}

function ComebackSBOddsColor(matchid, hasHalfOdds) {  //恢复背景颜色
    var obj = document.getElementById("table_" + matchid).getElementsByTagName("a");
    for (i = 0; i < obj.length; i++) {
        if (obj[i].className == "") continue;
        obj[i].style.backgroundColor = "";
        obj[i].innerHTML = obj[i].innerHTML.toLowerCase().replace(/<img.*?>/g, "");
    }
}
function ChangeDetail_s(matchid) {
    window.open("http://vip.win007.com/ChangeDetail/1x2.aspx?id=" + matchid + "&companyid=" + companyID, "", "");
}
function ChangeDetail(matchid) {
    window.open("http://vip.win007.com/ChangeDetail/handicap.aspx?id=" + matchid + "&companyid=" + companyID, "", "");
}
function ChangeDetail_t(matchid) {
    window.open("http://vip.win007.com/ChangeDetail/overunder.aspx?id=" + matchid + "&companyid=" + companyID, "", "");
}

function ChangeDetail2(matchid) {
    window.open("http://vip.win007.com/ChangeDetail/handicapHalf.aspx?id=" + matchid + "&companyid=" + companyID, "", "");
}


function ChangeDetail_t2(matchid) {
    window.open("http://vip.win007.com/ChangeDetail/overunderHalf.aspx?id=" + matchid + "&companyid=" + companyID, "", "");
}
function autoHide() {
    for (i = 0; i < matchdata.MatchNum; i++) {
        try {
            if (companyID == 3 || companyID == 12 || companyID == 24 || companyID == 31) {
                var oddsA2 = matchdata.Odds1List.Get(matchdata.MatchList.items[i].mId + "_" + companyID);
                if (oddsA2 == null) continue;
                if (boolshow[i] && oddsA2.zoudi == "False" && (new Date() - matchdata.MatchList.items[i].time) > difftime) {  //begin & not live
                    boolshow[i] = false;
                    document.getElementById("table_" + matchdata.MatchList.items[i].mId).style.display = "none";
                }
            }
            else {
                if (boolshow[i] && (new Date() - matchdata.MatchList.items[i].time) > difftime) { //begin
                    boolshow[i] = false;
                    document.getElementById("table_" + matchdata.MatchList.items[i].mId).style.display = "none";
                }
            }
        } catch (e) { }
    }
    window.setTimeout("autoHide()", 60000);
}

function formatTime(t) {
    var M = t.getMonth() + 1;
    var d = t.getDate();
    var h = t.getHours();
    var m = t.getMinutes();
    var result = "";
    if (M < 10) M = "0" + M;
    if (d < 10) d = "0" + d;
    if (h < 10) h = "0" + h;
    if (m < 10) m = "0" + m;
    return M + "-" + d + "<br>" + h + ":" + m;
}
function advices(ID) {
    window.open("http://article.win007.com/UserWeb/LiveInformation.aspx?ID=" + ID);
}
function TeamPanlu_10(ID) {
    window.open("http://bf.win007.com/panlu/" + ID + ".htm", "", "width=690,height=690,top=10,left=100,resizable=yes,scrollbars=yes");
}

function historyodds() {
    window.open("http://vip.win007.com/history/3in1Odds.aspx?companyid=" + companyID + "&company=" + company[companyID]);
}
function scoreDetail(ID) {
    window.open("http://bf.win007.com/detail/" + ID + ".htm","");
}
function updateTimeZone() {
    document.location.reload();
}
function daohang() {
    if (!document.ns) {
        var top = document.body.scrollTop;
        if (top == 0) top = document.documentElement.scrollTop;
        if (top > 280) {
            divDaohang.style.top = top;
            divDaohang.style.left = (document.documentElement.scrollWidth - 690) / 2;
            document.getElementById("divDaohang").style.display = "";
        }
        else
            document.getElementById("divDaohang").style.display = "none";
    }
    setTimeout("daohang();", 200)
}