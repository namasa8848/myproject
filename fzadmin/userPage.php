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
    <title>Users Dashboard</title>
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
.newUser , .Save , .changePassword , .Back  , .removeUsr , .changePreference{
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
#changePassword {
	 width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 10px;
}
#removeUsername {
	width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 15%;
}
#usernamePref , #cityPref , #delivery_typePref{
	width: 250px;
    height: 40px;
    padding: 20px;
    margin-top: 10px;
}
.submitPasswordBtn , .submitUsernameBtn , .submitPrefBtn {
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
		function value($box){
		if($box!="1")
			return 0;
		return 1;
	}
	$output="";
	if(isset($_POST['submitPrefBtn'])) // Change Preference
  {
				$addsql="";
				if(isset($_POST['cityPref'])) $addsql=$addsql." city='".strtoupper($_POST['cityPref'])."' , ";  else  $addsql=$addsql."city='ALL' , "; 	
				if(isset($_POST['delivery_typePref'])) $addsql=$addsql." delivery_type=".intval(value($_POST['delivery_typePref']))." , ";  else  $addsql=$addsql."delivery_type=".intval("0")." , "; 	
				if(isset($_POST['dashboardPref'])&& value($_POST['dashboardPref'])=="1") $addsql=$addsql."Dashboard=".intval(value($_POST['dashboardPref']))." , "; else  $addsql=$addsql."Dashboard=".intval("0")." , "; 	
				if(isset($_POST['ordersPref'])&& value($_POST['ordersPref'])=="1") $addsql=$addsql."Orders=".intval(value($_POST['ordersPref']))." , "; else  $addsql=$addsql." Orders=".intval("0")." , "; 	
				if(isset($_POST['sreportsPref'])&& value($_POST['sreportsPref'])=="1") $addsql=$addsql." `Service Reports`=".intval(value($_POST['sreportsPref']))." , ";	 else  $addsql=$addsql." `Service Reports`=".intval("0")." , "; 	
				if(isset($_POST['creportsPref'])&& value($_POST['creportsPref'])=="1") $addsql=$addsql." `Company Reports`=".intval(value($_POST['creportsPref']))." , ";	else  $addsql=$addsql."  `Company Reports`=".intval("0")." , "; 	
				if(isset($_POST['servicePref']) && value($_POST['servicePref'])=="1") $addsql=$addsql." `Service Provider`=".intval(value($_POST['servicePref']))." , ";	 else  $addsql=$addsql." `Service Provider`=".intval("0")." , "; 	
				if(isset($_POST['offersPref'])&& value($_POST['offersPref'])=="1") $addsql=$addsql." Offers=".intval(value($_POST['offersPref']))." , ";	 else  $addsql=$addsql." Offers=".intval("0")." , "; 	
				if(isset($_POST['couponsPref']) && value($_POST['couponsPref'])=="1") $addsql=$addsql."Coupons=".intval(value($_POST['couponsPref']))." , ";	 else  $addsql=$addsql."Coupons=".intval("0")." , "; 	
				if(isset($_POST['settingsPref'])&& value($_POST['settingsPref'])=="1") $addsql=$addsql." Settings=".intval(value($_POST['settingsPref']))." , ";	else  $addsql=$addsql." Settings=".intval("0")." , "; 	
				if(isset($_POST['usersPref'])&& value($_POST['usersPref'])=="1") $addsql=$addsql." Users=".intval(value($_POST['usersPref']))." , ";	else  $addsql=$addsql." Users=".intval("0")." , "; 	
				if(isset($_POST['customersPref'])&& value($_POST['customersPref'])=="1") $addsql=$addsql." Customers=".intval(value($_POST['customersPref']))." , "; else  $addsql=$addsql." Customers=".intval("0")." , "; 		
				if(isset($_POST['feedbackPref'])&& value($_POST['feedbackPref'])=="1") $addsql=$addsql." Feedbacks=".intval(value($_POST['feedbackPref']))." "; else  $addsql=$addsql." Feedbacks=".intval("0")." "; 	
	  
		$queryPref ="UPDATE adminUsers SET ".$addsql." WHERE username='".$_POST['usernamePref']."' ";
		$result =mysql_query($queryPref);
	    if($result > 0)
		$output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('Your Settings has been Successfully Changed.');  setTimeout( function(){ Refresh(); }, 1500); </script>";
	}
	if(isset($_POST['submitUsername'])) // Remove User from admin users
  {
		$remUsrQuery ="delete from adminUsers WHERE username='".$_POST['removeUsername']."' ";
		$result =mysql_query($remUsrQuery);
		if($result > 0)
	    $output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('User has been Removed Successfully');  setTimeout( function(){ Refresh(); }, 1500); </script>";
	
	}
	if(isset($_POST['submitUsrPsw'])) // Change password
  {
		$pswdQuery ="update adminUsers set password='". md5($_POST['changePassword'])."'  WHERE username='".$_POST['changeUsername']."' ";
		$result =mysql_query($pswdQuery);
		if($result > 0)
	    $output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('Your Password has been Successfully Changed.');  setTimeout( function(){ Refresh(); }, 1500); </script>";
	}
	if(isset($_POST['saveNewUser'])) // Add New User
	{
		$query=mysql_query("SELECT username FROM adminUsers WHERE username='".$_POST['username']."' ");
		if(mysql_num_rows($query)>0)
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Username Already Exists !'); </script>";
		else if(strlen($_POST['username']) <4)
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Username must be atleast 4 characters !'); </script>";
		  }
		  	else if(strlen($_POST['password']) < 8)
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Password must be atleast 8 characters !'); </script>";
		  }
		 else if(strlen($_POST['city']) < 1)
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('City Field Cant be left Empty !');  </script>";
		  }
		   else if(strlen($_POST['delivery_type'])>=3 )
		{	
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Invalid Delivery Type Field !'); </script>";
		  }
		else{ 
			$addsql="";
				if(isset($_POST['dashboard'])&& value($_POST['dashboard'])=="1" ) $addsql=$addsql.intval(value($_POST['dashboard'])).",";  else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['orders'])&& value($_POST['orders'])=="1" ) $addsql=$addsql.intval(value($_POST['orders'])).","; else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['sreports'])&& value($_POST['sreports'])=="1") $addsql=$addsql.intval(value($_POST['sreports'])).",";	else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['creports'])&& value($_POST['creports'])=="1") $addsql=$addsql.intval(value($_POST['creports'])).", ";	 else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['sprovider']) && value($_POST['sprovider'])=="1") $addsql=$addsql.intval(value($_POST['sprovider'])).",";	 else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['offers']) && value($_POST['offers'])=="1") $addsql=$addsql.intval(value($_POST['offers'])).",";	 else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['coupons']) && value($_POST['coupons'])=="1") $addsql=$addsql.intval(value($_POST['coupons'])).",";	 else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['settings'])&& value($_POST['settings'])=="1") $addsql=$addsql.intval(value($_POST['settings'])).",";	else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['users'])&& value($_POST['users'])=="1") $addsql=$addsql.intval(value($_POST['users'])).",";	else  $addsql=$addsql.intval("0").","; 	
				if(isset($_POST['customers'])&& value($_POST['customers'])=="1") $addsql=$addsql.intval(value($_POST['customers'])).","; else  $addsql=$addsql.intval("0").","; 		
				if(isset($_POST['feedback'])&& value($_POST['feedback'])=="1") $addsql=$addsql.intval(value($_POST['feedback']))." )"; else  $addsql=$addsql.intval("0")." )"; 	
					
		    $str = "INSERT INTO adminUsers VALUES('".$_POST['username']."','". md5($_POST['password'])."','".strtoupper($_POST['city'])."',".$_POST['delivery_type'].",".$addsql;
			$result =mysql_query($str);
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(1500).fadeOut('fast'); $('.msg').html('New Admin User has been Successfully Added');  setTimeout( function(){ Refresh(); }, 1500);  </script>";
		}
	}
		$SQL="SELECT * from adminUsers;";
		$result=mysql_query($SQL);
	?>
