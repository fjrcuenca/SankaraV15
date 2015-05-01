<?php
 
/****** Database Details *********/
 
$host = "dbserver.engr.scu.edu"; 
$user = "sankara"; 
$pass = "Fig2014"; 
$database = "sankara_web";
$con = mysql_connect($host,$user,$pass);
 
if (!$con) {
die('Could not connect: ' . mysql_error());
}
 
//echo 'Connected successfully'; 
 
mysql_select_db($database,$con);
 
/*******************************/
 
?>