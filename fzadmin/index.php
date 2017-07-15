<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<? include "styles.php"; ?>

<style>
ki { color:red; }
</style>

</head>
<body>

<? 
include "header.php"; 
include "sub_home.php"; 
?>

<div id="content">
<div id="container">
<h1 class="h1">Foodzoned Administrator</h1>

<?php $totalr = getSqlNumber("SELECT id FROM rests"); ?>
<?php $totalr2 = getSqlNumber("SELECT id FROM rests where status = 1"); ?>
Service Providers : <ki><?=$totalr2;?> (<?=$totalr;?>)</ki> | 

<?php $totalp = getSqlNumber("SELECT id FROM products"); ?>
Products : <ki><?=$totalp;?></ki> | 

<?php $totalp = getSqlNumber("SELECT id FROM products"); ?>
SMS Balance : <ki><?
$url9 = "http://sms.hspsms.com:/getSMSCredit?username=somilkhicha&apikey=7a487929-63af-4ed1-b387-c07a30aa068e";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url9);
$result = curl_exec($ch);
curl_close($ch);
?></ki> | 

<?php $totalc = getSqlNumber("SELECT id FROM users"); ?>
Customers : <ki><?=$totalc;?></ki>

<br/><br/>
<table>

<tr style="height:28px">
<td><a href="orders.php">Total Orders</a> </td><td> &nbsp; : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=1">Payment Pending</a> </td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 1");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=2">Confirmed</a> </td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 2");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=3">Under Process</a> </td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 3");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=4">Prepared</a></td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 4");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=5">Takeaway Ready</a></td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 5");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=6">On the way</a></td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 6");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=8">Cancelled</a></td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 8");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=error">Errors</a></td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status > 9");?></ki></td>
</tr>

<tr style="height:28px">
<td><a href="orders.php?status=7">Total Delivered</a></td><td> &nbsp;  : </td><td> &nbsp; <ki><?=getSqlNumber("SELECT id FROM orders WHERE status = 7");?></ki></td>
</tr>

</table>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>