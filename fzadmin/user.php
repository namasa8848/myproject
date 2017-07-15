<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Customers</title>
	<? include "styles.php"; ?>
</head>
<body>

<? 
include "header.php";
?>

<div id="content">
<div id="container">

<div style="float:left;width:45%;">

<h1 class="h1">Member</h1>

<?
if ( !$_REQUEST['id'] )
{ echo "No user found."; }
else
{
$mid = $_REQUEST['id'];
$rs=getSqlRow("SELECT * FROM users WHERE id ='".$mid."'");
if ( $rs['id'] == "" )
{ echo "No user found."; }
else
{
$mid2 = $_REQUEST['id'];
?>

<table>
<tr>
<td style="width:140px;height:25px;" class="t22">Member ID</td><td style="width:20px;"> : </td><td><?=$rs['id'];?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">Name</td><td> : </td><td><?=$rs['name'];?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">Email</td><td> : </td><td><?=$rs['email'];?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">Mobile</td><td> : </td><td><?=$rs['mobilphone'];?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">Gender</td><td> : </td><td><?=$rs['gender'];?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">DOB</td><td> : </td><td><?=date("d-m-Y", strtotime($rs['dob']));?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">City</td><td> : </td><td><?=$rs['city'];?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">Company</td><td> : </td><td><?=$rs['company'];?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">Phone</td><td> : </td><td><?=$rs['phone'];?></td><tr>
<tr><td style="width:140px;height:30px;" class="t22">Reg. Date</td><td> : </td><td><?=date("d-m-Y g:i A", strtotime($rs['regdate']));?></td>
<tr>
<tr>
<td style="width:140px;height:25px;" class="t22">Reg. Type</td><td> : </td><td>
<? if ( $rs['fb_id'] == "0" ) { echo "Email"; } else { echo "Facebook"; } ?></td><tr>
<tr><td style="width:140px;height:25px;" class="t22">Verified</td><td> : </td><td>
<? if ( $rs['verify'] == "" ) { echo "Yes"; } else { echo "No"; } ?></td>
<tr>

</table>

<? } } ?>

</div>
<div style="float:left;width:50%;">

<? if ( $mid2 ) { ?>
<h1 class="h1">Order History</h1>
<?
$totalR = getSqlNumber("SELECT id FROM orders WHERE userid='" . $mid2 ."'");
$query = mysql_query("SELECT * FROM orders WHERE userid='" . $mid2 ."' order by id desc LIMIT 15");
?>
Total Orders : <?=$totalR?><br/><br/>

<table width="600px">
<tr><th class="tdheader">OID</th><th class="tdheader">Date</th><th class="tdheader">Total</th><th class="tdheader">Status</th></tr>

<?php
$sl=1;
while($row = mysql_fetch_array($query)) {
$class=(($count++)%2==0)?"tda":"tdb";
echo "<tr>";
echo "<td class='" . $class . "'><a href='orders.php?q=" . $row[id] . "'>#" . $row[id] . "</a></td>";
echo "<td class='" . $class . "'>" . date("d/m/Y - g:iA", strtotime($row[orderdate])) . "</td>";
echo "<td class='" . $class . "'>" . setPrice($row[order_total]) . "</td>";
echo "<td class='" . $class . "'>" . getVal("order_statuses","status",$row['status']) . "</td>";
echo "</tr>";
$sl++;
}
?>
</table>

<? } ?>

<br/><br/><br/>

</div>

</div>
</div>


<? include "footer.php"; ?>

</body>
</html>