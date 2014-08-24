var lang2;
if (location.href.indexOf("big") != -1)
    lang2 = 1;
else
    lang2 = 0;
function ChangeSchedule(id, t) {
    var script = document.getElementById("scriptScsg");
    var s = document.createElement("script");
    s.type = "text/javascript";
    //http://info.win007.com/jsData/matchResult/2011-2012/s36.js? 
    s.charset = "utf-8";
    s.src = "http://info.nowscore.com/AjaxLeague.aspx?SclassID=" + id + "&SclassType=" + (t == 1 ? "s" : "c") + "&v=" + Date.parse(new Date());
    script.removeChild(script.firstChild);
    script.appendChild(s, "script");
}
function ChangeSchedule2(id, t, groupid) {
    var script = document.getElementById("scriptScsg");
    var s = document.createElement("script");
    s.type = "text/javascript";
    s.charset = "utf-8";
    s.src = "http://info.nowscore.com/AjaxLeague.aspx?SclassID=" + id + "&SclassType=" + (t == 1 ? "s" : "c") + "&SubSclassID=" + groupid + "&v=" + Date.parse(new Date());
    script.removeChild(script.firstChild);
    script.appendChild(s, "script");
}
function ChangeJS(sclassID, kind) {
    sclassID2 = sclassID;
    kind2 = kind;
    ChangeSchedule(sclassID, kind);
}
//轮次显示
function showRound(t) {
    var showRoundTd = document.getElementById("showRound");
    var html = " <table width='688' border='0' align='left'  cellpadding='0' cellspacing='1' bgcolor='#C6C6C6' id='Table2'> <tr align='center' bgcolor='#ffffff'>";
    html += "<td width='66' rowspan='2' bgcolor='" + arrLeague[5] + "'><div align='center' class='STYLE4'><strong>" + (t == "1" ? arrLeague[7 + parseInt(lang2)] : arrLeague[9 + parseInt(lang2)]) + "<br />第 " + selectRound + (parseInt(lang2) == 0 ? " 轮" : " 輪") + "</strong></div></td>";
    var totalRound
    if(t=="1")
        totalRound = currSubLeague[5];
        else
            totalRound = arrLeague[7];
    var upRound = parseInt(totalRound / 2);
    //上面一行
    for (var i = 1; i <= upRound; i++) {
        html += "<td width='25' class='lsm2'  " + (i == selectRound ? " id='selectName' style='color:#003366;background-color:#f4731f;'" : " onmouseover=\"this.className='lsm1'\"  onmouseout=\"this.className='lsm2'\" onclick='changeRound(this)' style='color:#003366;cursor:pointer;' ") + ">" + i + "</td> ";
    }
    html += "</tr><tr align='center' bgcolor='#ffffff'>"
    //下面一行
    for (var i = upRound + 1; i <= totalRound; i++) {
        html += "<td width='25' class='lsm2'  " + (i == selectRound ? " id='selectName' style='color:#003366;background-color:#f4731f;'" : " onmouseover=\"this.className='lsm1'\"  onmouseout=\"this.className='lsm2'\" onclick='changeRound(this)' style='color:#003366;cursor:pointer;' ") + ">" + i + "</td> ";
    }
    html += "</tr></table>";
    showRoundTd.innerHTML = html;
}

