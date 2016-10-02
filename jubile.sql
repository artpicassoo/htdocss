/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50548
Source Host           : localhost:3306
Source Database       : jubile

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2016-10-01 15:31:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `email`
-- ----------------------------
DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `website_name` varchar(100) NOT NULL,
  `smtp_server` varchar(100) NOT NULL,
  `smtp_port` int(10) NOT NULL,
  `email_login` varchar(150) NOT NULL,
  `email_pass` varchar(100) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `from_email` varchar(150) NOT NULL,
  `transport` varchar(255) NOT NULL,
  `verify_url` varchar(255) NOT NULL,
  `email_act` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of email
-- ----------------------------
INSERT INTO `email` VALUES ('1', 'User Spice', 'mail.userspice.com', '587', 'noreply@userspice.com', 'password', 'Your Name', 'noreply@userspice.com', 'tls', 'http://localhost/us4/', '0');

-- ----------------------------
-- Table structure for `keys`
-- ----------------------------
DROP TABLE IF EXISTS `keys`;
CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stripe_ts` varchar(255) NOT NULL,
  `stripe_tp` varchar(255) NOT NULL,
  `stripe_ls` varchar(255) NOT NULL,
  `stripe_lp` varchar(255) NOT NULL,
  `recap_pub` varchar(100) NOT NULL,
  `recap_pri` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of keys
-- ----------------------------

-- ----------------------------
-- Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(100) NOT NULL,
  `private` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'index.php', '0');
INSERT INTO `pages` VALUES ('2', 'z_us_root.php', '0');
INSERT INTO `pages` VALUES ('3', 'account.php', '1');
INSERT INTO `pages` VALUES ('4', 'admin.php', '1');
INSERT INTO `pages` VALUES ('5', 'admin_page.php', '1');
INSERT INTO `pages` VALUES ('6', 'admin_pages.php', '1');
INSERT INTO `pages` VALUES ('7', 'admin_permission.php', '1');
INSERT INTO `pages` VALUES ('8', 'admin_permissions.php', '1');
INSERT INTO `pages` VALUES ('9', 'admin_user.php', '1');
INSERT INTO `pages` VALUES ('10', 'admin_users.php', '1');
INSERT INTO `pages` VALUES ('11', 'edit_profile.php', '1');
INSERT INTO `pages` VALUES ('12', 'email_settings.php', '1');
INSERT INTO `pages` VALUES ('13', 'email_test.php', '1');
INSERT INTO `pages` VALUES ('14', 'forgot_password.php', '1');
INSERT INTO `pages` VALUES ('15', 'forgot_password_reset.php', '0');
INSERT INTO `pages` VALUES ('16', 'index.php', '0');
INSERT INTO `pages` VALUES ('17', 'init.php', '0');
INSERT INTO `pages` VALUES ('18', 'join.php', '0');
INSERT INTO `pages` VALUES ('19', 'joinThankYou.php', '0');
INSERT INTO `pages` VALUES ('20', 'login.php', '0');
INSERT INTO `pages` VALUES ('21', 'logout.php', '0');
INSERT INTO `pages` VALUES ('22', 'profile.php', '1');
INSERT INTO `pages` VALUES ('23', 'times.php', '0');
INSERT INTO `pages` VALUES ('24', 'user_settings.php', '1');
INSERT INTO `pages` VALUES ('25', 'verify.php', '0');
INSERT INTO `pages` VALUES ('26', 'verify_resend.php', '0');
INSERT INTO `pages` VALUES ('27', 'view_all_users.php', '1');
INSERT INTO `pages` VALUES ('29', 'test.php', '0');
INSERT INTO `pages` VALUES ('30', 'account.php', '0');
INSERT INTO `pages` VALUES ('31', 'admin.php', '0');
INSERT INTO `pages` VALUES ('32', 'admin_page.php', '0');
INSERT INTO `pages` VALUES ('33', 'admin_pages.php', '0');
INSERT INTO `pages` VALUES ('34', 'admin_permission.php', '0');
INSERT INTO `pages` VALUES ('35', 'admin_permissions.php', '0');
INSERT INTO `pages` VALUES ('36', 'admin_user.php', '0');
INSERT INTO `pages` VALUES ('37', 'admin_users.php', '0');
INSERT INTO `pages` VALUES ('38', 'edit_profile.php', '0');
INSERT INTO `pages` VALUES ('39', 'email_settings.php', '0');
INSERT INTO `pages` VALUES ('40', 'email_test.php', '0');
INSERT INTO `pages` VALUES ('41', 'forgot_password.php', '0');
INSERT INTO `pages` VALUES ('42', 'forgot_password_reset.php', '0');
INSERT INTO `pages` VALUES ('43', 'init.php', '0');
INSERT INTO `pages` VALUES ('44', 'join.php', '0');
INSERT INTO `pages` VALUES ('45', 'joinThankYou.php', '0');
INSERT INTO `pages` VALUES ('46', 'login.php', '0');
INSERT INTO `pages` VALUES ('47', 'logout.php', '0');
INSERT INTO `pages` VALUES ('48', 'profile.php', '0');
INSERT INTO `pages` VALUES ('49', 'test.php', '0');
INSERT INTO `pages` VALUES ('50', 'times.php', '0');
INSERT INTO `pages` VALUES ('51', 'user_settings.php', '0');
INSERT INTO `pages` VALUES ('52', 'verify.php', '1');
INSERT INTO `pages` VALUES ('53', 'verify_resend.php', '1');
INSERT INTO `pages` VALUES ('54', 'view_all_users.php', '1');
INSERT INTO `pages` VALUES ('55', 'z_us_root.php', '1');
INSERT INTO `pages` VALUES ('56', 'usersc/empty.php', '1');

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'User');
INSERT INTO `permissions` VALUES ('2', 'Administrator');

-- ----------------------------
-- Table structure for `permission_page_matches`
-- ----------------------------
DROP TABLE IF EXISTS `permission_page_matches`;
CREATE TABLE `permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(15) NOT NULL,
  `page_id` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission_page_matches
