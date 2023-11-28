
  <?php  

    date_default_timezone_set('Africa/Nairobi');
 	$timestamp = date('YmdHis');
	$code = '4096183';  // short code
	$passkey = 'd82fc51ccafb898d66f638729ea2cf08410b335900d0946959d5c6fd7af7b9fd';  // pass key
	$password = base64_encode($code.$passkey.$timestamp);
    $mobile = $_POST['phone'];
    $amount = $_POST['amount'];
	$a = 254;
    $b =  substr($mobile, -9);
    $c = $a.$b;
     //$c = 254715805406;
     $str2 = substr($amount, 3); //remove KES
    $str3 = str_replace(',', '', $str2); // Replaces all spaces with hyphens.
  //  $str4=round($str3, 0);
    $str4=200;
//	$phone = ''; // safaricom number - must start with 254
	$reference = 'MIST';  // can be user account identifier - will appear in stkpush prompt

   //generate access token
        $consumer_key="lA9YebiC8nMoIkrI3tvXqk0aMSKy0A1y";
        $consumer_secret="IzQWI1fLaY65tIaS";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
       // $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        $token=$access_token->access_token;
    	$accessToken = "Bearer ".$token; 
       // print_r($token);  // display callback response

	$postData = array(
		'BusinessShortCode' => $code,
		'Password' => $password,
		'Timestamp' => $timestamp,
		'TransactionType' => 'CustomerPayBillOnline',
		'Amount' => $str4,
		'PartyA' => $c,  // The phone number sending money. 2547... - should be same as phone number to receive stk push prompt
		'PartyB' => $code,
		'PhoneNumber' => $c,  // The Mobile Number to receive the STK Pin Prompt. 2547..  NB: callback comes with this number
		'CallBackURL' => 'http://admissions.mist.ac.ke/confirmpayment.php/',  // should not be the C2B callback, response
        'AccountReference' => $reference,
		'TransactionDesc' => 'Registration'
	);    
	$data_string = json_encode($postData);
 	$url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';  // live
   // $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';  // test
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:'.$accessToken)); //setting custom header
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $response = curl_exec($curl);
	$response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);   // response status code
	$decodedresponse = json_decode($response);
	curl_close($curl);
	print_r($response);  // display callback response
 
    

  	?>
