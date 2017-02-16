<?php

class Tailored_Helloworld_Model_Helloworld extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('helloworld/helloworld');
    }
}