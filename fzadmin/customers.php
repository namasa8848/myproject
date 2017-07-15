<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Customers</title>
	<? include "styles.php"; ?>
</head>
<body>

<? 
include "header.php";
?>

<div id="content">
<div id="container">
<h1 class="h1">Customers</h1>

 <form id="sss" action="<?=$_SERVER['PHP_SELF']?>" method="GET"> 
<input type="text" name="q" placeholder="Name / Mobile / Email" id="q" value="<?=$_REQUEST['q']?>" style="width:200px;" /> <input type="submit" value="Search" />
</form>
<br />

<table width="100%">
  <tr>
    <td width="30%" class="tdheader">Name</td>
    <td width="30%" class="tdheader">Email</td>
    <td width="20%" class="tdheader">Mobile</td>
    <td width="20%" class="tdheader">Reg. Date</td>
  </tr>
<?
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 25;


if ($_REQUEST['q']) {
	$q=safe($_REQUEST['q']);
	$addsql=" and name like '%".$q."%' OR mobilphone like '%".$q."%' OR email like '%".$q."%'";
	$additionalVars.="&q=".$q;
}


$totalResults = getSqlNumber("SELECT id FROM users where status<2 $addsql");
$getRs = mysql_query("SELECT * FROM users where status<2  $addsql order by id desc LIMIT ".$start.",".$limit." ");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>

  <tr>
    <td class="<?=$class?>"><a href="user.php?id=<?=$rs['id']?>"><?=$rs['name'];?></a></td>
    <td class="<?=$class?>"><?=$rs['email'];?></td>
    <td class="<?=$class?>"><?=$rs['mobilphone'];?></td>
    <td class="<?=$class?>"><?=$rs['regdate'];?></td>
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