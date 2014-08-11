/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : match

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2014-08-11 18:40:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `match`
-- ----------------------------
DROP TABLE IF EXISTS `match`;
CREATE TABLE `match` (
  `id` int(10) NOT NULL COMMENT '对阵ID',
  `rangqiu` varchar(255) NOT NULL DEFAULT '' COMMENT '让球数',
  `isshow` int(3) DEFAULT NULL COMMENT '是否显示',
  `matchnum` varchar(100) DEFAULT NULL COMMENT '比赛',
  `league` varchar(100) NOT NULL COMMENT '联赛名称',
  `simpleleague` varchar(100) NOT NULL COMMENT '联赛简称',
  `homename` varchar(100) NOT NULL COMMENT '主队',
  `homesxname` varchar(100) NOT NULL COMMENT '主队简称',
  `awayname` varchar(100) NOT NULL COMMENT '客队',
  `awaysxname` varchar(100) NOT NULL COMMENT '客队简称',
  `win` varchar(10) NOT NULL,
  `processname` varchar(10) NOT NULL,
  `processdate` varchar(30) DEFAULT NULL,
  `matchdate` varchar(30) DEFAULT NULL,
  `matchtime` varchar(30) DEFAULT NULL,
  `endtime` varchar(30) DEFAULT NULL,
  `matchnumdate` varchar(30) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `date` varchar(30) NOT NULL,
  `homenamesp` varchar(100) DEFAULT NULL COMMENT '外围主队名',
  `awaynamesp` varchar(100) DEFAULT NULL COMMENT '外围客队名',
  `isoffset` int(1) unsigned zerofill DEFAULT '0' COMMENT '是否按队名匹配1是；2否；默认0；否则按比赛时间匹配',
  `end` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of match
-- ----------------------------
INSERT INTO `match` VALUES ('79039', '-1', '1', '周一001', '瑞典超级联赛', '瑞典超', '赫根', '赫 根', '埃尔夫斯堡', '埃尔夫', '4.75', '1001', '2014-08-11', '2014-08-12', '2014-08-12 01:05', '2014-08-12 01:04', '2014-08-11', '2014-08-11 星期一', '20140811', null, null, '0', '0');
INSERT INTO `match` VALUES ('79040', '-1', '1', '周一002', '荷兰乙级联赛', '荷乙', '阿贾克斯青年队', '阿青年', '特尔斯达', '特尔斯', '2.80', '1002', '2014-08-11', '2014-08-12', '2014-08-12 02:00', '2014-08-12 01:59', '2014-08-11', '2014-08-11 星期一', '20140811', null, null, '0', '0');
INSERT INTO `match` VALUES ('79041', '-1', '1', '周一003', '德国乙级联赛', '德乙', '菲尔特', '菲尔特', '纽伦堡', '纽伦堡', '4.25', '1003', '2014-08-11', '2014-08-12', '2014-08-12 02:15', '2014-08-12 02:14', '2014-08-11', '2014-08-11 星期一', '20140811', null, null, '0', '0');
INSERT INTO `match` VALUES ('79042', '1', '1', '周一004', '英格兰联赛杯', '英联杯', '卡利斯尔联', '卡利斯', '德比郡', '德比郡', '2.60', '1004', '2014-08-11', '2014-08-12', '2014-08-12 02:45', '2014-08-12 02:44', '2014-08-11', '2014-08-11 星期一', '20140811', null, null, '0', '0');
INSERT INTO `match` VALUES ('79043', '1', '1', '周一005', '阿根廷甲级联赛', '阿甲', '兵工厂', '兵工厂', '拉普拉塔大学生', '拉普拉', '5.30', '1005', '2014-08-11', '2014-08-12', '2014-08-12 05:00', '2014-08-12 04:59', '2014-08-11', '2014-08-11 星期一', '20140811', null, null, '0', '0');
INSERT INTO `match` VALUES ('79044', '1', '1', '周一006', '阿根廷甲级联赛', '阿甲', '老虎竞技', '泰格雷', '萨斯菲尔德', '萨斯费', '5.75', '1006', '2014-08-11', '2014-08-12', '2014-08-12 07:30', '2014-08-12 07:29', '2014-08-11', '2014-08-11 星期一', '20140811', null, null, '0', '0');
INSERT INTO `match` VALUES ('79046', '-1', '1', '周一007', '日本职业联赛', '日职联', '广岛三箭', '广  岛', '鸟栖沙岩', '鸟  栖', '4.70', '1007', '2014-08-11', '2014-08-11', '2014-08-11 18:00', '2014-08-11 17:59', '2014-08-11', '2014-08-11 星期一', '20140811', null, null, '0', '0');
INSERT INTO `match` VALUES ('79059', '-1', '1', '周二013', '欧洲超级杯', '欧超杯', '皇家马德里', '皇  马', '塞维利亚', '塞维利', '1.90', '2013', '2014-08-12', '2014-08-13', '2014-08-13 02:45', '2014-08-13 02:44', '2014-08-12', '2014-08-12 星期二', '20140812', null, null, '0', '0');

-- ----------------------------
-- Table structure for `peilv`
-- ----------------------------
DROP TABLE IF EXISTS `peilv`;
CREATE TABLE `peilv` (
  `id` int(10) NOT NULL COMMENT '对阵ID',
  `sid` int(10) DEFAULT NULL COMMENT '外围ID',
  `rangqiu` varchar(10) NOT NULL COMMENT '让球数',
  `rangqiusp` varchar(10) DEFAULT NULL COMMENT '外围让球数',
  `win` varchar(10) NOT NULL COMMENT '竞彩赔率',
  `leagueEn` varchar(100) DEFAULT NULL COMMENT '联赛名称',
  `leagueCh` varchar(100) DEFAULT NULL COMMENT '联赛简称',
  `homenameEn` varchar(100) DEFAULT NULL COMMENT '主队',
  `homenameCh` varchar(100) DEFAULT NULL COMMENT '主队简称',
  `awaynameEn` varchar(100) DEFAULT NULL COMMENT '客队',
  `awaynameCh` varchar(100) DEFAULT NULL COMMENT '客队简称',
  `sp` varchar(10) DEFAULT NULL COMMENT '外围赔率',
  `matchtime` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of peilv
-- ----------------------------
INSERT INTO `peilv` VALUES ('79039', '1812809', '-1', '0', '4.75', 'Sweden Allsvenskan', '瑞典超级联赛', 'BK Hacken', '哈肯', 'IF Elfsborg', '艾夫斯堡', '0.86', '2014-08-12 01:05');
INSERT INTO `peilv` VALUES ('79040', '1817239', '-1', '0', '2.80', 'Club Friendly', '俱乐部友谊赛', 'Napoli', '那不勒斯', 'Paris Saint Germain', '巴黎圣日耳曼', '0.72', '2014-08-12 02:00');
INSERT INTO `peilv` VALUES ('79041', '1814987', '-1', '0', '4.25', 'Germany Bundesliga 2 - Specials', '德国乙级联赛 - 特别投注', 'SpVgg Greuther Furth - To Kick Off', '格雷特霍夫先开球', 'FC Nurnberg - To Kick Off', '纽伦堡先开球', '0.98', '2014-08-12 02:15');
INSERT INTO `peilv` VALUES ('79042', '1816666', '1', '0', '2.60', 'England Conference South', '英格兰足协南部联赛', 'Farnborough FC', '法保罗夫', 'Weston Super Mare AFC', '维斯顿', '0.84', '2014-08-12 02:45');
INSERT INTO `peilv` VALUES ('79043', '1812233', '1', '0', '5.30', 'Argentina Primera Division', '阿根廷甲级联赛', 'Arsenal de Sarandi', '沙兰迪兵工厂', 'Club Estudiantes de La Plata', '大学生', '1.35', '2014-08-12 05:00');
INSERT INTO `peilv` VALUES ('79044', '1812234', '1', '0', '5.75', 'Argentina Primera Division', '阿根廷甲级联赛', 'Club Atletico Tigre', '堤格雷', 'CA Velez Sarsfield', '萨斯菲尔德', '1.07', '2014-08-12 07:30');
INSERT INTO `peilv` VALUES ('79046', '1817327', '-1', '0', '4.70', 'Japan J-League Division 1 - Specials', '日本职业甲级联赛 - 特别投注', 'Hiroshima Sanfrecce - No. of Corners', '广岛三箭 - 角球总数', 'Sagan Tosu - No. of Corners', '鸟栖沙根 - 角球总数', '0.62', '2014-08-11 18:00');
INSERT INTO `peilv` VALUES ('79059', null, '-1', null, '1.90', null, null, null, null, null, null, null, '2014-08-13 02:45');
