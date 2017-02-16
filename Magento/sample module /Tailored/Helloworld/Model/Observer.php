<?php
class Tailored_Helloworld_Model_Observer
{
    public function my_event_name()
     {

     		//Mage::app()->getRequest()->getParams('showServer');
     		/* $s = $_GET['showServer'];
     		if($s){
				print_r($_SERVER);
     		}*/

     			  $products = Mage::getModel('catalog/product');

    // loop through products, update the product name and save the product
			    foreach ($products as $product) {
			        $product->setName('test');
			        $product->save();
			    }
			    Mage::log($product);
    }
}

?>