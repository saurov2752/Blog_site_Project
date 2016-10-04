<?php
include("config.php");
?>
<div id="templatemo_sidebar">
            	
                <h4>Categories</h4>
				<?php
					$statement=$db->prepare("select * from tbl_category order by cat_name asc");
					$statement->execute();
					$result=$statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
				?>
						 <ul class="templatemo_list">
						<li><a href="index.html"><?php echo $row['cat_name'] ?></a></li>
						</ul>
				<?php
					}
				?>
				
				
				
               
                
                <div class="cleaner_h40"></div>
                
                <h4>Friends</h4>
                <ul class="templatemo_list">
                    <li><a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a></li>
                    <li><a href="http://www.flashmo.com" target="_parent">Flash Templates</a></li>
                    <li><a href="http://www.templatemo.com/page/1" target="_parent">Free Blog Themes</a></li>
                    <li><a href="http://www.webdesignmo.com/blog" target="_parent">Web Design Blog</a></li>
                    <li><a href="http://www.koflash.com" target="_parent">Flash Websites Gallery</a></li>
                    <li><a href="#">Vestibulum laoreet</a></li>
                    <li><a href="#">Nullam nec mi enim</a></li>
                    <li><a href="#">Aliquam quam nulla</a></li>
                </ul>
                
          <div id="ads">
                	<a href="#"><img src="images/templatemo_200x100_banner.jpg" alt="banner 1" /></a>
                    
                    <a href="#"><img src="images/templatemo_200x100_banner.jpg" alt="banner 2" /></a>
              </div>
                
            </div>
        
        	<div class="cleaner"></div>
        </div>
    </div><div id="templatemo_main_bottom"></div>
</div>

<div id="templatemo_footer">
	<?php
	$statement=$db->prepare("select * from tbl_footer where id=1");
	$statement->execute();
	$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
		echo $row['description'];
	}
	?>
   
    
</div>
</html>
