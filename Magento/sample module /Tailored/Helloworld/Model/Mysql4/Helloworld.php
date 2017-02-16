<?php

class Tailored_Helloworld_Model_Mysql4_Helloworld extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the web_id refers to the key field in your database table.
        $this->_init('helloworld/helloworld', 'hid');
    }
}