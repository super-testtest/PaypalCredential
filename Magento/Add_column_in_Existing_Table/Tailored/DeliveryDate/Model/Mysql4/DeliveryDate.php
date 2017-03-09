<?php
class Tailored_DeliveryDate_Model_Mysql4_DeliveryDate extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('deliverydate/deliverydate','deliverydate_id');
    }
}