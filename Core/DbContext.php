<?php
session_start();
try
{
	$conn = new PDO('mysql:host=localhost;dbname=Blog', 'root', '', array(PDO::ATTR_PERSISTENT => true));
}
catch(PDOExeption $e)
{
	echo("Error ! : ".$e->getMessage()."<br/>");
	die();
}
?>