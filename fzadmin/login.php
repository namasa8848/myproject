<?
include "../conf/config.php"; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrator Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
    <link href="css/login.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
  <?
    $scr=explode("fzadmin/",$_SERVER['SCRIPT_NAME']); 
    $scr=$scr[1];
    $arr_anasayfa=array("index.php", "cities.php", "streets.php", "payment_types.php");
    $arr_rest=array("rests.php", "reklam_detay.php");
    $arr_reports=array("report_daily.php", "report_most_ordered.php");
  ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 side left hidden-xs">
            <img src="../images/foodlogo.png" class="image">
                <div class="welcome-text">
                        Welcome to<br>
                        Foodzoned<br>
                        Admin Login
                </div>
            </div>
            
            <div class="col-sm-6 side right col-xs-12">
                <form id="myform" name="myform" class="form-group" method="post" action="javascript:void(null);">
                    <input type="hidden" name="cmd" id="cmd" value="sys_login" />
                    <div class="sign-in">
                        Login to your account
                    </div>
                    <div class="input-group">
                        <i class="glyphicon glyphicon-user"></i>
                        <input name="username" id="username" class="input-fields" placeholder="Username" autofocus required="" type="text">
                    </div>
                    <div class="input-group">
                        <i class="glyphicon glyphicon-lock"></i>
                        <input name="password" id="password" class="input-fields" placeholder="Password" required="" autofocus type="password">
                    </div>
                    <button id="sbt" class="btn btn-block" type="submit" onclick="this.disabled=true;post_admin('myform');return false;" >LOGIN</button>
                </form>
            </div>
        </div>
    </div>
    <div id="result"></div>
    <?
        if ($dbh[0] != 0) {
            mysql_close($dbh);
        }
    ?>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.color.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/site-main-fun.js"></script>
  </body>
</html>