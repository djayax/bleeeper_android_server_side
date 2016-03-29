<?php
include('../conn.php');

$email=$_POST['email'];
$uname=$_POST['username'];
$pass=MD5($_POST['password']);
$date1=date("Y-m-d H:i:s");

$sql123="INSERT INTO profiling_tb (email,username,password,date)VALUES('$email','$uname','$pass','$date1');";
$res = mysqli_query($con,$sql123);
$x=null;

$sql222="SELECT * FROM profiling_tb WHERE  email = '$email'";
$res222 = mysqli_query($con,$sql222);
$result=mysqli_fetch_array($res222);
$x=$result['id'];

echo $x;
mysqli_close($con);

?>