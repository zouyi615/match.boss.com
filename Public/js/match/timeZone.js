function PopUp(Page,WinName)
{
    return showModalDialog(Page,WinName,'scrollbars=yes;resizable=no;help=no;status=no;dialogTop=130; dialogLeft=190;dialogWidth:750px;dialogHeight=490px');
}

function SelectTimeZone(Page)
{
	document.getElementById("TimeZoneList").innerHTML = '<iframe src="' + Page + '" frameborder="0" width="660" height="455" scrolling="no"></iframe>';
	with(document.getElementById("TimeZoneList_div").style)
	{
		left = (window.screen.width-parseInt(width))/2+"px";
		top = (window.screen.height-parseInt(height))/2+"px";
		display = "";
	}
}

function GetCurrentTimeZone()
{
	var now = new Date();
	var tz = 0 - now.getTimezoneOffset() / 60;//本地时区小时数
	var mtz = Math.floor(tz);
	var stz = (tz - mtz) * 60;
	var tzstr = "";
	if (tz >= 0)
		tzstr = "+";
	else
		tzstr = "-";
	if (mtz == 0)
		tzstr += "0";
	if ((tz > 0 && mtz < 10) || (tz < 0 && mtz > -10))
		tzstr += "0";
	tzstr += Math.abs(mtz).toString() + Math.abs(stz).toString();
	if (stz == 0)
		tzstr += "0";
	return tzstr;
}

function CloseTimeZoneList()
{
	document.getElementById("TimeZoneList_div").style.display = 'none';
}

var difference_Hour = 0;
var difference_Minute = 0;
var timezone_TZ = "";

function GetTimeZone(lg, DefaultTZ)	//获取时区设置
{
	if (typeof(DefaultTZ) == "undefined")
		DefaultTZ = GetCurrentTimeZone();	//默认时区

	var STZ_Hour = 8;
	var DST = false;
	var rlt = "";
	if (document.cookie.indexOf("bet007TZbegin") != -1 && document.cookie.indexOf("bet007TZend") != -1)
		timezone_TZ = document.cookie.substring(document.cookie.indexOf("bet007TZbegin") + 14, document.cookie.indexOf("bet007TZend")).toUpperCase();
	if (document.cookie.indexOf("bet007DSTbegin") != -1 && document.cookie.indexOf("bet007DSTend") != -1)
		DST = (document.cookie.substring(document.cookie.indexOf("bet007DSTbegin") + 15, document.cookie.indexOf("bet007DSTend")) == "1") ? true : false;

	if (timezone_TZ == "")
		timezone_TZ = DefaultTZ;
	
	if (timezone_TZ != "AUTO")
	{
		rlt = 'GMT' + timezone_TZ;
		var TZ_Hour = parseFloat(timezone_TZ.substring(0, 3));
		var TZ_Minute = parseFloat(timezone_TZ.substring(3, 5));
		difference_Minute = TZ_Minute;
		if (TZ_Hour < 0)
		{
			difference_Hour = 0 - (STZ_Hour - TZ_Hour);
			difference_Minute = 0 - difference_Minute;
		}
		else
		{	
			difference_Hour = TZ_Hour - STZ_Hour;
		}
	}
	else if (timezone_TZ == "AUTO")
	{
		DST = false;          //自动状况去掉夏令时cookie
		if (lg == 0)
			rlt = "自動";
		else if (lg == 1)
			rlt = "自动";
		else if (lg == 2)
			rlt = "Auto";
		else if (lg == 3)
			rlt = "Tự động";
		else if (lg == 4)
			rlt = "อัตโนมัติ";
		else if (lg == 5)
			rlt = "자동";
		var LTimeZone = new Date().getTimezoneOffset() / 60;
		STZ_Hour = 0 - STZ_Hour;
		if (LTimeZone < 0)
		{
			difference_Hour = STZ_Hour - LTimeZone;
		}
		else
		{
			difference_Hour = 0 - (LTimeZone - STZ_Hour);
			difference_Minute = 0 - difference_Minute;
		}
	}
	if (DST)	//Daylight Saving Time夏令时
	{
		difference_Hour += 1;
		if (lg == 0)
			rlt += "(夏令時)";
		else if (lg == 1)
			rlt += "(夏令时)";
		else if (lg == 2)
			rlt += "(DST)";
		else if (lg == 3)
			rlt += "(Giờ mùa)";
		else if (lg == 4)
			rlt += "(DST)";
		else if (lg == 5)
			rlt += "(서머타임)";
	}
	return rlt;
}

function TimeZone_formatNumber(s)
{
	if (s < 10)
		return "0" + s;
	return s;
}

function AmountTimeDiff(dateStr) {
    var dl = new Date(parseInt(dateStr));
    return (new Date(dl.getFullYear(), dl.getMonth(), dl.getDate(), dl.getHours() + difference_Hour, dl.getMinutes() + difference_Minute, 0, 0));
}


function AmountTimeDiff2(dateStr) {
    var t = dateStr.split(",");
    return (new Date(t[0], t[1], t[2], parseInt(t[3]) + difference_Hour, parseInt(t[4]) + difference_Minute, t[5], 0));
}

var CWeekDays = ["日","一","二","三","四","五","六"];
var EWeekDays = ["Sunday","Monthday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
var KWeekDays = ["일","월","화","수","목","금","토"];