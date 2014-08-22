#coding:gbk
import re,time,curl,traceback
from threading import Thread
from betball.func import common as Func
from betball.db.odds import Db_Odds
from betball.func import post as Post
'''ball365匹配线程'''
class ball365_match(Thread):
    def __init__(self):
        Thread.__init__(self)
        self.isRun=True
        self.data=[]
    def stop(self):
        self.isRun=False
        Func.write_log('[thread:ball365_match]线程停止!')
    def run(self):
        Func.write_log('[thread:ball365_match]线程开启!')
        while self.isRun:
            self.do()
            time.sleep(Func.getThreadSleep('ball365_match'))
    def getData(self):
        return self.data
    def request_once(self,url,timeout=10):
        try:
            content=''
            request=curl.Curl()
            #设置超时时间
            request.set_timeout(timeout)
            content=request.get(url)
            request.close()
            self.request_times=0
        except Exception,e:
            if self.request_times<3:
                self.request_times+=1
                return self.request_once(url,timeout)
            else:
                self.request_times=0
                Func.write_log('[thread:ball365_match]request_once请求%s页面出现异常:%s'%(url,e))
        return content
    def do(self):
        data_arr=[]   
        result_arr={}
        try:
            url=Func.getPath('ball365_xml')
            content=self.request_once(url,15)
            if content and content.find('<?xml version="1.0"')==0:
                now_time=str(time.strftime('%Y%m%d%H%M',time.localtime()))
                content=content.replace('<?xml version="1.0" encoding="gb2312"?>','<?xml version="1.0" encoding="gbk"?>')
                dom=Func.parseString(content)
                if dom:
                    node_arr=dom.getElementsByTagName('m')
                else:
                    node_arr=[]
                for node in node_arr:
                    matchdate=str(node.getElementsByTagName('MatchDate')[0].firstChild.nodeValue)
                    if matchdate<now_time:
                        continue
                    fixtureid=int(node.getElementsByTagName('MatchID')[0].firstChild.nodeValue)
                    ball365_matchid=int(node.getElementsByTagName('Ball365_MatchID')[0].firstChild.nodeValue)
                    home_tmp=node.getElementsByTagName('HomeName')[0].firstChild.nodeValue.encode('gbk').split(',')
                    hometeam=home_tmp[0]
                    hometeam_tmp=home_tmp[1]
                    away_tmp=node.getElementsByTagName('AwayName')[0].firstChild.nodeValue.encode('gbk').split(',')
                    awayteam=away_tmp[0]
                    awayteam_tmp=away_tmp[1]                 
                    isreverse=int(node.getElementsByTagName('IsReverse')[0].firstChild.nodeValue)
                    islottype=int(node.getAttribute('IsLotType'))
                    isbeidan=int(node.getAttribute('IsBeiDan'))
                    limit1=int(node.getAttribute('Limit1'))
                    limit2=int(node.getAttribute('Limit2'))
                    limit3=int(node.getAttribute('Limit3'))
                    
                    row={'fixtureid':fixtureid,'ball365_matchid':ball365_matchid,'hometeam':hometeam,'hometeam_tmp':hometeam_tmp,'awayteam':awayteam,'awayteam_tmp':awayteam_tmp,
                         'matchdate':matchdate,'isreverse':isreverse,'islottype':islottype,'isbeidan':isbeidan,'limit1':limit1,'limit2':limit2,'limit3':limit3}
                    result_arr[fixtureid]=row
        except Exception,e:
            Func.write_log('[thread:ball365_match]分析%s页面出现异常:%s'%(url,e))
            return  
        try:        
            url=Func.getPath('ball365_matchurl')

            ct_tmp=self.request_once(url,18)

            begin=time.strftime('%Y-%m-%d %H:%M:00',time.localtime())
            end=time.strftime('%Y-%m-%d',time.localtime(time.time()+8*24*3600))
            
            sp_time=time.strftime('%Y-%m-%d 12:00:00',time.localtime(time.time()+24*3600))
            
            list=Db_Odds().getballfixture(begin,end)
            
            pattern=re.compile(r'[\w]+\[[\d]+\]="([^"]+)";')
            ct_arr=pattern.findall(ct_tmp)
            for r in ct_arr:
                try:
                    item=r.split('')
                    matchname=item[6].strip()
                    matchtime=item[1].strip()
                    hometeam=item[3].strip()
                    awayteam=item[5].strip()
                    ball365_matchid=int(item[0])
                    isexists=0
                    for row in list:
                        fixtureid=row['fixtureid']
                        homename=row['home']
                        awayname=row['away']
                        matchdate=row['matchdatetime']
                        limit1=0
                        limit2=0
                        limit3=0
                        if row['sourcelimit'] and int(row['sourcelimit'])==1 and row['sourceoddslimit']:
                            source_arr=row['sourceoddslimit'].split(',')
                            for v in source_arr:
                                if v=='1':
                                    limit1=1
                                elif v=='2':
                                    limit2=1
                                elif v=='3':
                                    limit3=1
                        islottype=int(row['islottyle'])
                        isbeidan=int(row['isbeidan'])
                        flag1=(hometeam==row['ball365_1'] or hometeam==row['ball365_eur_1']) and (awayteam==row['ball365_2'] or awayteam==row['ball365_eur_2'])
                        flag2=(hometeam==row['ball365_2'] or hometeam==row['ball365_eur_2']) and (awayteam==row['ball365_1'] or awayteam==row['ball365_eur_1'])
                        flag3=Func.check_day_diff(matchtime,matchdate)
                        if (flag1 or flag2) and flag3:
                            home_tmp=''
                            away_tmp=''
                            isexists=1
                            isreverse=0
                            if flag1:
                                home_tmp=hometeam
                                away_tmp=awayteam
                            elif flag2:
                                home_tmp=awayteam  
                                away_tmp=hometeam
                                isreverse=1
                            result_arr[fixtureid]={}
                            result_arr[fixtureid]['fixtureid']=fixtureid
                            result_arr[fixtureid]['islottype']=islottype
                            result_arr[fixtureid]['isbeidan']=isbeidan
                            result_arr[fixtureid]['isreverse']=isreverse
                            result_arr[fixtureid]['limit1']=limit1
                            result_arr[fixtureid]['limit2']=limit2
                            result_arr[fixtureid]['limit3']=limit3
                            result_arr[fixtureid]['ball365_matchid']=ball365_matchid
                            result_arr[fixtureid]['hometeam']=homename
                            result_arr[fixtureid]['awayteam']=awayname
                            
                            result_arr[fixtureid]['hometeam_tmp']=home_tmp
                            result_arr[fixtureid]['awayteam_tmp']=away_tmp
    
                            #result_arr[fixtureid]['matchdate']=str(time.strftime('%Y%m%d%H%M',time.strptime(matchdate,'%Y-%m-%d %H:%M:%S')))
                            result_arr[fixtureid]['matchdate']=re.sub(r"\s|\-|\:","",str(matchdate))[0:12]
    
    
                            if str(matchdate)<str(sp_time):
                                istoday=1
                            else:
                                istoday=0
                            data_arr.append({'matchname':matchname,'fixtureid':fixtureid,'homename':homename,'awayname':awayname,'matchdate':matchdate,'url':Func.getPath('ball365_odds')%ball365_matchid,'ismatch':1,'istoday':istoday})
                            break
                    if isexists==0:
                        if str(matchtime)<str(sp_time):
                            istoday=1
                        else:
                            istoday=0
                        data_arr.append({'matchname':matchname,'fixtureid':'','homename':hometeam,'awayname':awayteam,'matchdate':matchtime,'url':Func.getPath('ball365_odds')%ball365_matchid,'ismatch':0,'istoday':istoday})
                except Exception,e:
                     Func.write_log('[thread:ball365_match]分析数据出现异常:%s'%traceback.format_exc())
            if Post.post_365xml(result_arr):
                self.data=data_arr
            result_arr=None
            data_arr=None
        except Exception,e:
            Func.write_log('[thread:ball365_match]请求%s页面出现异常:%s'%(url,traceback.format_exc()))