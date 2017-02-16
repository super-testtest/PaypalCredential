<?php
class Tailored_Goshippo_Block_Adminhtml_Go extends Mage_Core_Block_Template
{
 	public function index()
	{
		$orderkey = $this->getRequest()->getParam('key');

		?>
		<script type="text/javascript">
		var baseUrl = '<?php echo Mage::getUrl('');?>'
		var urlKey='<?php echo $orderkey;?>'

		function firstlabelajax(orderid, objectid,key)
			{
				$( '.goshipposervice'+key+' .firstlabelbtn' ).html('Loading...');
					$( '.errormsg' ).hide();

				jQuery.ajax({
				        type: "GET",
				        url: baseUrl + 'goshippo/adminhtml_index/index/order_id/'+orderid + '/object_id/' + objectid +'/key/'+urlKey,
				        success: function(response) {
				        	$( '.goshipposervice'+key+' .firstlabelbtn' ).html('Shipping Label');
				            // console.log(response);

				            var divs = response.split('!@#');
				           // console.log(divs);
						    if (divs[0] == 'SUCCESS'){
								//$( '.goshipposervice+key+ #msg' ).text( divs[0] );
								//$( '.goshipposervice+key+ #id' ).text( divs[1] );
								//console.log('.goshipposervice'+key+' .labelurl');
								$( '.goshipposervice'+key+' .labelurl' ).show().attr('href', divs[3] );

				            }
				            else{
				            	$( '.goshipposervice'+key+' .errormsg' ).show().text( divs[1] );
				            }

				        },
				        error: function(response) {
				            // console.log(response);
				            var divs = response.split('!@#');
				            $( '.goshipposervice'+key+' .errormsg' ).show().text( divs[1] );
				        }
				});


			}

			function returnlabelajax(orderid, objectid, key)
			{
				$( '.goshipposervice'+key+' .returnlabelbtn' ).html('Loading...');
				$( '.errormsg' ).hide();
		// console.log(orderid, objectid);
				jQuery.ajax({
				        type: "GET",

				        url: baseUrl + 'goshippo/adminhtml_index/index/order_id/'+orderid + '/object_id/' + objectid+'/key/'+urlKey,
				        success: function(response) {
				        		$( '.goshipposervice'+key+' .returnlabelbtn' ).html('Return Label');
				            // console.log(response);
				            var divs = response.split('!@#');
				            //console.log(divs);
				            //console.log('arjun');
				            if (divs[0] == 'SUCCESS'){
								//$( '#msg' ).text( divs[0] );
								//$( '#id' ).text( divs[1] );
								$( '.goshipposervice'+key+' .returnlabelurl' ).show().attr('href', divs[3] );
				            }
				            else{
				            	$( '.goshipposervice'+key+' .errormsg' ).show().text( divs[1] );
				            }

				        },
				        error: function(response) {
				            // console.log(response);
				            var divs = response.split('!@#');
				            $( '.goshipposervice'+key+' .errormsg' ).show().text( divs[1] );
				        }
					});

			}
		</script>
		<?php

				$orderid = '"' . $this->getRequest()->getParam('order_id') . '"';


				$orderid = $this->getRequest()->getParam('order_id');
				 $order = Mage::getModel('sales/order')->load($orderid);


				$billingAddress = $order->getBillingAddress();
				$shippingAddress = $order->getShippingAddress();

				$firstname = Mage::getStoreConfig('goshippo_option/goshippo2/name');

				// $street = $billingAddress->getData('street');
				$city = Mage::getStoreConfig('goshippo_option/goshippo2/city');
				$state1 = Mage::getStoreConfig('goshippo_option/goshippo2/state');
				// $region = Mage::getModel('directory/region')->load($state);
				// $state_code = $region->getCode();
				$postcode = Mage::getStoreConfig('goshippo_option/goshippo2/zip');
				$country_id = Mage::getStoreConfig('goshippo_option/goshippo2/country');

				// $countryName = $countryModel->getName();
				$phone = Mage::getStoreConfig('goshippo_option/goshippo2/phone');
				$email = Mage::getStoreConfig('goshippo_option/goshippo2/email');

				$shipfirstname = $shippingAddress->getData('firstname');
				$shipstreet = $shippingAddress->getData('street');
				$shipcity = $shippingAddress->getData('city');
				$shipstate = $shippingAddress->getData('region_id');
				$shipregion = Mage::getModel('directory/region')->load($shipstate);
				$shipstate_code = $shipregion->getCode();
				$shippostcode = $shippingAddress->getData('postcode');
				$countryModel = Mage::getModel('directory/country')->loadByCode($country_id);
				$shipcountry_id = $shippingAddress->getData('country_id');
				$shipcountryModel = Mage::getModel('directory/country')->loadByCode($country_id);
				$shipcountryName = $countryModel->getName();
				$shipphone = $shippingAddress->getData('telephone');
				$shipemail = $shippingAddress->getData('email');

			    $street=Mage::getStoreConfig('goshippo_option/goshippo2/street');
				$heights=Mage::getStoreConfig('goshippo_option/goshippo3/height');
				$widths=Mage::getStoreConfig('goshippo_option/goshippo3/width');
				 $lengths=Mage::getStoreConfig('goshippo_option/goshippo3/length');
				//$lengthbelow=Mage::getStoreConfig('goshippo_option/goshippo3/lenghtbelowone');
				$massunit=Mage::getStoreConfig('goshippo_option/goshippo3/massunit');
				$distanceunit=Mage::getStoreConfig('goshippo_option/goshippo3/distanceunit');
				$weight=$order->getWeight();



				//echo $width;exit;
				//require_once 'lib/Shippo.php';
				require_once Mage::getModuleDir('controllers', 'Tailored_Goshippo').'/lib/Shippo.php';
				$configValue = Mage::getStoreConfig('goshippo_option/goshippo1/privatetoken');
				Shippo::setApiKey($configValue);


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
					    'street1' => $street,
					    'city' => $city,
					    'state' => $state1,
					    'zip' => $postcode,
					    'country' => $country_id,
					    'phone' => $phone,
					    'email' => $email
					);


