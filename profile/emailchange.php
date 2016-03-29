<?php
include('../conn.php');
$email=$_POST['email'];
$id=$_POST['id'];
$x=0;

$sql="UPDATE profiling_tb SET email='$email' WHERE id='$id'";
$query=mysqli_query($con,$sql);
$x=1;

echo $x;

?>