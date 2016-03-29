<?php
include('../conn.php');
$send_id=$_POST['send_id'];
$rec_id=$_POST['rec_id'];
$msg=$_POST['msg'];
$sql123="UPDATE msg_tb SET msg_state_rec='2' WHERE id_reciever='$send_id' AND id_sender='$rec_id' AND msg_state_rec='1' AND msg_state_send='2'";
$query123=mysqli_query($con,$sql123);


$sql="INSERT INTO msg_tb (id_sender,id_reciever,message,msg_state_send,msg_state_rec,date) VALUES('$send_id','$rec_id','$msg','2','1','$date1')";
$res = mysqli_query($con,$sql);




//message send to friend and me
$sql7 = "SELECT * FROM msg_tb WHERE (id_reciever='$rec_id' AND id_sender='$send_id') OR (id_reciever='$send_id' AND id_sender='$rec_id') ORDER BY DATE DESC LIMIT 2";
$query7=mysqli_query($con,$sql7);
while($res7=mysqli_fetch_array($query7)){

$id=$res7['id'];
$sen=$res7['id_sender'];
$rec=$res7['id_reciever'];
$msg=$res7['message'];
$msgsen=$res7['msg_state_send'];
$msgrec=$res7['msg_state_rec'];
$date=$res7['date'];
$output='[{"msgtype":"msgs","id":"'.$id.'","id_sender":"'.$sen.'","id_reciever":"'.$rec.'","msg":"'.$msg.'","msgsen":"'.$msgsen.'","msgrec":"'.$msgrec.'","date":"'.$date.'"}]';



$sql22="SELECT * FROM profiling_tb WHERE id = '$rec_id'";
$res22 = mysqli_query($con,$sql22);
while($result88=mysqli_fetch_array($res22))
{
$dev=$result88['userdevice_number'];
if($dev!=""){

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

$sql22="SELECT * FROM profiling_tb WHERE id = '$send_id'";
$res22 = mysqli_query($con,$sql22);
while($result88=mysqli_fetch_array($res22))
{
$dev=$result88['userdevice_number'];
if($dev!=""){

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
$sql22="SELECT * FROM profiling_tb WHERE id = '$rec_id'";
$res22 = mysqli_query($con,$sql22);
while($result88=mysqli_fetch_array($res22))
{
$dev=$result88['userdevice_number'];
if($dev!=""){

$sql77="SELECT * FROM profiling_tb WHERE id='$send_id'";
$query77=mysqli_query($con,$sql77);    
$res77=mysqli_fetch_array($query77);

if($res77['first_name']==NULL && $res77['middle_name']==NULL && $res77['last_name']==NULL)
$names=$res77['username'];
else{
$names=$res77['first_name']." ".$res77['middle_name']." ".$res77['last_name'];
}
$message='[{"msgtype":"notific","from":"'.$names.'","not":"has sent you a message"}]';

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

?>