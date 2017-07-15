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
    <title>All Delivery Agents Report</title>
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
 <h1 class="h1">
<?php
    function value($box){
    if($box!="1")
      return 0;
    return 1;
  }
   $output="";
   $addsql="";
   $Addsql="";

   if ( $_REQUEST['date'] && $_REQUEST['date']!="custom" || $_REQUEST['date'] && $_REQUEST['date']!="week" ) {
      $addsql=" and date_format(Date,'%Y-%m%-%d')='".safe($_REQUEST['date'])."'";
      $Addsql=" and date_format(orderdate,'%Y-%m%-%d')='".safe($_REQUEST['date'])."'";
    }

    if ($_REQUEST['date']=="month") {
      $addsql=" and date_format(Date,'%Y-%m')='".Date("Y-m")."'";
      $Addsql=" and date_format(orderdate,'%Y-%m')='".Date("Y-m")."'";
    }

    if ($_REQUEST['date']=="last-month") {
      $addsql=" and date_format(Date,'%Y-%m')='".date('Y-m', strtotime('first day of last month'))."'";
      $Addsql=" and date_format(orderdate,'%Y-%m')='".date('Y-m', strtotime('first day of last month'))."'";
    }

    if ($_REQUEST['date']=="week") {
      $addsql=" and date_format(Date,'%Y-%m%-%d')>='".date('Y-m-d', strtotime('Last Monday', time()))."' and date_format(Date,'%Y-%m%-%d')<='".date('Y-m-d', strtotime('This Sunday', time()))."'";
      $Addsql=" and date_format(orderdate,'%Y-%m%-%d')>='".date('Y-m-d', strtotime('Last Monday', time()))."' and date_format(orderdate,'%Y-%m%-%d')<='".date('Y-m-d', strtotime('This Sunday', time()))."'";
    }

    if ($_REQUEST['date']=="custom") {
      $addsql=" and date_format(Date,'%Y-%m%-%d')>='".safe($_REQUEST['start_date'])."' and date_format(Date,'%Y-%m%-%d')<='".safe($_REQUEST['end_date'])."'";
      $Addsql=" and date_format(orderdate,'%Y-%m%-%d')>='".safe($_REQUEST['start_date'])."' and date_format(orderdate,'%Y-%m%-%d')<='".safe($_REQUEST['end_date'])."'";
    }

    $query=mysql_query("SELECT Date, sum(Petrol) as A, sum(Food) as B, sum(Extra) as C, sum(Tips) as D, sum(Advance) as E, sum(Amount_Rcvd_NoTip) as F, sum(Holiday) as G FROM delivery_expense WHERE 1 ".$addsql." GROUP BY Date ORDER BY Date DESC");
?>

</h1>
<?php 
    $date = date("Y-m-d H:i:s");// current date
?>

<form method="get" action="<?=$_SERVER['PHP_SELF']?>">
    <select name="date" id="date" onchange="check_dates(this.value);">
    <option value="">--- All ---</option>
    <option value="<?=date("Y-m-d")?>" <?php if ($_REQUEST['date']==date("Y-m-d")) echo "selected"; ?>>Today</option>
    <?php
    $date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " -1 day");
    $date=Date("Y-m-d",$date);
    ?>
    <option value="<?=$date?>" <?php if ($_REQUEST['date']==$date) echo "selected"; ?>>Yesterday</option>
    <option value="week" <?php if ($_REQUEST['date']=="week") echo "selected"; ?>>This Week</option>
    <option value="month" <?php if ($_REQUEST['date']=="month") echo "selected"; ?>>This month</option>
    <option value="last-month" <?php if ($_REQUEST['date']=="last-month") echo "selected"; ?>>Last month</option>
    <option value="custom" <?php if ($_REQUEST['date']=="custom") echo "selected"; ?>>Custom Date</option>
    </select> <input type="submit" value="List" />
    <br/>
    <div id="div_dates" style="<? if ($_REQUEST['date']!="custom") echo 'display:none;'; ?>">
      <?php
      $date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " -7 day");
      $date=Date("Y-m-d",$date);
      ?>
      <br/>
      <input class="datepicker" type="text" name="start_date" id="start_date" value="<?=($_REQUEST['start_date'])?$_REQUEST['start_date']:$date;?>" style="width:90px;" /> to <input type="text" name="end_date" id="end_date" value="<?=($_REQUEST['end_date'])?$_REQUEST['end_date']:date("Y-m-d");?>" style="width:90px;" /> date format : YYYY-mm-dd
    </div>
