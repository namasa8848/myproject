<?
include "../conf/config.php";
include "check_login.php";
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<? include "styles.php"; ?>
</head>
<body>
<? 
include "header.php"; 
include "sub_home.php"; 
?>

<div id="content">
<div id="container">
	<h1>
		Welcome, <?php echo $_SESSION['username'] ?>!
	</h1>
	<?php echo "<br>Redirecting ... Please Wait ! <br>"; ?>
	 <script>setTimeout(function(){ document.location.href='index.php'; }, 1000)</script>
</div>
<? include "footer.php"; ?>
</div>
</body>
</html>