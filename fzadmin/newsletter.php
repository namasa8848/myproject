<? 
include "../conf/config.php";
include "check_login.php"; 

if ($_REQUEST['cmd']=="reset") {
	$_SESSION['nid']="";
	echo "Newsletter sending started!";
	exit;
}

if ($_REQUEST['cmd']=="send") {
	if (!$_SESSION['nid']) {
		$rs=getSqlRow("SELECT * FROM users order by id asc");
		$_SESSION['nid']=$rs['id'];
	} else {
		$rs=getSqlRow("SELECT * FROM users where id>".$_SESSION['nid']." order by id asc");
		$_SESSION['nid']=$rs['id'];
	}
	
	if (!$rs['id']) {
		echo "<font color=green><b>Newsletter sending finished!</b></font>";
		echo "<script>StopSender();</script>";
	} else {
		echo $rs['email']." sended";
		
		$sender=$GLOBALS['email'];
		$to=$rs['email'];
		$reply=$GLOBALS['email'];
		$subject=$_REQUEST['subject'];		
		$msg=nl2br($_REQUEST['details']);

		$mailheaders= "Content-Type: text/html; charset=utf-8" . "\n";
		$mailheaders.="Return-path: $sender <$sender>\n";
		$mailheaders.="From:  <$sender>\n";
		$mailheaders.="Reply-To: ".$reply."\n";
		$mailheaders.="X-Mailer: php/" . phpversion()."\n";
		$mailheaders.="X-Return-Path: $sender\n";
		@mail($to,$subject,$msg,$mailheaders);	

	}
	exit;
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Newsletter</title>
<? include "styles.php"; ?>

<script>
 var Timer = "";
 
function reset_nid() {
	if (!$('#subject').val()) {
	  	alert("You did not write the subject!");
	  	$('#subject').focus();
	  	return false;
	  } else if (!$('#details').val()) {
	  	alert("You did not write the details!");
	  	$('#details').focus();
	  	return false;
	  } else {
		$.ajax({
			type: 'POST',
			url: '<?=$_SERVER['REQUEST_URI']?>',
			data: 'cmd=reset',
			success: function(result) {
				$('#span_count').html(result);
			}
		});
		xajax.$('sbt').disabled=true;
		StartSender();
	}
	return false;
} 
 
function send() {

	$.ajax({
		type: 'POST',
		url: '<?=$_SERVER['REQUEST_URI']?>',
		data: $('#myform').serialize(),
		success: function(result) {
			$('#span_count').html(result);
		}
	});
	
	return false;
}


function StartSender()
{
  	Timer = setInterval("send()",1000);
}

function StopSender()
{
  clearInterval(Timer);
}

</script>

</head>
<body>

<? include "header.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Newsletter</h1>
<?
$totalCustumers = getSqlNumber("SELECT id FROM users");
?>
You have <?=$totalCustumers?> custemer/s
<br /><br />

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="send" />
<table width="100%" style="line-height:30px;">
  <tr>
    <td width="20%">Subject</td>
    <td width="80%"><input type="text" name="subject" id="subject" value="" style="width:700px;" maxlength="100" /></td>
  </tr>
  <tr>
    <td width="20%" style="vertical-align:top;"><br />Details</td>
    <td width="80%"><br /><textarea name="details" id="details" style="width:700px;height:150px;"></textarea></td>
  </tr>

<!-- 

  <tr>
    <td></td>
    <td><br /><input type="submit" name="sbt" id="sbt" value="Send Message" style="font-size:14px;" onclick='this.disabled=true; xajax_Send_News(xajax.getFormValues("myform")); return false;' />&nbsp; <span id="span_countaa"></span></td>
  </tr>
 -->
    <tr>
    <td></td>
    <td><br /><input type="submit" name="sbt" id="sbt" value="Send Message" style="font-size:14px;" onclick='reset_nid();' />&nbsp; <span id="span_count"></span></td>
  </tr>

  </table>
</form>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>