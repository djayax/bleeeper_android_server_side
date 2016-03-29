<?php
include('../conn.php');
$dev=$_POST['dev'];
$id=$_POST['code'];


$sql="UPDATE profiling_tb SET userdevice_number='".$dev."' WHERE id='".$id."'";
$query=mysqli_query($con,$sql);


if(!$query )
{
die('<br/>Could not enter data:'.mysqli_error($con));
}
echo $dev;

?>