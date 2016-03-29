<?php
include('../conn.php');
$code=$_POST['code'];
$dev=$_POST['dev'];
$ids=array();
$gids=array();
array_push($ids,$code);
//profile update
$sql="SELECT * FROM profiling_tb WHERE id = '$code'";
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

$output='[{"msgtype":"pu","id":"'.$id.'","email":"'.$email.'","username":"'.$username.'","dob":"'.$dob.'","fname":"'.$fname.'","mname":"'.$mname.'","lname":"'.$lname.'","gen":"'.$gen.'","count":"'.$count.'","proff":"'.$proff.'"}]';


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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//request update
$sql1="SELECT id,id_sender,state,date_of_req FROM freind_req_tb WHERE id_reciever='$code' AND state IN(1,4)";
$query1=mysqli_query($con,$sql1);
while($res1=mysqli_fetch_array($query1)){

$id=$res1['id'];
$id_sender=$res1['id_sender'];
array_push($ids,$id_sender);
$state=$res1['state'];
$date_of_req=$res1['date_of_req'];


$output='[{"msgtype":"frql","id":"'.$id.'","id_sender":"'.$id_sender.'","state":"'.$state.'","date_of_req":"'.$date_of_req.'"}]';

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
//relationship update
$sql2="SELECT id,id_sender,id_reciever,state,date_and_time FROM freind_rel_tb WHERE (id_sender='$code' AND state IN(1,2,7))  OR (id_reciever='$code' AND state IN(1,2,7))";
$query2=mysqli_query($con,$sql2);

while($res2=mysqli_fetch_array($query2)){

$id=$res2['id'];
$id_sender=$res2['id_sender'];
$id_reciever=$res2['id_reciever'];
$state=$res2['state'];
$date_and_time = $res2['date_and_time'];

if($code==$id_sender)
{
array_push($ids,$id_reciever);
}
else if($code==$id_reciever)
{
array_push($ids,$id_sender);
}


$output='[{"msgtype":"frrl","id":"'.$id.'","id_sender":"'.$id_sender.'","id_reciever":"'.$id_reciever.'","state":"'.$state.'","date_and_time":"'.$date_and_time.'"}]';
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//friends boinkers
$sql="SELECT * FROM freind_rel_tb WHERE ( id_sender='$code' AND state='1') OR ( id_reciever='$code' AND state='1')";
$query=mysqli_query($con,$sql);
while($res1=mysqli_fetch_array($query)){
if($res1['id_reciever']!=$code){$rid=$res1['id_reciever'];}
else if($res1['id_sender']!=$code){$rid=$res1['id_sender'];}


$sql11="SELECT * FROM boinkers_tb WHERE id_user = '$rid'";
$query11=mysqli_query($con,$sql11);
while($res111=mysqli_fetch_array($query11)){
$id=$res111['id'];
$user=$res111['id_user'];
$boink=$res111['boink'];
$date=$res111['date'];

$output='[{"msgtype":"bc","id":"'.$id.'","user_id":"'.$user.'","boink":"'.$boink.'","date":"'.$date.'"}]';
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
//fetch personal boinks
$sql11="SELECT * FROM boinkers_tb WHERE id_user = '$code'";
$query11=mysqli_query($con,$sql11);
while($res111=mysqli_fetch_array($query11)){
$id=$res111['id'];
$user=$res111['id_user'];
$boink=$res111['boink'];
$date=$res111['date'];

$output='[{"msgtype":"bc","id":"'.$id.'","user_id":"'.$user.'","boink":"'.$boink.'","date":"'.$date.'"}]';
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

//friends shoutouts
$sql44="SELECT * FROM freind_rel_tb WHERE id_sender='$code' AND state='2'";
$query44=mysqli_query($con,$sql44);
while($res1=mysqli_fetch_array($query44)){
$rid=$res1['id_reciever'];

$sql11="SELECT * FROM shoutouts_tb  WHERE id_user = '$rid'";
$query11=mysqli_query($con,$sql11);
while($res111=mysqli_fetch_array($query11)){
$id=$res111['id'];
$user=$rid;
$shoutout=$res111['shoutout'];
$date=$res111['date'];

$output='[{"msgtype":"sc","id":"'.$id.'","user_id":"'.$user.'","shoutout":"'.$shoutout.'","date":"'.$date.'"}]';
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
//fetch personal  shoutouts
$sql111="SELECT * FROM shoutouts_tb  WHERE id_user = '$code'";
$query111=mysqli_query($con,$sql111);
while($res111=mysqli_fetch_array($query111)){
$id=$res111['id'];
$user2=$code;
$shoutout=$res111['shoutout'];
$date=$res111['date'];

$output='[{"msgtype":"sc","id":"'.$id.'","user_id":"'.$user2.'","shoutout":"'.$shoutout.'","date":"'.$date.'"}]';
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


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//fetching messages
$sql7 = "SELECT * FROM msg_tb WHERE id_reciever='$code' OR id_sender='$code' ORDER BY DATE DESC LIMIT 100";
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


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//group invites
$sql="SELECT * FROM group_invitation_tb WHERE reciever_id='$code' ORDER BY DATE_AND_TIME DESC LIMIT 50 ";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query))
{
array_push($gids,$res2['group_id']);
$id=$res2['id'];
$gid=$res2['group_id'];
$rid=$res2['reciever_id'];
$state=$res2['state'];
$date=$res2['date_and_time'];
$output='[{"msgtype":"ginv","id":"'.$id.'","gid":"'.$gid.'","rid":"'.$rid.'","state":"'.$state.'","date":"'.$date.'"}]';

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


//group memberships
$sql="SELECT * FROM group_member_rel_tb WHERE user_id='$code' ORDER BY DATE_AND_TIME DESC LIMIT 50";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query))
{
array_push($ids,$res2['user_id']);
array_push($gids,$res2['group_id']);
$id=$res2['id'];
$gid=$res2['group_id'];
$uid=$res2['user_id'];
$state=$res2['state'];
$date=$res2['date_and_time'];

$output='[{"msgtype":"gmrl","id":"'.$id.'","gid":"'.$gid.'","uid":"'.$uid.'","state":"'.$state.'","date":"'.$date.'"}]';

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




//members of group I admin
$sql="SELECT * FROM group_data_information_tb WHERE groups_admin_id='$code'";
$query=mysqli_query($con,$sql);
while($res3=mysqli_fetch_array($query)){
$gid=$res3['id'];

$sql="SELECT * FROM group_member_rel_tb WHERE group_id='$gid'";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query))
{
array_push($ids,$res2['user_id']);
array_push($gids,$res2['group_id']);
$id=$res2['id'];
$gid=$res2['group_id'];
$uid=$res2['user_id'];
$state=$res2['state'];
$date=$res2['date_and_time'];
$output='[{"msgtype":"gmrl","id":"'.$id.'","gid":"'.$gid.'","uid":"'.$uid.'","state":"'.$state.'","date":"'.$date.'"}]';

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
//members from groups am members with
$ar=count($gids);
for($i=0;$i<$ar;$i++)
{
$sql="SELECT * FROM group_member_rel_tb WHERE group_id='".$gids[$i]."'";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query)){

$id=$res2['id'];
$gid=$res2['group_id'];
$uid=$res2['user_id'];
array_push($ids,$res2['user_id']);
$state=$res2['state'];
$date=$res2['date_and_time'];

$output='[{"msgtype":"gmrl","id":"'.$id.'","gid":"'.$gid.'","uid":"'.$uid.'","state":"'.$state.'","date":"'.$date.'"}]';
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

//groupjoinrequests
$sql="SELECT * FROM group_data_information_tb WHERE groups_admin_id='$code' ";
$query=mysqli_query($con,$sql);
while($res3=mysqli_fetch_array($query)){
$gid=$res3['id'];

$sql="SELECT * FROM group_req_tb WHERE group_id='$gid' ORDER BY DATE_AND_TIME DESC LIMIT 50";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query))
{
array_push($gids,$res2['group_id']);
array_push($ids,$res2['sender_id']);
$id=$res2['id'];
$gid=$res2['group_id'];
$sid=$res2['sender_id'];
$state=$res2['state'];
$date=$res2['date_and_time'];
$output='[{"msgtype":"greq","id":"'.$id.'","gid":"'.$gid.'","sid":"'.$sid.'","state":"'.$state.'","date":"'.$date.'"}]';

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

///groupmessages
$ar=count($gids);
for($i=0;$i<$ar;$i++)
{

$sql="SELECT * FROM grp_msg_tb WHERE group_id='".$gids[$i]."'  ORDER BY DATE_AND_TIME DESC LIMIT 50";
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
$result;
}
}















//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
Getting data information from online
**/
//sending group data information
$ar=count($gids);
for($i=0;$i<$ar;$i++)
{
$sql="SELECT * FROM group_data_information_tb WHERE id='".$gids[$i]."'";
$query=mysqli_query($con,$sql);
while($res2=mysqli_fetch_array($query)){
array_push($ids,$res2['groups_admin_id']);
$id=$res2['id'];
$gname=$res2['group_name'];
$gadmin=$res2['groups_admin_id'];
$gabt=$res2['about_group'];
$gstate=$res2['state'];
$gdt=$res2['date_and_time'];

$output='[{"msgtype":"grpd","id":"'.$id.'","gname":"'.$gname.'","gadmin":"'.$gadmin.'","gabt":"'.$gabt.'","gstate":"'.$gstate.'","gdt":"'.$gdt.'"}]';

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

//fetching friends details
$ar=count($ids);
for($i=0;$i<$ar;$i++)
{
$sql="SELECT * FROM profiling_tb WHERE id = '".$ids[$i]."'";
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

//fetching profile picture details
$ar=count($ids);
for($i=0;$i<$ar;$i++)
{
$sql="SELECT * FROM ppic_tb WHERE user_id = '".$ids[$i]."'";
$res = mysqli_query($con,$sql);
while($result=mysqli_fetch_array($res))
{
$id=$result['id'];
$link=$result['ppic_link'];
$state=$result['ppic_state'];
$date=$result['date_and_time'];



$output='[{"msgtype":"ppic","id":"'.$id.'","puid":"'.$ids[$i].'","plink":"'.$link.'","pstate":"'.$state.'","pdate":"'.$date.'"}]';
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
echo "data sent";



?>