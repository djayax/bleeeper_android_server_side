<?php
include('../conn.php');
//$gid=$_POST['gid'];
//$sid=$_POST['sid'];
$gid="1";
$sid="13";
$date1=date("Y-m-d H:i:s");
$admin_id=NULL;


$check="SELECT * FROM group_data_information_tb WHERE id='$gid' AND groups_admin_id='$sid'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);

if($state['groups_admin_id']==$sid){
    echo 1;
}
else
{
$check="SELECT * FROM group_member_rel_tb WHERE group_id='$gid' AND user_id='$sid' AND state='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);

if($state['user_id']==$sid){
echo 2;
}
else
{
$check="SELECT * FROM group_invitation_tb WHERE group_id='$gid' AND reciever_id='$sid' AND state ='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);

if($state['state']=='1'){
echo 3;   
}
else
{

$check="SELECT * FROM group_req_tb WHERE group_id='$gid' AND sender_id='$sid' AND state ='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);    
    
if($state['state']=='1'){
echo 4;   
}
else
{
$sql="INSERT INTO group_req_tb(group_id,sender_id,state,date_and_time) VALUES('$gid','$sid','1','$date1')";
$query=mysqli_query($con,$sql);   

$check1="SELECT * FROM group_data_information_tb WHERE id='$gid'";
$qchck1=mysqli_query($con,$check1);
$state1=mysqli_fetch_array($qchck1);
$admin_id=$state1['groups_admin_id'];


$sql33="INSERT INTO notificator_tb(id_sender,id_reciever,notification_type,notification_state,DATE_AND_TIME) VALUES('$sid','$admin_id','7','2','$date1')";
$query33=mysqli_query($con,$sql33); 

echo 5;

///GCM///
$sql="SELECT * FROM group_req_tb WHERE group_id='$gid' ORDER BY DATE_AND_TIME DESC LIMIT 5";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query))
{
$id=$res2['id'];
$gid=$res2['group_id'];
$sid=$res2['sender_id'];
$state=$res2['state'];
$date=$res2['date_and_time'];
$output='[{"msgtype":"greq","id":"'.$id.'","gid":"'.$gid.'","sid":"'.$sid.'","state":"'.$state.'","date":"'.$date.'"}]';

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

//sending notifications
$sql22="SELECT * FROM profiling_tb WHERE id = '$admin_id'";
$res22 = mysqli_query($con,$sql22);
while($result88=mysqli_fetch_array($res22))
{
$dev=$result88['userdevice_number'];
if($dev!=""){

$sql77="SELECT * FROM profiling_tb WHERE id='$mid'";
$query77=mysqli_query($con,$sql77);    
$res77=mysqli_fetch_array($query77);

if($res77['first_name']==NULL && $res77['middle_name']==NULL && $res77['last_name']==NULL)
$names=$res77['username'];
else{
$names=$res77['first_name']." ".$res77['middle_name']." ".$res77['last_name'];
}
$message='[{"msgtype":"notific","from":"'.$names.'","not":"has accepted your group invite"}]';

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

////GCM//////
    
}
}
}
}




?>