				$toAddress = array(
					    'object_purpose' => 'PURCHASE',
					    'name' => $shipfirstname,
					    'street1' => $shipstreet,
					    'city' => $shipcity,
					    'state' => $shipregion->getName(),
					    'zip' => $shippostcode,
					    'country' => $shipcountry_id,
					    'phone' => $shipphone,
					   'email' => $shipemail
					);

			try
        	{
                $shipment = Shippo_Shipment::create( array(
                    'object_purpose'=> 'PURCHASE',
                    'address_from'=> $fromAddress,
                    'address_to'=> $toAddress,
                    'parcel'=> $parcel,
                    'async'=> false
                    )
                );
          	}
	       catch(Exception $e)
	        {
	        		echo $e->getMessage();exit;


	        }

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


			  $str=$order->getShippingMethod();
			  $selectedshippingmethod=substr($str,18);



		$findme   = 'tailored';
		$pos = strpos($str, $findme);
		$othershipingmethod='false';
		// Note our use of ===.  Simply == would not work as expected
		// because the position of 'a' was the 0th (first) character.
		if ($pos === false)
		{
		   $othershipingmethod='true';
		}

			foreach ($sortedshipment as $key => $value1)
			{

					$amount = $value1['amount'];

					$objectid = $value1['object_id'];


						$servicename=$value1['provider']. ' - ' . $value1['servicelevel_name'];

							echo '<form  method="post" class="fieldset-wide goshipposervice'.$key.'"><table class="form-list"><tr><td colspan="2"><div class="errormsg" style="color:red;"></div></td></tr><tr><td>'.$value1['provider']. ' - ' . $value1['servicelevel_name'].', price: '.$amount.'&nbsp;'.$value1['currency'].'</td><td align="right">';
						if(($selectedshippingmethod==$servicename)||($othershipingmethod==='true'))
						{
							echo '<button class="scalable go firstlabelbtn"  type="button" name="insert" onclick="firstlabelajax(\''.$orderid.'\',\''.$objectid.'\',\''.$key.'\');" translate="label">Shipping Label</button>&nbsp;<a class="form-button labelurl" href="" target="_blank"  style="display:none;text-decoration:none;"  >Download</a>';
						}
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button  type="button" class="returnlabelbtn scalable go" name="select" onclick="returnlabelajax(\''.$orderid.'\',\''.$objectid.'\',\''.$key.'\');" >Return Label</button>&nbsp;<a class="returnlabelurl form-button"  href="" target="_blank" style="display:none;text-decoration:none;" >Download</a></td></tr></table></form>';

			}

			foreach ($shipment["messages"] as $key => $message)
			{

				echo $message->source.': '.$message->text;
				echo '<br>';
			}

			function sortByOrder($a, $b)
			{

					echo "Arf";
					print_r($a['amount']);
					print_r($b['amount']);
					exit();
		    	return $a['amount'] - $b['amount'];
			}

	}

}
