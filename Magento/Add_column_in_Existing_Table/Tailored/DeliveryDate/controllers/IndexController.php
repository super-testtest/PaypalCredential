<?php
class Tailored_DeliveryDate_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {    	    		
		$this->loadLayout();     
		$this->renderLayout();
    }
	public function getinputAction()
	{
		$deliverydate = $_REQUEST['deliverydate'];
		$ordercomment=$_REQUEST['ordercomment'];
		Mage::getSingleton('core/session')->setdeliverydateval($deliverydate);
		Mage::getSingleton('core/session')->setordercommentval($ordercomment);
	}
}