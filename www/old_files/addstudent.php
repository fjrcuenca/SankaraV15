<?php
$con = mysql_connect("localhost:8889","root","root");

if(!$con)
{
	die('Could not connect: ' . mysql_error());
}


mysql_select_db("sankaraeye", $con);

$sql="INSERT INTO student (lastname, firstname, age) VALUES ('$_POST[ln]', '$_POST[fn]', '$_POST[age]')";

if (!mysql_query($sql, $con))
{
	die('Error: ' . mysql_error());
}


mysql_close($con);
?>
