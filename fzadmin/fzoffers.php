<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Foodzoned Offers</title>
<? include "styles.php"; ?>
<script>
function Del(id) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_offer&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}
</script>
</head>
<body>

<? include "header.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Offers</h1>

 <form id="sss" action="<?=$_SERVER['PHP_SELF']?>" method="GET"> 
<input type="text" name="q" id="q" placeholder="" value="<?=$_REQUEST['q']?>" style="width:230px;" /> <input type="submit" value="Search" />
</form>
<br />
<table width="100%">
  <tr>
    <td class="tdheader">ID</td>
    <td class="tdheader">Priority</td>
    <td class="tdheader">Restaurant</td>
    <td class="tdheader" width="30%">Offer</td>
    <td class="tdheader">City</td>
    <td class="tdheader">Status</td>
    <td class="tdheader">Details</td>
  </tr>
<?
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 30;


if ($_REQUEST['q']) {
	$q=safe($_REQUEST['q']);
	$addsql=" and name like '%".$q."%'";
	$additionalVars.="&q=".$q;
}


$totalResults = getSqlNumber("SELECT id FROM offers where status<2 $addsql");
$getRs = mysql_query("SELECT * FROM offers where status<2  $addsql order by id desc LIMIT ".$start.",".$limit." ");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
  <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>">#<?=$rs['id'];?></td>
    <td class="<?=$class?>"><?=$rs['priority'];?></td>
    <td class="<?=$class?>"><?=getval( "rests", "name", $rs['resid'] );?></td>
    <td class="<?=$class?>"><?=$rs['name'];?></td>
    <td class="<?=$class?>"><?=getval( "rests", "rcity", $rs['resid'] );?></td>
    <td class="<?=$class?>"><? if ( $rs['status'] == 1 ) { echo "ON"; } else { echo "OFF"; };?></td>
    <td class="<?=$class?>"><a href="offer.php?id=<?=$rs['id'];?>">Details</a> | <a href="#" onclick="Del(<?=$rs['id'];?>);">Del</a></td>
  </tr>
  
<? } ?>
</table>
<br />
<div class="pagination">
<ul>
<?
pages($start,$limit,$totalResults,$_SERVER['PHP_SELF'],$additionalVars);
?>
</ul>
</div>
</div>
</div>

<? include "footer.php"; ?>

</body>
</html>