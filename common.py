#coding:gbk
'''存放配置信息'''
config={}

'''线程睡眠时间'''
config['thread_sleep_time']={
   'ball365_today_odds':180, #ball365当天欧赔线程睡眠时间
   'ball365_today_asian':180, #ball365当天亚赔线程睡眠时间
   'ball365_today_dxodds':180,#ball365当天大小线程睡眠时间
   'ball365_dsodds':7200,#ball365单双线程睡眠时间
   'ball365_jqsodds':7200,#ball365进球数线程睡眠时间
   'ball365_bdodds':7200,#ball365波胆线程睡眠时间
   'ball365_bqcodds':7200,#ball365半全场线程睡眠时间
   'ball365_future_odds':300,#ball365未来欧赔线程睡眠时间
   'ball365_future_asian':900,#ball365未来亚赔线程睡眠时间
   'ball365_future_dxodds':900,#ball365未来大小线程睡眠时间
   'ball365_lot_odds':180,
   
   
   'bet007_today_odds':600,#球探当天欧赔线程睡眠时间
   'bet007_today_asian':900,#球探当天亚赔线程睡眠时间
   'bet007_today_dxodds':900,#球探当天大小线程睡眠时间
   'bet007_future_odds':600,#球探未来欧赔线程睡眠时间
   'bet007_future_asian':900,#球探未来亚赔线程睡眠时间
   'bet007_future_dxodds':900,#球探未来大小线程睡眠时间
   
   'betexplore_today_odds':180,#betexplore当天欧赔线程睡眠时间
   'betexplore_lot_odds':180,#betexplore当天lot线程睡眠时间
   'betexplore_main_odds':300,#betexplore未来时间主流赔率线程睡眠时间
   'betexplore_unmain_odds':600,#betexplore未来时间非主流赔率线程睡眠时间
   
   'ball365_match':6*3600,
   'bet007_todaymatch':10800,
   'bet007_futurematch':7200,
   'betexplore_match':3*3600,

   'gooooal_today_euro':600,#雪缘网当天欧赔线程睡眠时间
   'gooooal_today_asian':900,#雪缘网当天亚赔线程睡眠时间
   'gooooal_today_dx':900,#雪缘网当天大小线程睡眠时间
   'gooooal_future_euro':600,#雪缘网未来欧赔线程睡眠时间
   'gooooal_future_asian':900,#雪缘网未来亚赔线程睡眠时间
   'gooooal_future_dx':900,#雪缘网未来大小线程睡眠时间
   
   'gooooal_futurematch':7200,#雪缘网未来赛程匹配线程
   'gooooal_todaymatch':7200,#雪缘网当天赛程匹配线程
   
   'aomen_match_lq':7200, #澳门匹配篮球线程
   'aomen_match_zq':7200, #澳门匹配足球线程
   'aomen_match_tv':7200, #澳门TV线程
   'aomen_match_pen':7200, #澳门心水线程
   'aomen_match_lq_pen':7200, #澳门篮球心水线程
   'aomen_match_asian':180,#澳门亚盘线程
   'aomen_match_euro':300, #澳门欧赔线程
   'aomen_match_dx':1800,   #澳门大小球线程
   'aomen_match_halfeuro':1800,#澳门上半场欧赔
   'aomen_match_bd':3600,  #澳门波胆线程
   'aomen_match_bqc':3600, #澳门半全场线程
   'aomen_match_ds':3600, #澳门单双线程
   'aomen_match_jqs':3600, #澳门进球数
   'aomen_match_teamjqs':3600,#澳门球队进球数

   'betbrain_parse':1,
#   'betbrain_todaymatch':600,
#   'betbrain_futurematch':1800,
#   'betbrain_futureasian':60,
#   'betbrain_futurebig':60,
#   'betbrain_futureeuro':60,
#   
#   'betbrain_todayasian':10,
#   'betbrain_todaybig':10,
#   'betbrain_todayeuro':10
   'betbrain_match':300,
   'betbrain_big':30,
   'betbrain_euro':30,
   'betbrain_asian':30,
   
   'betbrain_check':60,
   'betbrain_memory':60,
   
   'aomen_match_winner':60,
   
    'redis_config':{
        'host':'localhost', 
        'port':6379,
    }
}

