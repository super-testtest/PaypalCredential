<?php
/*$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('deliverydate')};
CREATE TABLE {$this->getTable('deliverydate')}(
`deliverydate_id` int(11) unsigned NOT NULL auto_increment,
`ordernumber` varchar(255) NULL default '',  
`deliverydate` varchar(255) NULL default '',  
`ordercomment` varchar(255) NULL default '',  
`status` smallint(6) NULL default '1',
`created_time` datetime NULL,
`update_time` datetime NULL,
PRIMARY KEY (`deliverydate_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
");*/
$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE {$this->getTable('catalog_product_entity')}
    ADD COLUMN `itemcomment` VARCHAR(45) NOT NULL;
    ");
$installer->endSetup();