//对阵显示
function showSche() {
    var oTable=document.getElementById("Table3");    
    var rows = oTable.rows.length;
    while (rows > 2) {//清除旧数据
        oTable.deleteRow(rows - 1);
        rows--;
    }  
    var fra = document.createDocumentFragment();
    for (var i = 0; i < jh["R_" + selectRound].length; i++) {
        var arrOneRecord = jh["R_" + selectRound][i];
        var tr1 = document.createElement("tr");
        tr1.setAttribute("align", "center");
        tr1.appendChild(creatTd("bgcolor", "#DFEAF6", selectRound))//轮次
        tr1.appendChild(creatTd("bgcolor", "#ffffff", arrOneRecord[3])); //时间
        var h_redCard = "";
        if (arrOneRecord[18] != 0)
            h_redCard = "<span style='background-color:red;padding-left:2px; padding-bottom:0px; padding-right:2px; padding-bottom:0px;color:#fff;'>" + arrOneRecord[18] + "</span>"; //主队红牌
        tr1.appendChild(creatTd("bgcolor", "#ffffff", h_redCard + "<a href='http://info.win007.com/team/" + arrOneRecord[4] + (parseInt(lang2) == 0 ? "" : "_2") + ".htm' target='_blank'>" + teamHelper["T_" + arrOneRecord[4]][1 + parseInt(lang2)] + "</a><sup>[" + arrOneRecord[8] + "]</sup>"));   //主队

        tr1.appendChild(creatTd("bgcolor", "#ffffff", "<div class='redf' align='center'><a href='http://bf.win007.com/detail/" + arrOneRecord[0] + (parseInt(lang2) == 0 ? "cn" : "") + ".htm'  target='_blank'><strong>" + showScheScore(arrOneRecord[6]) + "</strong></a></div>"));  //比分
        var g_redCard = "";
        if (arrOneRecord[19] != 0)
            g_redCard = "<span style='background-color:red;padding-left:2px; padding-bottom:0px; padding-right:2px; padding-bottom:0px;color:#fff;'>" + arrOneRecord[19] + "</span>"; //客队红牌
        tr1.appendChild(creatTd("bgcolor", "#ffffff", "<a href='http://info.win007.com/team/" + arrOneRecord[5] + (parseInt(lang2) == 0 ? "" : "_2") + ".htm' target='_blank'>" + teamHelper["T_" + arrOneRecord[5]][1 + parseInt(lang2)] + "</a><sup>[" + arrOneRecord[9] + "]</sup>" + g_redCard)); //客队
        if (i % 2 == 0) {
            tr1.appendChild(creatTd("bgcolor", "#ffffff", showLetGoal(arrOneRecord[10]))); //让球
            tr1.appendChild(creatTd("bgcolor", "#ffffff", showLetGoal(arrOneRecord[11]))); //让球
            tr1.appendChild(creatTd("bgcolor", "#ffffff", arrOneRecord[12])); //大小
            tr1.appendChild(creatTd("bgcolor", "#ffffff", arrOneRecord[13])); //大小
        } else {
            tr1.appendChild(creatTd("style", "background-color:#E3EEF9", showLetGoal(arrOneRecord[10]))); //让球
            tr1.appendChild(creatTd("style", "background-color:#E3EEF9", showLetGoal(arrOneRecord[11]))); //让球
            tr1.appendChild(creatTd("style", "background-color:#F4E8FC", arrOneRecord[12])); //大小
            tr1.appendChild(creatTd("style", "background-color:#F4E8FC", arrOneRecord[13])); //大小
        }
        //亚欧析大
        tr1.appendChild(creatTd("bgcolor", "#ffffff", showFour(arrOneRecord[0], arrOneRecord[14], arrOneRecord[15], arrOneRecord[16], arrOneRecord[17])));
        tr1.appendChild(creatTd("bgcolor", "#ffffff", "<font color='red'>" + arrOneRecord[7] + "</font>"));
        fra.appendChild(tr1);
    }
    oTable.tBodies[0].appendChild(fra);

}
function creatTd(attrName, attrVal, txt) {
    try {
        var td = document.createElement("<td " + attrName + "='" + attrVal + "'></td>");
        td.innerHTML = txt;
        return td;
    } catch (e) {
        var td = document.createElement("td");
        if (attrName != null) {
            td.setAttribute(attrName, attrVal);
        }
        td.innerHTML = txt;
        return td;
    }
}
//赛程显示比分
function showScheScore(sscore) {
    if (sscore.indexOf("|") != -1) {
        return sscore.split("|")[parseInt(lang2)];
    }
    return sscore;
}
//让球显示，中英文
var GoalEn = ["0", "0/0.5", "0.5", "0.5/1", "1", "1/1.5", "1.5", "1.5/2", "2", "2/2.5", "2.5", "2.5/3", "3", "3/3.5", "3.5", "3.5/4", "4", "4/4.5", "4.5", "4.5/5", "5", "5/5.5", "5.5", "5.5/6", "6", "6/6.5", "6.5", "6.5/7", "7", "7/7.5", "7.5", "7.5/8", "8", "8/8.5", "8.5", "8.5/9", "9", "9/9.5", "9.5", "9.5/10", "10"];

