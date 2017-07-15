<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Service Providers</title>
<? include "styles.php"; ?>
<script>
function Del(id) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_rest&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}
</script>
</head>
<body>

<? include "header.php";
include "sub_rests.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Service Providers</h1>

 <form id="sss" action="<?=$_SERVER['PHP_SELF']?>" method="GET"> 
<input type="text" name="q" id="q" placeholder="City / Service Provider" value="<?=$_REQUEST['q']?>" style="width:230px;" /> <input type="submit" value="Search" />
</form>
<br />
<table width="100%">
  <tr>
    <td class="tdheader">ID</td>
    <td class="tdheader">Sellers</td>
    <td class="tdheader">Mobile</td>
    <td class="tdheader">Comm.</td>
    <td class="tdheader">Priority</td>
    <td class="tdheader">Discount</td>
    <td class="tdheader">Dis. Min.</td>
    <td class="tdheader">Status</td>
    <td class="tdheader">Details</td>
    <td class="tdheader">Region</td>
    <td class="tdheader">Delete</td>
  </tr>
<?
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 30;


if ($_REQUEST['q']) {
	$q=safe($_REQUEST['q']);
	$addsql=" and name like '%".$q."%' or rcity like '%".$q."%' ";
	$additionalVars.="&q=".$q;
}


$totalResults = getSqlNumber("SELECT id FROM rests where status<2 $addsql");
$getRs = mysql_query("SELECT * FROM rests where status<2  $addsql order by id desc LIMIT ".$start.",".$limit." ");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
  <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>">#<?=$rs['id'];?></td>
    <td class="<?=$class?>"><a href="rest-reports.php?date=month&rid=<?=$rs['id'];?>" target="_blank"><?=$rs['name'];?></a></td>
    <td class="<?=$class?>"><?=$rs['gsm'];?></td>
    <td class="<?=$class?>"><?=$rs['fz_comm'];?>%</td>
    <td class="<?=$class?>"><? if( $rs['priority'] == 0 ) { echo " "; }  else { echo $rs['priority'];  } ?></td>
    <td class="<?=$class?>"><? if( $rs['discount'] == 0 ) { echo " "; }  else { echo $rs['discount'] . "%";  } ?></td>
    <td class="<?=$class?>"><? if( $rs['dis_min'] == 0 ) { echo " "; }  else { echo SetPrice($rs['dis_min']); } ?></td>
    <td class="<?=$class?>"><? if( $rs['status'] == 1 ) { echo " "; } else { echo "<font color='red'>Closed</font>"; } ?></td>
    <td class="<?=$class?>"><a href="rest.php?id=<?=$rs['id'];?>">Details</a></td>
    <td class="<?=$class?>"><?=$rs['rcity'];?></td>
    <td class="<?=$class?>"><a href="#" onclick="Del(<?=$rs['id'];?>);">Del</a></td>
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