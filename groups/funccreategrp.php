<?php
include('../conn.php');
$grpname=$_POST['grpname'];
$adminid=$_POST['adminid'];
$abtgrp=$_POST['abtgrp'];
if($grpname==NULL or $grpname=="")
echo 1;
else if($abtgrp==NULL or $abtgrp=="")
echo 2;
else if(strlen($grpname)<5 || strlen($grpname)>35)
echo 3;
//else if(strlen($abtgrp)<40 || strlen($abtgrp)>100)
//echo 4;
else{
    $date1=date("Y-m-d H:i:s");
    $sql="INSERT INTO group_data_information_tb(group_name,groups_admin_id,about_group,date_and_time)VALUES('$grpname','$adminid','$abtgrp','$date1')";
    $res = mysqli_query($con,$sql);

    $sql22="SELECT * FROM group_data_information_tb WHERE groups_admin_id = '$adminid' ORDER BY DATE_AND_TIME DESC LIMIT 1";
    $query22=mysqli_query($con,$sql22);
    $res55=mysqli_fetch_array($query22);
    $gid=$res55['id'];
    
    $sql="INSERT INTO group_member_rel_tb(group_id,user_id,state,date_and_time) VALUES('$gid','$adminid','1','$date1')";
	$query=mysqli_query($con,$sql);
    

    echo 5;
	
	
	////GCM////

	$sql="SELECT * FROM group_data_information_tb WHERE group_name='".$grpname."'";
	$query=mysqli_query($con,$sql);
	while($res2=mysqli_fetch_array($query)){
	$id=$res2['id'];
	$gname=$res2['group_name'];
	$gadmin=$res2['groups_admin_id'];
	$gabt=$res2['about_group'];
	$gstate=$res2['state'];
	$gdt=$res2['date_and_time'];

	$output='[{"msgtype":"grpd","id":"'.$id.'","gname":"'.$gname.'","gadmin":"'.$gadmin.'","gabt":"'.$gabt.'","gstate":"'.$gstate.'","gdt":"'.$gdt.'"}]';
	$sql="SELECT * FROM profiling_tb WHERE id = '".$adminid."'";
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

	////GCM////
    }
?>