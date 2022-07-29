<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
confirm_login();?>
<?php
	$adminid=$_SESSION["userid"];
	global $ConnectingDB;
	$sql="SELECT * FROM admins WHERE id='$adminid'";
	$stmt=$ConnectingDB->query($sql);
	while($datarows=$stmt->fetch())
	{
		$existingname=$datarows['aname'];
		$existingheadline=$datarows['aheadline'];
		$existingbio=$datarows['abio'];
		$existingimage=$datarows['aimage'];
		$existingusername=$datarows['username'];
	}
	
	
	if(isset($_POST["submit"]))
	{
	 $aname=$_POST["aname"];
	 $aheadline=$_POST["aheadline"];
	 $abio=$_POST["abio"];
	 $image=$_FILES["image"]["name"];
	 $target="Upload/".basename($_FILES["image"]["name"]);
	 	 
	 if(strlen($aheadline)>30)
	 {
		$_SESSION["errormessage"]="headline must be less than 30 characters";
		Redirect_to("myprofile.php"); 
	 }
	 elseif(strlen($abio)>1000)
	 {
		$_SESSION["errormessage"]="Title must be less than 500 characters";
		Redirect_to("myprofile.php"); 
	 }
	 else
	 {
		 global $ConnectingDB;
		 if(!empty($_FILES["image"]["name"]))
		 {
			$sql="UPDATE admins SET aname='$aname', aheadline='$aheadline', abio='$abio', aimage='$image'
			WHERE id='$adminid'";
		 }
		 else
		 {
			$sql="UPDATE admins SET aname='$aname', aheadline='$aheadline', abio='$abio'
			WHERE id='$adminid'";			 
		 }
		$execute=$ConnectingDB->query($sql);
		 move_uploaded_file($_FILES["image"]["tmp_name"],$target);

		 if($execute)
		 {
			 $_SESSION["successmessage"]="Details updated successfully";
			 Redirect_to("myprofile.php");
		 }
		 else
		 {
			 $_SESSION["errormessage"]="ERROR please try again";
			 Redirect_to("myprofile.php");
		 }
	 }
 
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
		<title>My Profile</title>
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
		<a href='blog.php' class="nav-link">Live Blog</a>
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
	  	 <h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $existingusername;?></h1>
		 <small><?php echo $existingheadline;?></small>
		</div>
	  </div>
	 </div>
	</header>
	<!-- header end-->
	<!-- main area begin-->
	<section class="container py-2 mb-4">
		<div class="row"> <!--style="min-height:50px; background:red;" -->
		 <!-- left area begin-->
		 <div class="col-md-3">
		  <div class="card">
		   <div class="card-header bg-dark text-light">
		    <h3><?php echo $existingname;?></h3>
		   <div class="card-body">
		    <img src="Upload/<?php echo $existingimage;?>" class="block img-fluid mb-3" alt="">
		   <div class="card-body">
			<?php echo $existingbio;?>
		   </div>
		   </div>
		   </div>
		  </div>
		 </div>
		 <!-- left area end-->
		 <!-- right area begin-->
		 <div class="col-lg-9" style="min-height:400px;"> <!-- background:yellow;" -->
		  <?php
		  echo errormessage();
		  echo successmessage();
		  ?>
		  <form class="" action="myprofile.php" method="post" enctype="multipart/form-data">
		   <div class="card bg-dark text-light">
		    <div class="card-header bg-secondary text-light">
			 <h3>Edit Profile</h3>
			</div>
			<div class="card-body">
		     <div class="form-group">
			  <input class="form-control" type="text" name="aname" id="title" placeholder="Type name here" value="">
			 </div>
			 <div class="form-group">
			  <input class="form-control" type="text" name="aheadline" id="title" placeholder="headline" value="">
		      <small class="text-muted">Add professional headine e.g "engineer at xyz" or "architect"</small>
			  <span class="text-danger">Not more than 30 characters</span>
			 </div>
			  <div class="form-group">
			   <textarea class="form-control" id="post" name="abio" placeholder="bio" rows="8" cols="80"></textarea>
		      </div>
			 <div class="form-group">
			  <div class="custom-file">
				<input class="custom-file-input" type="file" name="image" id="imageselect" value="">
				<label for="imageselect" class="custom-file-label">Select image </label>
			  </div>
		     </div>
			 
			 <div class="row">
			  <div class="col-lg-6 mb-2">
			   <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
			  </div>
			  <div class="col-lg-6 mb-2">
			   <button type="submit" name="submit" class="btn btn-success btn-block">
			    <i class="fas fa-check"></i> Publish
			   </button>
			  </div>
			 </div>
			 
		    </div>
		   </div>
		  </form>
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