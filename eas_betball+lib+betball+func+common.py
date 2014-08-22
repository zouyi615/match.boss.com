#coding:gbk
'''���÷��� '''
import betball.config.common as cf
import logging
import time,urllib,urllib2
import XmlUtil
import curl
import datetime
import pycurl
import StringIO
'''��ȡ˯��ʱ��'''
def getThreadSleep(thread):
    if cf.config['thread_sleep_time'].has_key(thread):
        return cf.config['thread_sleep_time'][thread]
    else:
#        return 0
        return ''
    
'''��ȡ����·��'''
def getPath(key):
    if cf.config['path'].has_key(key):
        return cf.config['path'][key]
    else:
        return None
    
'''д��־����'''
def write_log(msg):
    logging.info(msg)
    
'''url����ҳ��'''    
def fopen(path,post={},type='',timeout=18):
    content=''
    try:
#        if post:
#            content=urllib2.urlopen(path,data=urllib.urlencode(post),timeout=10).read()
#        else:
#            content=urllib2.urlopen(path,timeout=10).read()
#        request=curl.Curl()
#        #���ó�ʱʱ��
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
            c = pycurl.Curl() #����һ��ͬlibcurl�е�CURL���������Ӧ��Curl����
            b = StringIO.StringIO()
            c.setopt(pycurl.URL, path) #����Ҫ���ʵ���ַ
            #д�Ļص�
            c.setopt(pycurl.WRITEFUNCTION, b.write)
            c.setopt(pycurl.FOLLOWLOCATION, 1) #������1��2
            c.setopt(pycurl.NOSIGNAL, 1)
            #����ض������,����Ԥ���ض�������
            c.setopt(pycurl.MAXREDIRS, 5)
            #���ӳ�ʱ����
            c.setopt(pycurl.CONNECTTIMEOUT, 20) #���ӳ�ʱ
            c.setopt(pycurl.TIMEOUT, 60) #���س�ʱ
            # c.setopt(pycurl.HEADER, True)
            c.setopt(c.HTTPHEADER, ["Referer:http://www.bet007.com"])
            #ģ�������
            c.setopt(pycurl.USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)")
            #����,���������ʽ���
            c.perform() #ִ������������ַ�Ĳ���
            content = b.getvalue()
            b.close()
            c.close()
        else:
            request=curl.Curl()
            #���ó�ʱʱ��
            request.set_timeout(timeout)
            if not post:
                content=request.get(path)
            else:
                content=request.post(path,post)
            request.close()
    except Exception,e:
        write_log('%s����ҳ��%s�����쳣:%s!'%(type,path,e))
    return content

'''����xml����'''
def parseString(string):
    if string and string.find('<?xml ')==0:
        return XmlUtil.parseString(string)
    else:
        return None

