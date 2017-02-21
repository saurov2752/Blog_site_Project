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
	if(!isset($_REQUEST['id'])) header('location:post_view.php');
	else
		$id=$_REQUEST['id'];
?>

<?php

if(isset($_POST['form1']))
{
	try
	{
		if(empty($_POST['title'])) throw new Exception("Title field can not empty");
		
		if(empty($_POST['description'])) throw new Exception("Description field can not empty");
		
		if(empty($_POST['cat_id'])) throw new Exception("Category field can not empty");
		
		if(empty($_POST['tag_id'])) throw new Exception("Tag field can not empty");
		
		$tag_id=$_POST['tag_id'];
		$i=0;
		foreach($tag_id as $val)
		{
			//echo $val."<br>";   evabe o value paoa jai.............
			$ary[$i]=$val;
			//echo $ary[$i]."<br>";
			$i++;
		}
		$tag_ids=implode(",",$ary);
		
		//$date= date('Y-m-d');
		//$timestamp= strtotime(date('Y-m-d'));
		
		if(empty($_FILES["post_image"]["name"]))
		{
			//echo "not updated";
			$statement=$db->prepare("update tbl_post set post_title=?,post_description=?,cat_id=?,tag_id=? where post_id=?");
			$statement->execute(array($_POST['title'],$_POST['description'],$_POST['cat_id'],$tag_ids,$id));
		}
		else {
			//echo "updated";
			$up_file=$_FILES["post_image"]["name"];
			$file_basename = substr($up_file, 0, strripos($up_file, '.')); 
			$file_ext = substr($up_file, strripos($up_file, '.'));
			$f1 = $id . $file_ext;
		
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
			
			$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
			$statement->execute(array($id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row)
			{
				$real_path = "../upload/".$row['post_image'];
				unlink($real_path);
			}
			move_uploaded_file($_FILES["post_image"]["tmp_name"],"../upload/" . $f1);
			
			
			$statement = $db->prepare("UPDATE tbl_post SET post_title=?, post_description=?,post_image=?, cat_id=?, tag_id=? WHERE post_id=?");
			$statement->execute(array($_POST['title'],$_POST['description'],$f1,$_POST['cat_id'],$tag_ids,$id));
			
		}

		$success="Data Updated Successfully";
	}
	catch(Exception $e)
	{
		$msg=$e->getMessage();
	}
}


?>

<?php
	$statement=$db->prepare("select * from tbl_post where post_id=?");
	$statement->execute(array($id));
	$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
		$post_title=$row['post_title'];
		$post_description=$row['post_description'];
		$post_image=$row['post_image'];
		$cat_id=$row['cat_id'];
		$tag_id=$row['tag_id'];
	}
?>

<?php include("header.php"); ?>

<h2>Edit Post</h2>

<?php
if(isset($msg)) echo "<div class='error'>".$msg."</div>";
	
if(isset($success)) echo "<div class='success'>".$success."</div>";
?>


<form action="post_edit.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
<table class="tbl1">
	<tr><td>Title</td></tr>
	<tr><td><input class="long" type="text" name="title" value="<?php echo $post_title ?>"></td></tr>
	<tr><td>Description</td></tr>
	
	<tr>
	<td><textarea name="description" cols="30" rows="10"><?php echo $post_description ?></textarea>
	
	
	<script type="text/javascript">
	if ( typeof CKEDITOR == 'undefined' )
	{
		document.write(
			'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
			'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
			'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
			'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
			'value (line 32).' ) ;
	}
	else
	{
		var editor = CKEDITOR.replace( 'description' );
		//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
	}

	</script>
	
	</td>
	</tr>
	
	<tr><td>Previous Image Preview</td></tr>
	<tr><td><img src="../upload/<?php echo $post_image ?>" alt="" width=200px;></td></tr>
	
	<tr><td>New Image</td></tr>
	<tr><td><input type="file" name="post_image"></td></tr>
	
	<tr><td>select Categories</td></tr>
	<tr>
		<td>
		<select name="cat_id">
		<option>Select Category</option>
		<?php
		$statement1=$db->prepare("select * from tbl_category order by cat_name asc");
		$statement1->execute();
		$result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach($result1 as $row1)
		{
		if($row1['cat_id'] == $cat_id)
			{
			?><option value="<?php echo $row1['cat_id']; ?>" selected><?php echo $row1['cat_name']; ?></option><?php
			}
			else 
			{
			?><option value="<?php echo $row1['cat_id']; ?>"><?php echo $row1['cat_name']; ?></option><?php
			}
		}
		
		?>
		</select>
		</td>
	</tr>
	
	<tr><td>select Tag</td></tr>
	<tr>
		<td>		
			<?php
		$statement=$db->prepare("select * from tbl_tag order by tag_name asc");
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$arr = explode(",",$tag_id);
			$count_arr = count(explode(",",$tag_id));
			$f=0;
			for($i=0;$i<$count_arr;$i++)
			{
				if($arr[$i]==$row['tag_id'])
				{
					$f=1;
					break;
				}
			}
			if($f==1)
			{
				?><input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id'];  ?>" checked>    <?php echo $row['tag_name'];  ?>&nbsp;&nbsp;
					<?php
			}
			else
			{
				?><input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id'];  ?>">    <?php echo $row['tag_name'];  ?>&nbsp;&nbsp;
				<?php
			}
			
		}
		
		?>
					
					
		</td>
	</tr>
	
	<tr><td><input type="submit" name="form1" value="Update"></td></tr>
	
</table>
</form>

<?php include("footer.php"); ?>
