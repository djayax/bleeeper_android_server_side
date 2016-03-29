<?php
include('../conn.php');
$element=$_POST['grpnames'];
$abtgrp=$admin=$grpname=$id=$date1=$nm=NULL;
$x=0;


$sql="SELECT id,group_name,about_group FROM group_data_information_tb WHERE group_name LIKE '$element%' AND state='1' ORDER BY DATE_AND_TIME DESC";
$query=mysqli_query($con,$sql);
while($res=mysqli_fetch_array($query))
{
$output[]=$res;
$x=$x+1;
}
if($x>0)
print(json_encode($output));
else
echo "0";
?>

