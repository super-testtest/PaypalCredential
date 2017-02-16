<?php
class Tailored_GoShippo_IndexController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{

		?>
		<style type="text/css">
		body{   color: #2f2f2f;
    font: 12px/1.5em Arial,Helvetica,sans-serif;}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <link rel="stylesheet" type="text/css" href="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);?>adminhtml/default/default/boxes.css" media="all
 " />



<script type="text/javascript">
var baseUrl = '<?php echo Mage::getUrl('');?>'

function firstlabelajax(orderid, objectid,key)
	{
		$( '.goshipposervice'+key+' .firstlabelbtn' ).html('Loading...');
			$( '.errormsg' ).hide();
// console.log(orderid, objectid);
jQuery.ajax({
        type: "POST",
        url: baseUrl + 'goshippo/index/trans/order_id/'+orderid + '/object_id/' + objectid,
        success: function(response) {
        	$( '.goshipposervice'+key+' .firstlabelbtn' ).html('Shipping Label');
            // console.log(response);
            var divs = response.split('!@#');
            //console.log(divs);
		    if (divs[0] == '\nSUCCESS'){
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
        type: "POST",
        url: baseUrl + 'goshippo/index/trans/order_id/'+orderid + '/object_id/' + objectid,
        success: function(response) {
        		$( '.goshipposervice'+key+' .returnlabelbtn' ).html('Return Label');
            // console.log(response);
            var divs = response.split('!@#');
            //console.log(divs);
            //console.log('arjun');
            if (divs[0] == '\nSUCCESS'){
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
		require_once 'lib/Shippo.php';
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
			    'state' => $shipstate_code,
			    'zip' => $shippostcode,
			    'country' => $shipcountry_id,
			    'phone' => $shipphone,
			    'email' => $shipemail
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


	foreach ($shipment["rates_list"] as $key => $value1) {



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
					echo '<button class="scalable go firstlabelbtn"  type="button" name="insert" onclick="firstlabelajax(\''.$orderid.'\',\''.$objectid.'\',\''.$key.'\');" translate="label">Shipping Label</button>&nbsp;<a class="form-button labelurl" href="" target=_parent"  style="display:none;text-decoration:none;"  >Download</a>';
				}
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button  type="button" class="returnlabelbtn scalable go" name="select" onclick="returnlabelajax(\''.$orderid.'\',\''.$objectid.'\',\''.$key.'\');" >Return Label</button>&nbsp;<a class="returnlabelurl form-button"  href="" target="_parent" style="display:none;text-decoration:none;" >Download</a></td></tr></table></form>';

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


	public function transAction()
	{
			require_once 'app/code/local/Tailored/GoShippo/controllers/lib/Shippo.php';
			Shippo::setApiKey("2783e6f5c372d5b083496deb6a5d8529e474ce39");
			$object_id = $this->getRequest()->getParam('object_id');
			// Purchase the desired rate.
			$transaction = Shippo_Transaction::create( array(
			    'rate' => $object_id,
			    'label_file_type' => "PDF",
			    'async' => false ) );
///print '<pre>'; print_r($transaction);exit;
			// Retrieve label url and tracking number or error message
			if ($transaction["object_status"] == "SUCCESS"){

				echo  $transaction["object_status"].'!@#'.$transaction["tracking_number"].'!@#'.$transaction["tracking_url_provider"].'!@#'.$transaction["label_url"] ;

			$resource     = Mage::getSingleton('core/resource');
			$writeAdapter   = $resource->getConnection('core_write');
			$status = $transaction['object_status'];
			$url = $transaction['label_url'];
			$trackid = $transaction['tracking_number'];
			// $table        = $resource->getTableName('tailored_data');
			// $query        = "INSERT INTO {$table} ("status","url") VALUES ('$transaction['object_status']','$transaction['label_url']');";
			$query = "insert into tailored_data (status, url, trackid) values('$status','$url','$trackid')";
			// INSERT INTO 'tailored_data' VALUES (1,'My New Title','This is a blog post','2009-07-01 00:00:00','2009-07-02 23:12:30');


			$writeAdapter->query($query);

			}else {

			    print_r('FALSE!@#'.$transaction["messages"] [0]->text );
			}
exit();



	}

}
?>

