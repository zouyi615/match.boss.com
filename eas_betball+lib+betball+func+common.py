#coding:gbk
'''公用方法 '''
import betball.config.common as cf
import logging
import time,urllib,urllib2
import XmlUtil
import curl
import datetime
import pycurl
import StringIO
'''获取睡眠时间'''
def getThreadSleep(thread):
    if cf.config['thread_sleep_time'].has_key(thread):
        return cf.config['thread_sleep_time'][thread]
    else:
#        return 0
        return ''
    
'''获取配置路径'''
def getPath(key):
    if cf.config['path'].has_key(key):
        return cf.config['path'][key]
    else:
        return None
    
'''写日志操作'''
def write_log(msg):
    logging.info(msg)
    
'''url访问页面'''    
def fopen(path,post={},type='',timeout=18):
    content=''
    try:
#        if post:
#            content=urllib2.urlopen(path,data=urllib.urlencode(post),timeout=10).read()
#        else:
#            content=urllib2.urlopen(path,timeout=10).read()
#        request=curl.Curl()
#        #设置超时时间
#        request.set_timeout(timeout)
#        if not post:
#            content=request.get(path)
#        else:
#            content=request.post(path,post)
#        request.close()
        host = path.split("/")[2]
        if host.find("fenxi.310v.com")>=0:
            heads = {'Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Charset':'GB2312,utf-8;q=0.7,*;q=0.7',
            'Accept-Language':'zh-cn,zh;q=0.5',
            'Cache-Control':'max-age=0',
            'Connection':'keep-alive',
            'Host':host,
            'Keep-Alive':'115',
            'Referer':path,
            'User-Agent':'Mozilla/5.0 (X11; U; Linux x86_64; zh-CN; rv:1.9.2.14) Gecko/20110221 Ubuntu/10.10 (maverick) Firefox/3.6.14'}
            opener = urllib2.build_opener(urllib2.HTTPCookieProcessor())
            urllib2.install_opener(opener)
            data = urllib.urlencode(post)
            req = urllib2.Request(path,data,headers=heads)
            content = opener.open(req, timeout=30).read()
        elif host.find("bet007.com")>=0:
            c = pycurl.Curl() #创建一个同libcurl中的CURL处理器相对应的Curl对象
            b = StringIO.StringIO()
            c.setopt(pycurl.URL, path) #设置要访问的网址
            #写的回调
            c.setopt(pycurl.WRITEFUNCTION, b.write)
            c.setopt(pycurl.FOLLOWLOCATION, 1) #参数有1、2
            c.setopt(pycurl.NOSIGNAL, 1)
            #最大重定向次数,可以预防重定向陷阱
            c.setopt(pycurl.MAXREDIRS, 5)
            #连接超时设置
            c.setopt(pycurl.CONNECTTIMEOUT, 20) #链接超时
            c.setopt(pycurl.TIMEOUT, 60) #下载超时
            # c.setopt(pycurl.HEADER, True)
            c.setopt(c.HTTPHEADER, ["Referer:http://www.bet007.com"])
            #模拟浏览器
            c.setopt(pycurl.USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)")
            #访问,阻塞到访问结束
            c.perform() #执行上述访问网址的操作
            content = b.getvalue()
            b.close()
            c.close()
        else:
            request=curl.Curl()
            #设置超时时间
            request.set_timeout(timeout)
            if not post:
                content=request.get(path)
            else:
                content=request.post(path,post)
            request.close()
    except Exception,e:
        write_log('%s访问页面%s操作异常:%s!'%(type,path,e))
    return content

'''解析xml内容'''
def parseString(string):
    if string and string.find('<?xml ')==0:
        return XmlUtil.parseString(string)
    else:
        return None

