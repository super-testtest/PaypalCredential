<?php

class Tailored_Goshippo_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{

    public function  __construct()
    {
            parent::__construct();
           $key = Mage::getSingleton('adminhtml/url')->getSecretKey("tailored_goshippo/adminhtml_index/","index");
         $AAurl = Mage::helper('adminhtml')->getUrl('goshippo/adminhtml_index/index/order_id/'.$this->getRequest()->getParam('order_id').'/key/'.$key);

            //$AAurl = Mage::getBaseUrl().'goshippo/adminhtml_index/index/key/c6f0bd47801f06170791676dea29fb9f/';
            $this->addButton('custom_button', array(
            'label'     => Mage::helper('core')->__('Print Shipping Label'),
            // 'onclick'   => "confirmSetLocation('{$message}', '{$this->getUrl('*/custombutton/mycontroller')}')",
            'onclick'   => "javascript:openMyPopup('".$AAurl."')",
            'class'     => 'go'
        ));
    }


}
?>
