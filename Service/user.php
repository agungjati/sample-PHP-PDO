<?php
include_once '../Core/DbCrud.php';
include_once '../Core/DbContext.php';
include_once '../Models/user.php';

$Connection = new DbCrud($conn, 'users');
$model = new user();

if(isset($_POST['input']))
{
	$model->Id = '';
	$model->Full_Name = mysql_real_escape_string($_POST['Full_Name']);
	$model->Address = mysql_real_escape_string($_POST['Address']);
	$model->Contact = mysql_real_escape_string($_POST['Contact']);
	$model->Photo = '';
	$model->Email = mysql_real_escape_string($_POST['Email']);
	$model->Username = mysql_real_escape_string($_POST['Username']);
	$model->Password = mysql_real_escape_string($_POST['Password']);
	$action = $Connection->Save($model);
	if($action)
	{
		$model =(array)$model;
		$model['Message'] = "Success";
		echo(json_encode($model));
	}
	else
	{
		header("HTTP/1.1 400 Bad Request");
		echo(json_encode(array("Message"=>"failed")));
	}
}
elseif (isset($_POST['update']))
{
	$model->Id = mysql_real_escape_string($_POST['Id']);
	$model->Full_Name = mysql_real_escape_string($_POST['Full_Name']);
	$model->Address = mysql_real_escape_string($_POST['Address']);
	$model->Contact = mysql_real_escape_string($_POST['Contact']);
	$model->Photo = '';
	$model->Email = mysql_real_escape_string($_POST['Email']);
	$model->Username = mysql_real_escape_string($_POST['Username']);
	$model->Password = mysql_real_escape_string($_POST['Password']);
	$action = $Connection->Update($model);
	if($action)
	{
		$model = (array)$model;
		$model['Message'] = "Success";
		echo(json_encode($model));
	}
	else
	{
		header("HTTP/1.1 400 Bad Request");
		echo(json_encode(array("Message"=>"failed")));
	}		
}
elseif (isset($_GET['delete']))
{
	
	$action = $Connection->Delete(mysql_real_escape_string($_GET['Id']));
	if($action)
	{
		echo(json_encode(array("Message"=>"Success")));
	}
	else
	{
		header("HTTP/1.1 400 Bad Request");
		echo(json_encode(array("Message"=>"failed")));
	}		
}
elseif (isset($_GET['Id'])) 
{
	
	$action = $Connection->showDetail(mysql_real_escape_string($_GET['Id']));
	if($action)
	{
		echo(json_encode($action));	
	}
	else
	{
		header("HTTP/1.1 400 Bad Request");
		echo(json_encode(array("Message"=>"failed")));
	}		
}
else
{
	$action = $Connection->showAll();
	if($action)
	{
		echo(json_encode($action));	
	}
	else
	{
		header("HTTP/1.1 400 Bad Request");
		echo(json_encode(array("Message"=>"failed")));
	}		
}
?>
