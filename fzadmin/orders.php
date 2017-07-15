<?php
include "../conf/config.php";
include "check_login.php";
$_SESSION["actual_link"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$addsql="";
$additionalVars="";
$status="";
$city="";
$dtype="";
?>

<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.1.0/jquery.countdown.js"></script> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Orders</title>
<?php include "styles.php";  ?>
<script>
function set_OrderStatus(id,val) {
setTimeout( function(){
	if (confirm("Are you sure?")) {
	$("#result").load("../conf/post_admin.php?cmd=set_order_status&back=<?php echo $_SERVER['PHP_SELF']; ?>&id="+id+"&val="+val);
}
}, 200); }
function toggleCheckbox(val)
 {
   if (confirm("Do you want Status to be Changed to Delivered ?")) {
	$.ajax({
           type: "POST",
           url: 'midnightScript.php',
           data:{element:val},
           success:function() {
                alert("Status Successfully Changed to Delivered.");
				window.location.reload(1);
           }
      });
}
 }
</script>
</head>
<body>
<?php include "header.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Orders</h1>

 <form id="sss" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"> 
Order Id: <input type="text" name="q" id="q" value="<?php if(isset($_REQUEST['q'])) { echo $_REQUEST['q']; }?>" style="width:67px;" />
 <select name="status" id="status" style="font-size:14px;color:blue;font-weight:bold;width:150px;">
	<option value="0">--- All orders ---</option>
	<?php
	$getRss = mysql_query("SELECT * FROM order_statuses order by id asc");
	while ($rss = mysql_fetch_array($getRss)) {
	?>
	<option value="<?php echo $rss['id']; ?>" <?php if(isset($_REQUEST['status'])) { if ($_REQUEST['status']==$rss['id']) echo "selected";  }?>><?php echo $rss['status']; ?></option>
	<?php } ?>
	</select> 
	<select name="city" id="city" style="font-size:14px;color:blue;font-weight:bold;width:150px">
			<option value="ALL">--- All Cities ---</option>
			<?php
				$getRss = mysql_query("SELECT city FROM order_statuses LIMIT 0,4");
				while ($rcity = mysql_fetch_array($getRss)) {
			?>
			<option value="<?php echo $rcity['city']; ?>" <?php  if(isset($_REQUEST['city'])){ if ($_REQUEST['city']==$rcity['city']) echo "selected";  } ?>><?php echo $rcity['city']; ?></option>
			<?php } ?>
	</select> 
<span>&nbsp;</span>
	<select name="delivery_type" id="delivery_typet" style="font-size:14px;color:blue;font-weight:bold;width:150px">
			<option value="ALL">--- All Deliveries ---</option>
			<?php
				$getRss = mysql_query("SELECT id,delivery_type FROM order_statuses LIMIT 0,2");
				while ($dtype = mysql_fetch_array($getRss)) {
			?>
			<option value="<?php echo $dtype['id']; ?>" <?php  if(isset($_REQUEST['delivery_type'])){ if ($_REQUEST['delivery_type']==$dtype['id']) echo "selected";  } ?>><?php echo $dtype['delivery_type']; ?></option>
			<?php } ?>
	</select> 
<span>&nbsp;&nbsp;</span>
<input style="width:250px;" id="restaurant" name="restaurant"  value="" placeholder="Search Restaurant (Optional)" type="text" class="input-text"> 
<span>&nbsp;</span>
	<input type="submit" value="Search" /> 
	<span>&nbsp;</span>
	<input type="checkbox" id="processOrder" style="cursor:pointer" value="0"  title="Change Status to Delivered" onchange="toggleCheckbox(this.value)"  /> 
</form> 
	
<br />

<table width="100%">
  <tr>
    <td width="20%" class="tdheader">Date/Total</td>
    <td width="28%" class="tdheader">Shipping Address</td>
    <td width="28%" class="tdheader">Order Details</td>
    <td width="24%" class="tdheader" style="text-align:center;">Status</td>
  </tr>
  <?php 
if ( isset($_GET['s']) && $_GET['s'] != ' ')	$start = $_GET['s']; 
else 
$start = 0;
$limit = 15;
@mysql_query("delete from orders where totalprice=0");
if(isset($_REQUEST['q']))
{	
	if ($_REQUEST['q']) {
		$q=safe($_REQUEST['q']);
		$addsql=$addsql." where id=".intval($q)." ";
		$additionalVars.="&q=".$q;
      }
}
if(isset($_REQUEST['status'])|| isset($_REQUEST['city'] )|| isset($_REQUEST['delivery_type']) )
{
		if (!$_REQUEST['q']) {
			   $status = $_REQUEST['status'] ;
				if(isset($_REQUEST['city'] )){  $city = $_REQUEST['city'];  }
				if(isset($_REQUEST['delivery_type'] )){  $dtype = $_REQUEST['delivery_type'];  }
				if(isset($_REQUEST['restaurant'] )){  $restaurant = $_REQUEST['restaurant'];  }
				
		if($restaurant == '')
	 {
			$resid="-1";
			$addsql = edge_multiplexing_sort($status,$city,$dtype,$resid);  // See config/func.php
		}
		else
	 {
					// Get the Restaurant_ID using Restaurant Name
					   $restaurant = trim($restaurant);
					   $restsql=mysql_query("SELECT id FROM rests where name like '%".$restaurant."%' ");
					   $found = mysql_num_rows($restsql);
				if($found > 0)
			{	   
					   while ($rest = mysql_fetch_array($restsql)) {
						   $resid = $rest ['id'];
						}			
						$addsql = edge_multiplexing_sort($status,$city,$dtype,$resid);  // See config/func.php	
			 }
			else
			{ 
				     $addsql=" where status > 9 "; $additionalVars="&status=error"; 
			}			
	 }
		if ($_REQUEST['status'] == "error") { 
					$addsql=" where status > 9 "; $additionalVars="&status=error"; }
			}			
}
$totalResults = getSqlNumber("SELECT id FROM orders".$addsql."");
$sql_query="SELECT * from orders ".$addsql."";
$last=" order by orderdate desc LIMIT ".$start.",".$limit;
if(strcmp($_SESSION['city'],'ALL'))
	$sql_query.=" AND city='".$_SESSION['city']."'";
if($_SESSION['delivery_type']!=0 ) 
	$sql_query.=" AND delivery_type= ".$_SESSION['delivery_type'];
$sql_query .= $last;
$getRs = mysql_query($sql_query);
$count = 0;
while ($rs = @mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
if (!$rs['deliverydate']) $rs['deliverydate']="Right Now";
$need_address=getWhere("order_types","need_address","order_type='".$rs['order_type']."'");
?>
  <tr>
    <td class="<?php echo $class; ?>"><br />

	<b>ID : <?php echo $rs['id']; ?></b>
	<br /><b><?php echo setPrice($rs['order_total']);?></b><br />
	<?php echo getVal("rests","name",$rs['resid']); ?><br />
	Ph: <?php echo getVal("rests","gsm",$rs['resid']); ?><br />
	<?php echo getVal("rests","address",$rs['resid']); ?><br />
	<?php echo getVal("rests","rcity",$rs['resid']); ?><br />
	<?php echo date('g:iA (d-m-y)', strtotime($rs['orderdate'])); ?><br />
<?php if ( $rs['discount'] > 0 ) { ?> Rest. Discount: <?php echo setPrice($rs['discount']);?><br /> <?php  } ?>
<?php if ($rs['delivery_type']==1)
		$output= '<span style = "color:#F44336;font-weight:bold">SELF</span>';
	else
		$output= '<span style = "color: #0000FF;font-weight:bold">EXPRESS</span>';
	?>
	DELIVERY  :  <?php echo $output;?>
	<br/>
<script  src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.countdown.js"></script>	

<div id="getting-started"></div>
<script type="text/javascript">
function getOrderedDate() {
var date = new date();
  return date;
}

function getService() {
  return <?php echo $service_min; ?>; 
}

function getCountDownDate(date, minutes) {
  // return the desired date for the countdown
  return new Date(date.getTime() + minutes * 60000);
}
  var orderdDate = getOrderedDate();
  var service = getService();
  var targetDate = getCountDownDate(orderdDate, service);


  $("#getting-started").countdown(targetDate, function(event) {
      $(this).text(
        event.strftime('%H:%M:%S')
      );
    });
</script>	
	<br /></td>

    <td class="<?php echo $class; ?>"><br />
    Member ID: <a href="user.php?id=<?php echo $rs['userid']; ?>"><?php echo $rs['userid']; ?></a><br />
	Name : <?php echo $rs['name']; ?><br />

	<?php /* ?> <b>Delivery Date:</b>	<?php=$rs['deliverydate']?><br /> <?php */ ?>
	Address: <?php echo nl2br($rs['address']); ?><br /><?php echo $rs['postcode']; ?><br /><?php echo $rs['city']; ?><br />

	Mobile : <?php echo $rs['mobilphone']?>
	<?php if ($rs['order_note']) { ?>
	<br />Order Note : <?php echo nl2br($rs['order_note']);?>
	<?php } ?>
	<br /><br /></td>

    <td class="<?php echo $class; ?>"><br />
	
	<?php
	$order_details="";
$getRss = mysql_query("SELECT * FROM order_details where orderid=".$rs['id']." order by id asc");
	while ($rss = mysql_fetch_array($getRss)) {
		$prod = getSqlField("SELECT name FROM products WHERE id=".$rss['prodid']."","name");
		$order_details.="- ".$rss['qty']." x ".$prod."<br />";
		if ($rss['optionals']) $order_details.="<span style='font-size:10px;line-height:14px;'>".$rss['optionals']."</span>";
	}
	echo $order_details;
	?>
	<br /><br /></td>
    <td class="<?php echo $class; ?>"><br />
    	<?php if($_SESSION['delivery_type']==0){ ?>
	<select name="status" id="status" onchange='set_OrderStatus(<?php echo $rs['id'];?>,this.value);' style="font-size:14px;color:blue;font-weight:bold;">
	<?php
	$getRss = mysql_query("SELECT * FROM order_statuses  order by id asc");
	while ($rss = mysql_fetch_array($getRss)) {
	?>
	<option value="<?php echo $rss['id']?>" <?php    if ($rs['status']==$rss['id']) echo "selected";   ?>><?php echo $rss['status']?></option>
	<?php } ?>
	</select>
	

<br /><br /><?php } ?>
	Order type: <?php echo $rs['order_type']; ?><br />
	Payment: <?php echo $rs['paymenttype']; ?><br />



	<?php if ( strtolower($rs['paymenttype']) !== "cod" ) { ?>
	Payment Status: <?php echo $rs['payment_status'];?><br />
	OP ID: <?php echo $rs['tracking_id'];?><br />
	
	Mode: <?php echo $rs['payment_mode'];?><br />
	Via: <?php echo $rs['card_name'];?><br />
	<?php if($_SESSION['delivery_type']==0 ){ ?>
	Bank Ref.: <?php echo $rs['bank_ref_no'];?><br />
	Paid: <?php echo setPrice($rs['paid_amount']);?>
	<?php } ?>
	<?php } ?>

	<br /><br /></td>
  </tr>
<?php } ?>
</table>
<br />

<div class="pagination">
<ul>
<?php
$status=$_GET['status'];
$city=$_GET['city'];
$dtype=$_GET['delivery_type'];
$restaurant=$_GET['restaurant'];
$additionalVars.="&status=".$status."&city=".$city."&delivery_type=".$dtype."&restaurant=".$restaurant." ";
pages($start,$limit,$totalResults,$_SERVER['PHP_SELF'],$additionalVars);
?>
</ul>
</div>

</div>
</div>

<?php include "footer.php"; ?>

</body>
</html>