function showLetGoal(goal) {
    try {
        var Goal2GoalCn = "";
        var goalKind = parseInt((goal * 4.0).toString());
        if (goal >= 0) {
            Goal2GoalCn = GoalEn[goalKind];
        }
        else {

            goalKind = Math.abs(goalKind);
            var enGoals = GoalEn[goalKind].split("/");
            var s = "";
            if (enGoals[0] !== "0") {//第一个数字为0则不显示负号
                if (enGoals.length == 2)
                    s = "-" + enGoals[0] + "/-" + enGoals[1];
                else
                    s = "-" + enGoals[0];
            } else {
                if (enGoals.length == 2)
                    s = enGoals[0] + "/-" + enGoals[1];
                else
                    s = enGoals[0];
            }

            Goal2GoalCn =  s;
        }      
        return Goal2GoalCn;
    } catch (e) {
        return "";
    }

}
//析，欧，亚，大
function showFour(scheid, x, o, y, d) {
    var str = "";
    if (x != 0)
        str += "<a href='http://news.win007.com/analysis/" + scheid + (parseInt(lang2) == 0 ? "cn" : "") + ".htm' target='_blank' >[析]</a>";
    if (o != 0)
        str += "<a href='http://1x2.win007.com/oddslist/" + scheid + (parseInt(lang2) == 0 ? "_2" : "") + ".htm' target='_blank' >[" + (parseInt(lang2) == 0 ? "欧" : "歐") + "]</a>";
    if (x + o + y + d > 2)
        str += "<br/>";
    if (y != 0)
        str += "<a href='http://vip.win007.com/AsianOdds_n.aspx?id=" + scheid + "' target='_blank' >[" + (parseInt(lang2) == 0 ? "亚" : "亞") + "]</a>";
    if (d != 0)
        str += "<a href='http://vip.win007.com/OverDown_n.aspx?id=" + scheid + "' target='_blank' >[大]</a>";
    return str;
}

//改变轮数
function changeRound(obj) {
    //颜色的改变
    var firstNode = document.getElementById("selectName");
    firstNode.removeAttribute("id");
    firstNode.style.backgroundColor = "";

    if (firstNode.className)
        firstNode.className = "lsm2";
    else
        firstNode.setAttribute("class", "lsm2");
    firstNode.style.cursor = "pointer";
    firstNode.onmouseover = function() { firstNode.className = 'lsm1'; };
    firstNode.onmouseout = function() { firstNode.className = 'lsm2'; };
    firstNode.onclick = function() { changeRound(firstNode); };

    obj.onmouseover = null;
    obj.onmouseout = null;
    obj.onclick = null;
    obj.className = "lsm2";
    obj.style.color = "#003366";
    obj.style.backgroundColor = "#f4731f";
    obj.setAttribute("id", "selectName");

    //重新显示轮次对阵
    selectRound = parseInt(obj.innerHTML);
    var tBoday = document.getElementById("Table3").tBodies[0];
    for (var i = tBoday.childNodes.length - 1; i > 1; i--) {
        tBoday.removeChild(tBoday.childNodes[i]);
    }
    showSche();
}
function changeSub(groupID) {
    ChangeSchedule2(sclassID2, kind2, groupID);
}
//显示总分榜------------------------------------------------------------------------------------------
//总积分榜 0颜色（没有则为-1）,1排名，2球队ID，3红牌数，4总场次，5胜，6平，7负，8得，9失，10净，11胜率，12平率，13负率，14均得，15均失，16积分，17扣分，18扣分说明


//积分榜标志，0为总积分榜，1为轮次积分榜
var scoreFlag = 0;

