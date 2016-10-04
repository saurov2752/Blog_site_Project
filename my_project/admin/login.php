<?php
include ("../config.php");
if(isset($_POST['form1']))
{
	$user=$_POST['username'];
	$pass=$_POST['password'];
	try
	{
		if(empty($user))
			throw new Exception("Username can not Empty");
		
		if(empty($pass))
			throw new Exception("Password can not Empty");
		
		$pass=md5($pass);
		
		$num=0;
		$statement=$db->prepare("select * from tbl_admin where username=? and password=? and id=1");
		$statement->execute(array($user,$pass));
		 
		$num=$statement->rowCount();
		 
		//var_dump($num);
		//exit;   
		if($num>0)
		{
			session_start();
			$_SESSION['name']="admin";
			header('location:index.php');
		}
		else
		{
			throw new Exception("Invalid Username and/or Password");
			//header('location:login.php');
		}
	}
	catch(Exception $e)
	{
		$msg=$e->getMessage();
	}
}

?>




<DOCTYPE html>
<html>
<head>
<title>Welcome to Login</title>
<link href="../style-admin.css" rel="stylesheet" type="text/css" >

</head>

<body>
<div id="wrapper-login">
<h1>Admin Panel</h1>

<?php
		if(isset($msg))
		{
			echo "<div class='error'>".$msg."</div>";
		}	
		?>

<form action="" method="post">
	<table>
	<tr>
		<td>Username</td>
		<td><input type="text" name="username"></td>
	</tr>
	
	<tr>
		<td>Password</td>
		<td><input type="password" name="password"></td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="submit" name="form1" value="Login"></td>
	</tr>
	</table>
</form>
</div>
</body>

</html>