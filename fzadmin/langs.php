<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Languages</title>
<? include "styles.php"; 	?>

<script LANGUAGE="JavaScript" TYPE="text/javascript">
function Del(lang) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_lang&back=<?=$_SERVER['PHP_SELF']?>&lang="+lang);
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
<h1 class="h1">Languages</h1>
Please don't use space etc.
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="add_lang_name" />
<input type="text" name="lang" id="lang" style="width:350px" /><input type="submit" name="sbt" id="sbt" value="Add" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;'>
</form>
<br />
<table width="400">
  <tr>
    <td width="90%" class="tdheader">Language</td>
    <td width="10%" class="tdheader">Del</td>
  </tr>
<?
$getRs = mysql_query("SHOW COLUMNS FROM langs");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
if ($rs['Field']!="id" && $rs['Field']!="name") {
?>
   <tr id="tr_<?=$rs['Field'];?>">
    <td class="<?=$class?>"><?=$rs['Field'];?></td>
    <td class="<?=$class?>"><<? if ($rs['Field']=="en") echo "/"; ?>a href="#" onclick="Del('<?=$rs['Field'];?>');">Del</a></td>
  </tr>
<? } 
}
?>
</table>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>