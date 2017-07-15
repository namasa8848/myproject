<? 
include "../conf/config.php";
include "check_login.php";
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Send Notification</title>
<? include "styles.php"; ?>

</head>
<body>

<? include "header.php"; ?>

<div id="content">
<div id="container">

<h1 class="h1">Notification (EMAIL & SMS)</h1>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="send_notification" />

<input type="text" name="orderid" id="orderid" placeholder="Order ID" value="" maxlength="100" > &nbsp; &nbsp;

<input type="submit" name="sbt" id="sbt" value="Send Notification" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;'> &nbsp; <span id="span_count"></span>

</form>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>