'''����ת������'''
def getSimplifiedChinese(string):
    simple_string=u'�����רҵ�Զ�˿������ɥ���ܷ���Ϊ����ô��������ϰ�����������ڿ���ب�ǲ�Ķ�����ڽ����ز����Ǽ����Ż����ɡΰ����������α������Ӷ�����½�����ȿ�٭ٯٶٱٲ��ٳ��ծ�������ǳ����ϴ��ж��������������������ڸԲ�д��ũڣ��������������������ݼ�����ƾ��������ۻ������մ�ɾ���i�ٹ����ܼ��н�����Ȱ����۽����������ѫ����������ҽ��Э����¬±����ȴ�᳧������ѹ���ǲ������ó����������΅���˫�������Ҷ��̾ߴ�����������Ķ�������߼߽Ż߿��Ա��Ǻ��ӽ���������������������������ܻ�������Ӵ��y��|������������������Х�������������������������԰��Χ���ͼԲʥ�۳��໵���̳�ް����׹¢�����ݿ����ѵ��눙����������������ǵ��Gܫǽ׳���Ǻ��״�������ͷ��ж���ۼ�ܽ���ױ���������橽�¦�欽�����测OӤ���������������ѧ������ʵ�����ܹ�����޶�Ѱ���ٽ�������Ң��ʬ��������������������᫸���ᰵ�����ᴿ��N�Ͽ�i����������ո�ɍ��������۹��ϱ�˧ʦ�������Ĵ�֡����������᥸ɲ��۹�ׯ��®�п�Ӧ���ӷώ��޿������������䵯ǿ�鵱¼���峹�������������黳̬��������������������Ҷ������������������������ҳͱ�㫲ѵ����㳷��Ը��\���������Ϸ�ս꯻�����Ǥִ����ɨ���Ÿ����ҿ�������������£��ӵ��š�����ֿ�Β���̢Ю�ӵ��������Ӓ�����񻻵�����°������������������§��Я�����ҡ��̯������ߢߣߥ���ܵ�����ի쵶�ն���޾�ʱ���D���o�Խ�ɹ�����������������ӻ�ɱ��Ȩ������追ܼ���������������ǹ���ɹ�������դ��ջ���ж����������������������嵵��������׮�Η���������������¥���鷘������ƺ���ӣ�ͳ��������ݻ��ŷ���������������Ź��챱ϱ�ձ�������뵻㺺��������û��Ž���ٲכh���mŢ���������к�������������ǳ����䥛��ǲ�䫼�䯛����Ũ䱛�Ϳӿ���������Л��������ɬ��Ԩ�����½���������������ʪ�����Ӝ�������������������б�̲����������ΫǱ���������������ֲ��¯�����������˸�������̷����ǻ��̽��Ȼ������������ְ�ү���ǣ��������״�����̱���A������ʨ����������������è���̡��_�`���⻷�֫o�����巩�竚���Q��������������걵续�������ű�����ߴ�������Ӹ�������컾������}������̱���Ѣ�񳰨����յ�μ�ǵ������������������������������ש�������������n��˶���ͳ}�~ȷ�ﰭ���׼�������t����������»����ͺ���ֻ��ƻඌ��˰�����������Ҥ���ѿ��������������ȼ���������ɸ�Y�ݳ�ǩ����������������¨���������������������������׽�����������������Լ����������γ������ɴ���������ڷ�ֽ�Ʒ�����Ŧ������������ϸ֯��称������ﾭ窰��޽������笻��Ѥ������ͳ�篾��������м�簼���������糴�����ά��緱��������������׺��罼������翼�������綶��������Ļ����Ʊ���Ե�Ƹ����Ƿ����ɲ���������������ӧ���������������������ٽ�������޷��������������������ʳ�����ְ���������೦����������в��ʤ�������ֽ�����������ŧ���������������N�������������H��������������ܳ�ս���ܼ��«��έ�����ɲ�������ƻ����������뾣���Q���������������ٻ�����ӫݡݣݥ��ݤݦݧҩݰݯ����ݪݫݲ��ݵӨݺݻ�[��өӪ�����������޽���������������Ǿ������ޭ��޴޻޺²���������Ϻ�ʴ������������������������������Ӭ���Ы����΅���]���β��������Є��Ϯ�Bװ���T���Ͽ����������[�����_�������������������`��������������Ԁ����ڥ�ƶ����ϼ�ڦڧ����ڨ��ѵ��Ѷ��ך����کڪ��ګ�����כ�Ϸ���þ�֤ڬڭ����ʶלթ����ڮ�ߴ�ڰگם��ڱڲڳ��ڴʫڵڶ����ڷ����ڸڹ��ѯ��ں�����ڻڼמ������ڽ��ھ�ջ�ڿ˵����������ŵ���·̿�����˭�ŵ�����׻��̸��ı�ȵ�����г����ν�����β�������������נ������лҥ����ǫ�׽�á������̷������������Ǵ���߹��k���긺�O�������Ͱ��˻��ʷ�̰ƶ�Ṻ���ᷡ�����������ܴ�ó�Ѻ������޼ֻ�����¸���������������޸��������ʹ��P�Q���������R׸��׬���������S����Ӯ���W�Ը�������Ծ�����ȼ��Q��������ӻ������������������������������a��ת��������������������������������������b�����������������Թ����c��ꣷ����d����ԯϽշ���ꥴǱ����ɴ�Ǩ�����˻����ԶΥ�������ɼ���ѡѷ��������ң����������������ۣۧۦ֣۩۪�ǵ����N������������⠼����������붤��������ǥ����蕷����������藸����Ѷ۳����Ʊ�������Կ�վ��ٹ���������ť����Ǯ��ǯ�ܲ������������������������������Ǧí������������������������������������ͭ��������ա��ϳ����������������綠�ҿ������������������������ﭳ��������ﲷ�п��������������ﻴ�ê�����������സ׶���@���������Ķ������������A������������������B���Ͷ�þ���C���������D�����E�������ָ���������F���������G�޾��������H���������������������������I�����������J�K�ⳤ���������\���ʴ��������ȼ�������բ�ֹ����������]��������������^���������������ղ������_���������`�����a��������׼�½¤���������������������ѳ���������ù����������������Τ��킺������ҳ��������˳������˶���������Ԥ­���ľ����F���G���Ƶ�H����Iӱ�����J���ն�������K����ȧ���r�s����t��u�vƮ�쮷�����𗼢����������������α�����¶�����������������������ڹ�������Ȳ��@���A����������������Ԧ��ѱ�����R��¿��ʻ�������פ��������������S�����溧���T������U�V�����������W�X��ƭ���Yɧ����������������������Z������������������������³�����������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������@��𯼦����\Ÿѻ�]�����Ѽ�^���_��ԧ�`��������a�b�����c���������������ȵ�����d�����e���f�g�h���i�����j�������k���l�m�n�o�Ϻ��p�����������������rӥ���s���t����������d������������ػ������촳�����������������������ȣ���������'
    target_string=u'�f�c�h���I���|�z�G�ɇ��ʂ����S�R�����e�N�x���������l���I�y���̝녁����a���H�C���|�H�ā��}�x���r����ⷕ����ゥ�����t����΁��w�N��L�b�H�e�ɂȃS�~���z�R�����z�������A��E�f�����������������h�m�P�dƝ�B�F�σȌ��Ԍ�܊�r�V�T�_�Q�r���Q�D���R�p���C���P�D�{�P������c�����t�����h�e�}�q�������������������k�Մ�ӄ�ńڄ݄��̈́��Q�T�^�t�A�f���u�R�u�P�l�s���S�d�х��������������B�N���P�h�����a�^�p�l׃���B�~̖�U�\�n�ᇘ�Ά�w�� ���Ǉ`�҇I���h�T�J�܆�ԁ�U�����z߸�j�y��푆��}�^�􇂇W�������чO�߇Z����r����K�݇��m�Ӈc�[���D���˺Ǉ��u�ڇ������o�F�@��������D�A�}������ĉK�ԉ��ȉΉ]�����ŉŉ������s�׉|�������N�߉P�_��|���q����ԭ�������؉�̎���}���^�F�A�Z�Y�J�^���W�y�D�����������K��I�ƋɌD�ʋz������ȋ����܋�ԋߌO�W�\�������������m���e���������ی����m�L����ƱM�ӌڌόÌٌҌՎZ�q�M�獏�s�S���u�X�[���h�G�F�{�A�����n�����M��V�􍣍⼹�p얎��Ŏ����������Î����͎Ύ������L�ցKô�V�f�c�]�T�쑪�R���U�F�[�_�����������������w��䛏����؏��ƶR���ԑn���ёB�Z���Y����z�������ّ����Q�Ð�Ő�������ґa���@�֑K�͑v�ܑM���T���C���|ؑ��𑿑Б��ߑ����������L�̔U�ВߓP�_�ᒁ���������o����M�n����r�Q�ܓ�쓴�����钶�ϓ��ג�D�]�͓Ɠp��Q�v���ӓ�S�ۓ���������v�R�����y�z�d�[�u�P���t�Δf�X�]�x�\���������S���Y�ؔ��o�f�r�番�ҕ����@�x��ԕϕ������ᄞ�g��C���s���l���q�ܘO�����З����g�������n�����f�d�Ř˗����ɗ������ژ䗫�ә藨����E�n�����u�����������z����������E�Ǚ���Ιx�������M�{�љ����������_�g�e�W���{����������������ݞ�����֚Кښ���菡�h�@�����e�ϛ]���a�r�S��t��������I�͞{�o�T�a���ɛܝ����D�ќ\�{�����۝�y�ҝ��g�I���G�❡���T�������Z�i���u�ݜo�읙���q���՜Y�O�n�^�u�ƝO�c�B���[���񝢞R�s�U���L�������M�]�V�E���I���˞E�u�t���H���z���|�l������`�ĠN���t�������c����q���N�T��������Z�C�a�៨�F�c��������۠����Ӡ��ޠُ�Ȯ��E�w�q�N���������M�{���b�z�s���C�J�M�i؈�o�I�H�^�m�����|�h�F���t�z�k�m���c�q�\�I�������a�v�����Y�T늮����ܮ��X�����O��󜯏������b�d�W�{�A���B�V�D�������T�c�a�`�]�_�dğ�}�����K�}�O�w�I�P�g�{�������A���m���C���\�V�X�a�u�����^�Z�a�[�A�����T�����o���_�|�K���~�A���L�Y�B�[���\���A���U�x�d���N�e�Q�x�v�����d���w�F�`�[�G�Z�C�Q�]�M�Q���V�S�P�a�{�\�e�B�`�Y���~�I�����U�j�D�X�j�������t�@�h�f�[�ei�g�c���S�Z�R�f�o�{��m�u�t�q�w�v�s���w�k�o�x�������������V�{���v�]�����y�������~�����C�X�����M�������K�U�O�E�I�B�[���H���q�Y�f�@�x�W�L�o�k�{�j�^�g�y�������C�����d�^�����w�c�x�m�_�p�b�y�i�K�S�d�R���I�T�^�J�C�`�U�G�Y�l�~�|�}���|�������Z�D���E���������P�����|�������N�`�d�b�p�\�c�p�r�O�V�_�~�z�w�t�s�����i�������\�`�R�Q�U�y���W�_�P�T�`�b�u�w�N�P�E�g�e�u�@�C�c�w�d�I�[Û�{đ�ٖV�L�FÄ�z�}Ē�vĚ�Xē�L�_Ó�TĘ�D�Z�s�|ā�t�e�vĜ�NݛŜŞœ�A�D�W�Hˇ���d�Gʏ�JɐȔ˞�{�O�n�r�K���O�o�d�\�L���O�G�]�R�vʁɜ�w�C�jʎ�sȝ��Ο��n�|�p�a�{ȇȒˎ�Wɉ�Rɏ�P�n�W�@�~���Lɔ�E�}Ξ�I�Mʒ�_�[�rʉ�Y�V�{�E�yʚ�v��N�`�A�@�I�N˒���\̔�]̓�x�A�l�m�rϊ�gρΛ�Qϖ͘�MϠ�|�U�U͐�u·ϓ͑΁Ϟω�X�sϐ�Nϔ�Q�\�D���a�rЖ�\��ы�m�u�U�b�dтў�cѝ�M�@�h���wҊ�^ҍҎҒҕҗ�[�X�JҠ�]�C�D�M�P�U�x�|�zׄ�u�`ӅӋӆӇ�J�Iӓӏӑ׌ӘәӖ�hӍӛӕ�v�M֎�nӠ�G�SӞՓ�K�A�S�O�L�E�C�b�X�u�{�R�w�p�V�\�g�a�~�x�t�v�g�r�E�CԇԟԊԑԜ�\�DԖԒ�QԍԏԎԃԄՊԓԔԌ՟Ԃ�p�]�_�Z�V�`�a�T�d�N�f�b�OՈ�TՌ�Z�xՎ�u�nՆ՘�lՔ�{�~ՏՁ�rՄ�x�\�Rՙ�e�G�C�o�]�^�@�I�X׋�J�O�V�B�i՛՚փו�q�x�{�r՞�t�k֔֙ֆ�vև�T�P�S׎�V�Hח�l�d׏�Y�rؐؑؓؒؕؔ؟�t���~؛�|؜؝ؚ�Hُ�A؞�E�v�S�B�N�F�L�J�Q�M�R�O�\ٗ�Z�V�D�U�T�E�Y�W�B�g�c�l�d�xـ�V�H�p�n�F�k�s�r�yهوٍَِّ٘�Iٝٚٛ٠�A�M�X�w�sڅڎ�O�Sۄە�V�`�J�Eۋ�]�Q�x�Pۙ�W�U�bۘ�X�f�k�g�|܇܈܉܎܍ܐ�Dܗ݆ܛ�Z�M�V�_�S�T�Wܠ�F�]�U�p�Y�d�e�I�c�b�`�^�m�o�v݂݅�x݁�y݈�z�wݏݗ݋ݜݔ�\�@ݠݚ�A�H�O�o�q�p߅�|�_�w�^�~�\߀�@�M�h�`�B�t߃ޟ�E�m�x�d�fߊ߉�z�b�����w�]�u�����d�S�P�����i�B�y���j�w�u�����Y���b��Y��������Q�T�A��l�C��{�S��O�]�}�b��g�n�R�c�^��k�j耚J�x�u�^��[��^�o�Z��X�`�Q�����O���X��f�g����F�K��p�U�T��C�B�G���I�o�D��s��E�B��e�y�t��K�~�X�H��z����b�A��f��|�x��t��P�C�q��P�|�|�@�y��T���o�n���H�N�i��{�z���~�n�S�s�h�\����J�R�Z�u�|�H��N��e�^�Q�W�u��K�_�a�d��N�F�\�e�v��x��U�V�I��i�O��}�|�I�J���@�R��}��D�X��V�U�t��[���n�k������y��^���\�g�S�M�N��a�O�R�C���B����h�u��|���j��Z�D�G�C��O�d�s�n���L�T�V�W�Z�\�]���J�c��e�b�g�h�`���l�[�|�Y�}��G�y�w�u��b���A����]�����U�@��T���H�D�F�I�R�X�����A�H��]�����E�U�S�[�`�h�y�rׇ�Z�F�V�q�\�n�o�v�^�X�d�x�f�g�h�n�t�y�w����������B��D��C��@�A�B�I�H�i�R�a�c�M�}���W�U�l�_�j�h�e�f�w�}�����~�D�����h���A�E�L�^�Q�R�S�Z�\�`�_�d�h�j�j�w����}����h��q������T������D���A��E��F��G�L�I�N�H�K�R�Q�W�^�l���k�t��v�x�o�s�}�~�z������R�S�W�Z�Y��_�g�H�z����x�|�v��w�{�A�~��R�������Q�P�G��H��E�U�T�S�K�R���_�s�j�}�\��t�q�~�����E�K�L�J�t�y�x�W�|�u�~������������E�G�T�|�O�W�V�N�U�c�Q�T�q�^�w�n�b�j�f�`�d�q�o�r�~���\���~�����������������z�a�����N���O�E�H�K�A�F�T���L�Y�X���a�l�s�l�[���g�w�{�q�v�m�e�F�c�������������������B�L�M�����I�@�Z�X�[�V�s�h�k�g�B�F�u�S�Q�O�t�f�I�d�c�����R���{���o�|�z�x���r���v���������@���[���M�P�Z�N�]�Z�O���Y�^�o���g�A�l�i�k�����t���������X���\�B�F�g�_�O�V�W�^�Y�Q�s�W�p�w�����������D���I�L�X�U�z�����S�Z�s�t�o�w�x�{����B�O�R�W�X�Z�[�]�e�g�_�f�b�l�r�p�x�}��������'
    return_str=''
    #��gbkת��Ϊunicode��,ʹ���С�Ӣ���ַ��ĳ���һ��
    string=unicode(string,'gbk') 
    for i in range(0,len(string)):
        tmp_str=string[i:i+1]
        index=target_string.find(tmp_str)
        if index!=-1:
            return_str+=simple_string[index:index+1]
        else:
            return_str+=tmp_str
    return return_str.encode('gbk')#��unicode��ת����gbk

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
    
