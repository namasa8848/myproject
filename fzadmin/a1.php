<?
$scr=explode("fzadmin/",$_SERVER['SCRIPT_NAME']); 
$scr=$scr[1];
$arr_anasayfa=array("index.php", "cities.php", "streets.php", "payment_types.php");
$arr_rest=array("rests.php", "reklam_detay.php");
$arr_reports=array("report_daily.php", "report_most_ordered.php");
$adminLevelSQL="SELECT * FROM adminUsers WHERE username='".$_SESSION['username']."'";
$adminLevelQuery=mysql_query($adminLevelSQL);
$row=mysql_fetch_assoc($adminLevelQuery);
?>

      <div class="fz-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="header">
          <img src="http://www.beta.foodzoned.com/img/logo.png" class="fz-logo-image">
          <div class="admin-name">
            Hey, <?=$_SESSION['username'] ?>!
          </div>
        </header>
        <nav class="mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="index.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Dashboard</a>
          <a class="mdl-navigation__link" href="orders.php?q=&status=2"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">store</i>Orders</a>
          <a class="mdl-navigation__link" href="company-report.php?date=month"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">receipt</i>Reports</a>
          <a class="mdl-navigation__link" href="service-providers.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">business_center</i>Service Providers</a>
          <a class="mdl-navigation__link" href="offer.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">loyalty</i>Offers</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">local_activity</i>Coupons</a>
          <a class="mdl-navigation__link" href="general_options.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Settings</a>
          <a class="mdl-navigation__link" href="userList.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Users</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link" href="customers.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">face</i>Customers</a>
        </nav>
      </div>

	