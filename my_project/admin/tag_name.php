<?php
ob_start();
session_start();
if($_SESSION['name']!="admin")
{
	header('location:login.php');
} 
include("../config.php");
?>

<?php
if(isset($_POST['form1']))
{
	$tag_name=$_POST['tag_name'];
	try
	{
		if(empty($tag_name))
			throw new Exception("Tag Name can not Empty");
		$num=0;
		$statement=$db->prepare("select * from tbl_tag where tag_name=?");
		$statement->execute(array($tag_name));
		$num=$statement->rowCount();
		if($num>0)
		{
			throw new Exception("Tag Name already exist");
		}
		$statement=$db->prepare("insert into tbl_tag (tag_name) value (?)");
		$statement->execute(array($tag_name));
		
		$success="Tag name inserted successfully";
	}	

	catch(Exception $e)
	{
		$msg=$e->getMessage();
	}
}
?>

<?php
if(isset($_POST['form2']))
{
	try
	{
		if(empty($_POST['tag_name']))
			throw new Exception("Tag Name can not Empty");
		
		$statement=$db->prepare("update tbl_tag set tag_name=? where tag_id=?");
		$statement->execute(array($_POST['tag_name'],$_POST['hdn']));
		
		$success2="Tag name has been updated successfully";
	}
	catch(Exception $e)
	{
		$msg2=$e->getMessage();
	}
}
?>

<?php
if(isset($_REQUEST['id']))
{
	$statement=$db->prepare("delete from tbl_tag where tag_id=?");
	$statement->execute(array($_REQUEST['id']));
	$dlt_msg="Tag name has been deleted successfully";
}

?>

<?php include("header.php"); ?>

<h2>Add New tag</h2>
<p>&nbsp;</p>
<?php
		if(isset($msg))
		{
			echo "<div class='error'>".$msg."</div>";
		}	
		if(isset($success))
		{
			echo "<div class='success'>".$success."</div>";
		}
?>

<form action="" method="post">
<table class="tbl1">
	<tr>
		<td>Tag Name: </td>
		<td><input class="short" type="text" name="tag_name"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="form1" value="Save"></td>
	</tr>
	
</table>
</form>
<h3 style="text-decoration:underline; text-align:center;">View all Tags</h3>
<p>&nbsp;</p>
<?php
		if(isset($msg2))
		{
			echo "<div class='error'>".$msg2."</div>";
		}	
		if(isset($success2))
		{
			echo "<div class='success'>".$success2."</div>";
		}
		if(isset($dlt_msg))
		{
			echo "<div class='success'>".$dlt_msg."</div>";
		}
?>

<table class="tbl2" width="100%">
	<tr>
		<th>Serial</th>
		<th>Tag Name</th>
		<th>Action</th>
	</tr>
	
<?php
$i=0;
$statement=$db->prepare("select * from tbl_tag");
$statement->execute();
$result=$statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
	$i++;
?>	
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row['tag_name']; ?></td>
		<td><a class="fancybox" href="#inline<?php echo $i; ?>">Edit</a> 
		<div id="inline<?php echo $i; ?>" style="width:400px; display:none;">
		<h3>Edit Data</h3>
		<p>
		<form action="" method="post">
		<input type="hidden" name="hdn" value="<?php echo $row['tag_id']; ?>">
		<table>
			<tr>
				<td>Tag Name:</td>
			</tr>
			<tr>
				<td><input type="text" name="tag_name" value="<?php echo $row['tag_name']; ?>"></td>
			</tr>
			<tr>
				<td><input type="submit" name="form2" value="Update"></td>
			</tr>
		</table>
		</form>
		</p>
		</div>
		
		&nbsp;| &nbsp; <a onclick="return confirm_delete();" href="tag_name.php?id=<?php echo $row['tag_id']; ?>">Delete</a></td>
	</tr>
	
<?php	
}
?>
	
	
</table>

<?php include("footer.php"); ?>