'''繁体转换简体'''
def getSimplifiedChinese(string):
    simple_string=u'万与丑专业丛东丝丢两严丧个丬丰临为丽举么义乌乐乔习乡书买乱争于亏云亘亚产亩亲亵亸亿仅从仑仓仪们价众优伙会伛伞伟传伤伥伦伧伪伫体余佣佥侠侣侥侦侧侨侩侪侬俣俦俨俩俪俭债倾偬偻偾偿傥傧储傩儿兑兖党兰关兴兹养兽冁内冈册写军农冢冯冲决况冻净凄凉凌减凑凛几凤凫凭凯击凼凿刍划刘则刚创删别刬刭刽刿剀剂剐剑剥剧劝办务劢动励劲劳势勋勐勚匀匦匮区医华协单卖卢卤卧卫却卺厂厅历厉压厌厍厕厢厣厦厨厩厮县叁参叆叇双发变叙叠叶号叹叽吁后吓吕吗吣吨听启吴呒呓呕呖呗员呙呛呜咏咔咙咛咝咤咴咸哌响哑哒哓哔哕哗哙哜哝哟唛唝唠唡唢唣唤唿啧啬啭啮啰啴啸喷喽喾嗫嗬嗳嘘嘤嘱噜噼嚣嚯团园囱围囵国图圆圣圹场坂坏块坚坛坜坝坞坟坠垄垅垆垒垦垧垩垫垭垯垱垲垴埘埙埚埝埯堑堕塆塬墙壮声壳壶壸处备复够头夸夹夺奁奂奋奖奥妆妇妈妩妪妫姗姜娄娅娆娇娈娱娲娴婳婴婵婶媪嫒嫔嫱嬷孙学孪宁宝实宠审宪宫宽宾寝对寻导寿将尔尘尝尧尴尸尽层屃屉届属屡屦屿岁岂岖岗岘岙岚岛岭岳岽岿峃峄峡峣峤峥峦崂崃崄崭嵘嵚嵛嵝嵴巅巩巯币帅师帏帐帘帜带帧帮帱帻帼幂幞干并幺广庄庆庐庑库应庙庞废庼廪开异弃张弥弪弯弹强归当录彟彦彻径徕御忆忏忧忾怀态怂怃怄怅怆怜总怼怿恋恳恶恸恹恺恻恼恽悦悫悬悭悯惊惧惨惩惫惬惭惮惯愍愠愤愦愿慑慭憷懑懒懔戆戋戏戗战戬户扎扑扦执扩扪扫扬扰抚抛抟抠抡抢护报担拟拢拣拥拦拧拨择挂挚挛挜挝挞挟挠挡挢挣挤挥挦捞损捡换捣据捻掳掴掷掸掺掼揸揽揿搀搁搂搅携摄摅摆摇摈摊撄撑撵撷撸撺擞攒敌敛数斋斓斗斩断无旧时旷旸昙昼昽显晋晒晓晔晕晖暂暧札术朴机杀杂权条来杨杩杰极构枞枢枣枥枧枨枪枫枭柜柠柽栀栅标栈栉栊栋栌栎栏树栖样栾桊桠桡桢档桤桥桦桧桨桩梦梼梾检棂椁椟椠椤椭楼榄榇榈榉槚槛槟槠横樯樱橥橱橹橼檐檩欢欤欧歼殁殇残殒殓殚殡殴毁毂毕毙毡毵氇气氢氩氲汇汉污汤汹沓沟没沣沤沥沦沧沨沩沪沵泞泪泶泷泸泺泻泼泽泾洁洒洼浃浅浆浇浈浉浊测浍济浏浐浑浒浓浔浕涂涌涛涝涞涟涠涡涢涣涤润涧涨涩淀渊渌渍渎渐渑渔渖渗温游湾湿溃溅溆溇滗滚滞滟滠满滢滤滥滦滨滩滪漤潆潇潋潍潜潴澜濑濒灏灭灯灵灾灿炀炉炖炜炝点炼炽烁烂烃烛烟烦烧烨烩烫烬热焕焖焘煅煳煺熘爱爷牍牦牵牺犊犟犭状犷犸犹狈狍狝狞独狭狮狯狰狱狲猃猎猕猡猪猫猬献獭玑玙玚玛玮环现玱玺珉珏珐珑珰珲琎琏琐琼瑶瑷璇璎瓒瓮瓯电画畅畲畴疖疗疟疠疡疬疮疯疱疴痈痉痒痖痨痪痫痴瘅瘆瘗瘘瘪瘫瘾瘿癞癣癫癯皑皱皲盏盐监盖盗盘眍眦眬着睁睐睑瞒瞩矫矶矾矿砀码砖砗砚砜砺砻砾础硁硅硕硖硗硙硚确硷碍碛碜碱碹磙礼祎祢祯祷祸禀禄禅离秃秆种积称秽秾稆税稣稳穑穷窃窍窑窜窝窥窦窭竖竞笃笋笔笕笺笼笾筑筚筛筜筝筹签简箓箦箧箨箩箪箫篑篓篮篱簖籁籴类籼粜粝粤粪粮糁糇紧絷纟纠纡红纣纤纥约级纨纩纪纫纬纭纮纯纰纱纲纳纴纵纶纷纸纹纺纻纼纽纾线绀绁绂练组绅细织终绉绊绋绌绍绎经绐绑绒结绔绕绖绗绘给绚绛络绝绞统绠绡绢绣绤绥绦继绨绩绪绫绬续绮绯绰绱绲绳维绵绶绷绸绹绺绻综绽绾绿缀缁缂缃缄缅缆缇缈缉缊缋缌缍缎缏缐缑缒缓缔缕编缗缘缙缚缛缜缝缞缟缠缡缢缣缤缥缦缧缨缩缪缫缬缭缮缯缰缱缲缳缴缵罂网罗罚罢罴羁羟羡翘翙翚耢耧耸耻聂聋职聍联聩聪肃肠肤肷肾肿胀胁胆胜胧胨胪胫胶脉脍脏脐脑脓脔脚脱脶脸腊腌腘腭腻腼腽腾膑臜舆舣舰舱舻艰艳艹艺节芈芗芜芦苁苇苈苋苌苍苎苏苘苹茎茏茑茔茕茧荆荐荙荚荛荜荞荟荠荡荣荤荥荦荧荨荩荪荫荬荭荮药莅莜莱莲莳莴莶获莸莹莺莼萚萝萤营萦萧萨葱蒇蒉蒋蒌蓝蓟蓠蓣蓥蓦蔷蔹蔺蔼蕲蕴薮藁藓虏虑虚虫虬虮虽虾虿蚀蚁蚂蚕蚝蚬蛊蛎蛏蛮蛰蛱蛲蛳蛴蜕蜗蜡蝇蝈蝉蝎蝼蝾螀螨蟏衅衔补衬衮袄袅袆袜袭袯装裆裈裢裣裤裥褛褴襁襕见观觃规觅视觇览觉觊觋觌觍觎觏觐觑觞触觯詟誉誊讠计订讣认讥讦讧讨让讪讫训议讯记讱讲讳讴讵讶讷许讹论讻讼讽设访诀证诂诃评诅识诇诈诉诊诋诌词诎诏诐译诒诓诔试诖诗诘诙诚诛诜话诞诟诠诡询诣诤该详诧诨诩诪诫诬语诮误诰诱诲诳说诵诶请诸诹诺读诼诽课诿谀谁谂调谄谅谆谇谈谊谋谌谍谎谏谐谑谒谓谔谕谖谗谘谙谚谛谜谝谞谟谠谡谢谣谤谥谦谧谨谩谪谫谬谭谮谯谰谱谲谳谴谵谶谷豮贝贞负贠贡财责贤败账货质贩贪贫贬购贮贯贰贱贲贳贴贵贶贷贸费贺贻贼贽贾贿赀赁赂赃资赅赆赇赈赉赊赋赌赍赎赏赐赑赒赓赔赕赖赗赘赙赚赛赜赝赞赟赠赡赢赣赪赵赶趋趱趸跃跄跖跞践跶跷跸跹跻踊踌踪踬踯蹑蹒蹰蹿躏躜躯车轧轨轩轪轫转轭轮软轰轱轲轳轴轵轶轷轸轹轺轻轼载轾轿辀辁辂较辄辅辆辇辈辉辊辋辌辍辎辏辐辑辒输辔辕辖辗辘辙辚辞辩辫边辽达迁过迈运还这进远违连迟迩迳迹适选逊递逦逻遗遥邓邝邬邮邹邺邻郁郄郏郐郑郓郦郧郸酝酦酱酽酾酿释里鉅鉴銮錾钆钇针钉钊钋钌钍钎钏钐钑钒钓钔钕钖钗钘钙钚钛钝钞钟钠钡钢钣钤钥钦钧钨钩钪钫钬钭钮钯钰钱钲钳钴钵钶钷钸钹钺钻钼钽钾钿铀铁铂铃铄铅铆铈铉铊铋铌铍铎铏铐铑铒铓铔铕铖铗铘铙铚铛铜铝铞铟铠铡铢铣铤铥铦铧铨铩铪铫铬铭铮铯铰铱铲铳铴铵银铷铸铹铺铻铼铽链铿销锁锂锃锄锅锆锇锈锉锊锋锌锍锎锏锐锑锒锓锔锕锖锗锘错锚锛锜锝锞锟锠锡锢锣锤锥锦锧锨锩锪锫锬锭键锯锰锱锲锳锴锵锶锷锸锹锺锻锼锽锾锿镀镁镂镃镄镅镆镇镈镉镊镋镌镍镎镏镐镑镒镓镔镕镖镗镘镙镚镛镜镝镞镟镠镡镢镣镤镥镦镧镨镩镪镫镬镭镮镯镰镱镲镳镴镵镶长门闩闪闫闬闭问闯闰闱闲闳间闵闶闷闸闹闺闻闼闽闾闿阀阁阂阃阄阅阆阇阈阉阊阋阌阍阎阏阐阑阒阓阔阕阖阗阘阙阚阛队阳阴阵阶际陆陇陈陉陕陧陨险随隐隶隽难雏雠雳雾霁霉霭靓静靥鞑鞒鞯鞴韦韧韨韩韪韫韬韵页顶顷顸项顺须顼顽顾顿颀颁颂颃预颅领颇颈颉颊颋颌颍颎颏颐频颒颓颔颕颖颗题颙颚颛颜额颞颟颠颡颢颣颤颥颦颧风飏飐飑飒飓飔飕飖飗飘飙飚飞飨餍饤饥饦饧饨饩饪饫饬饭饮饯饰饱饲饳饴饵饶饷饸饹饺饻饼饽饾饿馀馁馂馃馄馅馆馇馈馉馊馋馌馍馎馏馐馑馒馓馔馕马驭驮驯驰驱驲驳驴驵驶驷驸驹驺驻驼驽驾驿骀骁骂骃骄骅骆骇骈骉骊骋验骍骎骏骐骑骒骓骔骕骖骗骘骙骚骛骜骝骞骟骠骡骢骣骤骥骦骧髅髋髌鬓魇魉鱼鱽鱾鱿鲀鲁鲂鲄鲅鲆鲇鲈鲉鲊鲋鲌鲍鲎鲏鲐鲑鲒鲓鲔鲕鲖鲗鲘鲙鲚鲛鲜鲝鲞鲟鲠鲡鲢鲣鲤鲥鲦鲧鲨鲩鲪鲫鲬鲭鲮鲯鲰鲱鲲鲳鲴鲵鲶鲷鲸鲹鲺鲻鲼鲽鲾鲿鳀鳁鳂鳃鳄鳅鳆鳇鳈鳉鳊鳋鳌鳍鳎鳏鳐鳑鳒鳓鳔鳕鳖鳗鳘鳙鳛鳜鳝鳞鳟鳠鳡鳢鳣鸟鸠鸡鸢鸣鸤鸥鸦鸧鸨鸩鸪鸫鸬鸭鸮鸯鸰鸱鸲鸳鸴鸵鸶鸷鸸鸹鸺鸻鸼鸽鸾鸿鹀鹁鹂鹃鹄鹅鹆鹇鹈鹉鹊鹋鹌鹍鹎鹏鹐鹑鹒鹓鹔鹕鹖鹗鹘鹙鹚鹛鹜鹝鹞鹟鹠鹡鹢鹣鹤鹥鹦鹧鹨鹩鹪鹫鹬鹭鹯鹰鹱鹲鹳鹴鹾麦麸黄黉黡黩黪黾鼋鼌鼍鼗鼹齄齐齑齿龀龁龂龃龄龅龆龇龈龉龊龋龌龙龚龛龟'
    target_string=u'萬與醜專業叢東絲丟兩嚴喪個爿豐臨為麗舉麼義烏樂喬習鄉書買亂爭於虧雲亙亞產畝親褻嚲億僅從侖倉儀們價眾優夥會傴傘偉傳傷倀倫傖偽佇體餘傭僉俠侶僥偵側僑儈儕儂俁儔儼倆儷儉債傾傯僂僨償儻儐儲儺兒兌兗黨蘭關興茲養獸囅內岡冊寫軍農塚馮沖決況凍淨淒涼淩減湊凜幾鳳鳧憑凱擊氹鑿芻劃劉則剛創刪別剗剄劊劌剴劑剮劍剝劇勸辦務勱動勵勁勞勢勳猛勩勻匭匱區醫華協單賣盧鹵臥衛卻巹廠廳曆厲壓厭厙廁廂厴廈廚廄廝縣三參靉靆雙發變敘疊葉號歎嘰籲後嚇呂嗎唚噸聽啟吳嘸囈嘔嚦唄員咼嗆嗚詠哢嚨嚀噝吒噅鹹呱響啞噠嘵嗶噦嘩噲嚌噥喲嘜嗊嘮啢嗩唕喚呼嘖嗇囀齧囉嘽嘯噴嘍嚳囁呵噯噓嚶囑嚕劈囂謔團園囪圍圇國圖圓聖壙場阪壞塊堅壇壢壩塢墳墜壟壟壚壘墾坰堊墊埡墶壋塏堖塒塤堝墊垵塹墮壪原牆壯聲殼壺壼處備複夠頭誇夾奪奩奐奮獎奧妝婦媽嫵嫗媯姍薑婁婭嬈嬌孌娛媧嫻嫿嬰嬋嬸媼嬡嬪嬙嬤孫學孿寧寶實寵審憲宮寬賓寢對尋導壽將爾塵嘗堯尷屍盡層屭屜屆屬屢屨嶼歲豈嶇崗峴嶴嵐島嶺嶽崠巋嶨嶧峽嶢嶠崢巒嶗崍嶮嶄嶸嶔崳嶁脊巔鞏巰幣帥師幃帳簾幟帶幀幫幬幘幗冪襆幹並么廣莊慶廬廡庫應廟龐廢廎廩開異棄張彌弳彎彈強歸當錄彠彥徹徑徠禦憶懺憂愾懷態慫憮慪悵愴憐總懟懌戀懇惡慟懨愷惻惱惲悅愨懸慳憫驚懼慘懲憊愜慚憚慣湣慍憤憒願懾憖怵懣懶懍戇戔戲戧戰戩戶紮撲扡執擴捫掃揚擾撫拋摶摳掄搶護報擔擬攏揀擁攔擰撥擇掛摯攣掗撾撻挾撓擋撟掙擠揮撏撈損撿換搗據撚擄摑擲撣摻摜摣攬撳攙擱摟攪攜攝攄擺搖擯攤攖撐攆擷擼攛擻攢敵斂數齋斕鬥斬斷無舊時曠暘曇晝曨顯晉曬曉曄暈暉暫曖劄術樸機殺雜權條來楊榪傑極構樅樞棗櫪梘棖槍楓梟櫃檸檉梔柵標棧櫛櫳棟櫨櫟欄樹棲樣欒棬椏橈楨檔榿橋樺檜槳樁夢檮棶檢欞槨櫝槧欏橢樓欖櫬櫚櫸檟檻檳櫧橫檣櫻櫫櫥櫓櫞簷檁歡歟歐殲歿殤殘殞殮殫殯毆毀轂畢斃氈毿氌氣氫氬氳彙漢汙湯洶遝溝沒灃漚瀝淪滄渢溈滬濔濘淚澩瀧瀘濼瀉潑澤涇潔灑窪浹淺漿澆湞溮濁測澮濟瀏滻渾滸濃潯濜塗湧濤澇淶漣潿渦溳渙滌潤澗漲澀澱淵淥漬瀆漸澠漁瀋滲溫遊灣濕潰濺漵漊潷滾滯灩灄滿瀅濾濫灤濱灘澦濫瀠瀟瀲濰潛瀦瀾瀨瀕灝滅燈靈災燦煬爐燉煒熗點煉熾爍爛烴燭煙煩燒燁燴燙燼熱煥燜燾煆糊退溜愛爺牘犛牽犧犢強犬狀獷獁猶狽麅獮獰獨狹獅獪猙獄猻獫獵獼玀豬貓蝟獻獺璣璵瑒瑪瑋環現瑲璽瑉玨琺瓏璫琿璡璉瑣瓊瑤璦璿瓔瓚甕甌電畫暢佘疇癤療瘧癘瘍鬁瘡瘋皰屙癰痙癢瘂癆瘓癇癡癉瘮瘞瘺癟癱癮癭癩癬癲臒皚皺皸盞鹽監蓋盜盤瞘眥矓著睜睞瞼瞞矚矯磯礬礦碭碼磚硨硯碸礪礱礫礎硜矽碩硤磽磑礄確鹼礙磧磣堿镟滾禮禕禰禎禱禍稟祿禪離禿稈種積稱穢穠穭稅穌穩穡窮竊竅窯竄窩窺竇窶豎競篤筍筆筧箋籠籩築篳篩簹箏籌簽簡籙簀篋籜籮簞簫簣簍籃籬籪籟糴類秈糶糲粵糞糧糝餱緊縶糸糾紆紅紂纖紇約級紈纊紀紉緯紜紘純紕紗綱納紝縱綸紛紙紋紡紵紖紐紓線紺絏紱練組紳細織終縐絆紼絀紹繹經紿綁絨結絝繞絰絎繪給絢絳絡絕絞統綆綃絹繡綌綏絛繼綈績緒綾緓續綺緋綽緔緄繩維綿綬繃綢綯綹綣綜綻綰綠綴緇緙緗緘緬纜緹緲緝縕繢緦綞緞緶線緱縋緩締縷編緡緣縉縛縟縝縫縗縞纏縭縊縑繽縹縵縲纓縮繆繅纈繚繕繒韁繾繰繯繳纘罌網羅罰罷羆羈羥羨翹翽翬耮耬聳恥聶聾職聹聯聵聰肅腸膚膁腎腫脹脅膽勝朧腖臚脛膠脈膾髒臍腦膿臠腳脫腡臉臘醃膕齶膩靦膃騰臏臢輿艤艦艙艫艱豔艸藝節羋薌蕪蘆蓯葦藶莧萇蒼苧蘇檾蘋莖蘢蔦塋煢繭荊薦薘莢蕘蓽蕎薈薺蕩榮葷滎犖熒蕁藎蓀蔭蕒葒葤藥蒞蓧萊蓮蒔萵薟獲蕕瑩鶯蓴蘀蘿螢營縈蕭薩蔥蕆蕢蔣蔞藍薊蘺蕷鎣驀薔蘞藺藹蘄蘊藪槁蘚虜慮虛蟲虯蟣雖蝦蠆蝕蟻螞蠶蠔蜆蠱蠣蟶蠻蟄蛺蟯螄蠐蛻蝸蠟蠅蟈蟬蠍螻蠑螿蟎蠨釁銜補襯袞襖嫋褘襪襲襏裝襠褌褳襝褲襇褸襤繈襴見觀覎規覓視覘覽覺覬覡覿覥覦覯覲覷觴觸觶讋譽謄訁計訂訃認譏訐訌討讓訕訖訓議訊記訒講諱謳詎訝訥許訛論訩訟諷設訪訣證詁訶評詛識詗詐訴診詆謅詞詘詔詖譯詒誆誄試詿詩詰詼誠誅詵話誕詬詮詭詢詣諍該詳詫諢詡譸誡誣語誚誤誥誘誨誑說誦誒請諸諏諾讀諑誹課諉諛誰諗調諂諒諄誶談誼謀諶諜謊諫諧謔謁謂諤諭諼讒諮諳諺諦謎諞諝謨讜謖謝謠謗諡謙謐謹謾謫譾謬譚譖譙讕譜譎讞譴譫讖穀豶貝貞負貟貢財責賢敗賬貨質販貪貧貶購貯貫貳賤賁貰貼貴貺貸貿費賀貽賊贄賈賄貲賃賂贓資賅贐賕賑賚賒賦賭齎贖賞賜贔賙賡賠賧賴賵贅賻賺賽賾贗贊贇贈贍贏贛赬趙趕趨趲躉躍蹌蹠躒踐躂蹺蹕躚躋踴躊蹤躓躑躡蹣躕躥躪躦軀車軋軌軒軑軔轉軛輪軟轟軲軻轤軸軹軼軤軫轢軺輕軾載輊轎輈輇輅較輒輔輛輦輩輝輥輞輬輟輜輳輻輯轀輸轡轅轄輾轆轍轔辭辯辮邊遼達遷過邁運還這進遠違連遲邇逕跡適選遜遞邐邏遺遙鄧鄺鄔郵鄒鄴鄰鬱郤郟鄶鄭鄆酈鄖鄲醞醱醬釅釃釀釋裏钜鑒鑾鏨釓釔針釘釗釙釕釷釺釧釤鈒釩釣鍆釹鍚釵鈃鈣鈈鈦鈍鈔鍾鈉鋇鋼鈑鈐鑰欽鈞鎢鉤鈧鈁鈥鈄鈕鈀鈺錢鉦鉗鈷缽鈳鉕鈽鈸鉞鑽鉬鉭鉀鈿鈾鐵鉑鈴鑠鉛鉚鈰鉉鉈鉍鈮鈹鐸鉶銬銠鉺鋩錏銪鋮鋏鋣鐃銍鐺銅鋁銱銦鎧鍘銖銑鋌銩銛鏵銓鎩鉿銚鉻銘錚銫鉸銥鏟銃鐋銨銀銣鑄鐒鋪鋙錸鋱鏈鏗銷鎖鋰鋥鋤鍋鋯鋨鏽銼鋝鋒鋅鋶鐦鐧銳銻鋃鋟鋦錒錆鍺鍩錯錨錛錡鍀錁錕錩錫錮鑼錘錐錦鑕鍁錈鍃錇錟錠鍵鋸錳錙鍥鍈鍇鏘鍶鍔鍤鍬鍾鍛鎪鍠鍰鎄鍍鎂鏤鎡鐨鎇鏌鎮鎛鎘鑷钂鐫鎳鎿鎦鎬鎊鎰鎵鑌鎔鏢鏜鏝鏍鏰鏞鏡鏑鏃鏇鏐鐔钁鐐鏷鑥鐓鑭鐠鑹鏹鐙鑊鐳鐶鐲鐮鐿鑔鑣鑞鑱鑲長門閂閃閆閈閉問闖閏闈閑閎間閔閌悶閘鬧閨聞闥閩閭闓閥閣閡閫鬮閱閬闍閾閹閶鬩閿閽閻閼闡闌闃闠闊闋闔闐闒闕闞闤隊陽陰陣階際陸隴陳陘陝隉隕險隨隱隸雋難雛讎靂霧霽黴靄靚靜靨韃鞽韉韝韋韌韍韓韙韞韜韻頁頂頃頇項順須頊頑顧頓頎頒頌頏預顱領頗頸頡頰頲頜潁熲頦頤頻頮頹頷頴穎顆題顒顎顓顏額顳顢顛顙顥纇顫顬顰顴風颺颭颮颯颶颸颼颻飀飄飆飆飛饗饜飣饑飥餳飩餼飪飫飭飯飲餞飾飽飼飿飴餌饒餉餄餎餃餏餅餑餖餓餘餒餕餜餛餡館餷饋餶餿饞饁饃餺餾饈饉饅饊饌饢馬馭馱馴馳驅馹駁驢駔駛駟駙駒騶駐駝駑駕驛駘驍罵駰驕驊駱駭駢驫驪騁驗騂駸駿騏騎騍騅騌驌驂騙騭騤騷騖驁騮騫騸驃騾驄驏驟驥驦驤髏髖髕鬢魘魎魚魛魢魷魨魯魴魺鮁鮃鯰鱸鮋鮓鮒鮊鮑鱟鮍鮐鮭鮚鮳鮪鮞鮦鰂鮜鱠鱭鮫鮮鮺鯗鱘鯁鱺鰱鰹鯉鰣鰷鯀鯊鯇鮶鯽鯒鯖鯪鯕鯫鯡鯤鯧鯝鯢鯰鯛鯨鯵鯴鯔鱝鰈鰏鱨鯷鰮鰃鰓鱷鰍鰒鰉鰁鱂鯿鰠鼇鰭鰨鰥鰩鰟鰜鰳鰾鱈鱉鰻鰵鱅鰼鱖鱔鱗鱒鱯鱤鱧鱣鳥鳩雞鳶鳴鳲鷗鴉鶬鴇鴆鴣鶇鸕鴨鴞鴦鴒鴟鴝鴛鴬鴕鷥鷙鴯鴰鵂鴴鵃鴿鸞鴻鵐鵓鸝鵑鵠鵝鵒鷳鵜鵡鵲鶓鵪鶤鵯鵬鵮鶉鶊鵷鷫鶘鶡鶚鶻鶖鶿鶥鶩鷊鷂鶲鶹鶺鷁鶼鶴鷖鸚鷓鷚鷯鷦鷲鷸鷺鸇鷹鸌鸏鸛鸘鹺麥麩黃黌黶黷黲黽黿鼂鼉鞀鼴齇齊齏齒齔齕齗齟齡齙齠齜齦齬齪齲齷龍龔龕龜'
    return_str=''
    #将gbk转换为unicode码,使得中、英文字符的长度一致
    string=unicode(string,'gbk') 
    for i in range(0,len(string)):
        tmp_str=string[i:i+1]
        index=target_string.find(tmp_str)
        if index!=-1:
            return_str+=simple_string[index:index+1]
        else:
            return_str+=tmp_str
    return return_str.encode('gbk')#将unicode码转换成gbk

