<?php
require_once('../conn.php');
$sid=$_POST['sid'];
$rid=$_POST['rid'];
$date1=date("Y-m-d H:i:s");

$uni="";
$ids=array();


array_push($ids,$sid);
array_push($ids,$rid);

$sql15="SELECT * FROM freind_req_tb WHERE id_sender='$rid' AND id_reciever='$sid' AND state='4'";
$query15=mysqli_query($con,$sql15);
while($res15=mysqli_fetch_array($query15)){
$uni=$res15['id'];
}


$sql="UPDATE freind_req_tb SET state='1' WHERE id_reciever='$sid' AND id_sender='$rid' AND state='4'";
$query=mysqli_query($con,$sql);

$sql2="INSERT INTO freind_rel_tb(id_sender,id_reciever,state,date_and_time) VALUES('$rid','$sid','1','$date1')";
$query2=mysqli_query($con,$sql2);

$sql3="INSERT INTO notificator_tb(id_sender,id_reciever,notification_type,notification_state,date_and_time) VALUES('$sid','$rid','1','2','$date1')";
$query3=mysqli_query($con,$sql3);

echo 1;

//updating frq table
$sql22="SELECT * FROM freind_req_tb WHERE id='$uni'";
$query22=mysqli_query($con,$sql22);

while($res22=mysqli_fetch_array($query22)){

$id=$res22['id'];
$id_sender=$res22['id_sender'];
$state=$res22['state'];
$date_of_req=$res22['date_of_req'];

$output='[{"msgtype":"frql","id":"'.$id.'","id_sender":"'.$id_sender.'","state":"'.$state.'","date_of_req":"'.$date_of_req.'"}]';
}
//sending to the various devices
$sql11="SELECT * FROM profiling_tb WHERE id = '".$rid."'";
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


//updating frl table
$sql77="SELECT * FROM freind_rel_tb FROM freind_rel_tb WHERE (id_sender='$rid'  AND id_reciever='$sid' AND state='1') OR (id_sender='$sid'  AND id_reciever='$rid' AND state='1')";
$query77=mysqli_query($con,$sql22);
while($res77=mysqli_fetch_array($query77)){

$id=$res77['id'];
$id_sender=$res77['id_sender'];
$id_reciever=$res77['id_reciever'];
$state=$res77['state'];
$date_and_time = $res77['date_and_time'];

$output='[{"msgtype":"frrl","id":"'.$id.'","id_sender":"'.$id_sender.'","id_reciever":"'.$id_reciever.'","state":"'.$state.'","date_and_time":"'.$date_and_time.'"}]';
}
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
$message='[{"msgtype":"notific","from":"'.$names.'","not":"has accepted your bleeeper request"}]';

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

//sending data to the rid
$sql="SELECT * FROM profiling_tb WHERE id = '".$sid."'";
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
$siddev=$result['userdevice_number'];

$output='[{"msgtype":"frdd","id":"'.$id.'","email":"'.$email.'","username":"'.$username.'","dob":"'.$dob.'","fname":"'.$fname.'","mname":"'.$mname.'","lname":"'.$lname.'","gen":"'.$gen.'","count":"'.$count.'","proff":"'.$proff.'"}]';

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

//sending data to the sid
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

$fields=array(
                'registration_ids'  => array($siddev),
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

?>