<?php

class Chandan_Comment_Model_Observer extends Varien_Object
{
	 public function commentadd(Varien_Event_Observer $observer) {

		$order = $observer->getEvent()->getOrder();
		$orderid = $order->getIncrementId();
		$customeremail = $order->getCustomerEmail();	
		$orderComment = Mage::getSingleton('core/session')->gettextval();
		$test=Mage::getSingleton('core/session')->gettestval();
		//Mage::log(Mage::getSingleton('core/session'));
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$write->insert(
        "comment", 
        array("ordernumber" => $orderid, "customeremail" => $test, "comment" => $orderComment)
		);	
		/*Mage::getSingleton('core/session')->setnewcomment($orderComment);
		Mage::getSingleton('core/session')->unstextval();*/
    }   
}