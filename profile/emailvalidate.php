<?php
include('../conn.php');
$email=$_POST['email'];
$x=0;


$sql="SELECT * FROM profiling_tb WHERE email = '$email';;";
$posta = mysqli_query($con,$sql);
$row=mysqli_fetch_array($posta);
if($email==($row['email']) ){
$x=2;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$x=1;
}

echo $x;
?>