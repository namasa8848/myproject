 <?php
    include "../conf/config.php";
    include "check_login.php";    
  ?>
  <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Coupon Dashboard</title>
<?php include "styles.php";  ?>
  <style>
 .dashboard_head { margin-top:-6% !important;} 
.tdheader {
	  line-height: 38px !important; 
  }
 .tda , .tdb {
	   line-height: 50px !important;
 }
.tdc {
	   line-height: 10px !important;
	   padding:10px;
}	    
#addfield {
	  display:none;
}
.newCoupon , .Save , .emailCoupon , .Back  , .removeCpn , .couponGenerator{
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 40px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin-top: 40px;
    margin-left: 20px;
	 font-weight:bold;
	 box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
#cnfmbox {
  display:none;
	position: fixed;
    background: #f9edbe;
    border: 1px solid #F0C369;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    width: 400px;
    max-width: 450px;
    padding: 8px;
    top: 1em;
    border-radius: 2px;
    left: 30em;
}
#cnfmbox p {
margin: 0;
line-height: 1.2;
color: #222;
text-align: center;
font-weight: 700;
}
.overlay{
  display:none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10;
  background-color: rgba(0,0,0,0.5); /*dim the background*/
}
.overlayBox{
	 display:none;
    width: 300px;
    height: 300px;
    line-height: 200px;
    position: fixed;
    top: 50%; 
    left: 50%;
    margin-top: -150px;
    margin-left: -150px;
    background-color: #fff;
	 box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 5px;
    text-align: center;
    z-index: 11; /* 1px higher than the overlay layer */
	overflow: hidden;  /* Hide the Scroll Bar */
}
#changeUsername {
	 width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 20px;
}
#emailCoupon , #memberCoupon  , #emailVoucher , #emailSubject {
	 width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 10px;
}
#allCoupon {
	width:15px;
	height:15px;
}
#removeCoupn  {
	 width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 10px;
}
.couponGen{
	width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 10px;
}
.submitCouponBtn , .submitEmailBtn , .couponGenBtn{
	width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 10px;
	 background-color: #4CAF50;
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
	 line-height: 0px;
}	
.tabs-menu {
    height: 30px;
    float: left;
    clear: both;
	margin-left: 10px;
}
.tabs-menu li {
    height: 30px;
    line-height: 30px;
    float: left;
    margin-right: 10px;
    background-color: #ccc;
    border-top: 1px solid #d4d4d1;
    border-right: 1px solid #d4d4d1;
    border-left: 1px solid #d4d4d1;
}
.tabs-menu li.current {
    position: relative;
    background-color: #fff;
    border-bottom: 1px solid #fff;
    z-index: 5;
}
.tabs-menu li a {
    padding: 10px;
    text-transform: uppercase;
    color: #fff;
    text-decoration: none; 
}

.tabs-menu .current a {
    color: #2e7da3;
}
.tab {
    border: 1px solid #d4d4d1;
    background-color: #fff;
    float: left;
    margin-bottom: 20px;
	margin-top: -10px;
    width: auto;
}
.tab-content {
    width: 700px;
    padding: 5px;
    display: none;
    height: 305px;
}
#tab-1 {
 display: block;   
}
</style>	
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 </head>
 <body>
