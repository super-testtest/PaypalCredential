<?php

class Tailored_Goshippo_Adminhtml_IndexController extends Mage_Adminhtml_Controller_action
{

	public function indexAction()
	{
		$object_id = $this->getRequest()->getParam('object_id');

		if(!empty($object_id)){
			$this->trans();

		}else{
			$this->loadLayout();
			$this->renderLayout();
		}
	}

	public function trans()
	{
			require_once Mage::getModuleDir('controllers', 'Tailored_Goshippo').'/lib/Shippo.php';
			$configValue = Mage::getStoreConfig('goshippo_option/goshippo1/privatetoken');
				Shippo::setApiKey($configValue);
			 $object_id = $this->getRequest()->getParam('object_id');

			// Purchase the desired rate.
			$transaction = Shippo_Transaction::create( array(
			    'rate' => $object_id,
			    'label_file_type' => "PDF",
			    'async' => false ) );
///print '<pre>'; print_r($transaction);exit;
			// Retrieve label url and tracking number or error message
			if ($transaction["object_status"] == "SUCCESS")
			{

				echo  $transaction["object_status"].'!@#'.$transaction["tracking_number"].'!@#'.$transaction["tracking_url_provider"].'!@#'.$transaction["label_url"] ;
			}
			else
			{
			    print_r('FALSE!@#'.$transaction["messages"] [0]->text );
			}
		exit();

	}

}


