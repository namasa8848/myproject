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
    <title>Daily Agent Expense</title>
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
#gdfield {
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
	$SQL="";
	if(isset($_POST['saveNewUser'])) // Add New User
	{
		$GDATE=new DateTime($_POST['date']);
		$query=mysql_query("SELECT agent_id FROM delivery_expense WHERE Date='".$GDATE->format('Y-m-d')."' and agent_id='".$_POST['agentid']."' ");
		if(mysql_num_rows($query)>0)
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Agent ID Already Exists !'); </script>";
		else{
			$SQL="SELECT sum(service_fee) as A from orders WHERE date(orderdate)='".$_POST['date']."' and status_agent='Delivered:".$_POST['agentid']."' and paymenttype='COD'";
			$result=mysql_query($SQL);
			$row=mysql_fetch_array($result);

			$addsql="";
			if(isset($_POST['holi'])&& value($_POST['holi'])=="1" ) 
				$addsql=$addsql.intval(value($_POST['holi']));  
			else  
				$addsql=$addsql.intval("0"); 

			$str = "INSERT INTO delivery_expense VALUES(NULL,'".$_POST['agentid']."','".$_POST['date']."','".$_POST['petrol']."','".$_POST['food']."','".$_POST['extra']."','".$_POST['extrac']."','".$_POST['tip']."','".$_POST['advance']."','".$row['A']."',".$addsql." )";
				$result =mysql_query($str);
				if($result)
					$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Delivery Expense Added!'); </script>";
				else
					$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Insertion Failed!'); </script>";
		}
	}
	if(isset($_POST['updateNewUser'])) // Update User
	{
		$GDATE=new DateTime($_POST['date']);
		$addsql="";
			if(isset($_POST['holi'])&& value($_POST['holi'])=="1" ) 
				$addsql=$addsql.intval(value($_POST['holi']));  
			else  
				$addsql=$addsql.intval("0"); 
		$str = "UPDATE delivery_expense SET Petrol=".$_POST['petrol'].", Food=".$_POST['food'].", Extra=".$_POST['extra'].", Extra_Comments='".$_POST['extrac']."', Tips=".$_POST['tip'].", Advance=".$_POST['advance'].", Holiday=".$addsql." WHERE agent_id=".$_POST['agentid']." and Date='".$GDATE->format('Y-m-d')."'";
		$result =mysql_query($str);
		if($result>0)
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Delivery Report Updated!');  </script>";
		else
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('Update Failure!');  </script>";
		$SQL="SELECT * from delivery_expense WHERE agent_id=".$_POST['agentid'].";";
	}

		$result=mysql_query($SQL);
	?>
<header class="dashboard_head"> <div><h2> Daily Delivery Agent Expense </h2> </div></header>	
<table width="100%">
	<thead>
  <tr>
    <td width="8%" class="tdheader"><center>Agent ID</center></td>
	<td width="3%" class="tdheader"><center>Date</center></td>
    <td width="8%" class="tdheader"><center>Petrol</center></td>
    <td width="8%" class="tdheader" ><center>Food</center></td>
    <td width="8%" class="tdheader" ><center>Extra</center></td>
    <td width="8%" class="tdheader" ><center>Extra Comments</center></td>
    <td width="8%" class="tdheader" ><center>Tips</center></td>
    <td width="8%" class="tdheader" ><center>Advance</center></td>
    <td width="8%" class="tdheader" ><center>Holiday</center></td>
  </tr>
  </thead>
       <tbody>
			<tr id="addfield">
	          <form id="newuser" name="newuser" method="post"  action="delexp.php" >
	            <td><center><input type="text" id="agentid" name="agentid" placeholder="Agent ID"  style="width: 80px;"></center></td>
	            <td><center><input  type="date" id="date" name="date" placeholder="Date" style="width: 180px;"></center></td>
	            <td ><center><input  type="text" id="petrol" name="petrol" placeholder="Petrol" style="width: 80px;" ></center></td>
	            <td><center><input  type="text" id="food" name="food" placeholder="Food" style="width: 80px;"></center></td>
	            <td><center><input  type="text" id="extra" name="extra" placeholder="Extra" style="width: 80px;"></center></td>
	            <td><center><input  type="text" id="extrac" name="extrac" value="None" style="width: 180px;"></center></td>
	            <td><center><input  type="text" id="tip" name="tip" placeholder="Tips" style="width: 80px;"></center></td>
	            <td><center><input  type="text" id="advance" name="advance" placeholder="Advance" style="width: 80px;"></center></td>
	            <td><center><input type="checkbox" id="holi" name="holi" value="0" onchange="update_chkbx(this)"></center></td>
	        </tr>
	        </form>
	        <tr id="gdfield">
	          <form id="upuser" name="upuser" method="post"  action="update_delagent.php" >
	            <td><center><input type="text" id="agentid" name="agentid" placeholder="Agent ID"  style="width: 80px;"></center></td>
	            <td><center><input  type="date" id="date" name="date" placeholder="Date" style="width: 180px;"></center></td>
	        </tr>
	        </form>
	      </tbody>
	</form>
  </table>
  <div  style="margin-bottom: 60px;">
  <center>
		<button id="plus" class="newUser" name="submit" onclick="addUser()">Add New Delivery</button>
		<button id="edit" class="newUser" name="sbmit" onclick="editUser()">Edit Delivery</button>
		<button id="back" class="Back" name="submit" type="submit"  onclick="back()">Back to Dashboard</button>
		<button id="saveNewUser" class="newUser" style="display:none;" name="saveNewUser" type="submit" form="newuser" >Save New Delivery</button>
		<button id="GetData" class="newUser" style="display:none;" name="GetData" type="submit" form="upuser" onclick="GetData()">Get Values</button>
  </center>
  </div>
<div id="overlay" class="overlay" onclick="closeOverlay()"></div>
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
	function addUser(){
		document.getElementById("addfield").style.display = "table-row";
		document.getElementById("plus").style.display = "none";
		document.getElementById("edit").style.display = "none";
		document.getElementById("back").style.display = "none";
		document.getElementById("GetData").style.display = "none";
		document.getElementById("saveNewUser").style.display = "inline-block";
	}
	function editUser(){
		document.getElementById("gdfield").style.display = "table-row";
		document.getElementById("edit").style.display = "none";
		document.getElementById("plus").style.display = "none";
		document.getElementById("back").style.display = "none";
		document.getElementById("GetData").style.display = "none";
		document.getElementById("GetData").style.display = "inline-block";
	}
	function GetData(){
		document.getElementById("gdfield").style.display = "none";
		document.getElementById("upfield").style.display = "table-row";
		document.getElementById("edit").style.display = "none";
		document.getElementById("back").style.display = "none";		
		document.getElementById("plus").style.display = "none";
		document.getElementById("GetData").style.display = "none";
		document.getElementById("updateNewUser").style.display = "inline-block";
	}
	function Refresh()
	{
		 window.location = 'delexp.php';
	}
	function back()
	{
		 window.location = 'index.php';
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
	
