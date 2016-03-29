<?php
$id=$_POST['id'];
$dob=$_POST['dob'];
include('../conn.php');

$sql="UPDATE profiling_tb SET date_of_birth='$dob' WHERE id='$id'";
$query=mysqli_query($con,$sql);

echo 1;


?>