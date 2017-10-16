/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : school_manager

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-17 01:16:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1', 'lớp php');
INSERT INTO `class` VALUES ('2', 'lớp java');
INSERT INTO `class` VALUES ('3', 'lớp .net');
INSERT INTO `class` VALUES ('4', 'lớp c#');

-- ----------------------------
-- Table structure for pupil
-- ----------------------------
DROP TABLE IF EXISTS `pupil`;
CREATE TABLE `pupil` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `class_id` int(10) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `birthday` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sex` tinyint(1) NOT NULL,
  `introduce` text,
  `married` tinyint(1) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pupil
-- ----------------------------
INSERT INTO `pupil` VALUES ('26', '1', 'ádasdsa', '2017-10-13 00:00:00', '1', '', '0', '_cc9240eeaf5b42f3f53ce2c06076749659e0ab6a442e06.08622790.jpg');
INSERT INTO `pupil` VALUES ('25', '1', 'học sinh thứ hai của lớp php', '2017-10-11 00:00:00', '1', 'học sinh thứ', '0', '_730a03e78f4229904c255b737d12b0b759e0ac87bc4229.00088061.jpg');
INSERT INTO `pupil` VALUES ('24', '1', 'học sinh thứ nhất của lớp php', '2017-10-12 00:00:00', '1', 'Người này có kiến thức về java nhưng chưa có kiến thức về php', '1', '_d70d796adafaf11d2c499d0c60a0128959e0aca43830b7.69558439.jpg');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '123456');
