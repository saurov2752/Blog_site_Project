<?php

//mysql_connect("localhost","root","") or die("Can not connect to the server");
//mysql_select_db("data_me") or die("can not connect to database");


$dbhost="localhost";
$dbname="project";
$dbuser="root";
$dbpass="";

try
{
	$db = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
  
catch(PDOException $e)
{
	echo "Connection Error " . $e->getMessage();
}

?> 