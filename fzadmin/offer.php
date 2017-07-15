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

<? include "header.php";
?>

<div id="content">
<div id="container">
<h1 class="h1">
<? if (!$_REQUEST['id']) {
	echo "New Offer";
} else {
	echo "Edit Offer";
}
?>
</h1>


<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="save_offer" />
<input type="hidden" name="id" id="id" value="<?=$rs['id']?>">
<table width="600" style="line-height:30px;">

  <tr>
    <td>Status</td>
    <td><input type="radio" name="status" id="status" value="1" <? if ($rs['status']==1) echo "checked"; ?>> Active &nbsp; &nbsp; 
	<input type="radio" name="status" id="status" value="0" <? if ($rs['status']==0) echo "checked"; ?>> De-active</td>
  </tr>

  <tr>
    <td><br/>Offer Priority (optional)</td>
    <td><br/><input type="text" name="priority" id="priority" value="<?=$rs['priority']?>" style="width:80px;background:#dedede;" maxlength="11"></td>
  </tr>

  <tr>
    <td><br/>Seller ID</td>
    <td><br/><input type="text" name="resid" id="resid" value="<?=$rs['resid']?>" style="width:80px;background:#dedede;" maxlength="11"> &nbsp;&nbsp; (<a href="rests.php" target="_blank">Click here to get Seller ID</a>)</td>
  </tr>

  <tr>
    <td><br/>Offer Title</td>
    <td><br/><input type="text" name="name" id="name" value="<?=$rs['name']?>" style="width:400px;background:#dedede;" maxlength="300"> *</td>
  </tr>

  <tr>
    <td style="vertical-align:top;"><br/>Description</td>
    <td>
	<br/><textarea name="details" id="details" style="width:400px;height:100px;background:#dedede;"><?=$rs['details']?></textarea>
	</td>
  </tr>


  <tr>
    <td></td>
    <td><input type="submit" name="sbt" id="sbt" value="Submit" style="font-size:16px;margin-top:15px;" onclick='this.disabled=true; post_admin("myform"); return false;'></td>
  </tr>
</table>
</form>
</div>
</div>

<? include "footer.php"; ?>

</body>
</html>