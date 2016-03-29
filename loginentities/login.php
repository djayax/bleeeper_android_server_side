<?php
include('../conn.php');
$x=0;
$code=$_POST['code'];
$pass=MD5($_POST['password']);
$id=$email=$username=$dob=$fname=$mname=$lname=$gen=$count=$proff=$output=NULL;

$sql="SELECT * FROM profiling_tb WHERE (username = '$code' AND password='$pass') OR (email = '$code' AND password='$pass') ";
$res = mysqli_query($con,$sql);
while($result=mysqli_fetch_array($res))
{
$id=$result['id'];
$email=$result['email'];
$username=$result['username'];
$dob=$result['date_of_birth'];
$fname=$result['first_name'];
$mname=$result['middle_name'];
$lname=$result['last_name'];
$gen=$result['gender'];
$count=$result['country'];
$proff=$result['proffesion'];

$x++;
}

if($x==0)
{
echo 1;
}
else
{
$output='[{"id":"'.$id.'","email":"'.$email.'","username":"'.$username.'","dob":"'.$dob.'","fname":"'.$fname.'","mname":"'.$mname.'","lname":"'.$lname.'","gen":"'.$gen.'","count":"'.$count.'","proff":"'.$proff.'"}]';
print($output);

}

?>