def get_asian_pka(key):
    if cf.config['asian']['pka'].has_key(key):
        return cf.config['asian']['pka'][key]
    else:
        return None
    
def get_big_pka(key):
    if cf.config['big']['pka'].has_key(key):
        return cf.config['big']['pka'][key]
    else:
        return None
    
'''获取ball365.xml数据'''
def get_ball565xml_data(type):
    content=fopen(getPath('ball365_xml'),type='[FUNC:get_ball565xml_data]')
    return_arr=[]
    if content:
        content=content.decode('gb2312','ignore').encode('gbk').replace('<?xml version="1.0" encoding="gb2312"?>','<?xml version="1.0" encoding="gbk"?>')
        dom=parseString(content)
        if dom:
            node_arr=dom.getElementsByTagName('m')
        else:
            node_arr=[]        
        if type in ['today_asian','today_odds','today_dxodds']: #当天欧赔、亚赔、大小线程
            timestamp=time.time()
            today=time.strftime('%Y%m%d%H%M',time.localtime(timestamp))
            nextday=time.strftime('%Y%m%d%H%M',time.localtime(timestamp+86400))
        elif type in ['future_odds','future_asian','future_dxodds']:
            nextday=time.strftime('%Y%m%d%H%M',time.localtime(time.time()+86400))
        
        elif type=='lot_odds':
            today=time.strftime('%Y%m%d%H%M',time.localtime())
            
            
        for node in node_arr:
            matchdate=node.getElementsByTagName('MatchDate')[0].firstChild.nodeValue
            #当天欧赔线程
            if type=='today_odds' and (node.getAttribute('Limit1')!='0' or matchdate<=today or matchdate>nextday):
                continue
            #当天亚赔线程
            elif type=='today_asian' and (node.getAttribute('Limit2')!='0' or matchdate<=today or matchdate>nextday):
                continue
            #当天大小线程
            elif type=='today_dxodds' and (node.getAttribute('Limit3')!='0' or matchdate<=today or matchdate>nextday):
                continue
            #未来欧赔线程
            elif type=='future_odds' and (node.getAttribute('Limit1')!='0' or matchdate<=nextday):
                continue
            #未来亚赔线程
            elif type=='future_asian' and (node.getAttribute('Limit2')!='0' or matchdate<=nextday):
                continue
            elif type=='future_dxodds' and (node.getAttribute('Limit3')!='0' or matchdate<=nextday):
                continue
            #彩种赔率线程
            elif type=='lot_odds' and (node.getAttribute('IsLotType')!='1' or node.getAttribute('Limit1')!='0' or matchdate<=today):
                continue
            
            fixtureid=int(node.getElementsByTagName('MatchID')[0].firstChild.nodeValue)
            ball365_matchid=int(node.getElementsByTagName('Ball365_MatchID')[0].firstChild.nodeValue)
            home_tmp=node.getElementsByTagName('HomeName')[0].firstChild.nodeValue.encode('gbk').split(',')
            hometeam=home_tmp[0]
            hometeam_ball365=home_tmp[1]
            away_tmp=node.getElementsByTagName('AwayName')[0].firstChild.nodeValue.encode('gbk').split(',')
            awayteam=away_tmp[0]
            awayteam_ball365=away_tmp[1]                 
            isreverse=int(node.getElementsByTagName('IsReverse')[0].firstChild.nodeValue)
            islottype=int(node.getAttribute('IsLotType'))
            isbeidan=int(node.getAttribute('IsBeiDan'))
            row={'fixtureid':fixtureid,'ball365_matchid':ball365_matchid,'hometeam':hometeam,'awayteam':awayteam,'hometeam_ball365':hometeam_ball365,'awayteam_ball365':awayteam_ball365,'isreverse':isreverse,'islottype':islottype,'isbeidan':isbeidan,'matchdate':matchdate}
            return_arr.append(row)
    return return_arr
    
