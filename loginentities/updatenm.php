<?php
$id=$_POST['id'];
$fname=$_POST['fname'];
$mname=$_POST['mname'];
$lname=$_POST['lname'];
$gen=$_POST['gen'];
include('../conn.php');

$sql="UPDATE profiling_tb SET first_name='$fname',middle_name='$mname',last_name='$lname',gender='$gen' WHERE id='$id'";
$query=mysqli_query($con,$sql);

echo 1;


?>