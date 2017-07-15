<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Reports</title>
<? include "styles.php";?>

<link rel="stylesheet" href="../js/jqueryui/themes/base/jquery.ui.all.css" /> 
<script src="../js/jqueryui/ui/jquery.ui.core.js"></script> 
<script src="../js/jqueryui/ui/jquery.ui.widget.js"></script> 
<script src="../js/jqueryui/ui/jquery.ui.datepicker.js"></script> 
<script>
$(function() {
	$( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	$( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
});

function check_dates(val) {
	if (val=="custom") {
		$("#div_dates").show();
	} else {
		$("#div_dates").hide();
	}
}
</script>

</head>

<body>
<? include "header.php";
include "sub_reports.php"; ?>

<div id="content">
<div id="container">


<?
/* Condition Start */
if( !$_REQUEST['rid'] )
{
?>

<h1 class="h1">Service Provider Report</h1>
<form method="get" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="date" id="date" value="month">
Seller ID : <input type="text" name="rid" id="rid" style="width:80px;"> &nbsp; &nbsp; 
<input type="submit" value="VIEW REPORT" />
</form>

<? } else { 
$rrname = getval( "rests", "name", $_REQUEST['rid'] );
$delivery_type = getval( "rests", "delivery_type", $_REQUEST['rid'] );
$fz_monthly_fee = getval( "rests", "monthly_fee", $_REQUEST['rid'] );
$fz_city = getval('rests', 'rcity', $_REQUEST['rid']);
if((!(strcmp($fz_city,$_SESSION['city'])==0 ||strcmp($_SESSION['city'],'ALL')==0)) || !($_SESSION['delivery_type']==$delivery_type || $_SESSION['delivery_type']==0)){
?>
<h1 class="h1">Service Provider Report</h1>
<form method="get" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="date" id="date" value="month">
Seller ID : <input type="text" name="rid" id="rid" style="width:80px;"> &nbsp; &nbsp; 
<input type="submit" value="VIEW REPORT" />
</form>
<?
echo 'Access Denied';
} else { ?>
<h1 class="h1">
<a href="<?=$_SERVER['PHP_SELF']?>"><i class="fa fa-chevron-circle-left fa-1x"></i></a>
<?

if ( $rrname !== "" )
{ echo " " . $rrname . " <br/><small>FZ Commission: " . getval( "rests", "fz_comm", $_REQUEST['rid'] ) ."% | Delivery: "; }

if( $delivery_type == 1 ) { echo "Self"; } else if( $delivery_type == 2 ) { echo "<font color='blue'>FZ Express</font>"; } else { echo "<font color='red'>None</font>"; }

if( $fz_monthly_fee !== "0.00" )
{ echo " | Monthly Fee: " . setPrice($fz_monthly_fee);}

echo "</small>";
?>
</h1>

<?
$date = date("Y-m-d H:i:s");// current date
?>
<form method="get" action="<?=$_SERVER['PHP_SELF']?>">

Service Provider ID : <input type="text" name="rid" id="rid" value="<?=$_REQUEST['rid']?>" style="width:50px"> &nbsp; &nbsp; 

<select name="date" id="date" onchange="check_dates(this.value);">
<option value="">--- All ---</option>
<option value="<?=date("Y-m-d")?>" <? if ($_REQUEST['date']==date("Y-m-d")) echo "selected"; ?>>Today</option>
<?
$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " -1 day");
$date=Date("Y-m-d",$date);
?>
<option value="<?=$date?>" <? if ($_REQUEST['date']==$date) echo "selected"; ?>>Yesterday</option>
<option value="week" <? if ($_REQUEST['date']=="week") echo "selected"; ?>>This Week</option>
<option value="month" <? if ($_REQUEST['date']=="month") echo "selected"; ?>>This month</option>
<option value="last-month" <? if ($_REQUEST['date']=="last-month") echo "selected"; ?>>Last month</option>
<option value="custom" <? if ($_REQUEST['date']=="custom") echo "selected"; ?>>Custom Date</option>
</select> <input type="submit" value="List" />
<br />

<div id="div_dates" style="<? if ($_REQUEST['date']!="custom") echo 'display:none;'; ?>">
<?
$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " -7 day");
$date=Date("Y-m-d",$date);
?>
<br/>
<input class="datepicker" type="text" name="start_date" id="start_date" value="<?=($_REQUEST['start_date'])?$_REQUEST['start_date']:$date;?>" style="width:90px;" /> to <input type="text" name="end_date" id="end_date" value="<?=($_REQUEST['end_date'])?$_REQUEST['end_date']:date("Y-m-d");?>" style="width:90px;" /> date format : YYYY-mm-dd
</div>
<br/>
</form>
<form method="get" action = "print.php">
	<input type="hidden" name = "date" value ="<? echo $_REQUEST['date'] ?>">
	<input type="hidden" name="rid" value="<? echo $_REQUEST['rid'] ?>">
	<? if(isset($_REQUEST['start_date'])){ ?>
	<input type="hidden" name="start_date" value="<? echo $_REQUEST['start_date'] ?>">
	<input type="hidden" name="end_date" value="<? echo $_REQUEST['end_date'] ?>">
	<? } ?>
	<input type="text" name="paid">
	<input type="submit" value="Print">
</form>
<br/>
<br/>
<table width="100%" style="margin-top:10px;">
  <tr>
    <td width="25%" class="tdheader">DATE</td>
    <td class="tdheader" style="text-align:right;">ORDERS</td>
    <td class="tdheader" style="text-align:right;">ORDER TOTAL</td>
    <td class="tdheader" style="text-align:right;">COD</td>
    <td class="tdheader" style="text-align:right;">ONLINE</td>

<? if ( $delivery_type == 2 ) { ?>
    <td class="tdheader" style="text-align:right;">COD DELIVERY</td>
    <td class="tdheader" style="text-align:right;">OP DELIVERY</td>
<? } ?>

    <td class="tdheader" style="text-align:right;padding-right:10px;">FZ COMM.</td>
  </tr>
  <?
  
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 50;


if ( $_REQUEST['date'] && $_REQUEST['date']!="custom" || $_REQUEST['date'] && $_REQUEST['date']!="week" ) {
	$addsql=" and date_format(orderdate,'%Y-%m%-%d')='".safe($_REQUEST['date'])."'";
}

if ($_REQUEST['date']=="month") {
	$addsql=" and date_format(orderdate,'%Y-%m')='".Date("Y-m")."'";
}

if ($_REQUEST['date']=="last-month") {
	$addsql=" and date_format(orderdate,'%Y-%m')='".date('Y-m', strtotime('first day of last month'))."'";
}

if ($_REQUEST['date']=="week") {
	$addsql=" and date_format(orderdate,'%Y-%m%-%d')>='".date('Y-m-d', strtotime('Last Monday', time()))."' and date_format(orderdate,'%Y-%m%-%d')<='".date('Y-m-d', strtotime('This Sunday', time()))."'";
}

if ($_REQUEST['date']=="custom") {
	$addsql=" and date_format(orderdate,'%Y-%m%-%d')>='".safe($_REQUEST['start_date'])."' and date_format(orderdate,'%Y-%m%-%d')<='".safe($_REQUEST['end_date'])."'";
	$additionalVars.="&start_date=".$_REQUEST['start_date'];
	$additionalVars.="&end_date=".$_REQUEST['end_date'];
}


$additionalVars.="&date=".$_REQUEST['date'];


$totalResults = getSqlNumber("SELECT id,date_format(orderdate,'%Y-%m%-%d') as repor_date FROM orders where resid=".$_REQUEST['rid']." and status = '7' $addsql group by repor_date");

$getRs = mysql_query("SELECT count(id) as order_count,order_total,date_format(orderdate,'%Y-%m%-%d') as repor_date,sum(order_total) as total,sum(CASE WHEN paymenttype = 'COD' THEN order_total ELSE 0 END) AS codtotal,sum(CASE WHEN paymenttype = 'ONLINE PAYMENT' THEN order_total ELSE 0 END) AS optotal,sum(CASE WHEN paymenttype = 'COD' THEN service_fee ELSE 0 END) AS cod_delivery_total,sum(CASE WHEN paymenttype = 'ONLINE PAYMENT' THEN service_fee ELSE 0 END) AS op_delivery_total,sum(fz_fee) AS fz_total from orders where resid=".$_REQUEST['rid']." AND status = '7' $addsql group by repor_date order by orderdate desc LIMIT ".$start.",".$limit." ");

while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";

$total_amount=$total_amount+$rs['total'];
$total_order_count=$total_order_count+$rs['order_count'];
$codtotal_all=$codtotal_all+$rs['codtotal'];
$optotal_all=$optotal_all+$rs['optotal'];
$fz_total_all=$fz_total_all+$rs['fz_total'];

$all_cod_delivery_total = $all_cod_delivery_total + $rs['cod_delivery_total'];
$all_op_delivery_total = $all_op_delivery_total + $rs['op_delivery_total'];

?>
  <tr>
    <td class="<?=$class?>">
	<?=date("d-m-Y", strtotime($rs['repor_date']));?>
	</td>
    <td class="<?=$class?>" style="text-align:right;">
	<?=$rs['order_count'];?>
	</td>
    <td class="<?=$class?>" style="text-align:right;">
	<?=setPrice($rs['total']);?>
	</td>
    <td class="<?=$class?>" style="text-align:right;">
	<?=setPrice($rs['codtotal']);?>
	</td>
    <td class="<?=$class?>" style="text-align:right;">
	<?=setPrice($rs['optotal']);?>
	</td>
<? if ( $delivery_type == 2 ) { ?>
    <td class="<?=$class?>" style="text-align:right;">
	<?=setPrice($rs['cod_delivery_total']);?>
	</td>
    <td class="<?=$class?>" style="text-align:right;">
	<?=setPrice($rs['op_delivery_total']);?>
	</td>
<? } ?>
    <td class="<?=$class?>" style="text-align:right;padding-right:10px;">
	<?=setPrice($rs['fz_total']);?>
	</td>
    
  </tr>
<? } ?>

  <tr style="font-weight:bold;">
    <td class="" style="padding-top:6px;">
		Total
	</td>
    <td class="" style="text-align:right;padding-top:6px;">
	<?=$total_order_count;?>
	</td>
    <td class="" style="text-align:right;padding-top:6px;">
	<?=setPrice($total_amount);?>
	</td>
    <td class="" style="text-align:right;padding-top:6px;">
	<?=setPrice($codtotal_all);?>
	</td>
    <td class="" style="text-align:right;padding-top:6px;">
	<?=setPrice($optotal_all);?>
	</td>
<? if ( $delivery_type == 2 ) { ?>
    <td class="" style="text-align:right;padding-top:6px;">
	<?=setPrice($all_cod_delivery_total);?>
	</td>
    <td class="" style="text-align:right;padding-top:6px;">
	<?=setPrice($all_op_delivery_total);?>
	</td>
<? } ?>
    <td class="" style="text-align:right;padding-right:10px;padding-top:6px;">
	<?=setPrice($fz_total_all);?>
	</td>
    
  </tr>

</table>
<br />
<div class="pagination">
<ul>
<?
pages($start,$limit,$totalResults,$_SERVER['PHP_SELF'],$additionalVars);
?>
</ul>
</div>

<?
}}
/* Condition End */
?>
</div>
</div>


<? include "footer.php"; ?>

</body>
</html>