<br/>
</form>
<table width="100%">
	<thead>
  	<tr>
    	<td width="8%" class="tdheader"><center>Date</center></td>
			<td width="3%" class="tdheader"><center>Orders</center></td>
		  <td width="8%" class="tdheader"><center>Order Total</center></td>
		  <td width="4%" class="tdheader" ><center>COD</center></td>
			<td width="4%" class="tdheader" ><center>Online</center></td>
			<td width="6%" class="tdheader" ><center>COD Delivery</center></td>
			<td width="6%" class="tdheader" ><center>OP Delivery</center></td>
			<td width="4%" class="tdheader" ><center>Petrol</center></td>
			<td width="4%" class="tdheader" ><center>Food</center></td>
			<td width="6%" class="tdheader" ><center>Extras</center></td>
			<td width="4%" class="tdheader" ><center>EC</center></td>
			<td width="4%" class="tdheader" ><center>Tips</center></td>
			<td width="6%" class="tdheader" ><center>Advances</center></td>
			<td width="4%" class="tdheader" ><center>Holidays</center></td>
			<td width="8%" class="tdheader" ><center>Amount Received without Tips</center></td>
      <td width="8%" class="tdheader" ><center>Amount Received with Tips</center></td>
  	</tr>
 	</thead>
  <tbody>  
    <?php $count=0;  while($row=mysql_fetch_array($query)){ 
      $class=(($count++)%2==0)?"tda":"tdb";
      $COD="SELECT sum(order_total) as A, sum(service_fee) as B from orders WHERE date(orderdate)='".$row['Date']."' and paymenttype='COD and 'status=7 and delivery_type=2";
      $OP="SELECT sum(order_total) as A, sum(service_fee) as B from orders WHERE date(orderdate)='".$row['Date']."' and paymenttype='ONLINE PAYMENT' and status=7 and delivery_type=2";
      $SQL="SELECT count(id) as A, sum(order_total) as B from orders WHERE date(orderdate)='".$row['Date']."' and status=7 and delivery_type=2";
      $a=mysql_query($COD);
      $b=mysql_query($OP);
      $c=mysql_query($SQL);

      $A=mysql_fetch_array($a);
      $B=mysql_fetch_array($b);
      $C=mysql_fetch_array($c);
      $ANT=$row['F']-$row['A']-$row['B']-$row['C'];
    ?>
    <tr  class="<?php echo $class; ?>">
      <td><center><?php echo $row['Date'];?></center></td>
      <td ><center><?php echo $C['A'];?></center></td>
      <td ><center><?php if($C['B']) echo setPrice($C['B']); else echo setPrice(0); ?></center></td>      
      <td ><center><?php if($A['A']) echo setPrice($A['A']); else echo setPrice(0); ?></center></td>      
      <td ><center><?php if($B['A']) echo setPrice($B['A']); else echo setPrice(0); ?></center></td>      
      <td ><center><?php if($A['B']) echo setPrice($A['B']); else echo setPrice(0); ?></center></td>      
      <td ><center><?php if($B['B']) echo setPrice($B['B']); else echo setPrice(0); ?></center></td>      
      <td><center><?php if($row['A']) echo setPrice($row['A']); else echo setPrice(0);?></center></td>
      <td><center><?php if($row['B']) echo setPrice($row['B']); else echo setPrice(0);?></center></td>
      <td><center><?php if($row['C']) echo setPrice($row['C']); else echo setPrice(0);?></center></td>
      <td><center><?php echo "-Blank-" ?></center></td>
      <td><center><?php if($row['D']) echo setPrice($row['D']); else echo setPrice(0);?></center></td>
      <td><center><?php if($row['E']) echo setPrice($row['E']); else echo setPrice(0);?></center></td>
      <td><center><?php if($row['G']) echo $row['G']; else echo "0";?></center></td>
      <td ><center><?php echo $ANT ?></center></td>     
      <td ><center><?php echo $ANT+$row['D']; ?></center></td>    
   </tr>

    <?php  } ?>
    <?php 
      $query=mysql_query("SELECT sum(Petrol) as A, sum(Food) as B, sum(Extra) as C, sum(Tips) as D, sum(Advance) as E, sum(Amount_Rcvd_NoTip) as F, sum(Holiday) as G FROM delivery_expense WHERE 1".$addsql);
      $row=mysql_fetch_array($query);
      $ANT=$row['F']-$row['A']-$row['B']-$row['C'];

      $COD="SELECT sum(order_total) as A, sum(service_fee) as B from orders WHERE status=7 and delivery_type=2".$Addsql." and paymenttype='COD'";
      $OP="SELECT sum(order_total) as A, sum(service_fee) as B from orders WHERE status=7 and delivery_type=2".$Addsql." and paymenttype='ONLINE PAYMENT'";
      $SQL="SELECT count(id) as A, sum(order_total) as B from orders WHERE status=7 and delivery_type=2".$Addsql;
      $a=mysql_query($COD);
      $b=mysql_query($OP);
      $c=mysql_query($SQL);

      $A=mysql_fetch_array($a);
      $B=mysql_fetch_array($b);
      $C=mysql_fetch_array($c);
    ?>
		<tr style="font-weight:bold;">
		   <td><center> Total </center></td>
       <td><center><?php if($C['A']) echo $C['A']; else echo "0";?></center></td>
			 <td><center><?php if($C['B']) echo setPrice($C['B']); else echo setPrice(0);?></center></td>
		   <td><center><?php if($A['A']) echo setPrice($A['A']); else echo setPrice(0);?></center></td>
		   <td><center><?php if($B['A']) echo setPrice($B['A']); else echo setPrice(0);?></center></td>
		   <td><center><?php if($A['B']) echo setPrice($A['B']); else echo setPrice(0);?></center></td>
		   <td><center><?php if($B['B']) echo setPrice($B['B']); else echo setPrice(0);?></center></td>
		   <td><center><?php if($row['A']) echo setPrice($row['A']); else echo setPrice(0);?></center></td>
       <td><center><?php if($row['B']) echo setPrice($row['B']); else echo setPrice(0);?></center></td>
       <td><center><?php if($row['C']) echo setPrice($row['C']); else echo setPrice(0);?></center></td>
       <td><center><?php echo "-Blank-" ?></center></td>
       <td><center><?php if($row['D']) echo setPrice($row['D']); else echo setPrice(0);?></center></td>
       <td><center><?php if($row['E']) echo setPrice($row['E']); else echo setPrice(0);?></center></td>
       <td><center><?php if($row['G']) echo $row['G']; else echo "0";?></center></td>
       <td><center><?php if($ANT) echo setPrice($ANT); else echo setPrice(0);?></center></td>
       <td><center><?php if($ANT + $row['D']) echo setPrice($ANT+$row['D']); else echo setPrice(0);?></center></td>
		</tr>
 </table> 
 
 <button id="back" class="Back" name="submit" type="submit"  onclick="back()">Back to Dashboard</button>



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
		 window.location = 'delagent_report.php';
	}
	function back()
	{
		 window.location = 'index.php';
	}
  function check_dates(val) {
  if (val=="custom") {
    $("#div_dates").show();
  } else {
    $("#div_dates").hide();
  }
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