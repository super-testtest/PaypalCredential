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
		// Mage::app()->getLayout()->getBlock('head')->addJs('prototype/prototype.js');
		 // $this->getLayout()->getBlock('head')->addJs('prototype/prototype.js');


		$orderid = '"' . $this->getRequest()->getParam('order_id') . '"';


	// $array = array(
	// 	'firstname'=>$firstname,
	// 	'street'=>$street
	// 	);
	// $newarray = serialize($array);
	// $encodedvalue = base64_encode($newarray);
	// echo "<pre>";
	// print_r($billingAddress->getData());
	// print_r($shippingAddress->getData());

	//print_r($items);


// $uri = 'https://api.goshippo.com/v1/carrier_accounts/';
// $ch = curl_init($uri);
// curl_setopt_array($ch, array(
//     CURLOPT_HTTPHEADER  => array("Authorization: ShippoToken 2783e6f5c372d5b083496deb6a5d8529e474ce39"),
//     CURLOPT_RETURNTRANSFER  =>true,
//     CURLOPT_VERBOSE     => 1
// ));
// $out = curl_exec($ch);
// $servicename =  json_decode($out);
// curl_close($ch);
// echo "string";
		$orderid = $this->getRequest()->getParam('order_id');
		$order = Mage::getModel('sales/order')->load($orderid);
		$billingAddress = $order->getBillingAddress();
		$shippingAddress = $order->getShippingAddress();
		// echo "<pre>";
		// print_r($billingAddress->getData('region_id'));
		// echo "</pre>";
		// exit();

		// $configValue = Mage::getStoreConfig('goshippo_option/goshippo2/name');

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

		require_once 'lib/Shippo.php';
		$configValue = Mage::getStoreConfig('goshippo_option/goshippo1/privatetoken');
		Shippo::setApiKey($configValue);

		if ($state = 'US' && $state = 'CA') {
			$fromAddress = array(
		    'object_purpose' => 'PURCHASE',
		    'name' => $firstname,
		    'street1' => 'Broadway 1',
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

		$parcel = array(
		    'length'=> '5',
		    'width'=> '5',
		    'height'=> '5',
		    'distance_unit'=> 'in',
		    'weight'=> '2',
		    'mass_unit'=> 'lb',
		);

		$shipment = Shippo_Shipment::create( array(
		    'object_purpose'=> 'PURCHASE',
		    'address_from'=> $fromAddress,
		    'address_to'=> $toAddress,
		    'parcel'=> $parcel,
		    'async'=> false
		    )
		);
		}
		else
		{
			$fromAddress = array(
		    'object_purpose' => 'PURCHASE',
		    'name' => $firstname,
		    'street1' => $street,
		    'city' => $city,
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
		    'zip' => $shippostcode,
		    'country' => $shipcountry_id,
		    'phone' => $shipphone,
		    'email' => $shipemail
		);

		$parcel = array(
		    'length'=> '5',
		    'width'=> '5',
		    'height'=> '5',
		    'distance_unit'=> 'in',
		    'weight'=> '2',
		    'mass_unit'=> 'lb',
		);

		$shipment = Shippo_Shipment::create( array(
		    'object_purpose'=> 'PURCHASE',
		    'address_from'=> $fromAddress,
		    'address_to'=> $toAddress,
		    'parcel'=> $parcel,
		    'async'=> false
		    )
		);
		}


$sortedshipment = array();

foreach ($shipment["rates_list"] as $key => $value1) {


			// echo "<pre>";
			$amount = $value1->amount;

			$provider = $value1->provider;
			$servicename = $value1->servicelevel_name;
			$objectid = $value1->object_id;

$sortedshipment[$key] = array('amount'=>$value1->amount,'currency'=>$value1->currency,'provider'=>$value1->provider,'servicelevel_name'=>$value1->servicelevel_name,'object_id'=>$value1->object_id);
			// print_r($objectid);

}
	//  echo "<pre>"; print_r($shipment["rates_list"]);exit;

usort($sortedshipment, function($a, $b) {
    return $a['amount']  - $b['amount'];
});

		 // echo "<pre>";
		 // print_r($shipment["rates_list"]);
		 // echo "</pre>";



		// exit();

// echo "<pre>";
// print_r($servicename);
// echo "</pre>";
// exit();
// echo response output
// echo "<pre>";
// print_r($servicename);

// for ($i = 0; $i < count($shipment["rates_list"]); $i++)
// {
// 	for ($j = $i+1; $i < count($shipment["rates_list"]); $i++)
// 	{
// 		echo "<pre>shipment[rates_list][i]->amount = ";
// 		print_r($shipment["rates_list"][$i]->amount);
// 		echo "</pre><hr>";
// 		echo "<pre>shipment[rates_list][j]->amount = ";
// 		print_r($shipment["rates_list"][$j]->amount);
// 		echo "</pre><hr>";

// 		/*if ($i > $j) {
// 			array_push($i, $array);
// 		}*/
// 	}
// }

// usort($shipment["rates_list"], 'sortByOrder');
// echo "<pre>";
// print_r($shipment["rates_list"]);
// echo "</pre>";
// exit();
// $array = array();

// for ($i = 0; $i < count($shipment["rates_list"]); $i++)
// {
// 	for ($j = $i+1; $i < count($shipment["rates_list"]); $i++)
// 	{
// 		echo "<pre>shipment[rates_list][i]->amount = ";
// 		print_r($shipment["rates_list"][$i]->amount);
// 		echo "</pre><hr>";
// 		echo "<pre>shipment[rates_list][j]->amount = ";
// 		print_r($shipment["rates_list"][$j]->amount);
// 		echo "</pre><hr>";

// 		/*if ($i > $j) {
// 			array_push($i, $array);
// 		}*/
// 	}
// }
// exit();

foreach ($sortedshipment as $key => $value1) {


			// echo "<pre>";
			$amount = $value1['amount'];
			// $amount1 = $amount;
			// if($amount1 > $amount)
			// {
			// 	echo "1". $amount1;
			// 	exit();
			// }
			// else
			// {
			// 		echo "2";
			// }
			$objectid = $value1['object_id'];
			// print_r($objectid);



echo '<form  method="post" class="fieldset-wide goshipposervice'.$key.'"><table class="form-list"><tr><td colspan="2">
<div class="errormsg" style="color:red;"></div></td></tr><tr>
<td>'.$value1['provider']. ' - ' . $value1['servicelevel_name'].', price: '.$amount.'&nbsp;'.$value1['currency'].'</td><td align="right">
			<button class="scalable go firstlabelbtn"  type="button" name="insert" onclick="firstlabelajax(\''.$orderid.'\',\''.$objectid.'\',\''.$key.'\');" translate="label">Shipping Label</button>&nbsp;<a class="form-button labelurl" href="" target=_parent"  style="display:none;text-decoration:none;"  >Download</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button  type="button" class="returnlabelbtn scalable go" name="select" onclick="returnlabelajax(\''.$orderid.'\',\''.$objectid.'\',\''.$key.'\');" >Return Label</button>&nbsp;<a class="returnlabelurl form-button"  herf="" target="_parent" style="display:none;text-decoration:none;" >Download</a></td>

			</tr></table></form>'
			;

			/*echo "<form  method='post'><div style='height:40px;'><div>".$value1->carrier."</div><div style='float:right;'>
			<button class='scalable go' style='background: #ffac47 url('images/btn_bg.gif') repeat-x scroll 0 100%;border-color: #ed6502 #a04300 #a04300 #ed6502;border-style: solid;border-width: 1px;color: #fff;    cursor: pointer;font: bold 12px arial,helvetica,sans-serif;padding: 1px 7px 2px;text-align: center !important;white-space: nowrap;' onclick='function1(".$orderid.",".$objectid.");' type='button' name='insert'>Shipping Label</button>
			<button style='background: #ffac47 url('images/btn_bg.gif') repeat-x scroll 0 100%;border-color: #ed6502 #a04300 #a04300 #ed6502;border-style: solid;border-width: 1px;color: #fff;    cursor: pointer;font: bold 12px arial,helvetica,sans-serif;padding: 1px 7px 2px;text-align: center !important;white-space: nowrap;' type='button' class='scalable go' name='select' >Return Label</button></div></div></form>";
			echo "<hr>";*/


}
		function sortByOrder($a, $b) {
			echo "Arf";
			print_r($a['amount']);
			print_r($b['amount']);
			exit();
    return $a['amount'] - $b['amount'];
}




// if(isset($_POST['insert'])){
//     $message= "The insert function is called.";
//     $uri = 'https://www.google.co.in/?gfe_rd=cr&ei=W1jZV9rLK6jT8ge3wZPoBA&gws_rd=ssl';
// 	$ch = curl_init($uri);
// 	curl_setopt_array($ch, array(
//     CURLOPT_HTTPHEADER  => array("Authorization: ShippoToken 51636984e4d22218a1e42b311b5b3943a0900b7f"),
//     CURLOPT_RETURNTRANSFER  =>true,
//     CURLOPT_VERBOSE     => 1
// ));
// $out = curl_exec($ch);
// $servicename =  json_decode($out);
// curl_close($ch);

//     }
//     if(isset($_POST['select'])){
//       $message="The select function is called.";
//     }


            // $ch = curl_init();
            // // $data = array("username" => $username, "password" => $password);
            // // $data_string = json_encode($data);
            // $ch = curl_init('https://api.goshippo.com/v1/carrier_accounts/');
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            // // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //     'Content-Type: application/json',
            //     'Content-Length: ' . strlen($data_string))
            // );
            // $token = curl_exec($ch);


            // $headers = array("Authorization: ShippoToken 2783e6f5c372d5b083496deb6a5d8529e474ce39","Content-Type: application/json");

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



			}else {

			    print_r('FALSE!@#'.$transaction["messages"] [0]->text );
			}
exit();



		// $rate = $shipment["rates_list"][0];

		// // Purchase the desired rate.
		// $transaction = Shippo_Transaction::create( array(
		//     'rate' => $rate["object_id"],
		//     'label_file_type' => "PDF",
		//     'async' => false ) );
		// echo "<pre>";
		// print_r($transaction);
		// echo "</pre>";
		// exit();

		// // Retrieve label url and tracking number or error message
		// if ($transaction["object_status"] == "SUCCESS"){
		//     echo( $transaction["label_url"] );
		//     echo("\n");
		//     echo( $transaction["tracking_number"] );
		// }else {
		// 	echo "<pre>";
		//     print_r( $transaction["messages"] );
		// }
		// 		echo "<pre>";
		// print_r($shipment);
		// echo "</pre>";
		// exit();

		// $ch = curl_init();
  //           $data = array("username" => $username, "password" => $password);
  //           $data_string = json_encode($data);
  //           $ch = curl_init('https://api.goshippo.com/v1/carrier_accounts/');
  //           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  //           curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  //           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //           curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  //               'Content-Type: application/json',
  //               'Content-Length: ' . strlen($data_string))
  //           );
  //           $token = curl_exec($ch);
		// $uri = 'https://api.goshippo.com/v1/shipments/';
		// $ch = curl_init($uri);
		// curl_setopt_array($ch, array(
		//     CURLOPT_HTTPHEADER  => array("Authorization: ShippoToken 2783e6f5c372d5b083496deb6a5d8529e474ce39"),
		//     CURLOPT_RETURNTRANSFER  =>true,
		//     CURLOPT_VERBOSE     => 1
		// ));
		// $out = curl_exec($ch);
		// $servicename =  json_decode($out);
		// curl_close($ch);
		// echo $out;
	}

}
?>

