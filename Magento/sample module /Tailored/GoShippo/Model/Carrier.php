<?php

class Tailored_GoShippo_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{

    protected $_code = 'tailored_goshippo';
    public function collectRates(
    Mage_Shipping_Model_Rate_Request $request
    )
    {
        $result = Mage::getModel('shipping/rate_result');

        require_once Mage::getModuleDir('controllers', 'Tailored_GoShippo').'/lib/Shippo.php';
        $configValue = Mage::getStoreConfig('goshippo_option/goshippo1/privatetoken');
        Shippo::setApiKey($configValue);

        $address = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress();
        $name = $address->getFirstname().' '.$address->getLastname();
        $mydatas['company'] = $address->getCompany();
        $zip = $address->getPostcode();
        $city = $address->getCity();
         $state = $address->getRegion();
        $street = $address->getStreet();
        $street = $street[0];
        $email=$address->getEmail();
        $phone = $address->getTelephone();
        $mydatas['fax'] = $address->getFax();
        $country = $address->getCountry();



        $heights=Mage::getStoreConfig('goshippo_option/goshippo3/height');
        $widths=Mage::getStoreConfig('goshippo_option/goshippo3/width');
         $lengths=Mage::getStoreConfig('goshippo_option/goshippo3/length');
        //$lengthbelow=Mage::getStoreConfig('goshippo_option/goshippo3/lenghtbelowone');
        $massunit=Mage::getStoreConfig('goshippo_option/goshippo3/massunit');
        $distanceunit=Mage::getStoreConfig('goshippo_option/goshippo3/distanceunit');

        $firstname = Mage::getStoreConfig('goshippo_option/goshippo2/name');

        $fromcity = Mage::getStoreConfig('goshippo_option/goshippo2/city');
        $fromstate = Mage::getStoreConfig('goshippo_option/goshippo2/state');

        $zip1 = Mage::getStoreConfig('goshippo_option/goshippo2/zip');
        $country_id = Mage::getStoreConfig('goshippo_option/goshippo2/country');
        $state1 = Mage::getStoreConfig('goshippo_option/goshippo2/state');
         $street1=Mage::getStoreConfig('goshippo_option/goshippo2/street');

        $phone1 = Mage::getStoreConfig('goshippo_option/goshippo2/phone');
        $email1 = Mage::getStoreConfig('goshippo_option/goshippo2/email');

        $weight=0;
         foreach ($request->getAllItems() as $_item) {
            $weight += $_item->getWeight();
        }

        $height=($heights*$weight)/1;
        $width=($widths*$weight)/1;
        $length=($lengths*$weight)/1;
        $pound=$weight;

        if($pound<1)
            {
                $height=Mage::getStoreConfig('goshippo_option/goshippo3/heightbelowone');
                $width=Mage::getStoreConfig('goshippo_option/goshippo3/widthbelowone');
                $length=Mage::getStoreConfig('goshippo_option/goshippo3/lenghtbelowone');

            }
        $parcel = array(
            'length'=> $length,
            'width'=> $width,
            'height'=>$height,
            'distance_unit'=>$distanceunit ,
            'weight'=> $weight,
            'mass_unit'=> $massunit,
        );

        $fromAddress = array(
            'object_purpose' => 'PURCHASE',
            'name' => $firstname,
            'street1' =>$street1,
            'city' => $fromcity,
            'state' =>$fromstate,
            'zip' => $zip1,
            'country' => $country_id,
            'phone' => $phone1,
            'email' => $email1,
        );

        $toAddress = array(
            'object_purpose' => 'PURCHASE',
            'name' => $name,
            'street1' => $street,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $country,
            'phone' => $phone,
            'email' => $email,
        );

        $shipment = Shippo_Shipment::create( array(
            'object_purpose'=> 'PURCHASE',
            'address_from'=> $fromAddress,
            'address_to'=> $toAddress,
            'parcel'=> $parcel,
            'async'=> false
            )
        );

        $sortedshipment = array();

        foreach ($shipment["rates_list"] as $key => $value1)
        {
            $amount = $value1->amount;

            $provider = $value1->provider;
            $servicename = $value1->servicelevel_name;
            $objectid = $value1->object_id;

            $sortedshipment[$key] = array('amount'=>$value1->amount,'currency'=>$value1->currency,'provider'=>$value1->provider,'servicelevel_name'=>$value1->servicelevel_name,'object_id'=>$value1->object_id);


        }

        usort($sortedshipment, function($a, $b) {
            return $a['amount']  > $b['amount'];
        });

        foreach ($sortedshipment as $key => $value1) {
            $amount = $value1['amount'];
            $objectid = $value1['object_id'];
            $servicename=$value1['provider']. ' - ' . $value1['servicelevel_name'];
            $amount= $amount.'&nbsp;'.$value1['currency'];
            $result->append($this->_getStandardShippingRate($servicename,$amount));
        }

        foreach ($shipment["messages"] as $key => $message)
            {


                   $error = Mage::getModel('shipping/rate_result_error');
                    $error->setCarrier($this->_code);
                    $error->setCarrierTitle($this->getConfigData('title'));
                    $error->setErrorMessage($message->source.': '.$message->text);
                    $result->append($error);


            }






        return $result;
    }

    protected function _getStandardShippingRate($servicename,$amount)
    {


        $rate = Mage::getModel('shipping/rate_result_method');
        /* @var $rate Mage_Shipping_Model_Rate_Result_Method */

        $rate->setCarrier($this->_code);
        /**
         * getConfigData(config_key) returns the configuration value for the
         * carriers/[carrier_code]/[config_key]
         */
        $rate->setCarrierTitle($this->getConfigData('title'));

        $rate->setMethod($servicename);
        $rate->setMethodTitle($servicename);

        $rate->setPrice($amount);
        $rate->setCost(0);


        $msg = "Shipping rate cannot be calculated.";

    $rate->setErrorMessage($msg);
        return $rate;
    }



    public function getAllowedMethods() {
        return array(
            /*'Parcel Select' => 'Parcel Select',
            'Priority Mail' => 'Priority Mail',
            'On-demand' => 'On-demand',
            'Priority Mail Express' => 'Priority Mail Express',*/
        );
    }


}