<header class="dashboard_head"> <div><h2> User Dashboard </h2> </div></header>	
<table width="100%">
	<thead>
  <tr>
    <td width="8%" class="tdheader"><center>Username</center></td>
	<td width="3%" class="tdheader"><center>Password</center></td>
    <td width="8%" class="tdheader"><center>City</center></td>
    <td width="8%" class="tdheader" ><center>Delivery</center></td>
	 <td width="6%" class="tdheader" ><center>Dashboard</center></td>
	 <td width="6%" class="tdheader" ><center>Orders</center></td>
	 <td width="6%" class="tdheader" ><center>C Reports</center></td>
	 <td width="6%" class="tdheader" ><center>S Reports</center></td>
	 <td width="6%" class="tdheader" ><center>S Provider</center></td>
	 <td width="6%" class="tdheader" ><center>Offers</center></td>
	 <td width="6%" class="tdheader" ><center>Coupons</center></td>
	 <td width="6%" class="tdheader" ><center>Settings</center></td>
	 <td width="6%" class="tdheader" ><center>Users</center></td>
	 <td width="6%" class="tdheader" ><center>Customer</center></td>
	 <td width="6%" class="tdheader" ><center>Feedback</center></td>
  </tr>
  </thead>
       <tbody>
	      <?php $count=0;  while($row=mysql_fetch_array($result)){ 
		  $class=(($count++)%2==0)?"tda":"tdb";
		  ?>
	        <tr  class="<?php echo $class; ?>">
	          <td><center><?php echo $row[ 'username'];?></center></td>
			  <td ><center><?php echo $row[ 'password'];?></center></td>
	          <td ><center><?php echo $row[ 'City'];?></center></td>
	          <td><center><?php if ($row[ 'Delivery_Type']==1) echo 'FZ Delivery'; else if($row[ 'Delivery_Type']==2) echo 'Self Delivery'; else echo 'All';?> </center></td>
	          <td><center><span><label  for="<?php $row['username'].'-dashboard'?>">
		       				<input type="checkbox" id="<?php echo $row['username'].'-dashboard'?>"  <?php if ($row['Dashboard'])echo 'checked'; ?> />
		     			</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-orders'?>">
		       				<input type="checkbox" id="<?php echo $row['username'].'-orders'?>" <?php if($row['Orders']) echo 'checked'; ?> />
							</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-creports'?>">
		       				<input type="checkbox" id="<?php echo $row['username'].'-creports'?>"   <?php if ($row['Company Reports'])echo 'checked'; ?> />
		     			</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-sreports'?>">
		       				<input type="checkbox" id="<?php echo $row['username'].'-sreports'?>"  <?php if ($row['Service Reports']) echo 'checked'; ?> />
		     			</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-sprovider'?>">
		       				<input type="checkbox" id="<?php echo $row['username'].'-sprovider'?>" <?php if ($row['Service Provider']) echo 'checked'; ?> />
		     			</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-offer'?>">
		       				<input type="checkbox" id="<?php echo $row['username'].'-offer'?>"  <?php if ($row['Offers'])echo 'checked'; ?> />
		     			</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-coupon'?>">
		       				<input type="checkbox" id="<?php echo $row['username'].'-coupon'?>"  <?php if ($row['Coupons']) echo 'checked'; ?> />
		     			</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-setting'?>">
		       				<input type="checkbox" id="<?php  echo $row['username'] . '-setting'?>"  <?php if ($row['Settings']) echo 'checked'; ?> />
		     			</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-user'?>">
		       				<input type="checkbox" id="<?php echo $row['username'] . '-user'?>"  <?php if ($row['Users'])echo 'checked'; ?> />
		     		  </label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-cust'?>">
		       				<input type="checkbox" id="<?php $row['username'] . '-cust'?>"   <?php if ($row['Customers'])echo 'checked'; ?> />
		     		</label></span></center>
	          </td>
	          <td><center><span><label  for="<?php $row['username'].'-fback'?>">
		       			<input type="checkbox" id="<?php echo $row['username'] . '-fback'?>"  <?php if(isset($row['Feedbacks'])){ if ($row['Feedbacks'])echo 'checked';  }?> />
		     			</label></span></center>
	          </td>
	        </tr>
	        <?php  } ?>
			<tr id="addfield">
	          <form id="newuser" name="newuser" method="post"  action="userPage.php" >
	            <td><center><input type="text" id="username" name="username" placeholder="USERNAME"  style="width: 95px;"></center></td>
	            <td><center><input  type="password" id="password" name="password" placeholder="PASSWORD" style="width: 240px;"></center></td>
	            <td ><center><input  type="text" id="city" name="city" placeholder="CITY" style="width: 80px;" ></center></td>
	            <td><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="delivery_type" name="delivery_type" placeholder="DELIVERY TYPE"  value="0" style="width: 110px;"></center></td>
	            <td><center><input type="checkbox" id="dashboard" name="dashboard"  value="0"  onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="orders" name="orders" value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="creports" name="creports"  value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="sreports" name="sreports"  value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="sprovider" name="sprovider" value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="offers" name="offers" value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="coupons" name="coupons" value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="settings" name="settings" value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="users" name="users" value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="customers" name="customers" value="0" onchange="update_chkbx(this)"></center></td>
	            <td><center><input type="checkbox" id="feedback" name="feedback" value="0" onchange="update_chkbx(this)"></center></td>
	        </tr>
	      </tbody>
	</form>
  </table>
  <div  style="margin-bottom: 60px;">
  <center>
		<button id="plus" class="newUser" name="submit" onclick="addUser()">Add New User</button>
		<button id="saveNewUser" class="newUser" style="display:none;" name="saveNewUser" type="submit" form="newuser" >Save New User</button>
       <button class="changePreference" name="changePreference" type="submit" onclick="changePreference()">Change Preferences</button>
	    <button id="refresh" class="Save" name="submit" type="submit"  onclick="Refresh()">Refresh</button>
		<button  class="changePassword" name="ChangePassword" type="submit"  style="margin-left: calc(100% - 90em)" onclick="changePassword()">Change Password</button>
		<button  class="removeUsr" name="removeUsr" type="submit"   onclick="removeUser()">Remove User</button>
		<button class="Back" name="submit" type="submit"  onclick="back()">Back to Dashboard</button>
		</center>
  </div>
