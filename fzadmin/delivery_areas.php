<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Delivery Areas</title>
<? include "styles.php"; ?>

<script LANGUAGE="JavaScript" TYPE="text/javascript">
function Del(id) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_area&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}

</script>

</head>
<body>

<? 
include "header.php"; 
include "sub_home.php"; 
if ($_REQUEST['id']) {
	$rss=getSqlRow("select * from delivery_areas where id=".safe($_REQUEST['id'])."");
}
?>

<div id="content">
<div id="container">
<h1 class="h1">Delivery Areas</h1>


<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="save_area" />
<input type="hidden" name="id" id="id" value="<?=$rss['id']?>" />


<?php 
$query_parent = mysql_query("SELECT DISTINCT region FROM search order by region asc");
?>
        City &nbsp; <select class="input-text" type="text" name="region" id="region" style="width:203px;"> 
        <option value="">Select City</option>
        <?php while($row = mysql_fetch_array($query_parent)): ?>
        <option value="<?=$row['region'];?>" <? if($rss['region']==$row['region']) { echo "selected"; }?>><?=$row['region'];?></option>
        <?php endwhile; ?>
        </select>

 &nbsp; &nbsp; Area  &nbsp; <input type="text" name="city" id="city" value="<?=$rss['city']?>" style="width:150px;" />
 &nbsp; &nbsp; Pincode  &nbsp; <input type="text" name="zip" id="zip" value="<?=$rss['zip']?>" style="width:80px;" maxlength="10" onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' /> &nbsp; &nbsp; 
<input type="submit" name="sbt" id="sbt" value="Save" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;'>

</form>
<br />
<table width="100%">
  <tr>
    <td width="30%" class="tdheader">Region</td>
    <td width="30%" class="tdheader">Area</td>
    <td width="30%" class="tdheader">Pincode</td>
    <td width="10%" class="tdheader">Del</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM delivery_areas order by region,city,zip asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=$rs['region'];?></td>
    <td class="<?=$class?>"><?=$rs['city'];?></td>
    <td class="<?=$class?>"><a href="<?=$_SERVER['PHP_SELF']?>?id=<?=$rs['id'];?>"><?=$rs['zip'];?></a></td>
    <td class="<?=$class?>"><a href="#" onclick="Del(<?=$rs['id'];?>);">Del</a></td>
  </tr>
<? } ?>
</table>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>