'''获取betexplore xml信息'''
def get_betexplore_odds(type):
    content=fopen(getPath('betexplore_xml'),type='[FUNC:get_betexplore_odds]')
    return_arr=[]
    if content:
        content=content.replace('<?xml version="1.0" encoding="gb2312"?>','<?xml version="1.0" encoding="gbk"?>')
        dom=parseString(content)
        if dom:
            node_arr=dom.getElementsByTagName('m')
        else:
            node_arr=[]
        if type=='today_odds':
            today=time.strftime('%Y%m%d%H%M',time.localtime())
            nextday=time.strftime('%Y%m%d1200',time.localtime(time.time()+24*3600))
        elif type=='lot_odds':
            today=time.strftime('%Y%m%d%H%M',time.localtime())
        elif type in ['main_odds','unmain_odds']:
            nextday=time.strftime('%Y%m%d1200',time.localtime(time.time()+24*3600))
            
        for node in node_arr:
            matchdate=node.getElementsByTagName('MatchDate')[0].firstChild.nodeValue
            if type=='today_odds' and (node.getAttribute('ISLotType')!='0' or matchdate<=today or matchdate>nextday):
                continue
            elif type=='lot_odds' and (node.getAttribute('ISLotType')!='1' or matchdate<=today):
                continue
            elif type=='main_odds' and (node.getAttribute('ISLotType')!='0' or node.getAttribute('IsMain')!='1' or matchdate<=nextday):
                continue
            elif type=='unmain_odds' and (node.getAttribute('ISLotType')!='0' or node.getAttribute('IsMain')!='0' or matchdate<=nextday):
                continue
            fixtureid=int(node.getElementsByTagName('MatchID')[0].firstChild.nodeValue)
            isbeidan=int(node.getAttribute('IsBeiDan'))
            isreverse=int(node.getElementsByTagName('IsReverse')[0].firstChild.nodeValue)
            url=node.getElementsByTagName('MatchUrl')[0].firstChild.nodeValue.encode('gbk')