<div id="overlay" class="overlay" onclick="closeOverlay()"></div>
<center><div  id="modal1" class="OverlayBox">
<h2><center>Change Password</center></h2>
<form id="UsrPswd" name="UsrPswd" method="post"  action="userPage.php"> 
<input type="text" id="changeUsername" name="changeUsername"  value=""  placeholder="Enter username" ></br>
<input type="password" id="changePassword" name="changePassword"  value="" placeholder="Enter Password" ></br>
<button type="submit"  class="submitPasswordBtn" name="submitUsrPsw"  value="Change Password" placeholder=""  form="UsrPswd" >Change Password</button></br>
</form> 
</div></center>
<center><div  id="modal2" class="OverlayBox">
<h2><center>Remove the User</center></h2>
<form id="removeUsr" name="removeUsr" method="post"  action="userPage.php"> 
<input type="text" id="removeUsername" name="removeUsername"  value="" placeholder="Enter username" ></br>
<button type="submit"  class="submitUsernameBtn" name="submitUsername"  value="" placeholder="Remove User"  form="removeUsr" >Remove User</button></br>
</form> 
</div></center>
<center><div  id="modal3" class="OverlayBox" style="margin-left:calc(100% - 127%) !important;margin-top:-200px !important;">
<h2><center>Change Preference Settings</center></h2>
<form id="changePref" name="changePref" method="post"  action="userPage.php"> 
<div id="tabs-container">
    <ul class="tabs-menu">
        <li class="current"><a href="#tab-1">User Settings</a></li>
        <li><a href="#tab-2">Access Control 1</a></li>
        <li><a href="#tab-3">Access Control 2</a></li>
        <li><a href="#tab-4">Save & Complete</a></li>
    </ul>
    <div class="tab">
        <div id="tab-1" class="tab-content">
		<table width="100%">
          <tr><td class="tdc"><center><input type="text" id="usernamePref" name="usernamePref"  value=""  placeholder="Enter username" ></center></td></tr>
			<tr><td class="tdc" ><center><input  type="text" id="cityPref" name="cityPref" value="" placeholder="Change City" ></center></td></tr>
	       <tr><td class="tdc"><center><input  type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="delivery_typePref" name="delivery_typePref" value="" placeholder=" Change Delivery Type" ></center></td></tr>
		</table>
	   </div>
        <div id="tab-2" class="tab-content">
		  <table width="100%">
		    <tr><td class="tdc" ><center>Dashboard Access : <input type="checkbox" id="dashboardPref" name="dashboardPref"  value="0"  onchange="update_chkbx(this)"></center></td></tr>
	       <tr><td class="tdc"><center>Order Access : <input type="checkbox" id="ordersPref" name="ordersPref" value="0" onchange="update_chkbx(this)"></center></td></tr>
		   <tr><td class="tdc"><center>S-Report Access : <input type="checkbox" id="sreportsPref" name="sreportsPref"  value="0" onchange="update_chkbx(this)"></center></td></tr>
	        <tr><td class="tdc"><center>C-Report Access : <input type="checkbox" id="creportsPref" name="creportsPref"  value="0" onchange="update_chkbx(this)"></center></td></tr>
			 <tr><td class="tdc"><center>S-Provider Access : <input type="checkbox" id="servicePref" name="servicePref" value="0" onchange="update_chkbx(this)"></center></td></tr>
		</table>
		</div>
        <div id="tab-3" class="tab-content">
		<table width="100%">
		   <tr><td class="tdc"><center>Offers Access : <input type="checkbox" id="offersPref" name="offersPref" value="0" onchange="update_chkbx(this)"></center></td></tr>  
		   <tr><td class="tdc"><center>Coupens Access : <input type="checkbox" id="couponsPref" name="couponsPref" value="0" onchange="update_chkbx(this)"></center></td></tr>
	       <tr><td class="tdc"><center>Setting Access : <input type="checkbox" id="settingsPref" name="settingsPref" value="0" onchange="update_chkbx(this)"></center></td></tr>
	       <tr><td class="tdc"><center>User Access : <input type="checkbox" id="usersPref" name="usersPref" value="0" onchange="update_chkbx(this)"></center></td></tr>
	       <tr><td class="tdc"><center>Customer Access : <input type="checkbox" id="customersPref" name="customersPref" value="0" onchange="update_chkbx(this)"></center></td></tr>
			<tr><td class="tdc"><center>Feedback Access : <input type="checkbox" id="feedbackPref" name="feedbackPref" value="0" onchange="update_chkbx(this)"></center></td></tr>
		 </table>
        </div>
        <div id="tab-4" class="tab-content">
		<table width="100%">
		   <tr><td class="tdc" ><center><p style="margin-top: 50px !important;">All Your Settings are going Save, Hit the Save Button Below </p></br></center></td></tr>
		   <tr><td class="tdc" ><center><input type="submit"  class="submitPrefBtn"  name="submitPrefBtn"  value="Save & Finish" placeholder=""  form="changePref" /></br></center></td></tr>
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
   function changePreference()
   {
	     document.getElementById("overlay").style.display = "block";
		 document.getElementById("modal3").style.display = "block"; 
		 document.getElementById("modal3").style.width = "700px";
		 document.getElementById("modal3").style.height = "400px";
   }
   function removeUser()
   {
	   document.getElementById("overlay").style.display = "block";
		document.getElementById("modal2").style.display = "block";
   }
	function addUser(){
		document.getElementById("addfield").style.display = "table-row";
		document.getElementById("plus").style.display = "none";
		document.getElementById("saveNewUser").style.display = "inline-block";
	}
	function Refresh()
	{
		 window.location = 'userPage.php';
	}
	function back()
	{
		 window.location = 'index.php';
	}
	function changePassword()
	{
		document.getElementById("overlay").style.display = "block";
		document.getElementById("modal1").style.display = "block";
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
	