'''存放xml及其他页面的路径'''
config['path']={
    'ball365_xml':'http://resources.boss.com/static/info/info_server/eas_betball/ball365.xml',
    'ball365_odds':'http://fenxi.310v.com/odds_pic/e_100.php?match_id=891676',
    'ball365_lot':'http://fenxi.310v.com/odds_pic/e_100.php?match_id=%s',
    'ball365_asian':'http://fenxi.310v.com/odds_pic/a_100.php?match_id=%s',
    'ball365_dxodds':'http://fenxi.310v.com/odds_pic/b_100.php?match_id=%s',
    'ball365_dsodds':'http://fenxi.310v.com/odds_pic/sd_100.php?match_id=%s',
    'ball365_jqsodds':'http://fenxi.310v.com/odds_pic/bin_100.php?match_id=%s',
    'ball365_bdodds':'http://fenxi.310v.com/odds_pic/bd_100.php?mnid=%s',
    'ball365_bqcodds':'http://fenxi.310v.com/odds_pic/half_100.php?match_id=%s',
    
    'bet007_todayxml':'http://resources.boss.com/static/info/info_server/eas_betball/today.xml',
    'bet007_odds':'http://1x2.nowscore.com/%s.js',
    'bet007_asian':'http://vip.bet007.com/AsianOdds_n.aspx?id=%s',
    'bet007_bigsmall':'http://vip.bet007.com/OverDown_n.aspx?id=%s',
    
    'bet007_futurexml':'http://resources.boss.com/static/info/info_server/eas_betball/future.xml',
    
    'gooooal_todayxml':'http://resources.boss.com/static/info/info_server/eas_betball/gooooal_today.xml',
    'gooooal_futurexml':'http://resources.boss.com/static/info/info_server/eas_betball/gooooal_future.xml',
    'gooooal_asian':'http://odds.gooooal.com/match/%s/a_%s.match?ts=%s',
    'gooooal_euro':'http://odds.gooooal.com/match/%s/e_%s.match?ts=%s',
    'gooooal_dx':'http://odds.gooooal.com/match/%s/o_%s.match?ts=%s',
    'gooooal_url':'http://odds.gooooal.com/singlefield.html?mid=%s&type=1',
    
    
    'interface':'http://resources.boss.com/',
    'upload_odds_xml':'interface/odds/update_uad_odds_xml.php?key=esun500wan&Fixtureid=%s&companyid=%s&peilv=%s&Typeid=%s',
    'update_live_xml':'interface/odds/updatelivexml.php?Fixtureid=%s&companyid=%s&peilv=%s&Typeid=%s', 
    'update_asian_xml':'interface/odds/UpLoadAsianXml.php?Fixtureid=%s&companyid=%s&peilv=%s&CreateTime=%s',
    
    'betexplore_xml':'http://resources.boss.com/static/info/info_server/eas_betball/betexplorer.xml',   
    'betexplore_oddsurl':'http://www.betexplorer.com/soccer%s',
    
    'ball365_matchurl':'http://fenxi.310v.com/match_data_xml/coming_match.js',
    'bet007_todaymatch':'http://1x2.bet007.com/index_big.aspx?type=2',
    'bet007_futurematch':'http://1x2.bet007.com/TomorrowOdds.aspx',
    'betexplore_url':'http://www.betexplorer.com/next/index.php?year=%s&month=%s&day=%s',
    'gooooal_todaymatch':'http://www.gooooal.com/live/data/ft_all.js',
    'gooooal_futurematch':'http://analysis.gooooal.com/next/index_cn.html',
    
    
    '500wanxml_interface_url':'http://dist.boss.com/dist/distribute.php',
    'create_ball365_xml_path':'/static/info/info_server/eas_betball/ball365.xml',
    'create_bet007_today_xml_path':'/static/info/info_server/eas_betball/today.xml',
    'create_bet007_future_xml_path':'/static/info/info_server/eas_betball/future.xml',
    'create_betexplore_xml_path':'/static/info/info_server/eas_betball/betexplorer.xml',
    'create_gooooal_today_xml_path':'/static/info/info_server/eas_betball/gooooal_today.xml',
    'create_gooooal_future_xml_path':'/static/info/info_server/eas_betball/gooooal_future.xml',

    '500wan':'http://news.boss.com',
    'create_betbrain_today_txt_path':'/static/info/info_server/eas_betball/betbrain_today.txt',
    'create_betbrain_future_txt_path':'/static/info/info_server/eas_betball/betbrain_future.txt',

    'create_betbrain_day_txt_path':'/static/info/info_server/eas_betball/betbrain_day_%s.txt',
    'day_range':range(1,16),

    'aomen_fixtureurl':'http://www.macauslot.com/nba/xml/fixture/fixture.xml',
    'aome_sourceurl':'http://www.macauslot.com/soccer/xml/fixture/fixtures.xml',
    'predictions_url':'http://web.macauslot.com/soccer/xml/prediction/predictions.xml',
    'winoddsurl':'http://www.macauslot.com/soccer/xml/odds/winodds.xml',
    'windrawwinurl':'http://www.macauslot.com/soccer/xml/odds/windrawwin.xml',
    'overunderurl':'http://www.macauslot.com/soccer/xml/odds/overunder.xml',
    'windrawwinfirsthalfurl':'http://www.macauslot.com/soccer/xml/odds/windrawwinfirsthalf.xml',
    'correctscoreurl':'http://www.macauslot.com/soccer/xml/odds/correctscore.xml',
    'halffullurl':'http://www.macauslot.com/soccer/xml/odds/halffull.xml',
    'oddevenurl':'http://www.macauslot.com/soccer/xml/odds/oddeven.xml',
    'totalgoalsurl':'http://www.macauslot.com/soccer/xml/odds/totalgoals.xml',
    'numberofgoalsurl':'http://www.macauslot.com/soccer/xml/odds/numberofgoals.xml',
    'predictionsnbaurl':'http://www.macauslot.com/nba/xml/prediction/predictions.xml',
    
    'create_interface_url':'http://resources.boss.com',
    'create_nba_xml':'/static/info/info_server/eas_betball/macao_nba.xml',
    'create_zq_xml':'/static/info/info_server/eas_betball/macauid.xml',
    'create_fixture_zq_xml':'/static/info/info_server/eas_betball/fixtures.xml',
    
    'ball365_log_txt':'/static/info/info_server/eas_betball/ball365_%slog.txt',
    'bet007_log_txt':'/static/info/info_server/eas_betball/bet007_%slog.txt',
    'betexplore_log_txt':'/static/info/info_server/eas_betball/betexplore_%slog.txt',
    'gooooal_log_txt':'/static/info/info_server/eas_betball/gooooal_%slog.txt',
    
    'aome_winner':'http://www.macauslot.com/soccer/xml/odds/championodds.xml?nocache=%s',
    
    'redis_config':{
         'host':'localhost', 
         'port':6379,
    },
    'phone':'13427934147'
}

