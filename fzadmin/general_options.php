<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>General Options</title>
<? include "styles.php"; ?>

</head>
<body>

<? 
include "header.php"; 
include "sub_home.php"; 
?>

<div id="content">
<div id="container">
<h1 class="h1">General Options</h1>
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="save_options" />
<table width="650">
  <tr>
    <td width="200" class="tdheader">Option name</td>
    <td width="400" class="tdheader">Option value</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM options order by id asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>" style="vertical-align:top;"><?=$rs['option_name'];?></td>
    <td class="<?=$class?>"><textarea name="opt_<?=$rs['id'];?>" id="opt_<?=$rs['id'];?>" style="width:400px;height:35px;"><?=$rs['option_value'];?></textarea></td>
  </tr>
<? } ?>
<tr>
<td></td>
<td><input type="submit" name="sbt" id="sbt" value="Save options" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;' /></td>
</tr>
</table>

</form>
</div>
</div>

<? include "footer.php"; ?>

</body>
</html>