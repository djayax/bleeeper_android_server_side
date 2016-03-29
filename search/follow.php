<?php
include('../conn.php');
$_send=$_POST['senid'];
$_rec=$_POST['recid'];
$date1=date("Y-m-d H:i:s");

$check="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='5'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
    if($state['state']=='5'){
		//Already following
        echo 1;
		}
        else
        {
$check1="SELECT * FROM freind_req_tb WHERE id_sender='$_rec' AND id_reciever='$_send' AND state='3'";
$qchck1=mysqli_query($con,$check1);
$state1=mysqli_fetch_array($qchck1);
		if($state1['state']=='3'){
		//You were blocked by this user
        echo 2;
		}
        else{
		$check2="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='3' ";
		$qchck2=mysqli_query($con,$check2);
		$state2=mysqli_fetch_array($qchck2);
		if($state2['state']=='3'){
		//You blocked this user
        echo 3;
		}
        else
		{
		//Success
		echo 4; 

}
}
}
?>