function showTotalScore() {
    var mainDiv = document.getElementById("tableId");
    var arrData = new Array();
    if (parseInt(lang2) == 0)
        arrData.push("<table id='div_Table1' width='688px' border='0' cellpadding='0' cellspacing='1' style='font-size:small'  bgcolor='#C6C6C6' class='tdlink'><tr bgcolor='#D1E2F5' align='center' style='font-weight:bold;'><td width='30px'>排名</td><td  height='18px'  >球队名称</td><td width='25px' >赛</td><td width='25px' >胜</td><td width='25px'>平</td><td width='25px'>负</td><td width='25px'>得</td><td width='25px' >失</td><td width='25px' >净</td><td width='50px'>胜%</td><td width='50px'>平%</td><td width='50px'>负%</td><td width='38px'>均得</td><td width='38px'>均失</td><td width='28px' >积分</td><td width='88px' >近六场</td></tr>");
    else
        arrData.push("<table id='div_Table1' width='688px' border='0' cellpadding='0' cellspacing='1' style='font-size:small'  bgcolor='#C6C6C6' class='tdlink'><tr bgcolor='#D1E2F5' align='center' style='font-weight:bold;'><td width='30px'>排名</td><td  height='18px'  >球隊名稱</td><td width='25px' >賽</td><td width='25px' >勝</td><td width='25px'>平</td><td width='25px'>負</td><td width='25px'>得</td><td width='25px' >失</td><td width='25px' >凈</td><td width='50px'>勝%</td><td width='50px'>平%</td><td width='50px'>負%</td><td width='38px'>均得</td><td width='38px'>均失</td><td width='28px' >積分</td><td width='88px' >近六場</td></tr>");
    var arrColorRefer = new Array();
    for (var i = 0; i < totalScore.length; i++) {
        var oneRecord = totalScore[i];
        var bgColor = getScoreColor(oneRecord[0]);
        if (bgColor == '')
            bgColor = "#ffffff";
        arrData.push("<tr align='center'><td bgcolor='" + bgColor + "'>" + oneRecord[1] + "</td><td bgcolor='" + bgColor + "' align='left'><a href='http://info.win007.com/team/" + oneRecord[2] + (parseInt(lang2) == 0 ? "" : "_2") + ".htm' target='_blank'>" + showScoreTeam(oneRecord[3], oneRecord[2]) + "</a></td><td bgcolor='#ffffff'>" + oneRecord[4] + "</td><td bgcolor='#ffffff'>" + oneRecord[5] + "</td><td bgcolor='#ffffff'>" + oneRecord[6] + "</td><td bgcolor='#ffffff'>" + oneRecord[7] + "</td><td bgcolor='#ffffff'>" + oneRecord[8] + "</td><td bgcolor='#ffffff'>" + oneRecord[9] + "</td><td bgcolor='#ffffff'>" + oneRecord[10] + "</td><td bgcolor='#F5DBD1'>" + oneRecord[11] + "%</td><td bgcolor='#F7EDD5'>" + oneRecord[12] + "%</td><td bgcolor='#E7F7D7'>" + oneRecord[13] + "%</td><td bgcolor='#E7F7D7'>" + oneRecord[14] + "</td><td bgcolor='#DBEEEE'>" + oneRecord[15] + "</td><td bgcolor='#FDFCCC'>" + (oneRecord[16] - oneRecord[17]) + "</td><td bgcolor='#ffffff'>" + nearSix(oneRecord[19]) + nearSix(oneRecord[20]) + nearSix(oneRecord[21]) + nearSix(oneRecord[22]) + nearSix(oneRecord[23]) + nearSix(oneRecord[24]) + "</td></tr>");

        //扣分说明
        if (oneRecord[18] != "") {
            arrData.push("<tr bgcolor='#F0F0F0'><td colspan='16'>" + (parseInt(lang2) == 0 ? "注" : "註") + ":" + oneRecord[18] + "</td></tr>");
        }

        //颜色对照表，收集用到的颜色
        var isHave = false;
        for (var k = 0; k < arrColorRefer.length; k++) {
            if (arrColorRefer[k] == oneRecord[0]) {
                isHave = true;
                break;
            }
        }
        if (!isHave && oneRecord[0] != -1)
            arrColorRefer.push(oneRecord[0]);
    }
    //颜色对照条

    var colorReferHtml = "";
    for (var k = 0; k < arrColorRefer.length; k++) {
        colorReferHtml += "<span style='color:" + getScoreColor(arrColorRefer[k]) + ";font-size:16px;' >■</span>" + scoreColor[arrColorRefer[k]].split("|")[1 + parseInt(lang2)] + "&nbsp;";
    }
    arrData.push("<tr align='center'><td colspan='16' >" + colorReferHtml + "</td></tr>");
    arrData.push("</table>");
    mainDiv.innerHTML = arrData.join('');
}

//近6轮显示
function nearSix(num) {
    if (num == 0)
       // return "<font color='red' style='font-size:11px;'>W</font>";
        return "<font color='red' style='font-size:11px;'>W</font>";
    else if (num == 1)
        return "<font color='blue'>D</font>";
    else if (num == 2)
        return "<font  style='font-size:12px;'>L</font>";
    else
        return "-"
}

