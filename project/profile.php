<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php
$searchqueryparameter=$_GET["username"];
global $ConnectingDB;
$sql="SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:username";
$stmt=$ConnectingDB->prepare($sql);
$stmt->bindValue(':username',$searchqueryparameter);
$stmt->execute();
$result=$stmt->rowcount();
if($result==1)
{
	while($datarows=$stmt->fetch())
	{
		$existingname=$datarows["aname"];
		$existingbio=$datarows["abio"];
		$existingimage=$datarows["aimage"];
		$existingheadline=$datarows["aheadline"];
	}
}
else
{
	$_SESSION["errormessage"]="Bad Request";
	Redirect_to("blog.php?page=1");
	//Redirect_to("profile");
}	


?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://kit.fontawesome.com/ec4472c738.js" crossorigin="anonymous"></script>
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="styles.css">
		<title>Profile</title>
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
		<a href='blog.php?page=1' class="nav-link">Home</a>
		</li>
		<li class="nav-item">
		<a href='#.php' class="nav-link">About Us</a>
		</li>
		<li class="nav-item">
		<a href='blog.php' class="nav-link">Blog</a>
		</li>
		<li class="nav-item">
		<a href='#.php' class="nav-link">Contact Us</a>
		</li>
		<li class="nav-item">
		<a href='#' class="nav-link">Features</a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto">
		<form class="form-inline d-none d-sm-block" action="blog.php">
			<div class="form-group">
			<input class="form-control mr-2" type="text" name="search" placeholder="Search Here" value="">
			<button class="btn btn-primary" name="searchbutton">Go</button>
			</div>
		</form>
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
	  	 <h1><i class="fas fa-user text-success mr-2" style="color:#3366ff;"></i><?php echo $existingname;?></h1>
		 <h3><?php echo $existingheadline;?></h3>
		</div>
	  </div>
	 </div>
	</header>
	<!-- header end-->
	<!-- main area begin-->
	<section class="container">
	 <div class="row">
	  <div class="col-md-3">
	   <img src="Upload/<?php echo $existingimage;?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
	  </div>
	  <div class="col-md-9" style="min-height:400px;">
	   <div class="card">
	    <div class="card">
		 <p class="lead"><?php echo $existingbio;?></p>
	    </div>
	   </div>
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