<?php
include('../conn.php');
$element=$_POST['key'];
$x=0;

if($element!=null || $element!=""){


$sql="SELECT id,email,username,first_name,middle_name,last_name,country FROM profiling_tb WHERE email LIKE '$element%' OR username LIKE '$element%' OR first_name LIKE '$element%' OR middle_name LIKE '$element%' OR last_name LIKE '$element%'";
$query=mysqli_query($con,$sql);

if(! $query )
{
  die('<br/>Could not enter data:'.mysqli_error($con));
};

while($res=mysqli_fetch_array($query)){
$output[]=$res;
$x=$x+1;
}
}
if($x>0)
print(json_encode($output));
else
echo "0";

mysqli_close($con);
?>