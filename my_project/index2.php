<?php
include('config.php');
if(!isset($_REQUEST['id']))
{
	header("location: index.php"); 
}
else
{
	$id= $_REQUEST['id'];
}
?>

<?php
if(isset($_POST["form1"]))
{
	try
	{
		if(empty($_POST["c_name"]))
		{
			throw new Exception("Name field cant empty");
		}
		
		if(empty($_POST["c_email"]))
		{
			throw new Exception("Email field cant empty");
		}
		
		if(empty($_POST["c_message"]))
		{
			throw new Exception("Comment field cant empty");
		}
		
		if (!(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST["c_email"])))
			{
				throw new Exception("Enter valid Email address");
			}
		$c_date=date('Y-m-d');
		$active=0;
		$statement=$db->prepare("insert into tbl_comment (c_name,c_email,c_message,c_date,post_id,active) value (?,?,?,?,?,?)");
		$statement->execute(array($_POST["c_name"],$_POST["c_email"],$_POST["c_message"],$c_date,$id,$active));
		$success="Your Comment has been sent. It will be published on the website after admin's approval.";
	}
	
	catch(Exception $e)
	{
		$msg=$e->getMessage();
	}
}
?>

<?php
include('header.php');
?>

<div id="templatemo_main_wrapper">
	<div id="templatemo_main">
		<div id="templatemo_main_top">
        
        	<div id="templatemo_content">
			
			<?php
			$statement=$db->prepare("select * from tbl_post where post_id=?");
			$statement->execute(array($_REQUEST['id']));
			$result=$statement->fetchAll(PDO::FETCH_ASSOC);
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
                    
                	<strong>Author:</strong> Saurov | <strong>Tags:</strong> 
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
                    <a class="fancybox-effects-a" href="upload/<?php echo $row['post_image']; ?>" title="">
                    <img src="upload/<?php echo $row['post_image'] ?>" alt="image" width="400px" height="200px" ">
                    </a>
                    <p><?php echo $row['post_description'] ?></p>
					
					
					
					<div class="comment_tab">
                        Comments
                    </div>
                    
                    <div id="comment_section">
                <ol class="comments first_level">
                        
                        <li>
						<?php
						$statement=$db->prepare("select * from tbl_comment where active=1 and post_id=?");
						$statement->execute(array($id));
						$result=$statement->fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $row)
						{
						?>
						<div class="comment_box commentbox1">
                                    
                                <div class="gravatar">
								<?php 
									$gravatarMd5 = md5($row['c_email']);
									//$gravatarMd5 = "";   // when no gravatar is found
								?>
								<!--<img src="http://www.gravatar.com/avatar/<?php echo $gravatarMd5; ?>" alt="" width="" height=""> <br>-->
								
								<!--<img src="images/avatar1.jpg" alt="" width="80" height="80" /><br />-->

                                    <img src="http://www.gravatar.com/avatar/<?php echo $gravatarMd5; ?>" alt="" />
                                </div>
                                
                                <div class="comment_text">
                                    <div class="comment_author"><?php echo $row['c_name']; ?> <span class="date">
									<?php
									$year=substr($row['c_date'],0,4);
									$month=substr($row['c_date'],5,2);
									$day=substr($row['c_date'],8,2);
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
									echo $month_full." ".$day.", ".$year;
									?>
									</span> <span class="time">10:35 pm</span></div>
                                    <p><?php echo $row['c_message']; ?></p>
                                  <div class="reply"><a href="#">Reply</a></div>
                                </div>
                                <div class="cleaner"></div>
                            </div>
						<?php
						}
						?>
                                                    
                            
                        </li>
                        
                        <!--<li>
                        
                        
                            	<ol class="comments">
                            
                                    <li>
                                        <div class="comment_box commentbox2">
                                        
                                        <div class="gravatar">
                                        <img src="images/avator.png" alt="author 5" />
                                        </div>
                                        <div class="comment_text">
                                        <div class="comment_author">Julie <span class="date">November 27, 2048</span> <span class="time">09:20 pm</span></div>
                                        <p>Nullam bibendum tempor est nec cursus.</p>
                                        <div class="reply"><a href="#">Reply</a></div>
                                        </div>
                                        
                                        <div class="cleaner"></div>
                                        </div>                        
                                    
                                    
                                    </li>
                                    
                                    <li>
                                    
                            
                                        <ol class="comments">
                                    
                                            <li>
                                                <div class="comment_box commentbox1">
                                                
                                                    <div class="gravatar">
                                                        <img src="images/avator.png" alt="author 4" />
                                                    </div>
                                                    <div class="comment_text">
                                                        <div class="comment_author">John <span class="date">November 28, 2048</span> <span class="time">11:12 am</span></div>
                                                        <p> Vestibulum eget ligula et ipsum laoreet aliquam sed ut risus.  </p>
                                                      <div class="reply"><a href="#">Reply</a></div>
                                                    </div>
                                                    
                                                    <div class="cleaner"></div>
                                                </div>                        
                                                
                                                
                                            </li>
                                    
                                        </ol>
                        
                        			</li>
                                </ol>
                                
						</li>      -->
                    </ol>
                </div>
                    
                	<div id="comment_form">
                    <h3>Leave a comment</h3>
                    <?php
					if(isset($msg)) echo "<b>".$msg."</b>";
						
					if(isset($success)) echo "<b>".$success."</b>";
					?>
                    <form action="index2.php?id=<?php echo $id;  ?>" method="post">
                        <div class="form_row">
                            <label>Name ( Required )</label><br />
                            <input type="text" name="c_name" placeholder="Name" />
                        </div>
                        <div class="form_row">
                            <label>Email  (Required, will not be published)</label><br />
                            <input type="text" name="c_email" placeholder="Email"  />
                        </div>
                        <div class="form_row">
                            <label>Your comment</label><br />
                            <textarea  name="c_message" rows="" cols="" placeholder="Your comment" ></textarea>
                        </div>

                        <input type="submit" name="form1" value="Submit" class="submit_btn" />
                    </form>
                    
                </div>
                
            	</div>

                <div class="cleaner"></div>
                
            </div>
            <?php
				}
			?>
            
       	  </div>
            
<?php
include('footer.php');
?>
