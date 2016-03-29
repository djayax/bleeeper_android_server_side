<?php
$email=$_POST['email'];
$uname=$_POST['username'];
$pass=MD5($_POST['password']);
$date1=date("Y-m-d H:i:s");
include('../conn.php');
$x=0;


//validating email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$x=1;

}
//validating username
if (!preg_match("/^[a-zA-Z0-9]*$/",$uname)) {
$x=2;
}


$sql="SELECT * FROM profiling_tb WHERE email = '$email';;";
$posta = mysqli_query($con,$sql);
$row=mysqli_fetch_array($posta);
if($email==($row['email']) ){

$x=3;
}

$sql1="SELECT * FROM profiling_tb WHERE username = '$uname';;";
$posta1 = mysqli_query($con,$sql1);
$row1=mysqli_fetch_array($posta1);
if($uname==($row1['username']) ){
$cod='err';
$x=4;
}
echo $x;
mysqli_close($con);
?>