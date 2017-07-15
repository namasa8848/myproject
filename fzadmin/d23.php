<? 
include "../conf/config.php";
include "check_login.php"; 


if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$varmi = getSqlNumber("SELECT id FROM offers WHERE id=".$id."");
	if ($varmi==0) {
		echo "<script>document.location.href='offers.php'</script>";
		exit;
	}
	$rs=getSqlRow("SELECT * FROM offers WHERE id=".$id."");
}

if (!$id) {
	$rs['priority']="0";
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title><? if ($_REQUEST['id']) { ?>Edit Offer<? } else { ?>New Offer<? } ?></title>
<? include "styles.php"; ?>

</head>
<body>

<?
$getRs = mysql_query("SELECT * FROM products where resid=21 order by id asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>

<?=$rs['id'];?> <?=$rs['name'];?> <?=$rs['price'];?><br/>
<?
$price = "10" + $rs['price'];
$price .= ".00";
echo $price;
?>

<br/>
<? } ?>


</body>
</html>