<?php




$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('helloworld')};
CREATE TABLE {$this->getTable('helloworld')} (
  `hid` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',


  PRIMARY KEY (`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();