//积分榜显示颜色
function getScoreColor(colorNum) {
    if (colorNum == -1)
        return "";
    var color = scoreColor[colorNum];
    return color.split("|")[0];
}
//积分榜显示球队
function showScoreTeam(redCardNum, teamID) {
    var html = "";
    if (parseInt(lang2) == 2) { //英文名
        html += teamHelper["T_" + teamID][1 + parseInt(lang2)];
    } else {
    html += teamHelper["T_" + teamID][1 + parseInt(lang2)];
    }
    if (redCardNum != 0)
        html += "&nbsp;<span style=\"padding-bottom:0px; padding-top:0px; padding-left:2px; padding-right:2px; background-color:#F00;color:#fff;\">" + redCardNum + "</span>";
    return html;
}
//点击不同的积分
function SelectScore(point) {
    //那个积分按钮改变颜色
    for (var i = 1; i <= 6; i++) {
        var menu = document.getElementById("menu" + i);
        if (point == i) {
            if (menu.className)
                menu.className = "nav_selected";
            else
                menu.setAttribute("class", "nav_selected");
        } else {
            if (menu.className)
                menu.className = "nav_unselected";
            else
                menu.setAttribute("class", "nav_unselected");
        }
    }
    if (scoreFlag == 0) {
        //改变积分版显示的数据
        switch (point) {
            case 1: showTotalScore(); break;
            case 2: otherScore(homeScore); break;
            case 3: otherScore(guestScore); break;
            case 4: otherScore(halfScore); break;
            case 5: otherScore(homeHalfScore); break;
            case 6: otherScore(guestHalfScore); break;
        }
    } else {
        //轮次积分榜显示
        var scoreRound = document.getElementById("scoreRound");
        var val = scoreRound.options[scoreRound.selectedIndex].value;
        otherScore(getScoreList(val, point));

    }
}
////其他积分榜格式 0排名，1球队ID，2总场次，3胜，4平，5负，6得，7失，8净，9胜率，10平率，11负率，12均得，13均失，14积分
function otherScore(arrScore) {
    var mainDiv = document.getElementById("tableId");
    var arrData = new Array();
    if (parseInt(lang2) == 0)
        arrData.push("<table id='div_Table1' width='688' border='0' cellpadding='0' cellspacing='1' style='font-size:small'  bgcolor='#C6C6C6' class='tdlink'><tr bgcolor='#D1E2F5' align='center' style='font-weight:bold;'><td width='30px'>排名</td><td  height='18px'  >球队名称</td><td width='35px' >赛</td><td width='35px' >胜</td><td width='35px'>平</td><td width='35px'>负</td><td width='35px'>得</td><td width='35px' >失</td><td width='35px' >净</td><td width='55px'>胜%</td><td width='55px'>平%</td><td width='55px'>负%</td><td width='38px'>均得</td><td width='38px'>均失</td><td width='28px' >积分</td></tr>");
    else
        arrData.push("<table id='div_Table1' width='688' border='0' cellpadding='0' cellspacing='1' style='font-size:small'  bgcolor='#C6C6C6' class='tdlink'><tr bgcolor='#D1E2F5' align='center' style='font-weight:bold;'><td width='30px'>排名</td><td  height='18px'  >球隊名稱</td><td width='35px' >賽</td><td width='35px' >勝</td><td width='35px'>平</td><td width='35px'>負</td><td width='35px'>得</td><td width='35px' >失</td><td width='35px' >凈</td><td width='55px'>勝%</td><td width='55px'>平%</td><td width='55px'>負%</td><td width='38px'>均得</td><td width='38px'>均失</td><td width='28px' >積分</td></tr>");
    for (var i = 0; i < arrScore.length; i++) {
        var oneRecord = arrScore[i];
        arrData.push("<tr align='center' bgcolor='#FFFFFF'><td >" + oneRecord[0] + "</td><td align='left'><a href='http://info.win007.com/team/" + oneRecord[1] + (parseInt(lang2) == 0 ? "" : "_2") + ".htm' target='_blank'>" + showScoreTeam(0, oneRecord[1]) + "</a></td><td>" + oneRecord[2] + "</td><td>" + oneRecord[3] + "</td><td>" + oneRecord[4] + "</td><td>" + oneRecord[5] + "</td><td>" + oneRecord[6] + "</td><td>" + oneRecord[7] + "</td><td>" + oneRecord[8] + "</td><td bgcolor='#F5DBD1'>" + oneRecord[9] + "%</td><td bgcolor='#F7EDD5'>" + oneRecord[10] + "%</td><td bgcolor='#E7F7D7'>" + oneRecord[11] + "%</td><td bgcolor='#E7F7D7'>" + oneRecord[12] + "</td><td bgcolor='#DBEEEE'>" + oneRecord[13] + "</td><td bgcolor='#FDFCCC'>" + oneRecord[14] + "</td></tr>");
    }
    arrData.push("</table>");
    mainDiv.innerHTML = arrData.join('');
}


