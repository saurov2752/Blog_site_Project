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
		try
	{
		if(empty($_POST['footer'])) throw new Exception("Footer field can not empty");
		
		$statement=$db->prepare("update tbl_footer set description=? where id=1");
		$statement->execute(array($_POST['footer']));
		
		$success="Footer Updated Successfully";
	}
	catch(Exception $e)
	{
		$msg=$e->getMessage();
	}
	}

?>

<?php
	$statement=$db->prepare("select * from tbl_footer where id=1");
	$statement->execute();
	$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
		$new_footer=$row['description'];
	}
	
	

?>

<?php include("header.php"); ?>

<h2>Change Footer Text</h2>

<?php
if(isset($msg)) echo "<div class='error'>".$msg."</div>";
	
if(isset($success)) echo "<div class='success'>".$success."</div>";
?>

<form action="" method="post">
<table class="tbl1">
	<tr>
		<td>Footer text: </td>
		<td><input class="long" type="text" name="footer" value="<?php echo $new_footer; ?>"></td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="submit" name="form1" value="Save"></td>
	</tr>
	
</table>
</form>


<?php include("footer.php"); ?> 
