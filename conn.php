<?php
$host="localhost";
$acct="root";
$passw="";
$dbname="private_db";
$con=mysqli_connect($host,$acct,$passw,$dbname)
		or die("Connection has not been established");	
$url="https://android.googleapis.com/gcm/send";
$api="AIzaSyA8yyeNnH0MoP_8iAq0hvCgBGS3TxyIGL0";
?>