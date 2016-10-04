<?php
include('header.php');
include('config.php');
?>

<?php
	$statement=$db->prepare("select * from tbl_post order by post_id desc");
	$statement->execute();
	$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{?>
	<div id="templatemo_main_wrapper">
	<div id="templatemo_main">
		<div id="templatemo_main_top">
		<div id="templatemo_content">
        
    		<div class="post_section">
            
            	<div class="post_date">
                	30<span>Nov</span>
            	</div>
<div class="post_content">
                
                    <h2><?php echo $row['post_title']?></h2>

                    <strong>Author:</strong> Saurov | <strong>Tags:</strong> <a href="#">PSD</a>, <a href="#">Templates</a>
                    
                    <img src="upload/<?php echo $row['post_image'] ?>" alt="image" width="300px" height="200px">
                    
                    <p><?php echo $row['post_description'] ?></p>
</div>
                <div class="cleaner"></div>
            </div>
        
       	  </div>
		
		
		
	
	<?php
	}

?>
 
<?php
include('footer.php');
?>   
          