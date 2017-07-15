<?
include "../conf/config.php";
include "check_login.php";
header('Content-Type: application/json');
$query='SELECT * FROM adminUsers';
$sql=mysql_query($query);
$row=array();
$data=array();
$i=0;
while($row=mysql_fetch_row($sql)){
    $data['data'][$i]['username']=$row[0];
    $data['data'][$i]['password']=$row[1];
    $data['data'][$i]['City']=$row[2];
    $data['data'][$i]['Delivery_Type']=$row[3];
    $data['data'][$i]['Dashboard']=$row[4];
    $data['data'][$i]['Orders']=$row[5];
    $data['data'][$i]['Service Reports']=$row[6];
    $data['data'][$i]['Company Reports']=$row[7];
    $data['data'][$i]['Service Provider']=$row[8];
    $data['data'][$i]['Offers']=$row[9];
    $data['data'][$i]['Coupons']=$row[10];    
    $data['data'][$i]['Settings']=$row[11];
    $data['data'][$i]['Users']=$row[12];
    $data['data'][$i]['Customers']=$row[13];
    $data['data'][$i]['Feedbacks']=$row[14];
    $i++;
}
echo json_encode($data);
?>