//轮次积分榜----------------------------------------------------------------------------

//轮次积分榜的选择框
function scoreRoundSelect(t) {
    var sel = document.getElementById("scoreRound");
    var count = sel.options.length;
    for (var i = 1; i < count; i++) {
        sel.options[1] = null;
    }
    var ccount = 0;
    if (t == 0)
        ccount = arrLeague[8];
    else
        ccount = currSubLeague[6];
    for (var i = 1; i < ccount; i++) {
        sel.options.add(new Option("第" + i + (parseInt(lang2) == 0 ? "轮" : "輪"), i));
    }
}

function scoreRoundChange(obj) {
    var val = obj.options[obj.selectedIndex].value;
    var scoreTitleTd = document.getElementById("scoreTitle");
    if (val == 0) {
        //总积分榜
        scoreFlag = 0;
        scoreTitleTd.innerHTML = "总积分榜";
    } else {
        scoreFlag = 1; //轮次积分榜
        scoreTitleTd.innerHTML = "第" + val + (parseInt(lang2) == 0 ? "轮" : "輪") + "积分榜";
    }
    SelectScore(1);
}

Hashtable = function() {
    this.items = new Array();
    this.itemsCount = 0;
    this.add = function(key, value) {
        if (!this.containsKey(key)) {
            this.items[key] = value;
            this.itemsCount++;
        }
        else {//重复赋值
            this.items[key] = value;
        }
    }
    this.get = function(key) {
        if (this.containsKey(key))
            return this.items[key];
        else
            return null;
    }

    this.keys = function() {
        var keys = new Array();
        for (var i in this.items) {
            if (this.items[i] != null)
                keys.push(i);
        }
        return keys;
    }

    this.values = function() {
        var values = new Array();
        for (var i in this.items) {
            if (this.items[i] != null)
                values.push(this.items[i]);
        }
        return values;
    }
    this.getOneValues = function(key) {
        var retval = 0;
        if (this.containsKey(key))
            retval = parseInt(this.items[key]);
        return retval;
    }
    this.remove = function(key) {
        if (this.containsKey(key)) {
            delete this.items[key];
            this.itemsCount--;
        }
    }
    this.containsKey = function(key) {
        return typeof (this.items[key]) != "undefined";

    }
    this.containsValue = function containsValue(value) {
        for (var item in this.items) {
            if (this.items[item] == value)
                return true;
            break;
        }
        return false;
    }

    this.contains = function(keyOrValue) {
        return this.containsKey(keyOrValue) || this.containsValue(keyOrValue);
    }
    this.clear = function() {
        this.items = new Array();
        itemsCount = 0;
    }
}

