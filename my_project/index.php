<?php
include('header.php');
include('config.php');
?>

<div id="templatemo_main_wrapper">
	<div id="templatemo_main">
		<div id="templatemo_main_top">
        
        	<div id="templatemo_content"> 
			
			<?php
			/* ===================== Pagination Code Starts ================== */
			$adjacents = 7;

			$statement = $db->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC");
			$statement->execute();
			$total_pages = $statement->rowCount();
							
			
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 5;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
						
			$statement = $db->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC LIMIT $start, $limit");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&#171; previous</span>";    
				if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{   
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
				{
					if($page < 1 + ($adjacents * 2))        
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					else
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
					}
				}
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &#187;</span>";
				$pagination.= "</div>\n";       
			}
			/* ===================== Pagination Code Ends ================== */	
			
			?>	
			
	<?php

	foreach($result as $row)
	{?>
        
    		<div class="post_section">
            
            	<div class="post_date">
				<?php
				$post_date=$row["post_date"];
				$year=substr($post_date,0,4);
				$month=substr($post_date,5,2);
				$date=substr($post_date,8,2);
					if($month=='01') {$month="Jan";}
					if($month=='02') {$month="Feb";}
					if($month=='03') {$month="Mar";}
					if($month=='04') {$month="Apr";}
					if($month=='05') {$month="May";}
					if($month=='06') {$month="Jun";}
					if($month=='07') {$month="Jul";}
					if($month=='08') {$month="Aug";}
					if($month=='09') {$month="Sep";}
					if($month=='10') {$month="Oct";}
					if($month=='11') {$month="Nov";}
					if($month=='12') {$month="Dec";}
				?>
                	<?php echo $date ?><span><?php echo $month ?></span>
            	</div>
		<div class="post_content">
                
                    <h2><?php echo $row['post_title']?></h2>

                    <strong>Author:</strong> Saurov | <strong>Tags:</strong> &nbsp;
					<?php
					$arr = explode(",",$row['tag_id']);
					$count_arr = count(explode(",",$row['tag_id']));
					$k=0;
					for($j=0;$j<$count_arr;$j++)
					{
						
						$statement1 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=?");
						$statement1->execute(array($arr[$j]));
						$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result1 as $row1)
						{
							$k++;
							if($k>1){echo ",".$row1['tag_name'];}
							//$arr1[$k] = $row1['tag_name'];
							else echo $row1['tag_name'];
						}
						//$k++;
					}
					//$tag_names = implode(",",$arr1);
					//echo $tag_names;
				?>
					
                    
                    <img src="upload/<?php echo $row['post_image'] ?>" alt="image" width="400px" height="200px" ">
                    <?php
					$pieces = explode(" ", $row['post_description']);
					$final_words = implode(" ", array_splice($pieces, 0, 30));
					$final_words = $final_words.' ...';
					?>
                    <p><?php echo $final_words ?></p>
					<p>
					<?php
					$statement = $db->prepare("SELECT * FROM tbl_comment where post_id=? and active=1");
					$statement->execute(array($row['post_id']));
					$total_num = $statement->rowCount();
					echo $total_num;
					?>
					 Comments
					 | <a href="index2.php?id=<?php echo $row['post_id']  ?>">Continue reading...</a>                </p>
</div>
                <div class="cleaner"></div>
            </div>
<?php
	}
?>


<?php 
echo $pagination; 
?>


</div>   
<?php
include('footer.php');
?>
