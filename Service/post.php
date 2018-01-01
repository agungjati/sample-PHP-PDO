<?php
include_once '../Core/DbCrud.php';
include_once '../Core/DbContext.php';
include_once '../Models/post.php';

$Connection = new DbCrud($conn, 'posts');
$model = new post();

if(isset($_POST['input']))
{
	$model->Id = '';
	$model->Title = mysql_real_escape_string($_POST['Title']);
	$model->Content = mysql_real_escape_string($_POST['Content']);
	$model->Image = mysql_real_escape_string($_POST['Image']);
	$model->Creator = mysql_real_escape_string($_POST['Creator']);
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
	$model->Title = mysql_real_escape_string($_POST['Title']);
	$model->Content = mysql_real_escape_string($_POST['Content']);
	$model->Image = mysql_real_escape_string($_POST['Image']);
	$model->Creator = mysql_real_escape_string($_POST['Creator']);
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
