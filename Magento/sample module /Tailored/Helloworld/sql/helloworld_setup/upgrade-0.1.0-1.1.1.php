<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn(
        $this->getTable('helloworld'), //table name
        'adderss',      //column name
        'varchar(255) '  //datatype definition
        );
$installer->getConnection()->addColumn(
        $this->getTable('helloworld'), //table name
        'city',      //column name
        'varchar(255) '  //datatype definition
        );
$installer->endSetup();