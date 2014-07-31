/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50528
Source Host           : localhost:3306
Source Database       : match

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2014-08-01 01:11:47
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `match`
-- ----------------------------
DROP TABLE IF EXISTS `match`;
CREATE TABLE `match` (
  `id` int(10) NOT NULL COMMENT '对阵ID',
  `rangqiu` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '让球数',
  `isshow` int(3) DEFAULT NULL COMMENT '是否显示',
  `matchnum` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '比赛',
  `league` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '联赛名称',
  `simpleleague` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '联赛简称',
  `homename` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '主队',
  `homesxname` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '主队简称',
  `awayname` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '客队',
  `awaysxname` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '客队简称',
  `win` varchar(10) CHARACTER SET utf8 NOT NULL,
  `processname` varchar(10) CHARACTER SET utf8 NOT NULL,
  `processdate` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `matchdate` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `matchtime` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `endtime` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `matchnumdate` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `date` varchar(30) CHARACTER SET utf8 NOT NULL,
  `end` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of match
-- ----------------------------
INSERT INTO match VALUES ('78755', '1', '1', '周四003', '欧罗巴联赛', '欧联', '特伦钦', '特伦钦', '赫尔城', '赫尔城', '3.35', '4003', '2014-07-31', '2014-08-01', '2014-08-01 01:00', '2014-08-01 00:59', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78756', '1', '1', '周四004', '欧罗巴联赛', '欧联', '博莱斯拉夫', '博莱斯', '里昂', '里  昂', '3.45', '4004', '2014-07-31', '2014-08-01', '2014-08-01 01:00', '2014-08-01 00:59', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78757', '-1', '1', '周四005', '欧罗巴联赛', '欧联', 'IFK哥德堡', '哥德堡', '里奥阿维', '里奥阿', '4.65', '4005', '2014-07-31', '2014-08-01', '2014-08-01 01:00', '2014-08-01 00:59', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78759', '1', '1', '周四007', '欧罗巴联赛', '欧联', '布鲁马波卡纳', '布鲁马', '都灵', '都  灵', '2.08', '4007', '2014-07-31', '2014-08-01', '2014-08-01 01:00', '2014-08-01 00:59', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78760', '-1', '1', '周四008', '欧罗巴联赛', '欧联', '卡拉比克体育', '卡拉比', '罗森博格', '罗森博', '4.15', '4008', '2014-07-31', '2014-08-01', '2014-08-01 01:00', '2014-08-01 00:59', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78761', '-1', '1', '周四009', '欧罗巴联赛', '欧联', '布鲁日', '布鲁日', '布隆德比', '布隆德', '2.80', '4009', '2014-07-31', '2014-08-01', '2014-08-01 02:30', '2014-08-01 02:29', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78762', '-1', '1', '周四010', '欧罗巴联赛', '欧联', '美因茨', '美因茨', '特里波利海星', '特海星', '1.62', '4010', '2014-07-31', '2014-08-01', '2014-08-01 02:30', '2014-08-01 02:29', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78763', '-1', '1', '周四011', '欧罗巴联赛', '欧联', '皇家社会', '社  会', '阿伯丁', '阿伯丁', '1.73', '4011', '2014-07-31', '2014-08-01', '2014-08-01 02:30', '2014-08-01 02:29', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78764', '-1', '1', '周四012', '欧罗巴联赛', '欧联', '圣约翰斯通', '圣约翰', '特尔纳瓦斯巴达', '特尔纳', '4.55', '4012', '2014-07-31', '2014-08-01', '2014-08-01 02:45', '2014-08-01 02:44', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78765', '-1', '1', '周四013', '巴西杯', '巴西杯', '科里蒂巴', '科里蒂', '派桑杜', '帕桑度', '1.90', '4013', '2014-07-31', '2014-08-01', '2014-08-01 08:00', '2014-08-01 07:59', '2014-07-31', '2014-07-31 星期四', '20140731', '0');
INSERT INTO match VALUES ('78767', '-1', '1', '周五001', '挪威超级联赛', '挪超', '利勒斯特罗姆', '利勒斯', '布兰', '布  兰', '2.73', '5001', '2014-08-01', '2014-08-02', '2014-08-02 01:00', '2014-08-02 00:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78768', '-1', '1', '周五002', '法国乙级联赛', '法乙', '阿尔勒', '阿尔勒', '阿雅克肖', '阿雅克', '4.60', '5002', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78769', '-1', '1', '周五003', '法国乙级联赛', '法乙', '欧塞尔', '欧塞尔', '勒阿弗尔', '阿弗尔', '4.35', '5003', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78770', '-1', '1', '周五004', '法国乙级联赛', '法乙', '阿雅克肖GFCO', '阿雅GF', '瓦朗谢纳', '瓦朗谢', '5.50', '5004', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78771', '-1', '1', '周五005', '法国乙级联赛', '法乙', '南锡', '南  锡', '第戎', '第  戎', '3.60', '5005', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78772', '-1', '1', '周五006', '法国乙级联赛', '法乙', '尼姆', '尼  姆', '昂热', '昂  热', '4.20', '5006', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78773', '-1', '1', '周五007', '法国乙级联赛', '法乙', '拉瓦勒', '拉瓦勒', '尼奥尔', '尼奥尔', '4.45', '5007', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78774', '-1', '1', '周五008', '法国乙级联赛', '法乙', '图尔', '图 尔', '克雷泰伊', '克雷泰', '3.65', '5008', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78775', '1', '1', '周五009', '法国乙级联赛', '法乙', '沙托鲁', '沙托鲁', '特鲁瓦', '特鲁瓦', '4.95', '5009', '2014-08-01', '2014-08-02', '2014-08-02 02:00', '2014-08-02 01:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78776', '-1', '1', '周五010', '德国乙级联赛', '德乙', '杜塞尔多夫', '杜塞尔', '不伦瑞克', '不伦瑞', '3.80', '5010', '2014-08-01', '2014-08-02', '2014-08-02 02:30', '2014-08-02 02:29', '2014-08-01', '2014-08-01 星期五', '20140801', '0');
INSERT INTO match VALUES ('78779', '-1', '1', '周五013', '美国职业大联盟', '美职联', '堪萨斯城竞技', '肯萨斯', '费城联合', '费城联', '2.60', '5013', '2014-08-01', '2014-08-02', '2014-08-02 08:00', '2014-08-02 07:59', '2014-08-01', '2014-08-01 星期五', '20140801', '0');

-- ----------------------------
-- Table structure for `match_sp`
-- ----------------------------
DROP TABLE IF EXISTS `match_sp`;
CREATE TABLE `match_sp` (
  `sid` int(10) NOT NULL COMMENT '对阵ID',
  `rangqiu` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '让球数',
  `leagueEn` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '联赛名称',
  `leagueCh` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '联赛简称',
  `homenameEn` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '主队',
  `homenameCh` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '主队简称',
  `awaynameEn` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '客队',
  `awaynameCh` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '客队简称',
  `sp` varchar(10) CHARACTER SET utf8 NOT NULL,
  `matchtime` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of match_sp
-- ----------------------------

-- ----------------------------
-- Table structure for `peilv`
-- ----------------------------
DROP TABLE IF EXISTS `peilv`;
CREATE TABLE `peilv` (
  `id` int(10) NOT NULL,
  `sid` int(10) NOT NULL COMMENT '外围场次id',
  `rq` int(10) NOT NULL,
  `win` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT '竞彩赔率',
  `sp` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '外围赔率',
  `date` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of peilv
-- ----------------------------
INSERT INTO peilv VALUES ('78755', '0', '1', '3.35', '0', '2014-08-01 01:00');
INSERT INTO peilv VALUES ('78756', '0', '1', '3.45', '0', '2014-08-01 01:00');
INSERT INTO peilv VALUES ('78757', '0', '-1', '4.65', '0', '2014-08-01 01:00');
INSERT INTO peilv VALUES ('78759', '0', '1', '2.08', '0', '2014-08-01 01:00');
INSERT INTO peilv VALUES ('78760', '0', '-1', '4.15', '0', '2014-08-01 01:00');
INSERT INTO peilv VALUES ('78761', '0', '-1', '2.80', '0', '2014-08-01 02:30');
INSERT INTO peilv VALUES ('78762', '0', '-1', '1.62', '0', '2014-08-01 02:30');
INSERT INTO peilv VALUES ('78763', '0', '-1', '1.73', '0', '2014-08-01 02:30');
INSERT INTO peilv VALUES ('78764', '0', '-1', '4.55', '0', '2014-08-01 02:45');
INSERT INTO peilv VALUES ('78765', '0', '-1', '1.90', '0', '2014-08-01 08:00');
INSERT INTO peilv VALUES ('78767', '0', '-1', '2.73', '0', '2014-08-02 01:00');
INSERT INTO peilv VALUES ('78768', '0', '-1', '4.60', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78769', '0', '-1', '4.35', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78770', '0', '-1', '5.50', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78771', '0', '-1', '3.60', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78772', '0', '-1', '4.20', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78773', '0', '-1', '4.45', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78774', '0', '-1', '3.65', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78775', '0', '1', '4.95', '0', '2014-08-02 02:00');
INSERT INTO peilv VALUES ('78776', '0', '-1', '3.80', '0', '2014-08-02 02:30');
INSERT INTO peilv VALUES ('78779', '0', '-1', '2.60', '0', '2014-08-02 08:00');