<?php
$output="";
		function value($box){
		if($box!="1")
			return 0;
		return 1;
	}
	function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	if(isset($_POST['submitEmail'])) // Email the Coupon
  {
				$output="";
				if(isset($_POST['emailVoucher'])&& $_POST['emailVoucher'] !="" ) // Get the VoucherCode
					$email_Voucher=$_POST['emailVoucher'];
				else if($_POST['emailVoucher'] =="")
				{
					$output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('VoucherCode Field Cannot be left Empty.');  setTimeout( function(){ Refresh(); }, 1500); </script>";
				  }
				if(isset($_POST['emailSubject'])&& $_POST['emailSubject'] !="" ) // Get the Email Subject
					$email_subject=$_POST['emailSubject'];
				else if($_POST['emailSubject'] =="")
				{
					$output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('Email Subject Field Cannot be left Empty.');  setTimeout( function(){ Refresh(); }, 1500); </script>";
				  }
				 if(isset($_POST['emailCoupon'])&& $_POST['emailCoupon'] !="" ) // Get the optional Email Address
									$email_address =$_POST['emailCoupon'];
				if(isset($_POST['memberCoupon'])&& $_POST['memberCoupon'] !="") // Get the Member ID from that Get the Email Address
			   {       
							$query="SELECT email FROM users WHERE id=".intval($_POST['memberCoupon'])." ";
							$result=mysql_query($query );
							while ($r = mysql_fetch_array($result)) {
								$mem_email_address=$r['email'];
							}
				 }
				 if(isset($_POST['allCoupon'])&& $_POST['allCoupon'] !="0") // Get all the Email Addresses 
			   {       
							$query="SELECT email from users";
							$mail_addresses="";
							$result=mysql_query($query );
							while ($r = mysql_fetch_array($result)) {
								$mail_addresses=$mail_addresses.",".$r['email'];
							}
							$mail_addresses[0]="";
				 }
			if((isset($_POST['VoucherCode'])&& isset($_POST['emailSubject']))|| isset($_POST['emailCoupon']) || isset($_POST['memberCoupon']) || isset($_POST['allCoupon'])) 
			{
			if($_POST['emailCoupon'] =="" && isset($mem_email_address))
				$email=$mem_email_address;
			else if($_POST['memberCoupon'] == "" && isset($email_address))
				$email=$email_address;
			// else if(intval($_POST['allCoupon'])== 1)send it to all
			//	$email =$mail_addresses;
		if(isset($email_subject)&& isset($email_Voucher))
		send_coupon($email,$email_Voucher,$email_subject);
		$output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('Your Mail has been Sent Successfully.');  setTimeout( function(){ Refresh(); }, 1500); </script>";	
		}
	}
	if(isset($_POST['couponGenBtn'])) // Random Coupon Generator 
	{
		if(strlen($_POST['location']) < 1)
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Location Field Cannot be left Empty !');  </script>";
		  }
		   else if(strlen($_POST['voucherCode'])<4 )
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('voucherCode Must be Min. 4 characters !'); </script>";
		  }
		else{ 
		$edate="";
				if(isset($_POST['couponID']))  $couponID = $_POST['couponID'];
			if(isset($_POST['couponTimes'])) $couponTimes =  $_POST['couponTimes'];
			if(isset($_POST['voucherCode']))$voucherCode = $_POST['voucherCode']; // VoucherCode + Random Voucher code of 6 characters
			if(isset($_POST['location']))$location = strtoupper($_POST['location']);
			if(isset($_POST['restID']))$restID =  intval($_POST['restID']);
			if(isset($_POST['status']))$status =  intval($_POST['status']);
			if(isset($_POST['minBasketCost']))$minBasketCost =  $_POST['minBasketCost'];
			if(isset($_POST['discountType']))$discountType =  "'".$_POST['discountType']."'";
			if(isset($_POST['discountAmount']))$discountAmount =  $_POST['discountAmount'];
			if(isset($_POST['maxDiscount']))$maxDiscount =  $_POST['maxDiscount'];
			if(isset($_POST['maxUses']))$maxUses =  $_POST['maxUses']; else $maxUses=1;
			if(isset($_POST['totalVouchers']))$totalVouchers =  $_POST['totalVouchers']; else $totalVouchers=1;
			$cond = isset($_POST['expiry_y'])&& isset($_POST['expiry_m'])&& isset($_POST['expiry_d']) && isset($_POST['expiry_h'])&& isset($_POST['expiry_i'])&& isset($_POST['expiry_s']);
			if($cond )// If all values are set for expire date then retrieve them 
			{
				$year = $_POST['expiry_y'];
				$month = $_POST['expiry_m'];
				$day = $_POST['expiry_d'];
				$hour = $_POST['expiry_h'];
				$min = $_POST['expiry_i'];
				$sec = $_POST['expiry_s'];
				$edate="'".$year."-".$month."-".$day." ".$hour.":".$min.":".$sec."'"; //Unix TimeStamp Format
			}	
			$i = 0;
			while($i != $couponTimes)
		{
			$voucher=$voucherCode.generateRandomString();
			$string="INSERT INTO coupon VALUES(".$couponID.",'".$voucher."','".$location."',".$restID.",".$status.",".$minBasketCost.",".$discountType.",".$discountAmount.",".$maxDiscount.",".$maxUses.",".$totalVouchers.",".$edate." )";
			$result =mysql_query($string);
			$couponID= $couponID+1;
			$voucher='';
			$i=$i+1;
			}	
		$output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('Random Coupons has been Successfully Generated!'); setTimeout( function(){ Refresh(); }, 1500); </script>";

		}
	}
	if(isset($_POST['submitCoupon'])) // Remove Coupon from Coupon List
  {
		$remCpnQuery ="delete from coupon WHERE voucherCode='".$_POST['removeCpn']."' ";
		$result =mysql_query($remCpnQuery);
		if($result > 0)
	    $output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('Coupon has been Successfully Removed'); setTimeout( function(){ Refresh(); }, 1500); </script>";
	}
	if(isset($_POST['submitCouponALL'])) // Remove All Coupons from Coupon List
  {
		$remCpnQueryAll ="delete from coupon";
		$result =mysql_query($remCpnQueryAll);
		if($result > 0)
	    $output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('All Coupons has been Successfully Removed'); setTimeout( function(){ Refresh(); }, 1500); </script>";
	}
	if(isset($_POST['saveNewCoupon'])) // Add New Coupon
	{
		$query=mysql_query("SELECT voucherCode FROM coupon WHERE voucherCode='".$_POST['voucherCode']."' ");
		 if(mysql_num_rows($query)> 0)
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Voucher Code Already Exists !'); </script>";
		 else if(strlen($_POST['location']) < 1)
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Location Field Cannot be left Empty !');  </script>";
		  }
		   else if(strlen($_POST['voucherCode'])<4 )
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('voucherCode Must be Min. 4 characters !'); </script>";
		  }
		else{ 
			$addsql="";
			$cond = isset($_POST['expiry_y'])&& isset($_POST['expiry_m'])&& isset($_POST['expiry_d']) && isset($_POST['expiry_h'])&& isset($_POST['expiry_i'])&& isset($_POST['expiry_s']);
			if($cond )// If all values for expire date is present
			{
				$year = $_POST['expiry_y'];
				$month = $_POST['expiry_m'];
				$day = $_POST['expiry_d'];
				$hour = $_POST['expiry_h'];
				$min = $_POST['expiry_i'];
				$sec = $_POST['expiry_s'];
				$edate="'".$year."-".$month."-".$day." ".$hour.":".$min.":".$sec."'"; //Unix TimeStamp Format
			}	
				if(isset($_POST['ID'])) $addsql=$addsql.intval($_POST['ID']).", "; else $addsql=$addsql."0".","; 	// Default 0 for auto increment 
				if(isset($_POST['voucherCode'])) $addsql=$addsql."'".$_POST['voucherCode']."', "; else  $addsql=$addsql."'fzabcd', ";
				if(isset($_POST['location'])) $addsql=$addsql." '".strtoupper($_POST['location'])."', "; else  $addsql=$addsql."'ALL', ";
				if(isset($_POST['restID'])) $addsql=$addsql.intval($_POST['restID']).", "; else  $addsql=$addsql.intval("0").", "; 	
				if(isset($_POST['status'])) $addsql=$addsql.intval($_POST['status']).","; else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['minBasketCost'])) $addsql=$addsql.intval($_POST['minBasketCost']).", "; else  $addsql=$addsql.intval("500").", "; 	
				if(isset($_POST['discountType'])) $addsql=$addsql.intval($_POST['discountType']).","; else  $addsql=$addsql.intval("1").","; 	
				if(isset($_POST['discountAmount'])) $addsql=$addsql.intval($_POST['discountAmount']).", ";	else  $addsql=$addsql.intval("20").", "; 	
				if(isset($_POST['maxDiscount'])) $addsql=$addsql.intval($_POST['maxDiscount']).", ";	else  $addsql=$addsql.intval("100").", "; 	
				if(isset($_POST['maxUses'])) $addsql=$addsql.$_POST['maxUses'].", "; else  $addsql=$addsql.intval("1").", "; 		
				if(isset($_POST['totalVouchers'])) $addsql=$addsql.intval($_POST['totalVouchers']).", "; else  $addsql=$addsql.intval("-1").", "; 		
				if($cond) $addsql=$addsql.$edate."";  
		    $str = "INSERT INTO coupon VALUES(".$addsql.")";
			$result =mysql_query($str);
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('New Coupon has been Added Successfully');  setTimeout( function(){ Refresh(); }, 1500);  </script>";

		}
	}
		$SQL="SELECT * from coupon;"; // Retrieve all Coupons from the data base 
		$result=mysql_query($SQL);
	?>
