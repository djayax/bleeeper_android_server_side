<?php
include('../conn.php');
$gen=$_POST['gen'];
$id=$_POST['id'];
$x=0;

$sql="UPDATE profiling_tb SET gender='$gen' WHERE id='$id'";
$query=mysqli_query($con,$sql);
$x=1;

echo $x;

?>