#            team_str=node.getElementsByTagName('MatchTeam')[0].firstChild.nodeValue.encode('gbk')
#            team_arr=team_str.split('VS')
#            if isreverse==0:
#                hometeam=team_arr[0].strip()
#                awayteam=team_arr[1].strip()
#            else:
#                hometeam=team_arr[1].strip()
#                awayteam=team_arr[0].strip()
            row={'fixtureid':fixtureid,'isreverse':isreverse,'url':url,'isbeidan':isbeidan}
            return_arr.append(row)
    return return_arr
'''计算两个时间相差的天数'''
def day_diff(datetime1,datetime2):
#    time_tmp=datetime1.split(' ')
#    time1_tmp=time_tmp[0].split('-')
#    time2_tmp=time_tmp[1].split(':')
#    time1=datetime.datetime(int(time1_tmp[0]),int(time1_tmp[1]),int(time1_tmp[2]),int(time2_tmp[0]),int(time2_tmp[1]),int(time2_tmp[2]))
#    
#    time_tmp=datetime2.split(' ')
#    time1_tmp=time_tmp[0].split('-')
#    time2_tmp=time_tmp[1].split(':')
#    time2=datetime.datetime(int(time1_tmp[0]),int(time1_tmp[1]),int(time1_tmp[2]),int(time2_tmp[0]),int(time2_tmp[1]),int(time2_tmp[2]))
#    return (time2-time1).days
    timestamp_1=time.mktime(time.strptime(str(datetime1),'%Y-%m-%d %H:%M:%S'))
    timestamp_2=time.mktime(time.strptime(str(datetime2),'%Y-%m-%d %H:%M:%S'))
    return abs(timestamp_1-timestamp_2)/86400

