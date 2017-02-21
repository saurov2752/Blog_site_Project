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
						<li><a href="category.php?id=<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name'] ?></a></li>
						</ul>
				<?php
					}
				?>
                
                <div class="cleaner_h40"></div>
				<h4>Archives</h4>
                <?php
					$j=0;
					$statement=$db->prepare("select distinct(post_date) from tbl_post order by post_date desc");
					$statement->execute();
					$result=$statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
						$ym=substr($row['post_date'],0,7);
						$ary[$j++]=$ym;
					}
					$result=array_unique($ary);
					$final_val=implode(",",$result);
					$final_arr_date=explode(",",$final_val);
					$final_arr_date_count=count(explode(",",$final_val));
					for($i=0;$i<$final_arr_date_count;$i++)
					{
						$year=substr($final_arr_date[$i],0,4);
						$month=substr($final_arr_date[$i],5,2);
						if($month=='01') {$month_full="January";}
						if($month=='02') {$month_full="February";}
						if($month=='03') {$month_full="March";}
						if($month=='04') {$month_full="April";}
						if($month=='05') {$month_full="May";}
						if($month=='06') {$month_full="June";}
						if($month=='07') {$month_full="July";}
						if($month=='08') {$month_full="August";}
						if($month=='09') {$month_full="September";}
						if($month=='10') {$month_full="October";}
						if($month=='11') {$month_full="November";}
						if($month=='12') {$month_full="December";}
				?>
					<ul class="templatemo_list">
					
						 <ul class="templatemo_list">
						<li><a href="archive.php?date=<?php echo $final_arr_date[$i]; ?>"><?php echo $month_full.", ".$year."<br>"; ?></a></li>
						</ul>
				
				
                </ul>
				<?php
					}
				?>
                
              
                
            </div>
        
        	<div class="cleaner"></div>
            
        </div>
        
    </div>
    
    <div id="templatemo_main_bottom"></div>
    
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

</body>
</html>
