<?php
include('../conn.php');
$uname=$_POST['username'];
$x=0;
if (!preg_match("/^[a-zA-Z0-9]*$/",$uname)) {
$x=1;
}

$sql1="SELECT * FROM profiling_tb WHERE username = '$uname';;";
$posta1 = mysqli_query($con,$sql1);
$row1=mysqli_fetch_array($posta1);
if($uname==($row1['username']) ){
$cod='err';
$x=2;
}
echo $x;
?>
