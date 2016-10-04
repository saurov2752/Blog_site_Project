<?php

ob_start();
session_start();
if($_SESSION['name']!="admin")
{
	header('location:login.php');
}
  include("../config.php");
?>

<?php include("header.php"); ?>

<h2>view all posts</h2>

<table class="tbl2" width="100%">
	<tr>
		<th>Serial</th>
		<th>Title</th>
		<th>Action</th>
	</tr>
	
	<?php
	$i=0;
	$statement=$db->prepare("select * from tbl_post order by post_id desc");
	$statement->execute();
	$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
	$i++;
	?>	
	
	<tr>
		<td> <?php echo $i; ?> </td>
		<td><?php echo $row['post_title']; ?></td>
		<td><a class="fancybox" href="#inline<?php echo $i; ?>">view</a> 
		<div id="inline<?php echo $i; ?>" style="width:600px; display:none;">
		<h3 style="border-bottom:2px solid black">View all Data</h3>
		<p>
		<form action="" method="post">
		<table>
			<tr>
				<td><b>Title</b></td>
			</tr>
			<tr>
				<td><?php echo $row['post_title']; ?></td>
			</tr>
			<tr>
				<td><b>Description</b></td>
			</tr>
			<tr>
				<td><?php echo $row['post_description']; ?></td>
			</tr>
			<tr>
				<td><b>Featured Image</b></td>
			</tr>
			<tr>
				<td><img src="../upload/<?php echo $row['post_image']; ?>" alt=""></td>
			</tr>
			
			<tr>
				<td><b>Category</b></td>
			</tr>
			<tr>
				<td>
					<?php
					$statement1=$db->prepare("select * from tbl_category where cat_id=?");
					$statement1->execute(array($row['cat_id']));
					$result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
					foreach($result1 as $row1)
					{
						echo $row1['cat_name'];
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
					$arr = explode(",",$row['tag_id']);
					$count_arr = count(explode(",",$row['tag_id']));
					$k=0;
					for($j=0;$j<$count_arr;$j++)
						{
									
							$statement1 = $db->prepare("select * from tbl_tag where tag_id=?");
							$statement1->execute(array($arr[$j]));
							$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
							foreach($result1 as $row1)
								{
									$arr1[$k++] = $row1['tag_name'];
								}
								//$k++;
						}
						$tag_names = implode(",",$arr1);
						echo $tag_names;
					
				?>
				
				
				
				</td>
			</tr>
			
			<tr>
				<td><input type="submit" name="" value="Update"></td>
			</tr>
		</table>
		</form>
		</p>
		</div>
		&nbsp;| &nbsp;
		<a href="post_edit.php?id=<?php echo $row['post_id'];  ?>">Edit</a>
		&nbsp;| &nbsp; 
		<a onclick="return confirm_delete();" href="post_delete.php?id=<?php echo $row['post_id'];  ?>">Delete</a></td>
	</tr>	
	
	<?php
	}
	?>
	
</table>

<?php include("footer.php"); ?>