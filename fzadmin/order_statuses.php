<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Order Statuses</title>
<? include "styles.php"; ?>

<script LANGUAGE="JavaScript" TYPE="text/javascript">
function Del(id) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_order_status&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}

</script>

</head>
<body>

<? 
include "header.php"; 
include "sub_home.php"; 
if ($_REQUEST['id']) {
	$rss=getSqlRow("select * from order_statuses where id=".safe($_REQUEST['id'])."");
}
?>

<div id="content">
<div id="container">
<h1 class="h1">Order Statuses</h1>

ID 1: must be new order, ID 9: must be deleted

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="add_order_status" />
<input type="hidden" name="id" id="id" value="<?=$rss['id']?>" />
<input type="text" name="status" id="status" value="<?=$rss['status']?>" style="width:350px" /><input type="submit" name="sbt" id="sbt" value="Save" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;'>
</form>
<br />
<table width="400">
  <tr>
    <td width="90%" class="tdheader">Status</td>
    <td width="10%" class="tdheader">Del</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM order_statuses order by id asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>">#<?=$rs['id'];?> <a href="<?=$_SERVER['PHP_SELF']?>?id=<?=$rs['id'];?>"><?=$rs['status'];?></a></td>
    <td class="<?=$class?>"><<? if ($rs['id']==9 || $rs['id']==1) echo "/";?>a href="#" onclick="Del(<?=$rs['id'];?>);">Del</a></td>
  </tr>
<? } ?>
</table>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>