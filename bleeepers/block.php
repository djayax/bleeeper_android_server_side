<?php
include('../conn.php');
$_send=$_POST['senid'];
$_rec=$_POST['recid'];
$date1=date("Y-m-d H:i:s");

$check1="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='3'";
$qchck1=mysqli_query($con,$check1);
$state1=mysqli_fetch_array($qchck1);
    if($state1['state']=='3'){
		//You already blocked this person
        echo 1;
		}
        else{
		echo 2;
   }
    
?>