'''抛送赔率信息的公司'''
config['cid']={}
config['cid']['dx']=[2,3,5,9,280]


'''亚赔状态配置'''
config['asian']={}
config['asian']['pka']={
    1:'四球',
    3:'三球半/四球',
    4:'三球半',
    5:'三球/三球半',
    6:'三球',
    7:'两球半/三球',
    8:'两球半',
    9:'两球/两球半',
    10:'两球',
    11:'球半/两球',
    12:"球半",
    13:'一球/球半',
    14:'一球',
    15:'半球/一球',
    16:'半球',
    17:'平手/半球',
    19:'平手',
    31:'受平手/半球',
    32:'受半球',
    33:'受半球/一球',
    34:'受一球',
    35:'受一球/球半',
    36:"受球半",
    37:'受球半/两球',
    38:'受两球',
    39:'受两球/两球半',
    40:'受两球半',
    41:'受两球半/三球',
    42:'受三球',
    43:'受三球/三球半',
    44:'受三球半',
    45:'受三球半/四球',
    46:'受四球',
    47:'受四球/四球半',
    48:'受四球半',
    49:'受四球半/五球',
    50:'受五球',
    51:'受五球/五球半',
    52:'受五球半',
    53:'受五球半/六球',
    54:'受六球',
    55:'四球/四球半',
    56:'四球半',
    57:'四球半/五球',
    58:'五球',
    59:'五球/五球半',
    60:'五球半',
    61:'五球半/六球',
    62:'六球',
}

