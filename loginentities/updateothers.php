<?php
$id=$_POST['id'];
$count=$_POST['country'];
$profession=$_POST['profession'];

include('../conn.php');

$sql="UPDATE profiling_tb SET country='$count',proffesion='$profession' WHERE id='$id'";
$query=mysqli_query($con,$sql);

echo 1;


?>