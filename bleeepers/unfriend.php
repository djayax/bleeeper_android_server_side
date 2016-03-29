<?php
//13 is a notification state that involves unfriending
require_once('../conn.php');
$sid=$_POST['sid'];
$rid=$_POST['rid'];
$date1=date("Y-m-d H:i:s");

$uni=$output="";
$ids=array();


array_push($ids,$sid);
array_push($ids,$rid);

$sql15="SELECT * FROM freind_rel_tb WHERE (id_sender='$sid' AND id_reciever='$rid' AND state='1') OR (id_sender='$rid'  AND id_reciever='$sid' AND state='1')";
$query15=mysqli_query($con,$sql15);
while($res15=mysqli_fetch_array($query15)){
$uni=$res15['id'];
}


$sql="UPDATE freind_rel_tb SET state='7' WHERE (id_reciever='$sid' AND id_sender='$rid' AND state='1') OR (id_reciever='$rid' AND id_sender='$sid' AND state='1')";
$query=mysqli_query($con,$sql);

$sql3="INSERT INTO notificator_tb(id_sender,id_reciever,notification_type,notification_state,date_and_time) VALUES('$sid','$rid','13','2','$date1')";
$query3=mysqli_query($con,$sql3);


$sql22="SELECT * FROM freind_rel_tb WHERE id='$uni'";
$query22=mysqli_query($con,$sql22);

while($res22=mysqli_fetch_array($query22)){

$id=$res22['id'];
$id_sender=$res22['id_sender'];
$id_reciever=$res22['id_reciever'];
$state=7;
$date_and_time = $res22['date_and_time'];

$output='[{"msgtype":"frrl","id":"'.$id.'","id_sender":"'.$id_sender.'","id_reciever":"'.$id_reciever.'","state":"'.$state.'","date_and_time":"'.$date_and_time.'"}]';

//sending to the various devices
$ar=count($ids);
for($i=0;$i<$ar;$i++)
{
$sql11="SELECT * FROM profiling_tb WHERE id = '".$ids[$i]."'";
$res11 = mysqli_query($con,$sql11);
while($result99=mysqli_fetch_array($res11))
{
$dev=$result99['userdevice_number'];
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
$resultpost = curl_exec($ch);
curl_close($ch);
}
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

$sql77="SELECT * FROM profiling_tb WHERE id='$sid'";
$query77=mysqli_query($con,$sql77);    
$res77=mysqli_fetch_array($query77);

if($res77['first_name']==NULL && $res77['middle_name']==NULL && $res77['last_name']==NULL)
$names=$res77['username'];
else{
$names=$res77['first_name']." ".$res77['middle_name']." ".$res77['last_name'];
}
$message='[{"msgtype":"notific","from":"'.$names.'","not":"has just stopped being friends with you"}]';
echo $message;

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