def check_day_diff(time1,time2):
    if not time1 or not time2 or day_diff(time1,time2)>=1:
        return False
    else:
        return True

def addColor(str):
    return str.replace('W','<font color="#FF0000">W</font>').replace('D','<font color="#006600">D</font>').replace('L','<font color="#0000FF">L</font>')

def genRecommend(recommend,recommend_text,home,away):
    if recommend=="1":
        return home
    elif recommend=="2":
        return away
    elif recommend=="4":
        return recommend_text
    else:
        return '和局'
def genConfidence(n):
    string=''
    for i in range(1,n+1):
        string+='★'
    return string

def getHandicapName(handicap,homeismain):
    string=''
    if cf.config['aomen']['handicapname'].has_key(handicap):
        string=cf.config['aomen']['handicapname'][handicap]
    else:
        string=''
    if handicap!=1 and homeismain==0:
        string='受'+string
    return string
def getHandicap(handicapname):
    key_tmp=cf.config['aomen']['handicap'].keys()
    val_tmp=cf.config['aomen']['handicap'].values()
    if handicapname in val_tmp:
        id=val_tmp.index(handicapname)
        return key_tmp[id]
    else:
        return 0
    
def getCompany(type):
    if cf.config['cid'].has_key(type):
        return cf.config['cid'][type]
    else:
        return []

