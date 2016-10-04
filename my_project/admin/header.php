<DOCTYPE html>
<html>
<head>
<title>Welcome to Dashboard</title>
<link href="../style-admin.css" rel="stylesheet" type="text/css" >
	<script>
		function confirm_delete()
		{
			return confirm("Are you sure want to delete?");  //here confirm is a keyword;
		}
	</script>
		
		<!-- Fancybox jQuery -->
	<script type="text/javascript" src="../fancybox/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="../fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript" src="../fancybox/main.js"></script>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox.css" />
	<!-- //Fancybox jQuery --> 
		
		
		<!-- CKEditor Start -->
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
	<!-- // CKEditor End -->
		
</head>

<body>
	
	<div id="wrapper">
		<div id="header">
		<h1>Admin Panel</h1>
		</div>
		<div id="container">
		<div id="sidebar">
		<h2>page options</h2>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="change_footer.php">Change Footer Text</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
		
		<h2>Blog options</h2>
		<ul>
			<li><a href="post_add.php">Add post</a></li>
			<li><a href="post_view.php">View Post</a></li>
			<li><a href="category_name.php">Manage Category</a></li>
			<li><a href="tag_name.php">Manage Tags</a></li>
		</ul>
		<h2>Comment section</h2>
		<ul>
		<li><a href="comment-approve.php">View Comments</a></li>
		</ul>
		
		</div>
				<div id="content">