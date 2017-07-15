<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Language Texts</title>
<? include "styles.php"; ?>
</head>

<body>

<? 
include "header.php"; 
include "sub_home.php"; 
?>

<div id="content">
<div id="container">
<h1 class="h1">Language Texts</h1>
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="save_langs" />
<table width="700">
  <tr>
    <td width="200" class="tdheader">Code</td>
    <td width="400" class="tdheader">Value</td>
  </tr>
<?
$langs_arr=array();
$getRs = mysql_query("SHOW COLUMNS FROM langs");
while ($rs = mysql_fetch_array($getRs)) {
    if ($rs['Field']!="id" && $rs['Field']!="name") {
        array_push($langs_arr,$rs['Field']);
    }
}


$getRs = mysql_query("SELECT * FROM langs order by id asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>" style="vertical-align:top;"><?=$rs['name'];?></td>
    <td class="<?=$class?>">
    <? foreach ($langs_arr as $lang_name) { ?>
    <?=$lang_name?>:<br /><textarea name="opt_<?=$lang_name;?>_<?=$rs['id'];?>" id="opt_<?=$lang_name;?>_<?=$rs['id'];?>" style="width:400px;height:35px;"><?=$rs[$lang_name];?></textarea><br />
    <? } ?>
    </td>
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