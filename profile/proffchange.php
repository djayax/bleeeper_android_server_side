<?php
include('../conn.php');
$proff=$_POST['proff'];
$id=$_POST['id'];
$x=0;

$sql="UPDATE profiling_tb SET proffesion='$proff' WHERE id='$id'";
$query=mysqli_query($con,$sql);
$x=1;

echo $x;

?>