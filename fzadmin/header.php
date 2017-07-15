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


    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">FOODZONED.com</a>
            </div>
            <!-- /.navbar-header -->



            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
					
<? if ($_SESSION['sysarea']=="Active") { ?>
			<? if ($row['Dashboard']==1){ ?>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li><? } ?>
			<? if ($row['Orders']==1){ ?>
                        <li><a href="orders.php?q=&status=2&city=ALL&delivery_type=ALL&restaurant="><i class="fa fa-edit fa-fw"></i> Orders<? if($_SESSION['delivery_type']==0){ ?>  (<?=getSqlNumber("SELECT id FROM orders where status = 2");?>)<? } ?></a></li><? } ?>
			<? if ($row['Service Reports']==1 || $row['Company Reports']==1){ ?>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
			<? if ($row['Company Reports']==1){ ?>
                            <li><a href="company-report.php?date=month">Company Report</a></li><? } ?>
                            <? if ($row['Service Reports']==1){ ?>
                            <li><a href="rest-reports.php">Service Providers Report</a></li><? } ?>
                            <? if ($row['Company Reports']==1){ ?>
                            <li><a href="report_most_ordered.php">Most Ordered Products</a></li><? } ?>
									<? if ($row['Coupon Reports']==1){ ?>
                            <li><a href="couponReport.php?date=month">Coupon Report</a></li><? } ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li><? } ?>
			<? if ($row['Service Provider']==1){ ?>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Service Provider<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <li><a href="rest.php">Add Service Provider</a></li>
                            <li><a href="service-providers.php">Service Providers List</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li><? } ?>
			<? if ($row['Offers']==1){ ?>
                        <li>
                            <a href="#"><i class="fa fa-gift fa-fw"></i> Offers<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <li><a href="offer.php">New Offer</a></li>
                            <li><a href="fzoffers.php">Promotions List</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li><? } ?>
                        <? if ($row['Coupons']==1){ ?>
                        <li>
                            <a href="#"><i class="fa fa-gift fa-fw"></i> Coupons<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <li><a href="couponPage.php">New Coupon</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li><? } ?>
						    <? if ($row['Users']==1){ ?>	
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Users<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <li><a href="userPage.php"></i>User Dashboard</a></li>
                            </ul>
                        </li><? } ?>
			<? if ($row['Settings']==1){ ?>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Settings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="general_options.php">General Options</a></li>
                                <li><a href="delivery_areas.php">Delivery Areas</a></li>				
                                <li><a href="payment_types.php">Payment Types</a></li>
                                <li><a href="order_types.php">Order Types</a></li>
                                <li><a href="order_statuses.php">Order Statuses</a></li>
                                <li><a href="langs.php">Languages</a></li>
                                <li><a href="lang_texts.php">Language Texts</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li><? } ?>
			<? if ($row['Customers']==1){ ?>	
                        <li><a href="customers.php"><i class="fa fa-files-o fa-fw"></i> Customers</a></li><? } ?>
            <? if ($row['Agent']==1){ ?>    
                       <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Delivery<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="agents.php">Agent Dashboard</a></li>
                                <li><a href="allagent_report.php?date=month">Delivery Report</a></li>
                                <li><a href="delagent_report.php">Delivery Agent Report</a></li>
                                <li><a href="delexp.php">Daily Delivery Agent Expenses</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li><? } ?>
			<? if ($row['Feedbacks']==1){ ?>
                        <li><a href="user-feedback.php"><i class="fa fa-users fa-fw"></i> Feedbacks (<?=getSqlNumber("SELECT id FROM feedback");?>)</a></li>
			<? } ?>
                        <li><a href="logout.php"><i class="fa fa-user fa-fw"></i> Logout</a></li>
						<? } ?>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">