def getDxhandicap(handicap):
    return cf.config['aomen']['dx_handicap'][handicap]

def checkData(string):
    return float(string)-1

def getMacauZqXml(type):
    url=getPath('create_interface_url')+getPath('create_zq_xml')
    content=fopen(url)
    xml=parseString(content)
    if xml:
        m_node_arr=xml.getElementsByTagName('Table')
    else:
        m_node_arr=[]
    mid_arr={}
    for node in m_node_arr:
        if type in ['match_halfeuro','match_euro','match_dx','match_bd','match_bqc','match_ds','match_jqs','match_teamjqs']:
            fixtureid=int(node.getElementsByTagName('FixtureID')[0].firstChild.nodeValue)
            mid=int(node.getElementsByTagName('MacauID')[0].firstChild.nodeValue)
            isresver=int(node.getElementsByTagName('IsResver')[0].firstChild.nodeValue)
            matchdate=node.getElementsByTagName('MatchDate')[0].firstChild.nodeValue.encode('gbk')
            mid_arr[mid]={'fixtureid':fixtureid,'isresver':isresver,'matchdate':matchdate}
            
        elif type=='match_asian':
            fixtureid=int(node.getElementsByTagName('FixtureID')[0].firstChild.nodeValue)
            mid=int(node.getElementsByTagName('MacauID')[0].firstChild.nodeValue)
            isresver=int(node.getElementsByTagName('IsResver')[0].firstChild.nodeValue)
            islottyle=int(node.getElementsByTagName('IsLotTyle')[0].firstChild.nodeValue)
            isbeidan=int(node.getElementsByTagName('IsBeiDan')[0].firstChild.nodeValue)
            matchdate=node.getElementsByTagName('MatchDate')[0].firstChild.nodeValue.encode('gbk')
            vsteam=node.getElementsByTagName('VSTeam')[0].firstChild.nodeValue.encode('gbk','ignore')
            mid_arr[mid]={'fixtureid':fixtureid,'matchdate':matchdate,'isresver':isresver,'islottyle':islottyle,'isbeidan':isbeidan,'vsteam':vsteam}
            
    m_node_arr=None
    return mid_arr