'''大小状态配置'''
config['big']={}
config['big']['pka']={
    1:"2.5",
    2:"2.5/3",
    3:"2/2.5",
    4:"3",
    5:"3/3.5",
    6:"2",
    7:"3.5",
    8:"3.5/4",
    9:"4",
    10:"1.5/2",
    11:"0/0.5",
    12:"0.5",
    13:"0.5/1",
    14:"1",
    15:"1/1.5",
    16:"1.5",
    17:"1.5/2",
    18:"4/4.5",
    19:"4.5",
    20:"4.5/5",
    21:"5",
    22:"5/5.5",
    23:"5.5",
    24:"5.5/6",
    25:"6",
    26:"6/6.5",
    27:"6.5",
    28:"6.5/7",
    29:"7",
    30:"7/7.5",
    31:"7.5",
    32:"7.5/8",
    33:"8",
    34:"8/8.5",
    35:"8.5",
    36:"8.5/9",
    37:"9",
    38:"9/9.5",
    39:"9.5",
    40:"9.5/10",
    41:"10",
}

'''澳门hand配置'''
config['aomen']={}
config['aomen']['handicapname']={
    1:"平手",
    2:"平手/半球",
    3:"半球",
    4:"半球/一球",
    5:"一球",
    6:"一球/球半",
    7:"球半",
    8:"球半/两球",
    9:"两球",
    10:"两球/两球半",
    11:"两球半",
    12:"两球半/三球",
    13:"三球",
    14:"三球/三球半",
    15:"三球半",
    16:"三球半/四球",
    17:"四球",
    18:"四球/四球半",
    19:"四球半",
    20:"四球半/五球",
    21:"五球"
}
config['aomen']['handicap']={
    1:'平手',
    2:'平手/半球',
    3:'半球',
    4:'半球/一球',
    5:'一球',
    6:'一球/球半',
    7:'球半',
    8:'球半/两球',
    9:'两球',
    10:'两球/两球半',
    11:'两球半',
    12:'两球半/三球',
    13:'三球',
    14:'三球/三球半',
    15:'三球半',
    16:'三球半/四球',
    17:'四球',
    18:'受平手/半球',
    19:'受半球',
    20:'受半球/一球',
    21:'受一球',
    22:'受一球/球半',
    23:'受球半',
    24:'受球半/两球',
    25:'受两球',
    26:'受两球/两球半',
    27:'受两球半',
    28:'受两球半/三球',
    29:'受三球',
    30:'受三球/三球半',
    31:'受三球半',
    32:'受三球半/四球',
    33:'受四球',
    34:'四球/四球半',
    35:'四球半',
    36:'四球半/五球',
    37:'五球',
    38:'受四球/四球半',
    39:'受四球半',
    40:'受四球半/五球',
    41:'受五球'
}

config['aomen']['dx_handicap']=["0","0/0.5","0.5","0.5/1","1","1/1.5","1.5","1.5/2","2","2/2.5","2.5","2.5/3","3","3/3.5","3.5","3.5/4","4","4/4.5","4.5","4.5/5",
    "5","5/5.5","5.5","5.5/6","6","6/6.5","6.5","6.5/7","7","7/7.5","7.5","7.5/8","8","8/8.5","8.5","8.5/9","9","9/9.5","9.5","9.5/10","10"]

config['gooooal']={
    'handi':{
        0:'平手',
        1:'平手/半球',
        2:'半球',
        3:'半球/一球',
        4:'一球',
        5:'一球/球半',
        6:'球半',
        7:'球半/两球',
        8:'两球',
        9:'两球/两球半',
        10:'两球半',
        11:'两球半/三球',
        12:'三球',
        13:'三球/三球半',
        14:'三球半',
        15:'三球半/四球',
        16:'四球',
        17:'四球/四球半',
        18:'四球半',
        19:'四球半/五球',
        20:'五球'
    },
    'pk':{
        0:'0',
        1:'0/0.5',
        2:'0.5',
        3:'0.5/1',
        4:'1',
        5:'1/1.5',
        6:'1.5',
        7:'1.5/2',
        8:'2',
        9:'2/2.5',
        10:'2.5',
        11:'2.5/3',
        12:'3',
        13:'3/3.5',
        14:'3.5',
        15:'3.5/4',
        16:'4',
        17:'4/4.5',
        18:'4.5',
        19:'4.5/5',
        20:'5',
        21:'5/5.5'
    }
}