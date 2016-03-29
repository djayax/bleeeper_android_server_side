<?php
include('../conn.php');
$_send=$_POST['sid'];
$_rec=$_POST['rid'];

$check="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='5'";
$qchck=mysqli_query($con,$check);
$state=mysqli_fetch_array($qchck);
    if($state['state']=='5'){
        echo 1;//You are already following this person      
        }
        else if($state['state']!='5')
        {
$check1="SELECT * FROM freind_req_tb WHERE id_sender='$_rec' AND id_reciever='$_send' AND state='3'";
$qchck1=mysqli_query($con,$check1);
$state1=mysqli_fetch_array($qchck1);
    if($state1['state']=='3'){
        echo 2;//this user blocked you 
		}
        else if($state1['state']!='3'){
$check2="SELECT * FROM freind_req_tb WHERE id_sender='$_send' AND id_reciever='$_rec' AND state='3' ";
$qchck2=mysqli_query($con,$check2);
$state2=mysqli_fetch_array($qchck2);
    if($state2['state']=='3'){
        echo 3;//You blocked this person
        }
        else if($state2['state']!='3'){
		echo 4;//Proceed
        }
        }
    }
    
  
?>
