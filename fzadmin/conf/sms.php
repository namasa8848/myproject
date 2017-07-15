<?php

if( $nop['paymenttype'] == "COD" ) { $ptype = "COD"; } else { $ptype = "OP"; }

$smstext = "Order ID: ".$orderId."\n";
$smstext .= $nop['name']." ".$nop['mobilphone']."\n";
$smstext .= "Type: ".$nop['order_type']."\n";
$smstext .= "Order:".$nop['smsorderdetails']."\n";
$smstext .= "Address: ".$nop['address']."\n";
$smstext .= "Payment: ".$ptype."\n";
$smstext .= "Total: ".setprice( $nop['order_total'] );

$ID = "somil.khicha2792@gmail.com";
$Pwd = "8546";

if ( $mobilphone2 == "" )
{ $PhNo = $mobilphone; }
else
{ $PhNo = $mobilphone . "," . $mobilphone2; }


//echo $smstext;
$Text = urlencode($smstext);
$srvc_name = urlencode("TEMPLATE_BASED");
$sender_id = "FZONED";

//Invoke HTTP Submit url
$url = "http://smsapi.24x7sms.com/api_1.0/SendSMS.aspx?EmailID=$ID&Password=$Pwd&MobileNo=$PhNo&SenderID=$sender_id&Message=$Text&ServiceName=$srvc_name";

//open connection
$ch = curl_init();
 
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
 
//execute post
$result = curl_exec($ch);
 
//close connection
curl_close($ch);

?>