<?php
include('../conn.php');

$_send=$_POST['senid'];
$_rec=$_POST['recid'];
$date1=date("Y-m-d H:i:s");

$check="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='4'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
    if($state['state']=='4'){
	//Already sent request
	echo 1;
		
	}else{
	$sql="INSERT INTO freind_req_tb(id_sender,id_reciever,state,date_of_req)VALUES('$_send','$_rec','4','$date1');";
	$query=mysqli_query($con,$sql);

	$sql3="INSERT INTO notificator_tb(id_sender,id_reciever,notification_type,notification_state,date_and_time) VALUES ('$_send','$_rec','2','2','$date1');";
	$query3=mysqli_query($con,$sql3);
	echo 1;
	
	//frq update
$sql2="SELECT * FROM freind_req_tb WHERE id_reciever='$_rec' AND id_sender='$_send' AND state='4'";
$query2=mysqli_query($con,$sql2);

while($res2=mysqli_fetch_array($query2)){
$id=$res2['id'];
$id_sender=$res2['id_sender'];
$state=$res2['state'];
$date_and_time = $res2['date_of_req'];
$output='[{"msgtype":"frql","id":"'.$id.'","id_sender":"'.$id_sender.'","state":"'.$state.'","date_of_req":"'.$date_and_time.'"}]';

$sql22="SELECT * FROM profiling_tb WHERE id = '".$_rec."'";
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
$resultpostfollow = curl_exec($ch);
curl_close($ch);

}
}
}

//sending notifications
$sql22="SELECT * FROM profiling_tb WHERE id = '$_rec'";
$res22 = mysqli_query($con,$sql22);
while($result88=mysqli_fetch_array($res22))
{
$dev=$result88['userdevice_number'];
if($dev!=""){

$sql77="SELECT * FROM profiling_tb WHERE id='$_send'";
$query77=mysqli_query($con,$sql77);    
$res77=mysqli_fetch_array($query77);

if($res77['first_name']==NULL && $res77['middle_name']==NULL && $res77['last_name']==NULL)
$names=$res77['username'];
else{
$names=$res77['first_name']." ".$res77['middle_name']." ".$res77['last_name'];
}
$message='[{"msgtype":"notific","from":"'.$names.'","not":"has sent you a bleeeper buddy request"}]';

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

//catching user data
$sql="SELECT * FROM profiling_tb WHERE id = '".$_rec."'";
$res = mysqli_query($con,$sql);
while($result=mysqli_fetch_array($res))
{
$siddev=$result['userdevice_number'];
}

//sending data to the sid
$sql="SELECT * FROM profiling_tb WHERE id = '".$_send."'";
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
	}
	
	
mysqli_close($con);
?>