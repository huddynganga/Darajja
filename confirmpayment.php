<?php
    
 
$servername = "localhost";
$username = "musketeers_admissions";
$password = "pSW5Ejp5M8VPYTm";
$dbname = "musketeers_admissions";
 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

  try
	{
		//Set the response content type to application/json
		header("Content-Type:application/json");
		$resp = '{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}';
		//read incoming request
		$postData = file_get_contents('php://input');
		//log file
		$filePath = "payment-messages.log";
		//error log
		$errorLog = "payment-errors.log";
		//Parse payload to json
		$jdata = json_decode($postData,true);
		//perform business operations on $jdata here
		//open text file for logging messages by appending
		$file = fopen($filePath,"a");
		//log incoming request
		fwrite($file, $postData);
		fwrite($file,"\r\n");
		//log response and close file
		fwrite($file,$resp);
	
		// process transaction

$callbackData = json_decode($postData);
$amountsent= $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value; 
$mreceiptno= $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$tdate= $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value; 
$pnumber= $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value; 
$merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
$checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;
$resultCode=$callbackData->Body->stkCallback->ResultCode;

 		$sql="INSERT INTO wnpasem (Amount,MpesaReceiptNumber,TransactionDate,PhoneNumber,merchantRequestID,checkoutRequestID,resultCode) VALUES ('$amountsent','$mreceiptno','$tdate','$pnumber','$merchantRequestID','$checkoutRequestID','$resultCode')";
         	
			if ($conn->query($sql) === TRUE) {
		            echo $resp;
	            } 
	
            else {
    	            echo "Error: " . $sql . "<br>" . $conn->error;
    	        }
	

		
			fclose($file);
}
	catch (Exception $ex)
	{
		//append exception to errorLog
		$logErr = fopen($errorLog,"a");
		fwrite($logErr, $ex->getMessage());
		fwrite($logErr,"\r\n");
		fclose($logErr);
	}
    //echo response
 //   echo $resp;
    $conn->close();
    
    ?>