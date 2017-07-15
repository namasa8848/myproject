 <?php
    include "../conf/config.php";
    include "check_login.php";    
  ?>
  <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Delivery Agent Report</title>
<?php include "styles.php";  ?>
  <style>
 .dashboard_head { margin-top:-6% !important;} 
.tdheader {
	  line-height: 38px !important; 
  }
 .tda , .tdb {
	   line-height: 50px !important;
 }
.tdc {
	   line-height: 10px !important;
	   padding:10px;
}	    

.overlay{
  display:none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10;
  background-color: rgba(0,0,0,0.5); /*dim the background*/
}
.overlayBox{
	 display:none;
    width: 300px;
    height: 300px;
    line-height: 200px;
    position: fixed;
    top: 50%; 
    left: 50%;
    margin-top: -150px;
    margin-left: -150px;
    background-color: #fff;
	 box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 5px;
    text-align: center;
    z-index: 11; /* 1px higher than the overlay layer */
	overflow: hidden;  /* Hide the Scroll Bar */
}
.tabs-menu {
    height: 30px;
    float: left;
    clear: both;
	margin-left: 10px;
}
.tabs-menu li {
    height: 30px;
    line-height: 30px;
    float: left;
    margin-right: 10px;
    background-color: #ccc;
    border-top: 1px solid #d4d4d1;
    border-right: 1px solid #d4d4d1;
    border-left: 1px solid #d4d4d1;
}
.tabs-menu li.current {
    position: relative;
    background-color: #fff;
    border-bottom: 1px solid #fff;
    z-index: 5;
}
.tabs-menu li a {
    padding: 10px;
    text-transform: uppercase;
    color: #fff;
    text-decoration: none; 
}

.tabs-menu .current a {
    color: #2e7da3;
}
.tab {
    border: 1px solid #d4d4d1;
    background-color: #fff;
    float: left;
    margin-bottom: 20px;
	margin-top: -10px;
    width: auto;
}
.tab-content {
    width: 700px;
    padding: 5px;
    display: none;
    height: 305px;
}
#tab-1 {
 display: block;   
}
</style>	
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 </head>
 <body>

	<div id="beg">
		<header class="dashboard_head"> <div><h2> Delivery Agent Report </h2> </div></header>	
		<h1 class="h1">Service Provider Report</h1>
		<form method="post" action="delagent_report1.php" >
			<input type="hidden" name="date" id="date" value="month">
			Agent ID : <input type="text" name="rid" id="rid" style="width:80px;">
			<input id="rep" type="submit" value="VIEW REPORT" name="rep" />
		</form>
	</div>

   <script>
  
  $(document).ready(function() {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    }); 
});
	
	function Refresh()
	{
		 window.location = 'delagent_report.php';
	}
	function back()
	{
		 window.location = 'index.php';
	}
	function closeOverlay()
	{
		document.getElementById("overlay").style.display = "none";
		document.getElementById("modal1").style.display = "none";
		document.getElementById("modal2").style.display = "none";
		document.getElementById("modal3").style.display = "none";
	}
  </script>
</body>
</html> 