-- ----------------------------
INSERT INTO `permission_page_matches` VALUES ('2', '2', '27');
INSERT INTO `permission_page_matches` VALUES ('3', '1', '24');
INSERT INTO `permission_page_matches` VALUES ('4', '1', '22');
INSERT INTO `permission_page_matches` VALUES ('5', '2', '13');
INSERT INTO `permission_page_matches` VALUES ('6', '2', '12');
INSERT INTO `permission_page_matches` VALUES ('7', '1', '11');
INSERT INTO `permission_page_matches` VALUES ('8', '2', '10');
INSERT INTO `permission_page_matches` VALUES ('9', '2', '9');
INSERT INTO `permission_page_matches` VALUES ('10', '2', '8');
INSERT INTO `permission_page_matches` VALUES ('11', '2', '7');
INSERT INTO `permission_page_matches` VALUES ('12', '2', '6');
INSERT INTO `permission_page_matches` VALUES ('13', '2', '5');
INSERT INTO `permission_page_matches` VALUES ('14', '2', '4');
INSERT INTO `permission_page_matches` VALUES ('15', '1', '3');

-- ----------------------------
-- Table structure for `profiles`
-- ----------------------------
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of profiles
-- ----------------------------
INSERT INTO `profiles` VALUES ('1', '1', '<h1>This is the Admin\'s bio</h1>');
INSERT INTO `profiles` VALUES ('2', '2', 'This is your bio');
INSERT INTO `profiles` VALUES ('18', '18', 'This is your bio');
INSERT INTO `profiles` VALUES ('19', '19', 'This is your bio');

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `recaptcha` int(1) NOT NULL DEFAULT '0',
  `force_ssl` int(1) NOT NULL,
  `login_type` varchar(20) NOT NULL,
  `css_sample` int(1) NOT NULL,
  `us_css1` varchar(255) NOT NULL,
  `us_css2` varchar(255) NOT NULL,
  `us_css3` varchar(255) NOT NULL,
  `css1` varchar(255) NOT NULL,
  `css2` varchar(255) NOT NULL,
  `css3` varchar(255) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `language` varchar(255) NOT NULL,
  `track_guest` int(1) NOT NULL,
  `site_offline` int(1) NOT NULL,
  `force_pr` int(1) NOT NULL,
  `reserved1` varchar(100) NOT NULL,
  `reserverd2` varchar(100) NOT NULL,
  `custom1` varchar(100) NOT NULL,
  `custom2` varchar(100) NOT NULL,
  `custom3` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', '0', '0', '', '1', '../users/css/color_schemes/standard.css', '../users/css/sb-admin.css', '../users/css/custom.css', '', '', '', 'UserSpice', 'en', '0', '0', '0', '', '', '', '', '');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(155) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `permissions` int(11) NOT NULL,
  `logins` int(100) NOT NULL,
  `account_owner` tinyint(4) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL DEFAULT '0',
  `company` varchar(255) NOT NULL,
  `stripe_cust_id` varchar(255) NOT NULL,
  `billing_phone` varchar(20) NOT NULL,
  `billing_srt1` varchar(255) NOT NULL,
  `billing_srt2` varchar(255) NOT NULL,
  `billing_city` varchar(255) NOT NULL,
  `billing_state` varchar(255) NOT NULL,
  `billing_zip_code` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `vericode` varchar(15) NOT NULL,
  `title` varchar(100) NOT NULL,
  `active` int(1) NOT NULL,
  `custom1` varchar(255) NOT NULL,
  `custom2` varchar(255) NOT NULL,
  `custom3` varchar(255) NOT NULL,
  `custom4` varchar(255) NOT NULL,
  `custom5` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `EMAIL` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'userspicephp@gmail.com', 'admin', '$2y$12$1v06jm2KMOXuuo3qP7erTuTIJFOnzhpds1Moa8BadnUUeX0RV3ex.', 'Admin', 'Administrator', '1', '13', '1', '0', 'UserSpice', '', '', '', '', '', '', '', '2016-01-01 00:00:00', '2016-10-01 08:29:15', '1', '322418', '', '0', '', '', '', '', '');