<header class="dashboard_head"> <div><h2> Coupon Dashboard </h2> </div></header>	
<table width="100%">
	<thead>
  <tr>
    <td width="3%" class="tdheader"><center>ID</center></td>
	<td width="10%" class="tdheader"><center>VoucherCode</center></td>
    <td width="9%" class="tdheader"><center>Location</center></td>
    <td width="7%" class="tdheader" ><center>restID</center></td>
	 <td width="6%" class="tdheader" ><center>Status</center></td>
	 <td width="8%" class="tdheader" ><center>minBasketCost</center></td>
	 <td width="8%" class="tdheader" ><center>discount Type</center></td>
	 <td width="10%" class="tdheader" ><center>discount Amount</center></td>
	 <td width="8%" class="tdheader" ><center>maxDiscount</center></td>
	 <td width="6%" class="tdheader" ><center>maxUses</center></td>
	 <td width="8%" class="tdheader" ><center>Total Vouchers</center></td>
	 <td width="12%" class="tdheader" ><center>Expiry Date</center></td>
  </tr>
  </thead>
       <tbody>
	      <?php $count=0;  while($row=mysql_fetch_array($result)){ 
		  $class=(($count++)%2==0)?"tda":"tdb";
		  ?>
	        <tr  class="<?php echo $class; ?>">
	          <td><center><?php echo $row[ 'ID'];?></center></td>
			  <td ><center><?php echo $row[ 'voucherCode'];?></center></td>
	          <td ><center><?php echo $row[ 'location'];?></center></td>
			    <td ><center><?php echo $row[ 'restID'];?></center></td>
	          <td><center><?php if ($row[ 'status']==1) echo 'Active'; else if($row[ 'status']==0)  echo 'in-active';  ?> </center></td>
			   <td ><center><?php echo $row[ 'minBasketCost'];?></center></td>
			   <td><center><?php if ($row[ 'discountType']=='-') echo 'Flat'; else if ($row[ 'discountType']=='%') echo 'Percentage';  else if ($row[ 'discountType']=='^')echo 'Cashback';?> </center></td>
			   <td ><center><?php echo $row[ 'discountAmount'];?></center></td>
			   <td ><center><?php echo $row[ 'maxDiscount'];?></center></td>
			   <td ><center><?php echo $row[ 'maxUses'];?></center></td>
			   <td ><center><?php echo $row[ 'totalVouchers'];?></center></td>
			   <td ><center><?php echo $row[ 'expiry'];?></center></td>
	        </tr>
	        <?php  } ?>
			<tr id="addfield">
	          <form id="newcoupon" name="newcoupon" method="post"  action="couponPage.php" >
	            <td><center><input type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="ID" name="ID" value="" placeholder="Coupon ID"  style="width:80px;margin-right: 5px;"></center></td>
	            <td><center><input  type="text" id="voucherCode" name="voucherCode" value="" placeholder="Voucher Code" style="width: 170px;"></center></td>
	            <td ><center><input  type="text" id="location" name="location" value="" placeholder="Location" style="width: 90px;" ></center></td>
	            <td><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?"  id="restID" name="restID" value="" placeholder="Rest. ID" style="width: 80px;" ></center></td>
	            <td ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="status" name="status" value="" placeholder="Status"  style="width: 70px;" ></center></td>  
				  <td ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="minBasketCost" name="minBasketCost" value="" placeholder="min. BasketCost"  style="width: 80px;"></center></td>  
				  <td ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?"  id="discountType" name="discountType" value="" placeholder="Discnt.Type"  style="width: 80px;"></center></td>  
				  <td ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="discountAmount" name="discountAmount" value="" placeholder="Discnt. Amt"  style="width: 80px;"></center></td>
				  <td ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="maxDiscount" name="maxDiscount" value="" placeholder="max. Discnt"  style="width: 80px;" ></center></td>
				  <td ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="maxUses" name="maxUses" value="" placeholder="max. Users"  style="width: 70px;"></center></td>
				  <td ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="totalVouchers" name="totalVouchers" value="" placeholder="Total Vouchers"  style="width: 70px;"></center></td>
				  <td ><center><input  type="text" id="expiry_y" name="expiry_y" value="" placeholder="yyyy"  style="width: 36px;">
							<input  type="text" id="expiry_m" name="expiry_m" value="" placeholder="mo"  style="width: 20px;">
							<input  type="text" id="expiry_d" name="expiry_d" value="" placeholder="dd"  style="width: 20px;">	
							<input  type="text" id="expiry_h" name="expiry_h" value="" placeholder="hr"  style="width: 20px;">
							<input  type="text" id="expiry_i" name="expiry_i" value="" placeholder="mm"  style="width: 20px;">
							<input  type="text" id="expiry_s" name="expiry_s" value="" placeholder="ss"  style="width: 20px;"></center>
				  </td>
	         </form> 
			</tr>
	      </tbody>
	</form>
  </table>
  <div style="margin-bottom: 60px;">
  <center>
		<button id="plus" class="newCoupon" name="submit" onclick="addCoupon()">Add New Coupon</button>
		<button id="saveNewCoupon" class="newCoupon" style="display:none;" name="saveNewCoupon" type="submit" form="newcoupon" >Save New Coupon</button>
       <button class="couponGenerator" name="couponGenerator" type="submit" onclick="couponGenerator()">Coupon Generator</button>
	    <button id="refresh" class="Save" name="submit" type="submit"  onclick="Refresh()">Refresh</button>
		<button  class="emailCoupon" name="emailCpn" type="submit"  style="margin-left: calc(100% - 90em)" onclick="emailCoupon()">Email Coupon</button>
		<button  class="removeCpn" name="removeCpn" type="submit"   onclick="removeCpn()">Remove Coupon</button>
		<button class="Back" name="submit" type="submit"  onclick="back()">Back to Dashboard</button>
		</center>
  </div>
