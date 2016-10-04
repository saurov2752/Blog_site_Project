<?php

ob_start();
session_start();
if($_SESSION['name']!="admin")
{
	header('location:login.php');
}
  
?>

<?php include("header.php"); ?>

<h1>Welcome to Admin Panel</h1>
<div style="color:blue;font size:20px;text-align:center;padding-top:20px;">
<p>Welcome to Dashboard of<br> sample blog with php</p>
</div>


<?php include("footer.php"); ?>