<?php

class Tailored_GoShippo_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{

    public function  __construct() {

        parent::__construct();
         $AAurl = Mage::getBaseUrl().'goshippo/index/index/order_id/'.$this->getRequest()->getParam('order_id');
        $this->addButton('custom_button', array(
        'label'     => Mage::helper('core')->__('Print Shipping Label'),
        // 'onclick'   => "confirmSetLocation('{$message}', '{$this->getUrl('*/custombutton/mycontroller')}')",
        'onclick'   => "javascript:openMyPopup('".$AAurl."')",
        'class'     => 'go'
    ));
    }

     protected function _prepareLayout()
    {

		$head = $this->getLayout()->getBlock('head');
        $head->addJs('goshippo.js');
        $head->addJs('prototype/prototype.js');
        $head->addCss('lib/prototype/windows/themes/magento.css');

        $head->addItem('js_css','prototype/windows/themes/default.css');
        return parent::_prepareLayout();
    }
}
?>