<div id="overlay" class="overlay" onclick="closeOverlay()"></div>
<center><div  id="modal1" class="OverlayBox">
<h2><center>Email the Coupon</center></h2>
<form id="couponEmail" name="couponEmail" method="post"  action="couponPage.php"> 
<input  type="text" id="emailVoucher" name="emailVoucher" value="" placeholder="Voucher Code (Required )"  ></br>
<input  type="text" id="emailSubject" name="emailSubject" value="" placeholder="Email Subject (Required )"  ></br>
<input type="text" id="emailCoupon" name="emailCoupon"  value=""  placeholder="Enter Email-Address ( Optional )" ></br>
<input type="text" id="memberCoupon" name="memberCoupon"  value="" placeholder="Enter Member ID ( Optional )" ></br>
<table width="100%"><tr><td style="padding-left: 25px;padding-top: 10px;padding-bottom: 10px;">Send it to All (Optional )<span>&nbsp;&nbsp;</span><input type="checkbox" id="allCoupon" name="allCoupon"  value="0"   placeholder="Send it to All" onchange="update_chkbx(this)"></td></tr></table>
<button type="submit"  class="submitEmailBtn" name="submitEmail"  value="" placeholder="Send"  form="couponEmail" >Send Email</button></br>
</form> 
</div></center>
<center><div  id="modal2" class="OverlayBox">
<h2><center>Remove the Coupon</center></h2>
<form id="removeCoupon" name="removeCoupon" method="post"  action="couponPage.php" > 
<input type="text" id="removeCoupn" name="removeCpn"  value="" placeholder="Enter VoucherCode" ></br>
<button type="submit"  class="submitCouponBtn" name="submitCoupon"  value="" placeholder=""  form="removeCoupon" >Remove Coupon</button></br>
<button type="submit"  class="submitCouponBtn" name="submitCouponALL"  value="" placeholder=""  form="removeCoupon" >Remove All Coupons</button></br>
</form> 
</div></center>
<center><div  id="modal3" class="OverlayBox" style="margin-left:calc(100% - 127%) !important;margin-top:-200px !important;">
<h2><center>Random Coupon Generator</center></h2>
<form id="rndmcpngen" name="rndmcpngen" method="post"  action="couponPage.php"> 
<div id="tabs-container">
    <ul class="tabs-menu">
        <li class="current"><a href="#tab-1">Coupon Settings</a></li>
        <li><a href="#tab-2">Coupon Details 1</a></li>
        <li><a href="#tab-3">Coupon Details 2</a></li>
        <li><a href="#tab-4">Coupon Details 3</a></li>
    </ul>
    <div class="tab">
        <div id="tab-1" class="tab-content">
		<table width="100%">
          <tr><td class="tdc"><center><input type="text" class="couponGen" name="couponID"  value=""  placeholder="Enter Starting Coupon ID" ></center></td></tr>
		  <tr><td class="tdc"><center><input type="text" class="couponGen" name="couponTimes"  value=""  placeholder="Enter Number of Times" ></center></td></tr>
			<tr><td class="tdc" ><center><input  type="text" class="couponGen"  name="voucherCode" value="" placeholder="Enter Voucher Code" ></center></td></tr>
	       <tr><td class="tdc"><center><input  type="text" class="couponGen" name="location" value="" placeholder=" Enter the Location" ></center></td></tr>
		</table>
	   </div>
        <div id="tab-2" class="tab-content">
		  <table width="100%">
		    <tr><td class="tdc"><center><input type="text" pattern="-?[0-9]*(\.[0-9]+)?" class="couponGen" name="restID"  value=""  placeholder="Enter Restaurant ID" ></center></td></tr>
			<tr><td class="tdc" ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" class="couponGen"  name="status" value="" placeholder="Enter Status (1 | 0  )" ></center></td></tr>
	       <tr><td class="tdc"><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" class="couponGen" name="minBasketCost" value="" placeholder="Enter the MinBasketCost" ></center></td></tr>
		</table>
		</div>
        <div id="tab-3" class="tab-content">
		<table width="100%">
		   <tr><td class="tdc"><center><input type="text"  class="couponGen" name="discountType"  value=""  placeholder="DiscountType [ - | % | ^ ]" ></center></td></tr>
			<tr><td class="tdc" ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" class="couponGen"  name="discountAmount" value="" placeholder="Enter Discount Amount" ></center></td></tr>
	       <tr><td class="tdc"><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" class="couponGen" name="maxDiscount" value="" placeholder=" Enter max. Discount" ></center></td></tr>
		 </table>
        </div>
        <div id="tab-4" class="tab-content">
		<table width="100%">
		<tr><td class="tdc"><center><input type="text"  pattern="-?[0-9]*(\.[0-9]+)?" class="couponGen" name="maxUses"  value=""  placeholder="Enter maxUses" ></center></td></tr>
			<tr><td class="tdc" ><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" class="couponGen"  name="totalVouchers" value="" placeholder="Enter totalVouchers" ></center></td></tr>
	       <tr> <td ><center><input  type="text" id="expiry_y" name="expiry_y" value="" placeholder="yyyy"  style="width: 50px;">
							<input  type="text" id="expiry_m" name="expiry_m" value="" placeholder="mo"  style="width: 30px;">
							<input  type="text" id="expiry_d" name="expiry_d" value="" placeholder="dd"  style="width: 30px;">	
							<input  type="text" id="expiry_h" name="expiry_h" value="" placeholder="hr"  style="width: 30px;">
							<input  type="text" id="expiry_i" name="expiry_i" value="" placeholder="mm"  style="width: 30px;">
							<input  type="text" id="expiry_s" name="expiry_s" value="" placeholder="ss"  style="width: 30px;"></center>
				  </td></tr>
		   <tr><td class="tdc" ><center><p style="margin-top: 10px !important;">All Your Coupons are going to Generate, Hit the Generate Button Below </p></br></center></td></tr>
		   <tr><td class="tdc" ><center><input type="submit"  class="couponGenBtn"  name="couponGenBtn"  value="Generate Coupons" placeholder=""  form="rndmcpngen" /></br></center></td></tr>
		 </table>
        </div>
    </div>
