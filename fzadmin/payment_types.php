<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Payment Types</title>
<? include "styles.php"; 	?>

<script LANGUAGE="JavaScript" TYPE="text/javascript">
function Del(id) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_payment_type&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}
</script>

</head>
<body>

<? 
include "header.php"; 
include "sub_home.php"; 
?>

<div id="content">
<div id="container">
<h1 class="h1">Payment Types</h1>
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="add_payment_type" />
<input type="text" name="paymenttype" id="paymenttype" style="width:350px" /><input type="submit" name="sbt" id="sbt" value="Add" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;'>
</form>
<br />
<table width="400">
  <tr>
    <td width="90%" class="tdheader">Type</td>
    <td width="10%" class="tdheader">Del</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM paymenttypes order by paymenttype asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=$rs['paymenttype'];?></td>
    <td class="<?=$class?>"><a href="#" onclick="Del(<?=$rs['id'];?>);">Del</a></td>
  </tr>
<? } ?>
</table>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>