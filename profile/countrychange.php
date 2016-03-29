<?php
include('../conn.php');
$count=$_POST['count'];
$id=$_POST['id'];
$x=0;

$sql="UPDATE profiling_tb SET country='$count' WHERE id='$id'";
$query=mysqli_query($con,$sql);
$x=1;

echo $x;

?>