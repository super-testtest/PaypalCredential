<?php

class Tailored_DeliveryDate_Model_Observer extends Varien_Object
{
	 public function deliverydate(Varien_Event_Observer $observer) {

		$order = $observer->getEvent()->getOrder();
		$orderid = $order->getIncrementId();
		
		$customeremail = $order->getCustomerEmail();
		//$createddate=Mage::getModel('core/date')->date('Y-m-d H:i:s');	
		$deliverydate = Mage::getSingleton('core/session')->getdeliverydateval();
		$ordercomment=Mage::getSingleton('core/session')->getordercommentval();
		$data=array('ordernumber'=>$orderid,'deliverydate'=>$deliverydate,'ordercomment'=>$ordercomments);
		//Mage::log(Mage::getSingleton('core/session'));
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$write->insert(
        "deliverydate", 
        $data
		);
		//Mage::getSingleton('core/session')->unstextval();
    }   
}

