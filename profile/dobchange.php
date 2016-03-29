<?php
include('../conn.php');
$dob=$_POST['dob'];
$id=$_POST['id'];
$x=0;

$sql="UPDATE profiling_tb SET date_of_birth='$dob' WHERE id='$id'";
$query=mysqli_query($con,$sql);
$x=1;

echo $x;

?>