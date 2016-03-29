<?php
$rid=$_POST['rid'];
$gid=$_POST['gid'];
include('../conn.php');


$check="SELECT * FROM group_data_information_tb WHERE id='$gid' AND groups_admin_id='$rid'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);

if($state['groups_admin_id']==$rid){
echo 1;
}
else
{
$check="SELECT * FROM group_req_tb WHERE group_id='$gid' AND sender_id='$rid' AND state='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
if ($state['state']=='1'){
echo 2;    
}
else
{
$check="SELECT * FROM group_invitation_tb WHERE group_id='$gid' AND reciever_id='$rid' AND state='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
if ($state['state']=='1'){
echo 3;    
}else
{
$check="SELECT * FROM group_member_rel_tb WHERE group_id='$gid' AND user_id='$rid' AND state='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
if ($state['state']=='1'){
echo 4; 
}
else
{
$date1=date("Y-m-d H:i:s");
$sql="INSERT INTO group_invitation_tb(group_id,reciever_id,state,date_and_time) VALUES('$gid','$rid','1','$date1')";
$query=mysqli_query($con,$sql); 

$check1="SELECT * FROM group_data_information_tb WHERE id='$gid'";
$qchck1=mysqli_query($con,$check1);
$state1=mysqli_fetch_array($qchck1);
$admin_id=$state1['groups_admin_id'];


$sql33="INSERT INTO notificator_tb(id_sender,id_reciever,notification_type,notification_state,DATE_AND_TIME) VALUES('$admin_id','$rid','8','2','$date1')";
$query33=mysqli_query($con,$sql33); 
   

echo 5;   

////// GCM SEND GRP INVITE//////
$output=NULL;
$ids=array();
array_push($ids,$rid);
///Send admin and new user data update group data
//group invites
$sql="SELECT * FROM group_invitation_tb WHERE reciever_id='$rid' ORDER BY DATE_AND_TIME DESC LIMIT 5";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query))
{

$id=$res2['id'];
$gid=$res2['group_id'];
$rid=$res2['reciever_id'];
$state=$res2['state'];
$date=$res2['date_and_time'];
$output='[{"msgtype":"ginv","id":"'.$id.'","gid":"'.$gid.'","rid":"'.$rid.'","state":"'.$state.'","date":"'.$date.'"}]';


$sql="SELECT * FROM profiling_tb WHERE id = '".$rid."'";
$res = mysqli_query($con,$sql);
while($result=mysqli_fetch_array($res))
{
$dev=$result['userdevice_number'];
$fields=array(
                'registration_ids'  => array($dev),
                'data'              => array( "message" => $output ),
                );
$headers = array( 
                    'Authorization: key=' .$api,
                    'Content-Type: application/json'
                );
$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch);
curl_close($ch);
}
}


//sending user admin data

$sql="SELECT * FROM profiling_tb WHERE id = '".$rid."'";
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

$output='[{"msgtype":"frdd","id":"'.$id.'","email":"'.$email.'","username":"'.$username.'","dob":"'.$dob.'","fname":"'.$fname.'","mname":"'.$mname.'","lname":"'.$lname.'","gen":"'.$gen.'","count":"'.$count.'","proff":"'.$proff.'"}]';

$sql="SELECT * FROM profiling_tb WHERE id = '".$admin_id."'";
$res = mysqli_query($con,$sql);

while($result=mysqli_fetch_array($res))
{
$dev=$result['userdevice_number'];

$fields=array(
                'registration_ids'  => array($dev),
                'data'              => array( "message" => $output ),
                );
$headers = array( 
                    'Authorization: key=' .$api,
                    'Content-Type: application/json'
                );
$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch);
curl_close($ch);
}
}
}

//sending notifications
$sql22="SELECT * FROM profiling_tb WHERE id = '$rid'";
$res22 = mysqli_query($con,$sql22);
while($result88=mysqli_fetch_array($res22))
{
$dev=$result88['userdevice_number'];
if($dev!=""){

$sql77="SELECT * FROM profiling_tb WHERE id='$admin_id'";
$query77=mysqli_query($con,$sql77);    
$res77=mysqli_fetch_array($query77);

if($res77['first_name']==NULL && $res77['middle_name']==NULL && $res77['last_name']==NULL)
$names=$res77['username'];
else{
$names=$res77['first_name']." ".$res77['middle_name']." ".$res77['last_name'];
}
$message='[{"msgtype":"notific","from":"'.$names.'","not":"has sent you a group invite"}]';

$fields=array(
                'registration_ids'  => array($dev),
                'data'              => array( "message" =>$message ),
                );
$headers = array( 
                    'Authorization: key=' .$api,
                    'Content-Type: application/json'
                );
$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
$resultpostnot = curl_exec($ch);
curl_close($ch);
}
} 

////// GCM SEND GROUP INVITE//////   
}
}
}

?>