'''从xml获取篮球匹配信息'''
def getMacauLqXml(type):
    url=getPath('create_interface_url')+getPath('create_nba_xml')
    content=fopen(url)
    xml=parseString(content)
    if xml:
        m_node_arr=xml.getElementsByTagName('Table')
    else:
        m_node_arr=[]
    mid_arr={}
    
    for node in m_node_arr:
        if type=='match_lq_pen':
            fixtureid=int(node.getElementsByTagName('FixtureID')[0].firstChild.nodeValue)
            mid=int(node.getElementsByTagName('MacauID')[0].firstChild.nodeValue)
            vsteam=node.getElementsByTagName('VSTeam')[0].firstChild.nodeValue.encode('gbk','ignore')
            mid_arr[mid]={'fixtureid':fixtureid,'vsteam':vsteam}
    m_node_arr=None
    return mid_arr

def get_gooooal_handi(handi,isreverse):
    if isreverse==1:
        handi=-1*handi
    if cf.config['gooooal']['handi'].has_key(abs(handi)):
        if handi<=0:
            str=cf.config['gooooal']['handi'][abs(handi)]
        else:
            str='受'+cf.config['gooooal']['handi'][handi]
    else:
        str=''
    return str

def get_gooooal_pka(handi):
    if cf.config['gooooal']['pk'].has_key(handi):
        str=cf.config['gooooal']['pk'][handi]
    else:
        str=''
    return str      

def sendMsgInterface(phone,content):
    import EasClient
    import JsonUtil
    import XmlConfig
    import os
    XmlConfig.loadFile(os.environ['_BASIC_PATH_'] + '/etc/service.xml')
    eas_instance = EasClient.EasClient().getInstance('others')
    if type(content)==unicode:
        content = content.encode("gbk")
    result = []
    for p in phone.split("|"):
        params={
            'tag':'www.server.notice',
            'mobile':p,
            'args':JsonUtil.write({'content':content}),
        }
        res = eas_instance.invoke('sendSMS',params)
        result.append("%s:%s" % (p, res[0]))
    return str(result)


def Sc_Interface(type,fixtureid):
    import EasClient
    import XmlConfig
    import os
    #上传接口
    XmlConfig.loadFile(os.environ['_BASIC_PATH_'] + '/etc/service.xml')
    eas_instance = EasClient.EasClient().getInstance('odds_interface')
    if type=='euro':
        type_param='euro'
    elif type=='asian':
        type_param='asian'
    else:
        type_param='dxq'
    params={'type':type_param,'fid':str(fixtureid)}
    eas_instance.invoke('api/make',params)