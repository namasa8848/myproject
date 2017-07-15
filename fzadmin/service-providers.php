<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Service Providers</title>
<? include "styles.php"; ?>
<script>
function Del(id) {
if(!confirm('You will delete the record!\nDo you approve?')) return false;
	$("#result").load("../conf/post_admin.php?cmd=del_rest&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}
</script>


    <style type="text/css" title="currentStyle">
                @import "system/service-providers/grid_sytles.css";
                @import "system/service-providers/jquery-ui-1.8.4.custom.css";

    </style>

    <!-- jQuery libs -->
    <script  type="text/javascript" src="system/service-providers/jquery-ui-1.7.custom.min.js"></script>
    <script  type="text/javascript" src="system/service-providers/jquery-search.js"></script>

    <script type="text/javascript">
    var TableBackgroundNormalColor = "#ffffff";
    var TableBackgroundMouseoverColor = "#E0ECF8";
    function ChangeBackgroundColor(row) { row.style.backgroundColor = TableBackgroundMouseoverColor; }
    function RestoreBackgroundColor(row) { row.style.backgroundColor = TableBackgroundNormalColor; }
    </script>

</head>
<body>

<? include "header.php";
include "sub_rests.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Service Providers</h1>




    <div id="dataTable">

        <div class="ui-grid ui-widget ui-widget-content ui-corner-all">


<?php 
$query_par2 = mysql_query("SELECT * FROM search order by region asc");
?>
<select style="width:148px;" id="searchCat" class="input-text">
        <option value="0" selected>ALL REGIONS</option>
        <?php while($row = mysql_fetch_array($query_par2)): ?>
        <option value="<?php echo $row['region'];?>"><?php echo $row['region'];?></option>
        <?php endwhile; ?>
</select> 

&nbsp; &nbsp; 
<input style="width:300px;" id="searchData" placeholder="Search using Name / Mobile" type="text" class="input-text" autofocus>

<br/><br/>

            <table class="ui-grid-content ui-widget-content cStoreDataTable" id="cStoreDataTable">
                <thead>

  <tr>
    <th class="ui-state-default">ID</th>
    <th class="ui-state-default">Seller</th>
    <th class="ui-state-default">Mobile</th>
    <th class="ui-state-default">Comm.</th>
    <th class="ui-state-default">Sort</th>
    <th class="ui-state-default">Discount</th>
    <th class="ui-state-default">Dis. Min.</th>
    <th class="ui-state-default">Shipping</th>
    <th class="ui-state-default">Status</th>
    <th class="ui-state-default">Region</th>
  </tr>
                </thead>
                <tbody id="results"></tbody>
            </table>

        </div>
    </div>



<br /><br />

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>