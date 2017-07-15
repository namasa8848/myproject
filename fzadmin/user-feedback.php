<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Feedback</title>
	<? include "styles.php"; ?>
</head>
<body>

<? 
include "header.php";
?>

<div id="content">
<div id="container">
<h1 class="h1">Feedback</h1>

<table width="100%">
  <tr>
    <td width="10%" class="tdheader">Date</td>
    <td width="10%" class="tdheader">Type</td>
    <td width="30%" class="tdheader">Name & Details</td>
    <td width="50%" class="tdheader">Message</td>
  </tr>
<?
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 20;


$totalResults = getSqlNumber("SELECT id FROM feedback");
$getRs = mysql_query("SELECT * FROM feedback order by fdate desc LIMIT ".$start.",".$limit." ");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
  <tr>

<td class="<?=$class?>"><?=$rs['fdate'];?></td>

<td class="<?=$class?>">
<? if ( $rs['type'] == "1" ) { echo "General"; } else if ( $rs['type'] == "2" ) { echo "Suggestion"; } else { echo "Problem"; } ?>
</td>

<td class="<?=$class?>"><?=$rs['name'];?><br/>From: <?=$rs['city'];?><br/><?=$rs['email'];?><br/>Mobile: <?=$rs['mobile'];?></td>

<td class="<?=$class?>"><?=$rs['message'];?></td>
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