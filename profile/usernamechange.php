<?php
include('../conn.php');
$uname=$_POST['username'];
$id=$_POST['id'];
$x=0;

$sql="UPDATE profiling_tb SET username='$uname' WHERE id='$id'";
$query=mysqli_query($con,$sql);

$x=1;

echo $x;

?>