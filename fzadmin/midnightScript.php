<?php
include "../conf/config.php";

if($_POST['element'] == "0") {
 $query = mysql_query("update orders set status=7 where status=2 and id>2000");
}

?>