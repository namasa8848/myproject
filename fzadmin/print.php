<? 
include "../conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Reports</title>
<? include "styles.php"; ?>
<link rel="stylesheet" href="../js/jqueryui/themes/base/jquery.ui.all.css" />
<link rel="stylesheet" href="../css/print.css" media="all"/>
<script src="../js/jqueryui/ui/jquery.ui.core.js"></script> 
<script src="../js/jqueryui/ui/jquery.ui.widget.js"></script> 
<script>
$(document).ready(function(){
  window.print();
});
</script>
</head>
<body>
<?

$rrname = getval( "rests", "name", $_REQUEST['rid'] );
$delivery_type = getval( "rests", "delivery_type", $_REQUEST['rid'] );
$fz_monthly_fee = getval( "rests", "monthly_fee", $_REQUEST['rid'] );

?>
<div class ="header">
	<img src="../img/fz-logo.png">
	<h2>INVOICE</h2>
	<h3><? echo $rrname ?></h3>
</div>
<br><br><br>
<table>
  <tr>
    <td class="tdheader">DATE</td>
    <td class="tdheader right-align">ORDERS</td>
    <td class="tdheader right-align">ORDER TOTAL</td>
    <td class="tdheader right-align">COD</td>
    <td class="tdheader right-align">ONLINE</td>

<? if ( $delivery_type == 2 ) { ?>
    <td class="tdheader right-align">COD DELIVERY</td>
    <td class="tdheader right-align">OP DELIVERY</td>
<? } ?>

    <td class="tdheader right-align" style="padding-right:10px;">FZ COMM.</td>
  </tr>
  <?
  
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

$getRs = mysql_query("SELECT count(id) as order_count,order_total,date_format(orderdate,'%Y-%m%-%d') as repor_date,sum(order_total) as total,sum(CASE WHEN paymenttype = 'COD' THEN order_total ELSE 0 END) AS codtotal,sum(CASE WHEN paymenttype = 'ONLINE PAYMENT' THEN order_total ELSE 0 END) AS optotal,sum(CASE WHEN paymenttype = 'COD' THEN service_fee ELSE 0 END) AS cod_delivery_total,sum(CASE WHEN paymenttype = 'ONLINE PAYMENT' THEN service_fee ELSE 0 END) AS op_delivery_total,sum(fz_fee) AS fz_total from orders where resid=".$_REQUEST['rid']." AND status = '7' $addsql group by repor_date order by orderdate desc ");

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
    <td class="<?=$class?>"><?=date("d-m-Y", strtotime($rs['repor_date']));?></td>
    <td class="<?=$class?> right-align"><?=$rs['order_count'];?></td>
    <td class="<?=$class?> right-align"><?=setPrice($rs['total']);?></td>
    <td class="<?=$class?> right-align"><?=setPrice($rs['codtotal']);?></td>
    <td class="<?=$class?> right-align"><?=setPrice($rs['optotal']);?></td>
<? if ( $delivery_type == 2 ) { ?>
    <td class="<?=$class?> right-align"><?=setPrice($rs['cod_delivery_total']);?></td>
    <td class="<?=$class?> right-align"><?=setPrice($rs['op_delivery_total']);?></td>
<? } ?>
    <td class="<?=$class?> right-align" style="padding-right:10px;"><?=setPrice($rs['fz_total']);?></td>
  </tr>
<? } ?>

  <tr style="font-weight:bold;">
    <td class="tdheader" style="padding-top:6px;">Total</td>
    <td class="tdheader right-align padd"><?=$total_order_count;?></td>
    <td class="tdheader right-align padd"><?=setPrice($total_amount);?></td>
    <td class="tdheader right-align  padd"><?=setPrice($codtotal_all);?></td>
    <td class="tdheader right-align  padd"><?=setPrice($optotal_all);?>	</td>
<? if ( $delivery_type == 2 ) { ?>
    <td class="tdheader right-align  padd"><?=setPrice($all_cod_delivery_total);?></td>
    <td class="tdheader right-align  padd"><?=setPrice($all_op_delivery_total);?></td>
<? } ?>
    <td class="tdheader right-align  padd"><?=setPrice($fz_total_all);?></td>
  </tr>
</table>

<?
$FZQuery = "SELECT fz_comm, monthly_fee FROM rests WHERE id=".$_REQUEST['rid'];
$FZSQL=mysql_query($FZQuery);
$FZResult=mysql_fetch_array($FZSQL);
$rid=$_REQUEST['rid'].".jpg";
$FZValue=($total_amount-$all_cod_delivery_total-$all_op_delivery_total)*$FZResult['fz_comm']/100;

$FZValue1=($total_amount)*$FZResult['fz_comm']/100;
?>

<div class="table-responsive">
	<table>
		<tbody>
			<tr>
				<td>Commision @ <?echo $FZResult['fz_comm']?>%:</td>
				<td class="right-align">
				<? if ( $delivery_type == 2 )
					echo setPrice($FZValue);
				else
					echo setPrice($FZValue1);?></td>
			</tr>
			<tr>
				<td>Monthly:</td>
				<td class="right-align"><?=setPrice($FZResult['monthly_fee']);?></td>
			</tr>
			<tr>
				<td>Total FZ Fee:</td>
				<td class="right-align">
				<? if ( $delivery_type == 2 )
					echo setPrice($FZValue + $FZResult['monthly_fee']);
				else
					echo setPrice($FZValue1 + $FZResult['monthly_fee']);?>
				</td>
			</tr>
			<tr>
				<td>Paid:</td>
				<td class="right-align"><?=setPrice($_REQUEST['paid']);?></td>
			</tr>
			<tr>
				<td>Restaurant Balance:</td>
				<td class="right-align"><?
				if ( $delivery_type == 2 )
				echo setPrice($optotal_all-($FZValue + $FZResult['monthly_fee']+$_REQUEST['paid'])-$all_op_delivery_total);
				else
				echo setPrice($optotal_all-($FZValue1 + $FZResult['monthly_fee']+$_REQUEST['paid']));
				?></td>
			</tr>
		</tbody>
	</table>
</div>
<div class ="foot">
	<img src="../logos/<? echo $rid ?> ">
	<center>
		<h5>
			<b>Khicha eCreations</b><br>
			Eshwar Nagar, Manipal, Karnataka-576104<br>
			Mobile: +91-7204555321, +91-9035515321<br>
			E-mail: care@foodzoned.com<br>
			<b>Thanks for doing bussiness with us!</b>
		</h5>
	</center>
</div>
</body>
</html>