function getScoreList(round, type) {//type 1:总积分榜;2:主场积分榜;3:客场积分榜;4:半场总积分榜;5:半场主场积分榜;6:半场客场积分榜
    var hs = new Hashtable();
    var scoreList = new Array(arrTeam.length);
    for (var k = 0; k < arrTeam.length; k++) {
        var teamid = arrTeam[k][0];
        for (var i = 1; i <= round; i++) {
            for (var j = 0; j < jh["R_" + i].length; j++) {
                if (jh["R_" + i][j][6].indexOf("-") == -1) continue; //推迟,取消的赛事不参与计算
                var scores = jh["R_" + i][j][6].split("-"); //全场比分
                var scoresHalf = jh["R_" + i][j][7].split("-"); //半场比分
                if (type == 4 || type == 5 || type == 6)
                    scores = scoresHalf;
                if (teamid == jh["R_" + i][j][4] && (type == 1 || type == 2 || type == 5 || type == 4))//主场
                {
                    if (scores[0] > scores[1]) {
                        if (hs.containsKey("win1_" + teamid))
                            hs.items["win1_" + teamid] = parseInt(hs.get("win1_" + teamid)) + 1;

                        else
                            hs.add("win1_" + teamid, 1);
                    }
                    else if (scores[0] == scores[1]) {
                        if (hs.containsKey("flat1_" + teamid))
                            hs.items["flat1_" + teamid] = parseInt(hs.get("flat1_" + teamid)) + 1;
                        else
                            hs.add("flat1_" + teamid, 1);
                    }
                    else {
                        if (hs.containsKey("fail1_" + teamid))
                            hs.items["fail1_" + teamid] = parseInt(hs.get("fail1_" + teamid)) + 1;
                        else
                            hs.add("fail1_" + teamid, 1);
                    }
                    if (hs.containsKey("homeScore1_" + teamid))//主场得
                        hs.items["homeScore1_" + teamid] = parseInt(hs.get("homeScore1_" + teamid)) + parseInt(scores[0]);
                    else
                        hs.add("homeScore1_" + teamid, scores[0]);
                    if (hs.containsKey("guestScore1_" + teamid))//主场失
                        hs.items["guestScore1_" + teamid] = parseInt(hs.get("guestScore1_" + teamid)) + parseInt(scores[1]);
                    else
                        hs.add("guestScore1_" + teamid, scores[1]);
                }
                else if (teamid == jh["R_" + i][j][5] && (type == 1 || type == 3 || type == 6 || type == 4))//客场
                {
                    if (scores[1] > scores[0]) {
                        if (hs.containsKey("win2_" + teamid))
                            hs.items["win2_" + teamid] = parseInt(hs.get("win2_" + teamid)) + 1;
                        else
                            hs.add("win2_" + teamid, 1);
                    }
                    else if (scores[1] == scores[0]) {
                        if (hs.containsKey("flat2_" + teamid))
                            hs.items["flat2_" + teamid] = parseInt(hs.get("flat2_" + teamid)) + 1;
                        else
                            hs.add("flat2_" + teamid, 1);
                    }
                    else {
                        if (hs.containsKey("fail2_" + teamid))
                            hs.items["fail2_" + teamid] = parseInt(hs.get("fail2_" + teamid)) + 1;
                        else
                            hs.add("fail2_" + teamid, 1);
                    }
                    if (hs.containsKey("homeScore2_" + teamid))//客场得
                        hs.items["homeScore2_" + teamid] = parseInt(hs.get("homeScore2_" + teamid)) + parseInt(scores[1]);
                    else
                        hs.add("homeScore2_" + teamid, scores[1]);
                    if (hs.containsKey("guestScore2_" + teamid))//客场失
                        hs.items["guestScore2_" + teamid] = parseInt(hs.get("guestScore2_" + teamid)) + parseInt(scores[0]);
                    else
                        hs.add("guestScore2_" + teamid, scores[0]);
                }
            }
        }
        scoreList[k] = new Array(13);
        if (type == 1 || type == 4) {//全场
            scoreList[k][3] = hs.getOneValues("win1_" + teamid) + hs.getOneValues("win2_" + teamid); //胜
            scoreList[k][4] = hs.getOneValues("flat1_" + teamid) + hs.getOneValues("flat2_" + teamid); //平
            scoreList[k][5] = hs.getOneValues("fail1_" + teamid) + hs.getOneValues("fail2_" + teamid); //负
            scoreList[k][6] = hs.getOneValues("homeScore1_" + teamid) + hs.getOneValues("homeScore2_" + teamid); //得
            scoreList[k][7] = hs.getOneValues("guestScore1_" + teamid) + hs.getOneValues("guestScore2_" + teamid); //失
        }
        else if (type == 2 || type == 5) {//主
            scoreList[k][3] = hs.getOneValues("win1_" + teamid);
            scoreList[k][4] = hs.getOneValues("flat1_" + teamid);
            scoreList[k][5] = hs.getOneValues("fail1_" + teamid);
            scoreList[k][6] = hs.getOneValues("homeScore1_" + teamid);
            scoreList[k][7] = hs.getOneValues("guestScore1_" + teamid);
        }
        else if (type == 3 || type == 6) {//客
            scoreList[k][3] = hs.getOneValues("win2_" + teamid);
            scoreList[k][4] = hs.getOneValues("flat2_" + teamid);
            scoreList[k][5] = hs.getOneValues("fail2_" + teamid);
            scoreList[k][6] = hs.getOneValues("homeScore2_" + teamid);
            scoreList[k][7] = hs.getOneValues("guestScore2_" + teamid);
        }
        scoreList[k][1] = teamid;
        scoreList[k][2] = scoreList[k][3] + scoreList[k][4] + scoreList[k][5]; //赛
        scoreList[k][8] = scoreList[k][6] - scoreList[k][7]; //净
        scoreList[k][9] = (scoreList[k][2] > 0 ? to2bits(scoreList[k][3] / scoreList[k][2] * 100, 10) : 0.0); //胜%
        scoreList[k][10] = (scoreList[k][2] > 0 ? to2bits(scoreList[k][4] / scoreList[k][2] * 100, 10) : 0.0); //平%
        scoreList[k][11] = (scoreList[k][2] > 0 ? to2bits(scoreList[k][5] / scoreList[k][2] * 100, 10) : 0.0); //负%
        scoreList[k][12] = (scoreList[k][2] > 0 ? to2bits(scoreList[k][6] / scoreList[k][2], 100) : 0.0); //均得
        scoreList[k][13] = (scoreList[k][2] > 0 ? to2bits(scoreList[k][7] / scoreList[k][2], 100) : 0.0); //均失
        scoreList[k][14] = scoreList[k][3] * 3 + scoreList[k][4]; //积分
    }
    hs.clear();
    scoreList.sort(cmp); //按积分,净,得降序排序
    for (var i = 0; i < scoreList.length; i++) {
        scoreList[i][0] = i + 1; //排名
    }
    return scoreList;
}
function cmp(a, b) {
    return b[14] == a[14] ? (a[8] == b[8] ? b[6] - a[6] : b[8] - a[8]) : b[14] - a[14];
}
function to2bits(flt, num) {
    if (flt != 0)
        return Math.round(flt * num) / num;
    else
        return 0.0;
}

