<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
 confirm_login();?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://kit.fontawesome.com/ec4472c738.js" crossorigin="anonymous"></script>
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="styles.css">
		<title>Dashboard</title>
	</head>
<body>
<!-- nav bar begin -->
	<div style="height:10px; background:#3366ff;"></div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
	<a href='basic.html' class="navbar-brand">vishwath.com</a>
	<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarcollapseCMS">
	<ul class="navbar-nav mr-auto">
		<li class="nav-item">
		<a href='myprofile.php' class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
		</li>
		<li class="nav-item">
		<a href='dashboard.php' class="nav-link">Dashboard</a>
		</li>
		<li class="nav-item">
		<a href='posts.php' class="nav-link">Posts</a>
		</li>
		<li class="nav-item">
		<a href='categories.php' class="nav-link">Categories</a>
		</li>
		<li class="nav-item">
		<a href='admins.php' class="nav-link">Manage Admins</a>
		</li>
		<li class="nav-item">
		<a href='comments.php' class="nav-link">Comments</a>
		</li>
		<li class="nav-item">
		<a href='blog.php?page=1' class="nav-link">Live Blog</a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto">
		<li class="navbar-nav">
		<a href="logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i>Logout</a>
		</li>
	<ul>
	</div>
	</div>
	</nav>
	<div style="height:10px; background:#3366ff;"></div>
	<!-- nav bar end -->
	<!-- header begin-->
	<header class="bg-dark text-white py-3">
	 <div class="container">
	  <div class="row"> 
	    <div class="col-md-12">
	  	 <h1><i class="fas fa-cog" style="color:#3366ff;"></i> Dashboard</h1>
		</div>
		<div class="col-lg-3 mb-2">
		 <a href="addnewpost.php" class="btn btn-primary btn-block">
		 <i class="fas fa-edit"> Add new post</i> 
		 </a>
		</div>		
		<div class="col-lg-3 mb-2">
		 <a href="categories.php" class="btn btn-info btn-block">
		 <i class="fas fa-folder-plus"> Add new category</i> 
		 </a>
		</div>
		<div class="col-lg-3 mb-2">
		 <a href="admins.php" class="btn btn-warning btn-block">
		 <i class="fas fa-user-plus"> Add new admin</i> 
		 </a>
		</div>
		<div class="col-lg-3 mb-2">
		 <a href="comments.php" class="btn btn-success btn-block">
		 <i class="fas fa-check"> Add new comment</i> 
		 </a>
		</div>		
	  </div>
	 </div>
	</header>
	<!-- header end-->
	<!-- main area begin-->
	<section class="container py-2 mb-4">
	 <div class="row">
	  	<?php
		echo errormessage();
		echo successmessage();
		?>
	<!-- left main area begin-->
		<div class="col-lg-2 d-none d-md-block">
		 <div class="card text-center bg-dark text-white mb-3">
		  <h1 class="lead">Posts</h1>
		  <h4 class="display-5"><i class="fab fa-readme"></i>
		   <?php
		    global $ConnectingDB;
			$sql="SELECT COUNT(*)FROM posts";
			$stmt=$ConnectingDB->query($sql);
			$totalrows=$stmt->fetch();
			$totalposts=array_shift($totalrows);
			echo $totalposts;
		   ?>
		  </h4>
		 </div>
		 <div class="card text-center bg-dark text-white mb-3">
		  <h1 class="lead">Categories</h1>
		  <h4 class="display-5"><i class="fas fa-folder"></i>
		   <?php
		    global $ConnectingDB;
			$sql="SELECT COUNT(*)FROM category";
			$stmt=$ConnectingDB->query($sql);
			$totalrows=$stmt->fetch();
			$totalposts=array_shift($totalrows);
			echo $totalposts;
		   ?>
		   </h4>
		 </div>
		 <div class="card text-center bg-dark text-white mb-3">
		  <h1 class="lead">Admins</h1>
		  <h4 class="display-5"><i class="fas fa-users"></i>
		   <?php
		    global $ConnectingDB;
			$sql="SELECT COUNT(*)FROM admins";
			$stmt=$ConnectingDB->query($sql);
			$totalrows=$stmt->fetch();
			$totalposts=array_shift($totalrows);
			echo $totalposts;
		   ?>
		   </h4>
		 </div>
		 <div class="card text-center bg-dark text-white mb-3">
		  <h1 class="lead">Comments</h1>
		  <h4 class="display-5"><i class="fas fa-comments"></i>
		   <?php
		    global $ConnectingDB;
			$sql="SELECT COUNT(*)FROM comments";
			$stmt=$ConnectingDB->query($sql);
			$totalrows=$stmt->fetch();
			$totalposts=array_shift($totalrows);
			echo $totalposts;
		   ?>
		   </h4>
		 </div>
		</div>
		
	<!-- left main area end-->
	<!-- right main area begin-->
	<div class="col-lg-10">
	 <h1>Top Posts</h1>
	   <table class="table table-striped table-hover">
	    <thead class="thead-dark">
		 <tr>
		  <th>#</th>
		  <th>Title</th>
		  <th>Date & Time</th>
		  <th>Author</th>
		  <th>Comments</th>
		  <th>Details</th>
		  </tr>
		</thead>
	    
		<?php 
		 global $ConnectingDB;
		 $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
		 $stmt=$ConnectingDB->query($sql);
		 $sr=0;
		 while($datarows=$stmt->fetch())
		 {
			 $id=$datarows["id"];
			 $datetime=$datarows["datetime"];
			 $posttitle=$datarows["title"];
			 $admin=$datarows["author"];
			 $sr++;
		?>
		<tbody>
		<tr>
		 <td><?php echo $sr; ?></td>
		 <td><?php if(strlen($posttitle)>20){$posttitle=substr($posttitle,0,15).'...';} echo $posttitle; ?></td>
		 <td><?php if(strlen($datetime)>25){$datetime=substr($datetime,0,11).'...';} echo $datetime; ?></td>
		 <td><?php if(strlen($admin)>10){$admin=substr($admin,0,6).'...';} echo $admin; ?></td>
		 <td>
		  <?php
		    $total=approvecomment($id);
			if($total>0)
			{
				?>
				<span class="badge badge-success">
				<?php echo $total;?>
				</span>
				<?php
			}
			$total=disapprovecomment($id);
			if($total>0)
			{
				?>
				<span class="badge badge-danger">
				<?php echo $total;?>
				</span>
				<?php
			}
		  ?>
		  
		 </td>
		 <td><a href="fullpost.php?id=<?php echo $id;?>" target="_blank"><span class="btn btn-info">Preview</span></a></td>
		</tr>
		</tbody>
		 <?php } ?>
	   </table>	 
	</div>
	<!-- right main area end-->
	 </div>
	</section>
	<!-- main area end-->
	<!-- footer begin-->
	<footer class="bg-dark text-white">
	<div class="container">
		<div class="row">
			<div class="col">
			<p class="lead text-center">Theme by | Vishwath Ramachandran| <span id="year"></span> &copy; ----All Rights Reserved.</p>
			<p class="text-center small"><a style="color:white; text-decoration:none; corsor:pointer;" href="http://www.nasa.gov/">
			This site is ceated for fun. Go to udemy to learn more about how to do this.<br>Vishwath.com | NASA | Udemy<br>
			</p>
		</div>
		</div>
	</div>
	</footer>
	<div style="height:10px; background:#3366ff;"></div>
	<!-- footer end-->
	
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
		$('#year').text(new Date().getFullYear());
	</script>
</body>
</html>