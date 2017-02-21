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

	if(isset($_REQUEST['id']))
	{
		try
	{
		$statement=$db->prepare("update tbl_comment set active=1 where c_id=?");
		$statement->execute(array($_REQUEST['id']));
		
		$success="Comment is Approved.";
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

<h2>All Un-approved Comments</h2>
<?php
if(isset($msg)) echo "<div class='error'>".$msg."</div>";
	
if(isset($success)) echo "<div class='success'>".$success."</div>";
?>
<table class="tbl2" width="100%">
	<tr>
		<th>Serial</th>
		<th>Name</th>
		<th>Email</th>
		<th>Comment</th>
		<th>Post ID</th>
		<th>Action</th>
	</tr>
	
	<?php
	$i=0;
	$statement=$db->prepare("select * from tbl_comment where active=0 order by c_id desc");
	$statement->execute();
	$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
	$i++;
	?>	
	
	<tr>
		<td> <?php echo $i; ?> </td>
		<td><?php echo $row['c_name']; ?></td>
		<td><?php echo $row['c_email']; ?></td>
		<td><?php echo $row['c_message']; ?></td>
		
		<td><a class="fancybox" href="#inline<?php echo $i; ?>"><?php echo $row['post_id']; ?></a>
		<div id="inline<?php echo $i; ?>" style="width:600px; display:none;">
		<h3 style="border-bottom:2px solid black">View Post Details</h3>
		<p>
		<?php
		$statement1=$db->prepare("select * from tbl_post where post_id=?");
		$statement1->execute(array($row['post_id']));
		$result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach($result1 as $row1)
		{
		?>
			<table>
			<tr>
				<td><b>Title</b></td>
			</tr>
			<tr>
				<td><?php echo $row1['post_title']; ?></td>
			</tr>
			<tr>
				<td><b>Description</b></td>
			</tr>
			<tr>
				<td><?php echo $row1['post_description']; ?></td>
			</tr>
			<tr>
				<td><b>Featured Image</b></td>
			</tr>
			<tr>
				<td><img src="../upload/<?php echo $row1['post_image']; ?>" alt=""></td>
			</tr>
			
			<tr>
				<td><b>Category</b></td>
			</tr>
			<tr>
				<td>
					<?php
					$statement2=$db->prepare("select * from tbl_category where cat_id=?");
					$statement2->execute(array($row1['cat_id']));
					$result2=$statement2->fetchAll(PDO::FETCH_ASSOC);
					foreach($result2 as $row2)
					{
						echo $row2['cat_name'];
					}
					?>
				</td>
			</tr>
			<tr>
				<td><b>Tag</b></td>
			</tr>
			<tr>
				<td>
				<?php
					$arr = explode(",",$row1['tag_id']);
					$count_arr = count(explode(",",$row1['tag_id']));
					$k=0;
					for($j=0;$j<$count_arr;$j++)
						{
									
							$statement2 = $db->prepare("select * from tbl_tag where tag_id=?");
							$statement2->execute(array($arr[$j]));
							$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
							foreach($result2 as $row2)
								{
									$arr1[$k++] = $row2['tag_name'];
								}
								//$k++;
						}
						$tag_names = implode(",",$arr1);
						echo $tag_names;
					
				?>
				</td>
			</tr>
		</table>
		
		<?php
		}
		?>
		
		</p>
		</div>
		</td>

		<td><a href="comment-approve.php?id=<?php echo $row['c_id']; ?>">Approve</a></td>
		
	</tr>	
	
	<?php
	}
	?>
	
</table>





<h2>All Approved Comments</h2>

<table class="tbl2" width="100%">
	<tr>
		<th>Serial</th>
		<th>Name</th>
		<th>Email</th>
		<th>Comment</th>
		<th>Post ID</th>
	</tr>
	
	<?php
	$i=0;
	$statement=$db->prepare("select * from tbl_comment where active=1 order by c_id desc");
	$statement->execute();
	$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
	$i++;
	?>	
	
	<tr>
		<td> <?php echo $i; ?> </td>
		<td><?php echo $row['c_name']; ?></td>
		<td><?php echo $row['c_email']; ?></td>
		<td><?php echo $row['c_message']; ?></td>
		<td><a class="fancybox" href="#inline<?php echo $i; ?>"><?php echo $row['post_id']; ?></a>
		<div id="inline<?php echo $i; ?>" style="width:600px; display:none;">
		<h3 style="border-bottom:2px solid black">View Post Details</h3>
		<p>
		<?php
		$statement1=$db->prepare("select * from tbl_post where post_id=?");
		$statement1->execute(array($row['post_id']));
		$result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach($result1 as $row1)
		{
		?>
			<table>
			<tr>
				<td><b>Title</b></td>
			</tr>
			<tr>
				<td><?php echo $row1['post_title']; ?></td>
			</tr>
			<tr>
				<td><b>Description</b></td>
			</tr>
			<tr>
				<td><?php echo $row1['post_description']; ?></td>
			</tr>
			<tr>
				<td><b>Featured Image</b></td>
			</tr>
			<tr>
				<td><img src="../upload/<?php echo $row1['post_image']; ?>" alt=""></td>
			</tr>
			
			<tr>
				<td><b>Category</b></td>
			</tr>
			<tr>
				<td>
					<?php
					$statement2=$db->prepare("select * from tbl_category where cat_id=?");
					$statement2->execute(array($row1['cat_id']));
					$result2=$statement2->fetchAll(PDO::FETCH_ASSOC);
					foreach($result2 as $row2)
					{
						echo $row2['cat_name'];
					}
					?>
				</td>
			</tr>
			<tr>
				<td><b>Tag</b></td>
			</tr>
			<tr>
				<td>
				<?php
					$arr = explode(",",$row1['tag_id']);
					$count_arr = count(explode(",",$row1['tag_id']));
					$k=0;
					for($j=0;$j<$count_arr;$j++)
						{
									
							$statement2 = $db->prepare("select * from tbl_tag where tag_id=?");
							$statement2->execute(array($arr[$j]));
							$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
							foreach($result2 as $row2)
								{
									$arr1[$k++] = $row2['tag_name'];
								}
								//$k++;
						}
						$tag_names = implode(",",$arr1);
						echo $tag_names;
					
				?>
				</td>
			</tr>
		</table>
		
		<?php
		}
		?>
		
		</p>
		</div>
		</td>
	</tr>	
	
	<?php
	}
	?>
	
</table>



<?php include("footer.php"); ?>
