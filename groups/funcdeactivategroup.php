<?php
include('../conn.php');
$gid=$_POST['gid'];
$sql="UPDATE group_data_information_tb SET state='2' WHERE id='$gid'";
$query=mysqli_query($con,$sql);

////GCM//////
////GCM//////
?>
