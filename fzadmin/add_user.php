<? 
include "../conf/config.php";
include "check_login.php";
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>
		Add User
	</title>
	<? include "styles.php"; ?>
</head>
<body>
	<?

	function value($box){
		if($box!="1")
			return 0;
		return 1;
	}
	$output="";
	if(isset($_POST['submit'])){
		$checkSQL=mysql_query("SELECT username FROM adminUsers WHERE username='".$_POST['username']."'");
		if(mysql_num_rows($checkSQL)>0)
			$output="Username exists!";
		else if(strlen($_POST['username']) <4 || strlen($_POST['password'])<6)
			$output="Username or Password is small";
		else{ 
			$str = "INSERT INTO adminUsers VALUES('".$_POST['username']."','". md5($_POST['password'])."','".strtoupper($_POST['city'])."',".$_POST['delivery_type'].",". value($_POST['dashboard']).", ".value($_POST['orders']).", ".value($_POST['coupons']).", ".value($_POST['reports']).", ".value($_POST['creports']).", ".value($_POST['service']).",". value($_POST['offers']).",". value($_POST['settings']).",". value($_POST['users']).",". value($_POST['customers']).",". value($_POST['feedback']).")";
			$result =mysql_query($str);
			$output="New User Added!";
		}
	}
	
	?>

	<? include "header.php";?>
	
	<div id="content">
		<div id="container">
			<h1 class="h1">Add User</h1>
			<form id="myform" name="myform" method="post" action="add_user.php">
				Username:  <input type="text" name="username"><br><br>
				Password: &nbsp;  <input type="password" name="password"><br><br>
				City(Name/ALL):  <input type='text' name='city'><br><br>
				Delivery Type(0/1/2): <input type="text" name="delivery_type"><br><br>
				<input type="checkbox" name="dashboard" value="1"> Dashboard<br><br>
				<input type="checkbox" name="orders" value="1"> Orders<br><br>
				<input type="checkbox" name="reports" value="1"> Service Reports<br><br>
				<input type="checkbox" name="creports" value="1"> Company Reports<br><br>
				<input type="checkbox" name="service" value="1"> Service<br><br>
				<input type="checkbox" name="offers" value="1"> Offers<br><br>
				<input type="checkbox" name="coupons" value="1"> Coupons<br><br>
				<input type="checkbox" name="settings" value="1"> Settings<br><br>
				<input type="checkbox" name="users" value="1"> Users<br><br>
				<input type="checkbox" name="customers" value="1"> Customers<br><br>
				<input type="checkbox" name="feedback" value="1"> Feedback<br><br>
				<input type="submit" name="submit" value="Submit"><br><br>
			</form>
			<div>
				<? echo $output ?>
			</div>
		</div>
	</div>
	
	<? include "footer.php"; ?>

</body>
</html>