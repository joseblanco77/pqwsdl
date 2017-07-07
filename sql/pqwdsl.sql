CREATE TABLE IF NOT EXISTS `pqwsdl` (
  `id_wsdl` int(11) unsigned NOT NULL auto_increment,
  `id_stock` int(11) unsigned NOT NULL default 0,
  `response` text NOT NULL default '',
  `status` varchar(5) NOT NULL default '',
  `params` text NOT NULL default '',
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id_wsdl`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
