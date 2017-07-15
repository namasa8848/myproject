<? 
include "../conf/config.php";
include "check_login.php"; 


if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$varmi = getSqlNumber("SELECT id FROM rests WHERE id=".$id."");
	if ($varmi==0) {
		echo "<script>document.location.href='rests.php'</script>";
		exit;
	}
	$rs=getSqlRow("SELECT * FROM rests WHERE id=".$id."");
	$rsd=getSqlRow("select * from delivery_areas where id=".$rs['da_id']."");
}
if (!$id) {
	$rs['servicetime']="45";
}

if (!$id) {
	$rs['fz_comm']="10";
	$rs['monthly_fee']="0.00";
	$rs['packing_fee_type']="1";
	$rs['packing_fee']="0.00";
	$rs['custom_qty']="0";
	$rs['priority']="0";
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Seller</title>
<? include "styles.php"; ?>

<script type="text/javascript" charset="utf-8">


$(function(){
  $("select#region").change(function(){
		$("select#city").html('<option value="">---</option>');
		$("select#zip").html('<option value="">---</option>');
		$("#result").load("../conf/post_admin.php",{cmd: "update_select_city", region: $(this).val(), ajax: 'true'});
		
	});

	$("select#city").change(function(){
		$("select#zip").html('<option value="">---</option>');
		$("#result").load("../conf/post_admin.php",{cmd: "update_select_zip",  region: $("select#region").val(), city: $(this).val(), ajax: 'true'});
	});
})

</script>
</head>
<body>

<? include "header.php";
include "sub_rests.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">
<? if (!$_REQUEST['id']) {
	echo "New Seller";
} else {
	echo $rs['name'];
}
?>
</h1>

<?
//PLEASE DONT REMOVE THIS CODE
$productrests = getSqlNumber("SELECT id FROM rests"); 
?>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="id" id="id" value="<?=$rs['id']?>">
<input type="hidden" name="olduser" id="olduser" value="<?=$rs['username']?>">
<input type="hidden" name="cmd" id="cmd" value="save_rest" />
<table width="600" style="line-height:30px;">

   <tr>
    <td>Status</td>
    <td><input type="radio" name="status" id="status" value="1" <? if ($rs['status']==1) echo "checked"; ?>> Active &nbsp; &nbsp; 
	<input type="radio" name="status" id="status" value="0" <? if ($rs['status']==0) echo "checked"; ?>> Closed</td>
  </tr>

<?php $query_p = mysql_query("SELECT * FROM site_services"); ?>
<tr>
<td>Service Type</td><td>
<select name="site_service" id="type" id="site_service"> 
<option value="0">--- Service Type ---</option>
<?php while($row = mysql_fetch_array($query_p)) { ?>
<option value="<?=$row['id'];?>" <? if ( $rs['site_service'] == $row['id'] ) echo "selected"; ?>><?=$row['name'];?></option>
<? } ?>
</select>
</td></tr>


<tr>
<td>Delivery Provider</td><td>
<select name="delivery_type" id="type" id="delivery_type">
<option value="0">--- Select ---</option>
<option value="1" <? if ( $rs['delivery_type'] == "1" ) echo "selected"; ?>>Self</option>
<option value="2" <? if ( $rs['delivery_type'] == "2" ) echo "selected"; ?>>FZ Express Delivery</option>
</select>
</td></tr>

<tr>
    <td width="30%"><br/>Region</td>
    <td width="70%"><br/><select name="region"  id="region" style="width:300px;background: #FFFF80;" >
<option value="">--- Select ---</option>
<? 
$getRss = mysql_query("SELECT id,region FROM delivery_areas group by region");
while ($rss = mysql_fetch_array($getRss)) { ?>
<option value="<?=$rss['region'];?>" <? if ($rsd['region']==$rss['region']) echo "selected"; ?>><?=$rss['region'];?></option>
<? } ?>
</select> *</td>
  </tr>
  
  <tr>
    <td width="30%">Area</td>
    <td width="70%"><select name="city" id="city" style="width:300px;background: #FFFF80;" <? if (!$rs['id']) { echo 'disabled="true"'; } ?>  >
	<option value="">---</option>
	<? 
	if ($rs['id']) {
	$getRss = mysql_query("SELECT id,city FROM delivery_areas where region='".$rsd['region']."' group by city");
	while ($rss = mysql_fetch_array($getRss)) { ?>
	<option value="<?=$rss['city'];?>" <? if ($rsd['city']==$rss['city']) echo "selected"; ?>><?=$rss['city'];?></option>
	<? } 
	}
	?>
	</select> *
</td>
  </tr>


   <tr>
    <td width="30%">Pincode</td>
    <td width="70%"><select name="zip" id="zip" style="width:300px;background: #FFFF80;" <? if (!$rs['id']) { echo 'disabled="true"'; } ?>   >
	<option value="">---</option>
	<? 
	if ($rs['id']) {
	$getRss = mysql_query("SELECT id,zip FROM delivery_areas where region='".$rsd['region']."' and city='".$rsd['city']."' group by zip");
	while ($rss = mysql_fetch_array($getRss)) { ?>
	<option value="<?=$rss['zip'];?>" <? if ($rsd['zip']==$rss['zip']) echo "selected"; ?>><?=$rss['zip'];?></option>
	<? } 
	}
	?>
	</select> *
</td>
  </tr>
   
  <tr>
    <td width="30%">Username</td>
    <td width="70%"><input type="text" name="username" id="username" value="<?=$rs['username']?>" style="width:200px;background: #FFFF80;" maxlength="20"> *</td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="text" name="password" id="password" value="<?=$rs['password']?>" style="width:200px;background: #FFFF80;" maxlength="20"> *</td>
  </tr>
  <tr>
    <td>Service Name</td>
    <td><input type="text" name="name" id="name" value="<?=$rs['name']?>" style="width:300px;background: #FFFF80;" maxlength="250"> *</td>
  </tr>

<tr>
<td>Products Type</td><td>
<select name="type" id="type">
<option value="0" <? if ($rs['type']==0) echo "selected"; ?>>Select Type</option>
<option value="1" style="color:green;" <? if ($rs['type']==1) echo "selected"; ?>>Vegetarian</option>
<option value="2" style="color:red;" <? if ($rs['type']==2) echo "selected"; ?>>Non-Vegetarian</option>
<option value="3" style="color:blue;" <? if ($rs['type']==3) echo "selected"; ?>>Veg & Non-Veg</option>
<option value="4" style="color:purple;" <? if ($rs['type']==4) echo "selected"; ?>>Alcohol</option>
<option value="5" <? if ($rs['type']==5) echo "selected"; ?>>Others</option>
</select>
</td>
</tr>

  <tr>
    <td>Email</td>
    <td><input type="text" name="email" id="email" value="<?=$rs['email']?>" style="width:300px" maxlength="250"></td>
  </tr>
  <tr>
    <td>Landline</td>
    <td><input type="text" name="phone" id="phone" value="<?=$rs['phone']?>" style="width:200px" maxlength="20"></td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td><input type="text" name="gsm" id="gsm" value="<?=$rs['gsm']?>" style="width:200px" maxlength="20"></td>
  </tr>
  <tr>
    <td>Mobile 2</td>
    <td><input type="text" name="gsm2" id="gsm2" value="<?=$rs['gsm2']?>" style="width:200px" maxlength="20"></td>
  </tr>
  <tr>
    <td>Fax</td>
    <td><input type="text" name="fax" id="fax" value="<?=$rs['fax']?>" style="width:200px" maxlength="20"></td>
  </tr>
   <tr>
    <td>Minimum Order</td>
    <td><input type="text" name="minorder" id="minorder" value="<?=intval($rs['minorder'])?>"  style="width:80px;text-align:right;" maxlength="4"  onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' /> </td>
  </tr>
   <tr>
    <td>Service Fee</td>
    <td><input type="text" name="servicefee" id="servicefee" value="<?=intval($rs['servicefee'])?>"  style="width:80px;text-align:right;" maxlength="3"  onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' /> </td>
  </tr>
   <tr>
    <td>Service Time</td>
    <td><input type="text" name="servicetime" id="servicetime" value="<?=$rs['servicetime']?>" style="width:80px;text-align:right;" maxlength="3"  onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' /> Minutes </td>
  </tr>
  <tr>
    <td>Tax for orders (%)</td>
    <td><input type="text" name="rest_tax" id="rest_tax" value="<?=$rs['rest_tax']?>"  style="width:80px;text-align:right;" maxlength="6"  /> 8.245 format.</td>
  </tr>

<tr>
<td>Packing Fee Option</td><td>
<select name="packing_fee_type" id="packing_fee_type">
<option value="0" <? if ($rs['packing_fee_type']==0) echo "selected"; ?>>--- Select ---</option>
<option value="1" <? if ($rs['packing_fee_type']==1) echo "selected"; ?>>Not Applicable</option>
<option value="2" <? if ($rs['packing_fee_type']==2) echo "selected"; ?>>No. of Quantity</option>
<option value="3" <? if ($rs['packing_fee_type']==3) echo "selected"; ?>>Total Bill</option>
<option value="4" <? if ($rs['packing_fee_type']==4) echo "selected"; ?>>Custom Quantity</option>
</select>
</td>
</tr>

  <tr>
    <td>Packing Fee</td>
    <td><input type="text" name="packing_fee" id="packing_fee" value="<?=$rs['packing_fee']?>"  style="width:80px;text-align:right;" maxlength="6"  /> in Rs.</td>
  </tr>
   <tr>
    <td>Custom Quantity</td>
    <td><input type="text" name="custom_qty" id="custom_qty" value="<?=$rs['custom_qty']?>"  style="width:80px;text-align:right;" maxlength="6"  /> </td>
  </tr>

  <tr>
    <td>Discount (%)</td>
    <td><input type="text" name="discount" id="discount" value="<?=$rs['discount']?>"  style="width:80px;text-align:right;" maxlength="6"  /></td>
  </tr>
  <tr>
    <td>Discount on Minimum</td>
    <td><input type="text" name="dis_min" id="dis_min" value="<?=$rs['dis_min']?>"  style="width:80px;text-align:right;" maxlength="6"  /> Ex: 199</td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address" id="address" value="<?=$rs['address']?>" style="width:400px" maxlength="250"></td>
  </tr>
  <tr>
    <td style="vertical-align:top;">About Service</td>
    <td>
	<textarea name="description" id="description" style="width:400px;height:100px;"><?=$rs['description']?></textarea>
	</td>
  </tr>
  <tr>
    <td style="vertical-align:top;">Information (User note)</td>
    <td>
	<textarea name="note" id="note" style="width:400px;height:100px;"><?=$rs['note']?></textarea>
	</td>
  </tr>
  <? if (strtolower(ENABLE_PAYPAL_FOR_REST)=="yes") { ?>
  <tr>
    <td>PayPal Email</td>
    <td><input type="text" name="paypal_email" id="paypal_email" value="<?=$rs['paypal_email']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <?  } ?>
  
  <? if (strtolower(ENABLE_AUTHORIZE_FOR_REST)=="yes") { ?>
  <tr>
    <td>Authorize Login Id</td>
    <td><input type="text" name="authorize_login_id" id="authorize_login_id" value="<?=$rs['authorize_login_id']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <tr>
    <td>Authorize Key</td>
    <td><input type="text" name="authorize_key" id="authorize_key" value="<?=$rs['authorize_key']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <?  } ?>
   <? if (strtolower(ENABLE_GOOGLE_CHECKOUT_FOR_REST)=="yes") { ?>
  <tr>
    <td>Authorize Login Id</td>
    <td><input type="text" name="google_merchant" id="google_merchant" value="<?=$rs['google_merchant']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <tr>
    <td>Authorize Key</td>
    <td><input type="text" name="google_key" id="google_key" value="<?=$rs['google_key']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <?  } ?>
      <tr>
    <td>Accept Order Types</td>
    <td>
    <? 
    $order_types=unserialize($rs['order_types']);
$getRss = mysql_query("SELECT * FROM order_types order by order_type");
while ($rss = mysql_fetch_array($getRss)) { ?>
    <input type="checkbox" name="order_types[]" id="order_types[]" value="<?=$rss['id']?>" <? if (@in_array($rss['id'],$order_types)) echo "checked='true'"; ?> /> <?=$rss['order_type']?>
    <? } ?>
    </td>
  </tr>

  <tr>
    <td><br/>* FZ Commission </td>
    <td><br/><input type="text" name="fz_comm" id="fz_comm" value="<?=$rs['fz_comm']?>"  style="width:80px;text-align:right;" maxlength="6"  /> %</td>
  </tr>

  <tr>
    <td><br/>Monthly Fixed Fee </td>
    <td><br/><input type="text" name="monthly_fee" id="monthly_fee" value="<?=$rs['monthly_fee']?>"  style="width:80px;text-align:right;" maxlength="6"  /> Rs.</td>
  </tr>

  <tr>
    <td><br/>Search Priority </td>
    <td><br/><input type="text" name="priority" id="priority" value="<?=$rs['priority']?>" style="width:80px;text-align:right;" maxlength="6"  /> 

&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 

Flash as NEW : <input type="checkbox" name="flash" id="flash" value="1" <? if ($rs['flash']=="1") echo 'checked="true"'; ?>><br /><br />

</td>
  </tr>



  <tr>
    <td></td>
    <td><input type="submit" name="sbt" id="sbt" value="Submit" style="font-size:16px;margin-top:15px;" onclick='this.disabled=true; post_admin("myform"); return false;'></td>
  </tr>
</table>
</form>
</div>
</div>

<? include "footer.php"; ?>

</body>
</html>