</div>
</form> 
</div></center>
  <center><div id="cnfmbox"><p class="msg"></p></div></center>
   <script>
   function update_chkbx(chk_bx){
        if(chk_bx.checked)
			chk_bx.value="1";
        else
            chk_bx.value="0";
  } 
  $(document).ready(function() {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    }); 
});
   function couponGenerator()
   {
	     document.getElementById("overlay").style.display = "block";
		 document.getElementById("modal3").style.display = "block"; 
		 document.getElementById("modal3").style.width = "700px";
		 document.getElementById("modal3").style.height = "400px";
   }
   function removeCpn()
   {
	   document.getElementById("overlay").style.display = "block";
		document.getElementById("modal2").style.display = "block";
   }
	function addCoupon(){
		document.getElementById("addfield").style.display = "table-row";
		document.getElementById("plus").style.display = "none";
		document.getElementById("saveNewCoupon").style.display = "inline-block";
	}
	function Refresh()
	{
		 window.location = 'couponPage.php';
	}
	function back()
	{
		 window.location = 'index.php';
	}
	function emailCoupon()
	{
		document.getElementById("overlay").style.display = "block";
		document.getElementById("modal1").style.display = "block";
		document.getElementById("modal1").style.height = "400px";
	}
	function closeOverlay()
	{
		document.getElementById("overlay").style.display = "none";
		document.getElementById("modal1").style.display = "none";
		document.getElementById("modal2").style.display = "none";
		document.getElementById("modal3").style.display = "none";
	}
</script>
  <?php echo $output; ?>
</body>
</html> 
	
