#coding:gbk
'''���������Ϣ'''
config={}

'''�߳�˯��ʱ��'''
config['thread_sleep_time']={
   'ball365_today_odds':180, #ball365����ŷ���߳�˯��ʱ��
   'ball365_today_asian':180, #ball365���������߳�˯��ʱ��
   'ball365_today_dxodds':180,#ball365�����С�߳�˯��ʱ��
   'ball365_dsodds':7200,#ball365��˫�߳�˯��ʱ��
   'ball365_jqsodds':7200,#ball365�������߳�˯��ʱ��
   'ball365_bdodds':7200,#ball365�����߳�˯��ʱ��
   'ball365_bqcodds':7200,#ball365��ȫ���߳�˯��ʱ��
   'ball365_future_odds':300,#ball365δ��ŷ���߳�˯��ʱ��
   'ball365_future_asian':900,#ball365δ�������߳�˯��ʱ��
   'ball365_future_dxodds':900,#ball365δ����С�߳�˯��ʱ��
   'ball365_lot_odds':180,
   
   
   'bet007_today_odds':600,#��̽����ŷ���߳�˯��ʱ��
   'bet007_today_asian':900,#��̽���������߳�˯��ʱ��
   'bet007_today_dxodds':900,#��̽�����С�߳�˯��ʱ��
   'bet007_future_odds':600,#��̽δ��ŷ���߳�˯��ʱ��
   'bet007_future_asian':900,#��̽δ�������߳�˯��ʱ��
   'bet007_future_dxodds':900,#��̽δ����С�߳�˯��ʱ��
   
   'betexplore_today_odds':180,#betexplore����ŷ���߳�˯��ʱ��
   'betexplore_lot_odds':180,#betexplore����lot�߳�˯��ʱ��
   'betexplore_main_odds':300,#betexploreδ��ʱ�����������߳�˯��ʱ��
   'betexplore_unmain_odds':600,#betexploreδ��ʱ������������߳�˯��ʱ��
   
   'ball365_match':6*3600,
   'bet007_todaymatch':10800,
   'bet007_futurematch':7200,
   'betexplore_match':3*3600,

   'gooooal_today_euro':600,#ѩԵ������ŷ���߳�˯��ʱ��
   'gooooal_today_asian':900,#ѩԵ�����������߳�˯��ʱ��
   'gooooal_today_dx':900,#ѩԵ�������С�߳�˯��ʱ��
   'gooooal_future_euro':600,#ѩԵ��δ��ŷ���߳�˯��ʱ��
   'gooooal_future_asian':900,#ѩԵ��δ�������߳�˯��ʱ��
   'gooooal_future_dx':900,#ѩԵ��δ����С�߳�˯��ʱ��
   
   'gooooal_futurematch':7200,#ѩԵ��δ������ƥ���߳�
   'gooooal_todaymatch':7200,#ѩԵ����������ƥ���߳�
   
   'aomen_match_lq':7200, #����ƥ�������߳�
   'aomen_match_zq':7200, #����ƥ�������߳�
   'aomen_match_tv':7200, #����TV�߳�
   'aomen_match_pen':7200, #������ˮ�߳�
   'aomen_match_lq_pen':7200, #����������ˮ�߳�
   'aomen_match_asian':180,#���������߳�
   'aomen_match_euro':300, #����ŷ���߳�
   'aomen_match_dx':1800,   #���Ŵ�С���߳�
   'aomen_match_halfeuro':1800,#�����ϰ볡ŷ��
   'aomen_match_bd':3600,  #���Ų����߳�
   'aomen_match_bqc':3600, #���Ű�ȫ���߳�
   'aomen_match_ds':3600, #���ŵ�˫�߳�
   'aomen_match_jqs':3600, #���Ž�����
   'aomen_match_teamjqs':3600,#������ӽ�����

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

'''���xml������ҳ���·��'''
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

'''����������Ϣ�Ĺ�˾'''
config['cid']={}
config['cid']['dx']=[2,3,5,9,280]


'''����״̬����'''
config['asian']={}
config['asian']['pka']={
    1:'����',
    3:'�����/����',
    4:'�����',
    5:'����/�����',
    6:'����',
    7:'�����/����',
    8:'�����',
    9:'����/�����',
    10:'����',
    11:'���/����',
    12:"���",
    13:'һ��/���',
    14:'һ��',
    15:'����/һ��',
    16:'����',
    17:'ƽ��/����',
    19:'ƽ��',
    31:'��ƽ��/����',
    32:'�ܰ���',
    33:'�ܰ���/һ��',
    34:'��һ��',
    35:'��һ��/���',
    36:"�����",
    37:'�����/����',
    38:'������',
    39:'������/�����',
    40:'�������',
    41:'�������/����',
    42:'������',
    43:'������/�����',
    44:'�������',
    45:'�������/����',
    46:'������',
    47:'������/�����',
    48:'�������',
    49:'�������/����',
    50:'������',
    51:'������/�����',
    52:'�������',
    53:'�������/����',
    54:'������',
    55:'����/�����',
    56:'�����',
    57:'�����/����',
    58:'����',
    59:'����/�����',
    60:'�����',
    61:'�����/����',
    62:'����',
}

'''��С״̬����'''
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

'''����hand����'''
config['aomen']={}
config['aomen']['handicapname']={
    1:"ƽ��",
    2:"ƽ��/����",
    3:"����",
    4:"����/һ��",
    5:"һ��",
    6:"һ��/���",
    7:"���",
    8:"���/����",
    9:"����",
    10:"����/�����",
    11:"�����",
    12:"�����/����",
    13:"����",
    14:"����/�����",
    15:"�����",
    16:"�����/����",
    17:"����",
    18:"����/�����",
    19:"�����",
    20:"�����/����",
    21:"����"
}
config['aomen']['handicap']={
    1:'ƽ��',
    2:'ƽ��/����',
    3:'����',
    4:'����/һ��',
    5:'һ��',
    6:'һ��/���',
    7:'���',
    8:'���/����',
    9:'����',
    10:'����/�����',
    11:'�����',
    12:'�����/����',
    13:'����',
    14:'����/�����',
    15:'�����',
    16:'�����/����',
    17:'����',
    18:'��ƽ��/����',
    19:'�ܰ���',
    20:'�ܰ���/һ��',
    21:'��һ��',
    22:'��һ��/���',
    23:'�����',
    24:'�����/����',
    25:'������',
    26:'������/�����',
    27:'�������',
    28:'�������/����',
    29:'������',
    30:'������/�����',
    31:'�������',
    32:'�������/����',
    33:'������',
    34:'����/�����',
    35:'�����',
    36:'�����/����',
    37:'����',
    38:'������/�����',
    39:'�������',
    40:'�������/����',
    41:'������'
}

config['aomen']['dx_handicap']=["0","0/0.5","0.5","0.5/1","1","1/1.5","1.5","1.5/2","2","2/2.5","2.5","2.5/3","3","3/3.5","3.5","3.5/4","4","4/4.5","4.5","4.5/5",
    "5","5/5.5","5.5","5.5/6","6","6/6.5","6.5","6.5/7","7","7/7.5","7.5","7.5/8","8","8/8.5","8.5","8.5/9","9","9/9.5","9.5","9.5/10","10"]

config['gooooal']={
    'handi':{
        0:'ƽ��',
        1:'ƽ��/����',
        2:'����',
        3:'����/һ��',
        4:'һ��',
        5:'һ��/���',
        6:'���',
        7:'���/����',
        8:'����',
        9:'����/�����',
        10:'�����',
        11:'�����/����',
        12:'����',
        13:'����/�����',
        14:'�����',
        15:'�����/����',
        16:'����',
        17:'����/�����',
        18:'�����',
        19:'�����/����',
        20:'����'
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