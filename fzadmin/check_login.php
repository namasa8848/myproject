<?php
if ($_SESSION['sysarea']!="Active") {
    echo "<script>document.location.href='login.php'</script>";
    exit;
}
?>