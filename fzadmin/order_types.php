<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Order Types</title>
<? include "styles.php"; 	?>

<script LANGUAGE="JavaScript" TYPE="text/javascript">
function Del(id) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_order_type&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
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
<h1 class="h1">Order Types</h1>
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="add_order_type" />
<input type="text" name="order_type" id="order_type" style="width:350px" /><select name="need_address" id="need_address"><option value="1">Need address</option><option value="0">Don't need address</option></select><input type="submit" name="sbt" id="sbt" value="Add" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;'>
</form>
<br />
<table width="400">
  <tr>
    <td width="90%" class="tdheader">Type</td>
    <td width="10%" class="tdheader">Del</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM order_types order by order_type asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=$rs['order_type'];?> (<?=($rs['need_address'])?"Need addres":"Don't need addres";?>)</td>
    <td class="<?=$class?>"><a href="#" onclick="Del(<?=$rs['id'];?>);">Del</a></td>
  </tr>
<? } ?>
</table>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>