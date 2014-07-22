/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.1.50-community-log : Database - collect
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`collect` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `collect`;

/*Table structure for table `tp_collect` */

DROP TABLE IF EXISTS `tp_collect`;

CREATE TABLE `tp_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '网站路径',
  `name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '采集项目名称',
  `url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '采集页面路径',
  `list_list` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页列表',
  `list_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页标题',
  `list_url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页链接',
  `list_author` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页作者',
  `list_date` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页时间',
  `list_hits` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页面访问量',
  `list_content` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页内容',
  `list_order` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页面其他内容',
  `list_img` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内容缩略图',
  `isdown` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否下载图片',
  `downext` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '永许下载内容后缀',
  `lasturl` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后抓取地址',
  `testurl` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '测试抓取地址',
  `charset` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '抓取页面编码',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `updatetime` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `tp_collect` */

insert  into `tp_collect`(`id`,`site`,`name`,`url`,`list_list`,`list_title`,`list_url`,`list_author`,`list_date`,`list_hits`,`list_content`,`list_order`,`list_img`,`isdown`,`downext`,`lasturl`,`testurl`,`charset`,`createtime`,`updatetime`) values (1,'http://www.thinkphp.cn','thinkphp 官方网站','http://www.thinkphp.cn/document/index.html','.extend li','.fl a','a','','','','.art-cnt','','',0,'','','','UTF-8',1394347508,1394347508);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