function SubSelect(arrSubLeague, lang2, subSclassID) {
    var div = document.getElementById("SubSelectDiv");
    var divContent = "<table width='638' border='0' style=' border-collapse:inherit' cellpadding='0' cellSpacing='5'   align='center'><tr align='center' bgcolor='#FFFFFF' height='28'>";
    for (var i = 0; i < arrSubLeague.length; i++) {
        var subLeague = arrSubLeague[i];
        if (i != 0 && i % 4 == 0) {
            divContent += "</tr><tr align='center' bgcolor='#FFFFFF' height='28'>";
        }
        divContent += "<td  class='cupmatch_rw2' " + (subLeague[0] == subSclassID ? "style='color:red;'" : " onclick='changeSub(" + subLeague[0] + ")' style='font-weight:bold;color:blue;cursor:pointer;' ") + "  onmouseover=\"this.className='cupmatch_rw1'\"  onmouseout=\"this.className='cupmatch_rw2'\" >" + subLeague[1 + lang2] + "</td>";
        if (subLeague[0] == subSclassID) currSubLeague = subLeague;
    }
    var j = arrSubLeague.length % 4;
    for (var i = 0; j > 0 && i < 4 - j; i++) {
        divContent += "<td  width='154'></td>";
    }

    divContent += "</tr></table>";
    div.innerHTML = divContent;
}

function creatTd2(attrName, attrVal, attrName2, attrVal2, txt) {
    try {
        var td = document.createElement("<td " + attrName + "='" + attrVal + "'  " + attrName2 + "='" + attrVal2 + "' ></td>");
        td.innerHTML = txt;
        return td;
    } catch (e) {
        var td = document.createElement("td");
        td.setAttribute(attrName, attrVal);
        td.setAttribute(attrName2, attrVal2);
        td.innerHTML = txt;
        return td;
    }
}
function InitTeam() {
    for (var i = 0; i < arrTeam.length; i++) {
        teamHelper["T_" + arrTeam[i][0]] = arrTeam[i];
    }
}

function showLeageuScore() {
    try {
    document.getElementById("SubSelectDiv").style.display = "none";
    
        if (selectRound == -1)
            selectRound = arrLeague[8];
        InitTeam();
        showRound(0);
        showSche();
        showTotalScore();
        scoreRoundSelect(0);
    }
    catch (e)
    { }
}
function showSubLeageuScore() {
    try {       
        document.getElementById("SubSelectDiv").style.display = "block";

        SubSelect(arrSubLeague, parseInt(lang2), SubSclassID);
        if (selectRound == -1)
            selectRound = currSubLeague[6];
        InitTeam();
        if (currSubLeague[4] == 1) {
            if (currSubLeague[5] > 1)
                showRound(1);
            showTotalScore();
            scoreRoundSelect(1)
        } else {
            //隐藏积分榜
            document.getElementById("Table2").style.display = "none";
            document.getElementById("ScoreAllMenu").style.display = "none";
            document.getElementById("tableId").style.display = "none";
            document.getElementById("navSelectBottom").style.display = "none";
        }
        showSche();
    }
    catch (e)
    { }
}