INSERT INTO `users` VALUES ('2', 'noreply@userspice.com', 'user', '$2y$12$HZa0/d7evKvuHO8I3U8Ff.pOjJqsGTZqlX8qURratzP./EvWetbkK', 'user', 'user', '1', '0', '1', '0', 'none', '', '', '', '', '', '', '', '2016-01-02 00:00:00', '2016-01-02 00:00:00', '1', '970748', '', '1', '', '', '', '', '');
INSERT INTO `users` VALUES ('19', 'picassoo_2006@yahoo.com', 'razvan', '$2y$12$l5Wf0jQq66mvzmzqIkwbVejmXhqE8LdLBb0a50LmWN1dVIbqSBiui', 'Crasnaru', 'Razvan', '1', '3', '1', '0', 'jubile', '', '', '', '', '', '', '', '2016-10-01 03:34:37', '2016-10-01 03:41:52', '1', '973577', '', '1', '', '', '', '', '');

-- ----------------------------
-- Table structure for `users_online`
-- ----------------------------
DROP TABLE IF EXISTS `users_online`;
CREATE TABLE `users_online` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `user_id` int(10) NOT NULL,
  `session` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_online
-- ----------------------------

-- ----------------------------
-- Table structure for `users_session`
-- ----------------------------
DROP TABLE IF EXISTS `users_session`;
CREATE TABLE `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `uagent` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_session
-- ----------------------------
INSERT INTO `users_session` VALUES ('38', '1', 'e5c284103ce354831561e3b447d1758976c799922d7e20743e9f8c290dfe078f', 'Mozilla (Windows NT 6.1; Win64; x64) AppleWebKit (KHTML, like Gecko) Chrome Safari');

-- ----------------------------
-- Table structure for `user_permission_matches`
-- ----------------------------
DROP TABLE IF EXISTS `user_permission_matches`;
CREATE TABLE `user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_permission_matches
-- ----------------------------
INSERT INTO `user_permission_matches` VALUES ('100', '1', '1');
INSERT INTO `user_permission_matches` VALUES ('101', '1', '2');
INSERT INTO `user_permission_matches` VALUES ('102', '2', '1');
INSERT INTO `user_permission_matches` VALUES ('105', '19', '2');
