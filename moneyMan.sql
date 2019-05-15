/*
 Navicat MySQL Data Transfer

 Source Server         : SMTP
 Source Server Type    : MySQL
 Source Server Version : 50622
 Source Host           : localhost
 Source Database       : MoneyManager

 Target Server Type    : MySQL
 Target Server Version : 50622
 File Encoding         : utf-8

 Date: 11/05/2019 23:16:44 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;
 
-- ----------------------------
--  Table structure for `UserDetails`
-- ----------------------------
DROP TABLE IF EXISTS `UserDetails`;
CREATE TABLE `UserDetails` (
  `UserID` varchar(120) NOT NULL,
  `UserName` varchar(150) NOT NULL,
  `FirstName` varchar(150) DEFAULT NULL,
  `LastName` varchar(150) DEFAULT NULL,
  `Email` varchar(150) NOT NULL,
  `Password` varchar(1000) DEFAULT NULL,
  `OwesTotal` int(11) DEFAULT NULL,
  `lentTotal` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserName`,`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `UserDetails`
-- ----------------------------
BEGIN;
INSERT INTO `UserDetails` VALUES ('cyftrb', 'FrodoBaggins', 'Frodo', 'Baggins', 'frodo@localhost.com', 'ce1615712e24b7c7ebf23feab855a75b4a8a852bbcfae9a99911246256a0fe497', '100', '1'), ('4frvct', 'JohnSmith', 'John', 'Smith', 'js@gmail.com', '6f4e26455b0f9c987a0009f3c5bd12786300b90fa76fb5399c82f2e63ab7121aa', '1445987595', '1'), ('692g6q', 'PraviinM', 'Praviin', 'Mandhare', 'pravsm@gmail.com', '1e905117d466dc32016cb71e3cb798cea73a942f2221fcbda1b5dc8104c2565ee', '200', '500');
COMMIT;

-- ----------------------------
--  Table structure for `oweTable`
-- ----------------------------
DROP TABLE IF EXISTS `oweTable`;
CREATE TABLE `oweTable` (
  `uniqueid` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(120) NOT NULL,
  `owes_UserId` varchar(120) NOT NULL,
  `money` int(11) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `oweTable`
-- ----------------------------
BEGIN;
INSERT INTO `oweTable` VALUES ('2', 'xwk1rj', '4r19xl', 200);
INSERT INTO `oweTable` VALUES ('2', 'xwk1rj', 'cyftrb', 10);
INSERT INTO `oweTable` VALUES ('2', 'cyftrb', '4r19xl', 50);
INSERT INTO `oweTable` VALUES ('2', 'cyftrb', 'xwk1rj', 55);
COMMIT;

-- ----------------------------
--  Table structure for `lentTable`
-- ----------------------------
DROP TABLE IF EXISTS `lentTable`;
CREATE TABLE `lentTable` (
  `uniqueid` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(120) NOT NULL,
  `lent_UserId` varchar(120) NOT NULL,
  `money` int(11) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `lentTable`
-- ----------------------------

BEGIN;
INSERT INTO `lentTable` VALUES ('2', 'cyftrb', '4r19xl', 200);
INSERT INTO `lentTable` VALUES ('3', 'xwk1rj', 'cyftrb', 10);
INSERT INTO `lentTable` VALUES ('4', 'xwk1rj', '4r19xl', 50);
INSERT INTO `lentTable` VALUES ('5', 'cyftrb', 'xwk1rj', 55);
INSERT INTO `lentTable` VALUES ('8', 'xwk1rj', '692g6q', 72);
COMMIT;
