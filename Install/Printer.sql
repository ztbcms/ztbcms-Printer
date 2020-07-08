-- Create syntax for TABLE 'bm_printer_feie_app'
CREATE TABLE `cms_printer_feie_app` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(128) NOT NULL DEFAULT '' COMMENT '飞鹅注册账号用户名',
  `ukey` varchar(128) NOT NULL DEFAULT '' COMMENT '飞鹅注册的用户key',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `is_default` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'bm_printer_feie_msg'
CREATE TABLE `cms_printer_feie_msg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(128) NOT NULL DEFAULT '' COMMENT '打印机编号',
  `content` text NOT NULL COMMENT '打印内容',
  `times` int(11) NOT NULL COMMENT '打印次数',
  `return_data` varchar(512) DEFAULT '' COMMENT '打印结果返回数据',
  `orderid` varchar(128) DEFAULT NULL COMMENT '打印成功返回订单',
  `status` tinyint(2) DEFAULT '0' COMMENT '1已经打印，0未打印',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'bm_printer_feie_object'
CREATE TABLE `cms_printer_feie_object` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `remark` varchar(64) NOT NULL DEFAULT '' COMMENT '打印机备注',
  `sn` varchar(128) NOT NULL DEFAULT '' COMMENT '打印机编号',
  `key` varchar(128) NOT NULL DEFAULT '' COMMENT '打印机key',
  `status_msg` varchar(128) DEFAULT '' COMMENT '打印机状态信息',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;