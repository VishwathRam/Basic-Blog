<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php confirm_login();?>
<?php 
	$searchqueryparameter=$_GET["id"];
	if(isset($_POST["submit"]))
	{
	 $posttitle=$_POST["posttitle"];
	 $category=$_POST["category"];
	 $image=$_FILES["image"]["name"];
	 $target="Upload/".basename($_FILES["image"]["name"]);
	 $postdescription=$_POST["postdescription"];
	 $admin="Vishwath";
	 date_default_timezone_set("Asia/Kolkata");
	 $Currenttime=time();
	 $datetime=strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
	 
	 
	 if(empty($posttitle))
	 {
	  $_SESSION["errormessage"]="please give title";
	  Redirect_to("posts.php");
	 }
	 elseif(strlen($posttitle)<5)
	 {
		$_SESSION["errormessage"]="Title must be greater than 5 characters";
		Redirect_to("posts.php"); 
	 }
	 elseif(strlen($posttitle)>9999)
	 {
		$_SESSION["errormessage"]="Title must be less than 10000 characters";
		Redirect_to("posts.php"); 
	 }
	 else
	 {
		 global $ConnectingDB;
		 if(!empty($_FILES["image"]["name"]))
		 {
			$sql="UPDATE posts SET title='$posttitle', category='$category', image='$image', post='$postdescription' 
			WHERE id='$searchqueryparameter'";
		 }
		 else
		 {
			$sql="UPDATE posts SET title='$posttitle', category='$category', post='$postdescription' 
			WHERE id='$searchqueryparameter'";			 
		 }
		$execute=$ConnectingDB->query($sql);
		 move_uploaded_file($_FILES["image"]["tmp_name"],$target);

		 if($execute)
		 {
			 $_SESSION["successmessage"]="post edited successfully";
			 Redirect_to("posts.php");
		 }
		 else
		 {
			 $_SESSION["errormessage"]="ERROR please try again";
			 Redirect_to("posts.php");
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
		<title>Edit Posts</title>
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
	  	 <h1><i class="fas fa-edit" style="color:#3366ff;"></i> Edit Post</h1>
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
		  
		  ?>
		  <form class="" action="editpost.php?id=<?php echo $searchqueryparameter;?>" method="post" enctype="multipart/form-data">
		   <div class="card bg-secondary text-light mb-3">
			<div class="card-body bg-dark">
		     <div class="form-group">
		      <label for="title"><span class="FieldInfo">Post title:</span></label>
			  <input class="form-control" type="text" name="posttitle" id="title" placeholder="Type title here" value="<?php echo $oldtitle?>">
		     </div>
			 <div class="form-group">
			 <span class="FieldInfo">Existing Category:</span>
			 <?php echo $oldcategory;?>
			 <br>
			 <label for="categorytitle"><span class="FieldInfo">Choose category:</span></label>
			  <select class="form-control" id="categorytitle" name="category">
				<?php
				global $ConnectingDB;
				$sql="SELECT id,title FROM category";
				$stmt=$ConnectingDB->query($sql);
				while($datarows=$stmt->fetch())
				{
					$id=$datarows["id"];
					$categoryname=$datarows["title"];
					?>
					<option><?php echo $categoryname; ?></option>
					<?php
				}
				?>
			  </select>
		     </div>
			 <div class="form-group">
			 <span class="FieldInfo">Existing image:</span>
			 <img class="mb-1" src="upload/<?php echo $oldimage;?>" width="170px"; height="70px";>
			  <div class="custom-file">
				<input class="custom-file-input" type="file" name="image" id="imageselect" value="">
				<label for="imageselect" class="custom-file-label">Select image </label>
			  </div>
			  <div class="form-group">
		       <label for="post"><span class="FieldInfo">Post:</span></label>
			   <textarea class="form-control" id="post" name="postdescription" rows="8" cols="80">
			    <?php echo $oldpost;?>
			   </textarea>
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