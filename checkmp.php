<?php
  $con = mysqli_connect('localhost', 'musketeers_admissions', 'pSW5Ejp5M8VPYTm', 'musketeers_admissions');
  $phone = $_POST['phone'];
 
    $b =  substr($phone, -9);
    $a = 254;
    $c = $a.$b;
     $query = "select count(*) as cntUser from wnpasem where status =0 and (PhoneNumber ='$c' OR TransactionDate ='$c')";

   $result = mysqli_query($con,$query);
   $response = "1";
   if(mysqli_num_rows($result)){
      $row = mysqli_fetch_array($result);

      $count = $row['cntUser'];
    
      if($count > 0){
          $response= "1";
      }
      else{
            $response= "0";
      }
   
   }

   echo $response;
   die;
 