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
    <title>Delivery Expense</title>
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
	if(isset($_POST['GetData'])){		
		$query=mysql_query("SELECT * FROM agent_login WHERE user_id='".$_POST['Loginid']."'");
		if(mysql_num_rows($query)<1)
			$output="<script> $('#cnfmbox').fadeIn('slow').delay(2000).fadeOut('fast'); $('.msg').html('No Agent Exists !');  setTimeout( function(){ Refresh(); }, 15000); </script>";
		$row=mysql_fetch_array($query);
	}	
	?>
<header class="dashboard_head"> <div><h2> Delivery Expense DashBoard </h2> </div></header>	
<table width="100%">
	<thead>
  <tr>
    <td width="8%" class="tdheader"><center>Name</center></td>
    <td width="3%" class="tdheader"><center>Login ID</center></td>
    <td width="8%" class="tdheader"><center>Password</center></td>
    <td width="8%" class="tdheader" ><center>GSM</center></td>
    <td width="8%" class="tdheader" ><center>City</center></td>
    <td width="8%" class="tdheader" ><center>Salary</center></td>  
  </tr>
  </thead>
       <tbody>
			<tr id="upfield">
	          <form id="updateagent" name="updateagent" method="post"  action="agents.php" >
	            <td ><center><input  type="text" id="Name" name="Name" value=<?php echo $row['Name']; ?> style="width: 80px;" ></center></td>
              <td><center><input type="text" id="Loginid" name="Loginid" value=<?php echo $row['user_id']; ?>  style="width: 80px;"></center></td>
              <td><center><input  type="text" id="Password" name="Password" value=<?php echo $row['password']; ?> style="width: 80px;"></center></td>
              <td><center><input  type="text" id="GSM" name="GSM" value=<?php echo $row['gsm']; ?> style="width: 80px;"></center></td>
              <td><center><input  type="text" id="City" name="City" value=<?php echo $row['City']; ?> style="width: 180px;"></center></td>
              <td><center><input  type="text" id="Salary" name="Salary" value=<?php echo $row['Salary']; ?> style="width: 80px;"></center></td>
	        </tr>
	      </tbody>
	</form>
  </table>
  <div  style="margin-bottom: 60px;">
    <center>
		<button id="updateAgent" class="newUser" name="updateAgent" type="submit" form="updateagent" >Update Agent</button>
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
 	function Refresh()
	{
		 window.location = 'agents.php';
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
	
