<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 confirm_login();?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://kit.fontawesome.com/ec4472c738.js" crossorigin="anonymous"></script>
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="styles.css">
		<title>Comments</title>
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
	  	 <h1><i class="fas fa-Comments" style="color:#3366ff;"></i> Manage Comments</h1>
		</div>
	  </div>
	 </div>
	</header>
	<!-- header end-->
	<!-- main area begin-->
	<section class="container py-2 mb-4">
	<div class="row" style="min-height:30px;">
	<div class="col-lg-12" style="min-height:400px;">
	    <table class="table table-striped table-hover">
		<thead class="thead-dark">
		 <tr>
		  <th>#</th>
		  <th>Date & Time</th>
		  <th>name</th>
		  <th>Comment</th>
		  <th>Approve</th>
  		  <th>Delete</th>
		  <th>Details</th>
		  </tr>
		</thead>
	<?php
		echo errormessage();
		echo successmessage();
	?>
	<h2>Un-approved Comments</h2>
	<?php
	global $ConnectingDB;
	$sql="SELECT * FROM  comments WHERE status='OFF' ORDER BY id DESC";
	$execute=$ConnectingDB->query($sql);
	$srno=0;
	while($datarows=$execute->fetch())
	{
		$commentid=$datarows["id"];
		$datetime=$datarows["datetime"];
		$commentname=$datarows["name"];
		$commentcontent=$datarows["comment"];
		$commentpostid=$datarows["post_id"];
		$srno++;
	?>
		<tbody>
		<tr>
		 <td><?php echo htmlentities($srno); ?></td>
		 <td><?php echo htmlentities($datetime); ?></td>
		 <td><?php echo htmlentities($commentname); ?></td>
		 <td><?php echo htmlentities($commentcontent); ?></td>
		 <td><a href="approvecomments.php?id=<?php echo $commentid;?>"><span class="btn btn-success">Approve</span></a></td>
		 <td><a href="deletecomments.php?id=<?php echo $commentid;?>"><span class="btn btn-danger">delete</span></a></td>
		 <td style="min-width:140px;">
		 <a class="btn btn-primary" href="fullpost.php?id=<?php echo $commentpostid;?>" target="_blank">Live Preview</a>
		 </td>
		</tr>
		</tbody>
	<?php } ?>
	   </table>
	    <table class="table table-striped table-hover">
		<thead class="thead-dark">
		 <tr>
		  <th>#</th>
		  <th>Date & Time</th>
		  <th>name</th>
		  <th>Comment</th>
		  <th>Revert</th>
  		  <th>Delete</th>
		  <th>Details</th>
		  </tr>
		</thead>
	<?php
		echo errormessage();
		echo successmessage();
	?>
	<h2>Approved Comments</h2>
	<?php
	global $ConnectingDB;
	$sql="SELECT * FROM  comments WHERE status='ON' ORDER BY id DESC";
	$execute=$ConnectingDB->query($sql);
	$srno=0;
	while($datarows=$execute->fetch())
	{
		$commentid=$datarows["id"];
		$datetime=$datarows["datetime"];
		$commentname=$datarows["name"];
		$commentcontent=$datarows["comment"];
		$commentpostid=$datarows["post_id"];
		$srno++;
	?>
		<tbody>
		<tr>
		 <td><?php echo htmlentities($srno); ?></td>
		 <td><?php echo htmlentities($datetime); ?></td>
		 <td><?php echo htmlentities($commentname); ?></td>
		 <td><?php echo htmlentities($commentcontent); ?></td>
		 <td style="min-width:140px;"><a href="disapprovecomments.php?id=<?php echo $commentid;?>"><span class="btn btn-warning">Disapprove</span></a></td>
		 <td><a href="deletecomments.php?id=<?php echo $commentid;?>"><span class="btn btn-danger">Delete</span></a></td>
		 <td style="min-width:140px;">
		 <a class="btn btn-primary" href="fullpost.php?id=<?php echo $commentpostid;?>" target="_blank">Live Preview</a>
		 </td>
		</tr>
		</tbody>
	<?php } ?>
	   </table>   
	</div>
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