'''��ȡball365.xml����'''
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
        if type in ['today_asian','today_odds','today_dxodds']: #����ŷ�⡢���⡢��С�߳�
            timestamp=time.time()
            today=time.strftime('%Y%m%d%H%M',time.localtime(timestamp))
            nextday=time.strftime('%Y%m%d%H%M',time.localtime(timestamp+86400))
        elif type in ['future_odds','future_asian','future_dxodds']:
            nextday=time.strftime('%Y%m%d%H%M',time.localtime(time.time()+86400))
        
        elif type=='lot_odds':
            today=time.strftime('%Y%m%d%H%M',time.localtime())
            
            
        for node in node_arr:
            matchdate=node.getElementsByTagName('MatchDate')[0].firstChild.nodeValue
            #����ŷ���߳�
            if type=='today_odds' and (node.getAttribute('Limit1')!='0' or matchdate<=today or matchdate>nextday):
                continue
            #���������߳�
            elif type=='today_asian' and (node.getAttribute('Limit2')!='0' or matchdate<=today or matchdate>nextday):
                continue
            #�����С�߳�
            elif type=='today_dxodds' and (node.getAttribute('Limit3')!='0' or matchdate<=today or matchdate>nextday):
                continue
            #δ��ŷ���߳�
            elif type=='future_odds' and (node.getAttribute('Limit1')!='0' or matchdate<=nextday):
                continue
            #δ�������߳�
            elif type=='future_asian' and (node.getAttribute('Limit2')!='0' or matchdate<=nextday):
                continue
            elif type=='future_dxodds' and (node.getAttribute('Limit3')!='0' or matchdate<=nextday):
                continue
            #���������߳�
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
    
'''��ȡbetexplore xml��Ϣ'''
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
'''��������ʱ����������'''
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
        return '�;�'
def genConfidence(n):
    string=''
    for i in range(1,n+1):
        string+='��'
    return string

def getHandicapName(handicap,homeismain):
    string=''
    if cf.config['aomen']['handicapname'].has_key(handicap):
        string=cf.config['aomen']['handicapname'][handicap]
    else:
        string=''
    if handicap!=1 and homeismain==0:
        string='��'+string
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

'''��xml��ȡ����ƥ����Ϣ'''
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
            str='��'+cf.config['gooooal']['handi'][handi]
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
    #�ϴ��ӿ�
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