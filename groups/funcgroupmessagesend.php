<?php
include('../conn.php');
$sid=$_POST['mid'];
$gid=$_POST['gid'];
$msg=$_POST['msg'];

$type='text';
$date1=date("Y-m-d H:i:s");

$sql="INSERT INTO grp_msg_tb (group_id,sender_id,message_type,context_message,date_and_time) VALUES('$gid','$sid','$type','$msg','$date1')";
$query=mysqli_query($con,$sql);
////GCM//////
$output=NULL;
$ids=array();
array_push($ids,$sid);
//Updating friends of new user join
$sql="SELECT * FROM group_member_rel_tb WHERE group_id='$gid' AND state='1'";
$query=mysqli_query($con,$sql);

while($res2=mysqli_fetch_array($query))
{
$uid=$res2['user_id'];
array_push($ids,$uid);
}


$sql="SELECT * FROM grp_msg_tb WHERE group_id='".$gid."'  ORDER BY DATE_AND_TIME DESC LIMIT 5";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query)){
array_push($ids,$res2['sender_id']);
$id=$res2['id'];
$gid=$res2['group_id'];
$sid=$res2['sender_id'];
$messagetype=$res2['message_type'];
$conmsg=$res2['context_message'];
$fileshare=$res2['file_share'];
$date=$res2['date_and_time'];

$output='[{"msgtype":"gmsg","id":"'.$id.'","gid":"'.$gid.'","sid":"'.$sid.'","messagetype":"'.$messagetype.'","conmsg":"'.$conmsg.'","fileshare":"'.$fileshare.'","date":"'.$date.'"}]';
$ar=count($ids);
for($i=0;$i<$ar;$i++)
{
$sql="SELECT * FROM profiling_tb WHERE id = '".$ids[$i]."'";
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


$ar=count($ids);
for($i=0;$i<$ar;$i++)
{
//sending notifications
$sql22="SELECT * FROM profiling_tb WHERE id = '".$ids[$i]."'";
$res22 = mysqli_query($con,$sql22);
while($result88=mysqli_fetch_array($res22))
{
$dev=$result88['userdevice_number'];
if($dev!=""){

$sql77="SELECT * FROM profiling_tb WHERE id='$sid'";
$query77=mysqli_query($con,$sql77);    
$res77=mysqli_fetch_array($query77);

if($res77['first_name']==NULL && $res77['middle_name']==NULL && $res77['last_name']==NULL)
$names=$res77['username'];
else{
$names=$res77['first_name']." ".$res77['middle_name']." ".$res77['last_name'];
}
$message='[{"msgtype":"notific","from":"'.$names.'","not":"has posted on group message"}]';

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
}
////GCM//////

?>