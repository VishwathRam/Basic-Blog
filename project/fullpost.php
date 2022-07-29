<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php $searchqueryparameter=$_GET["id"];?>
<?php 
	if(isset($_POST["submit"]))
	{
	 $name=$_POST["commentername"];
	 $email=$_POST["commenteremail"];
	 $comment=$_POST["commenterthoughts"];
	 date_default_timezone_set("Asia/Kolkata");
	 $Currenttime=time();
	 $datetime=strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
	 
	 
	 if(empty($name)||empty($email)||empty($comment))
	 {
	  $_SESSION["errormessage"]="All fields must be filled out";
	  Redirect_to("fullpost.php?id=$searchqueryparameter");
	 }
	 elseif(strlen($comment)>499)
	 {
		$_SESSION["errormessage"]="Title must be less than 500 characters";
		Redirect_to("fullpost.php?id=$searchqueryparameter"); 
	 }
	 else
	 {
		 global $ConnectingDB;
		 $sql= "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
		 $sql.="VALUES(:datetime,:name,:email,:comment,'Pending','OFF',:postidfromURL)";
		 $stmt=$ConnectingDB->prepare($sql);
		 $stmt->bindValue(':datetime',$datetime);
		 $stmt->bindValue(':name',$name);
		 $stmt->bindValue(':email',$email);
		 $stmt->bindValue(':comment',$comment);
		 $stmt->bindValue(':postidfromURL',$searchqueryparameter);

		 $execute=$stmt->execute();
		 if($execute)
		 {
			 $_SESSION["successmessage"]="Comment submitted successfully";
			 Redirect_to("fullpost.php?id=$searchqueryparameter");
		 }
		 else
		 {
			 $_SESSION["errormessage"]="ERROR please try again";
			 Redirect_to("fullpost.php?id=$searchqueryparameter");
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
		<title>Full Post</title>
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
	<!-- main area begin-->
	<div class="container">
	 <div class="row mt-4">
	  <div class="col-sm-8">
	   <h1>The Complete Responsive CMS Blog</h1>
	   <h1 class="lead">The Complete Blog Using PHP By Vishwath Ramachandran</h1>
	   <?php
		  echo errormessage();
		  echo successmessage();
		  ?>
	   <?php
	    global $ConnectingDB;
	   	if(isset($_GET["searchbutton"]))
		{
			$search=$_GET["search"];
			$sql="SELECT * FROM posts
			WHERE datetime LIKE :search 
			OR title LIKE :search
			OR category LIKE :search
			OR post LIKE :search";
			$stmt=$ConnectingDB->prepare($sql);
			$stmt->bindValue(':search','%'.$search.'%');
			$stmt->execute();
		}
	    
		else
		{
			$postidfromURL=$_GET["id"];
			if(!isset($postidfromURL))
			{
				$_SESSION["errormessage"]="Incorrect request";
				Redirect_to("blog.php");
			}
			
			$sql="SELECT * FROM posts WHERE id='$postidfromURL' ORDER BY id desc";
			$stmt=$ConnectingDB->query($sql);
			$result=$stmt->rowcount();
			if($result!=1)
			{
				$_SESSION["errormessage"]="Incorrect request";
				Redirect_to("blog.php?page=1");
			}
		}
		
		while($datarows=$stmt->fetch())
		{
			 $postid=$datarows["id"];
			 $datetime=$datarows["datetime"];
			 $posttitle=$datarows["title"];
			 $category=$datarows["category"];
			 $admin=$datarows["author"];
			 $image=$datarows["image"];
			 $postdescription=$datarows["post"];
		
	   ?>
	 <div class="card">
		<img src="Upload/<?php echo htmlentities($image);?>" style="max-height:450px;" class="img-fluid card-img-top">
	    <div class="card-body">
		 <h4 class="card-title"><?php echo htmlentities($posttitle);?></h4>
		 <small class="text-muted">Written by <?php echo htmlentities($admin);?> On <? echo htmlentities($datetime);?></small>
		 <span style="float:right;" class="badge badge-dark text-light">Comments 
		 <?php echo approvecomment($postid);?>
		 </span>
		 <hr>
		 <p class="card-text">
		  <?php echo nl2br($postdescription);?>
		 </p>
	</div>
	</div>
	<br>
		<?php } ?>
	<!-- commments begin-->	
	<!-- commments fetching begin-->
		<span class="FieldInfo">Comments</span> 
		<br><br>
	<?php
	global $ConnectingDB;
	$sql="SELECT * FROM comments WHERE post_id='$searchqueryparameter' AND status='ON'";
	$stmt=$ConnectingDB->query($sql);
	while($datarows=$stmt->fetch())
	{
		$commentdate=$datarows['datetime'];
		$commentname=$datarows['name'];
		$commentcontent=$datarows['comment'];
		
	
	?>
	<div>
	 <div class="media ">
	 <img class="d-block img-fluid align-self-start" src="photo/userimage.png">
	  <div class="media-body ml-2">
	   <h6 class="lead"><?php echo $commentname;?></h6>
	   <p class="small"><?php echo $commentdate;?></p>
	   <p class="small"><?php echo $commentcontent;?></p>
	  </div>
	 </div>
	</div>
	<hr>
	<?php } ?>
	<!-- commments fetching end-->		
	<div class="">
	 <form class="" action="fullpost.php?id=<?php echo $searchqueryparameter; ?>" method="post">
	 <div class="card mb-3"> 
	  <div class="card-header">
	   <h5 class="FieldInfo">Share your thoughts about this post</h5>
	  </div>
	  <div class="card-body">
	   <div class="form-group">
	    <div class="input-group">
		 <div class="input-group-prepend">
		  <span class="input-group-text"><i class="fas fa-user"></i></span>
		 </div>
	    <input class="form-control" type="text" name="commentername" placeholder="name" value="">
	    </div>
	   </div>
	   <div class="form-group">
	    <div class="input-group">
		 <div class="input-group-prepend">
		  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
		 </div>
	    <input class="form-control" type="text" name="commenteremail" placeholder="email" value="">
		 </div>
		</div>
		 <div class="form-group">
		  <textarea name="commenterthoughts" class="form-control" rows="6" cols="80"></textarea>
		 </div>
		 <div class="">
		 <button type="submit" name="submit" class="btn btn-primary">Submit</button>
		 </div>
	  </div>
	 </div>
	</div>
	<!-- comments end-->		
	 </div>

	<!-- side area begin-->
	<div class="col-sm-4" style="min-height:40px;">
	 <div class="card mt-4">
	  <div class="card-body">
	   <img src="photo/82206.png" class="d-block img-fluid mb-3" alt="">
	   <div class="text-center">
	    weil WXijmcr eomc wtm tailtwacl wumtwcm twmcwtm wtmuwc  w4xtd,cw t4a,' m IM WT4I aiomrc ,tw TWCMOT mtwdmi tutedm tutdm eymytm mitwacim rrs3, mxtmtiut tmtmtxmtx,t txmt.
	   </div>
	  </div>
	 </div>
	 <br>
	 <div class="card">
	  <div class="card-header bg-dark text-light">
	   <h2 class="lead">Sign Up!</h2>
	  </div>
	  <div class="card-body">
	   <button type="button" class="btn btn-success btn-block text-center text-white mb-3" name="button">Join The Forum</button>
	   <button type="button" class="btn btn-danger btn-block text-center text-white mb-3" name="button">Login</button>
	   <div class="input-group mb-3">
	    <input type="text" class="form-control" name="" placeholder="Enter Your Email" value="">
		<div class="input-group-append">
	     <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
		</div>
	   </div>
	  </div>
	 </div>
	 <br>
	 <div class="card">
	  <div class="card-header bg-primary text-light">
	   <h2 class="lead">Categories</h2>
	  </div>
	    <div class="card-body">
		 <?php
		 global $ConnectingDB;
		 $sql="SELECT * FROM category ORDER BY id desc";
		 $stmt=$ConnectingDB->query($sql);
		 while($datarows=$stmt->fetch())
		 {
		   $categoryid=$datarows["id"];
		   $categoryname=$datarows["title"]; 
		   ?>
		   <a href="blog.php?category=<?php echo $categoryname;?>"><span class="heading"><?php echo $categoryname;?> </span><br></a>
		   <?php
		}
		 ?>
		</div>
	 </div>
	 <br>
	 <div class="card">
	  <div class="card-header bg-info text-light">
	   <h2 class="lead">Recent Posts</h2>
	  </div>
	  <div class="card-body">
	  <?php
	     global $ConnectingDB;
		 $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
		 $stmt=$ConnectingDB->query($sql);
		 while($datarows=$stmt->fetch())
		 {
			 $id=$datarows["id"];
			 $datetime=$datarows["datetime"];
			 $title=$datarows["title"];
			 $image=$datarows["image"];
		   ?>
			<div class="media">
			 <img src="Upload/<?php echo htmlentities($image);?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
			 <div class="media-body ml-2">
			  <a href="fullpost.php?id=<?php echo htmlentities($id);?>" target="_blank"><h6 class="lead"><?php echo htmlentities($title);?> </h6></a>
			  <p class="small"><?php echo htmlentities($datetime);?></p>
			 </div>
			</div>
			<hr>
		    <?php
		 }
		  ?>
	   </div>
	 </div>
	</div>
	<!--side area end-->
	</div>
	</div>
	
	<!-- main area end-->

	<!-- footer begin-->
	<footer class=" bg-dark text-white">
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