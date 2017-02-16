<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('web')};
CREATE TABLE {$this->getTable('web')} (
  `web_id` int(11) unsigned NOT NULL auto_increment,
  `ipaddress` varchar(40) NOT NULL default '',
  `status` varchar(40) NOT NULL default '',

  PRIMARY KEY (`web_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();