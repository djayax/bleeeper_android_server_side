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
		//nullify requests any friend request sent or follow            
		$sql1="UPDATE freind_req_tb SET state='7' WHERE id_sender='$_send' AND id_reciever='$_rec' AND state NOT IN (3);";
		$query1=mysqli_query($con,$sql1);

		$sql11="UPDATE freind_req_tb SET state='7' WHERE id_sender='$_rec' AND id_reciever='$_send' AND state NOT IN (3) ;";
		$query11=mysqli_query($con,$sql11);

		//nullify friendships

		$sql12="UPDATE freind_rel_tb SET state='7' WHERE id_sender='$_send' AND id_reciever='$_rec';";
		$query1=mysqli_query($con,$sql12);

		$sql112="UPDATE freind_rel_tb SET state='7' WHERE id_sender='$_rec' AND id_reciever='$_send';";
		$query112=mysqli_query($con,$sql112);
		
		echo 2;
   }
    
?>
