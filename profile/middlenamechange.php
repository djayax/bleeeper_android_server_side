<?php
include('../conn.php');
$name=$_POST['name'];
$id=$_POST['id'];
$x=0;

$sql="UPDATE profiling_tb SET middle_name='$name' WHERE id='$id'";
$query=mysqli_query($con,$sql);
$x=1;

echo $x;

?>