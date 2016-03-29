<?php
include('../conn.php');

$_send=$_POST['senid'];
$_rec=$_POST['recid'];


$check="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='4'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
    if($state['state']=='4'){
		//Already sent request
        echo 1;
		}
        else if($state['state']!='4')
        {
		$check="SELECT * FROM freind_req_tb WHERE id_sender='$_rec' AND id_reciever='$_send' AND state='4'";
		$qchck=mysqli_query($con,$check);
		$state=mysqli_fetch_array($qchck);
    if($state['state']=='4'){
        //Already sent you a request
		echo 2;
		}
        else if($state['state']!='4'){   
$check="SELECT * FROM freind_rel_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
    if($state['state']=='1'){
        //Already Friends
		echo 3;
		}
        else if($state['state']!='1'){
$check="SELECT * FROM freind_rel_tb WHERE id_sender='$_rec' AND id_reciever='$_send' AND state='1'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
    if($state['state']=='1'){
        echo 3;
		}
        else if($state['state']!='1'){
$check1="SELECT * FROM freind_req_tb WHERE id_sender='$_rec' AND id_reciever='$_send' AND state='3' ";
$qchck1=mysqli_query($con,$check1);
$state1=mysqli_fetch_array($qchck1);
    if($state1['state']=='3'){
	//You are blocked by this user
        echo 4;
		}
        else if($state1['state']!='3'){
$check2="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='3' ";
$qchck2=mysqli_query($con,$check2);
$state2=mysqli_fetch_array($qchck2);
    if($state2['state']=='3'){
        //You blocked the user
		echo 5;
		}
        else if($state2['state']!='3'){
		//Request sent
		echo 6;
}
        }
        }
        }
        }
        }
mysqli_close($con);
?>