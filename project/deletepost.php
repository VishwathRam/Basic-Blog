<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php confirm_login();?>
<?php 
	$searchqueryparameter=$_GET["id"];
 global $ConnectingDB;

		  $sql="SELECT * FROM posts WHERE id='$searchqueryparameter'";
		  $stmt=$ConnectingDB->query($sql);
		  while($datarows=$stmt->fetch())
		  {
			$oldtitle=$datarows["title"];
			$oldcategory=$datarows["category"];
			$oldimage=$datarows["image"];
			$oldpost=$datarows["post"];
			
		  }
	if(isset($_POST["submit"]))
	{
	  
		global $ConnectingDB;
		$sql="DELETE FROM posts WHERE id='$searchqueryparameter'";
		$execute=$ConnectingDB->query($sql);

		 if($execute)
		 {
			 $target_path_to_delete_image="Upload/$oldimage";
			 unlink($target_path_to_delete_image);
			 $_SESSION["successmessage"]="post deleted successfully";
			 Redirect_to("posts.php");
		 }
		 else
		 {
			 $_SESSION["errormessage"]="ERROR please try again";
			 Redirect_to("posts.php");
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
		<title>Delete Posts</title>
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
		<a href='blog.php?page-1' class="nav-link">Comments</a>
		</li>
		<li class="nav-item">
		<a href='#' class="nav-link">Live Blog</a>
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
	  	 <h1><i class="fas fa-edit" style="color:#3366ff;"></i> Delete Post</h1>
		</div>
	  </div>
	 </div>
	</header>
	<!-- header end-->
	<!-- main area begin-->
	<section class="container py-2 mb-4">
		<div class="row"> <!--style="min-height:50px; background:red;" -->
		 <div class="offset-lg-1 col-lg-10 style="min-height:400px;"> <!-- background:yellow;" -->
		  <?php
		  echo errormessage();
		  echo successmessage();

		  ?>
		  <form class="" action="deletepost.php?id=<?php echo $searchqueryparameter;?>" method="post" enctype="multipart/form-data">
		   <div class="card bg-secondary text-light mb-3">
			<div class="card-body bg-dark">
		     <div class="form-group">
		      <label for="title"><span class="FieldInfo">Post title:</span></label>
			  <input disabled class="form-control" type="text" name="posttitle" id="title" placeholder="Type title here" value="<?php echo $oldtitle?>">
		     </div>
			 <div class="form-group">
			 <span class="FieldInfo">Existing Category:</span>
			 <?php echo $oldcategory;?>
			 <br>

		     </div>
			 <div class="form-group">
			 <span class="FieldInfo">Existing image:</span>
			 <img class="mb-1" src="upload/<?php echo $oldimage;?>" width="170px"; height="70px";>

			  <div class="form-group">
		       <label for="post"><span class="FieldInfo">Post:</span></label>
			   <textarea disabled class="form-control" id="post" name="postdescription" rows="8" cols="80">
			    <?php echo $oldpost;?>
			   </textarea>
		      </div>
		     </div>
			 
			 <div class="row">
			  <div class="col-lg-6 mb-2">
			   <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
			  </div>
			  <div class="col-lg-6 mb-2">
			   <button type="submit" name="submit" class="btn btn-danger btn-block">
			    <i class="fas fa-trash"></i> Delete
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