<?php
require_once('../conn.php');

$id=$_POST['id'];
$boink=$_POST['msg'];

$date1=date("Y-m-d H:i:s");

$sql="INSERT INTO boinkers_tb(id_user,boink,date) VALUES('$id','$boink','$date1')";
$res = mysqli_query($con,$sql);

/////Boink GCM///////
$ids=array();
array_push($ids,$id);

$sql2="SELECT id,id_sender,id_reciever,state,date_and_time FROM freind_rel_tb WHERE (id_sender='$id' AND state IN(1))  OR (id_reciever='$id' AND state IN(1))";
$query2=mysqli_query($con,$sql2);

while($res2=mysqli_fetch_array($query2)){
$id_sender=$res2['id_sender'];
$id_reciever=$res2['id_reciever'];
if($id==$id_sender)
{
array_push($ids,$id_reciever);
}
else if($id==$id_reciever)
{
array_push($ids,$id_sender);
}
}

$ar=count($ids);
for($i=0;$i<$ar;$i++)
{
$sql="SELECT * FROM profiling_tb WHERE id = '".$ids[$i]."'";
$res = mysqli_query($con,$sql);
while($result=mysqli_fetch_array($res))
{

$dev=$result['userdevice_number'];
if($dev!=""){
$sql11="SELECT * FROM boinkers_tb WHERE id_user = '$id' ORDER BY ID DESC LIMIT 2";
$query11=mysqli_query($con,$sql11);
while($res111=mysqli_fetch_array($query11)){
$id=$res111['id'];
$user=$res111['id_user'];
$boink=$res111['boink'];
$date=$res111['date'];

$output='[{"msgtype":"bc","id":"'.$id.'","user_id":"'.$user.'","boink":"'.$boink.'","date":"'.$date.'"}]';
echo $output;
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
}
/////Boink GCM///////

?>