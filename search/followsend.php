<?php
include('../conn.php');
$_send=$_POST['senid'];
$_rec=$_POST['recid'];
$date1=date("Y-m-d H:i:s");

$ids=array();
array_push($ids,$_send);
array_push($ids,$_rec);
		
		$check="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='5'";
		$qchck=mysqli_query($con,$check);
		$state=mysqli_fetch_array($qchck);
		if($state['state']=='5'){
		echo 1;
		}
        else
        {


		//indication of following in frend req_tb
		$sql="INSERT INTO freind_req_tb(id_sender,id_reciever,state,date_of_req) VALUES('$_send','$_rec','5','$date1')";
		$query=mysqli_query($con,$sql);

		//indication of follower in frend rel tb
		$sql2="INSERT INTO freind_rel_tb(id_sender,id_reciever,state,date_and_time) VALUES('$_send','$_rec','2','$date1')";
		$query2=mysqli_query($con,$sql2);

		$sql3="INSERT INTO notificator_tb(id_sender,id_reciever,notification_type,notification_state,date_and_time) VALUES('$_send','$_rec','3','2','$date1')";
		$query3=mysqli_query($con,$sql3);
		echo 1;
		
		//frl update
$sql2="SELECT * FROM freind_rel_tb WHERE (id_reciever='$_send' AND id_sender='$_rec') OR (id_reciever='$_rec' AND id_sender='$_send')";
$query2=mysqli_query($con,$sql2);

while($res2=mysqli_fetch_array($query2)){
$id=$res2['id'];
$id_sender=$res2['id_sender'];
$id_reciever=$res2['id_reciever'];
$state=$res2['state'];
$date_and_time = $res2['date_and_time'];
$output='[{"msgtype":"frrl","id":"'.$id.'","id_sender":"'.$id_sender.'","id_reciever":"'.$id_reciever.'","state":"'.$state.'","date_and_time":"'.$date_and_time.'"}]';

$ar=count($ids);
for($i=0;$i<$ar;$i++)
{
$sql22="SELECT * FROM profiling_tb WHERE id = '".$ids[$i]."'";
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
$message='[{"msgtype":"notific","from":"'.$names.'","not":"is now following you"}]';

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
		

?>