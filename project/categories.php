<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
 confirm_login();?>
<?php 
	if(isset($_POST["submit"]))
	{
	 $category=$_POST["categorytitle"];
	 $admin=$_SESSION["username"];
	 date_default_timezone_set("Asia/Kolkata");
	 $Currenttime=time();
	 $datetime=strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
	 
	 
	 if(empty($category))
	 {
	  $_SESSION["errormessage"]="All fields must be filled out";
	  Redirect_to("categories.php");
	 }
	 elseif(strlen($category)<3)
	 {
		$_SESSION["errormessage"]="Title must be greater than 2 characters";
		Redirect_to("categories.php"); 
	 }
	 elseif(strlen($category)>49)
	 {
		$_SESSION["errormessage"]="Title must be less than 50 characters";
		Redirect_to("categories.php"); 
	 }
	 else
	 {
		 global $ConnectingDB;
		 $sql= "INSERT INTO category(title,author,datetime)";
		 $sql.="VALUES(:categoryname,:adminname,:datetime)";
		 $stmt=$ConnectingDB->prepare($sql);
		 $stmt->bindValue(':categoryname',$category);
		 $stmt->bindValue(':adminname',$admin);
		 $stmt->bindValue(':datetime',$datetime);
		 $execute=$stmt->execute();
		 if($execute)
		 {
			 $_SESSION["successmessage"]="category with id: ".$ConnectingDB->lastInsertId()." added successfully";
			 Redirect_to("categories.php");
		 }
		 else
		 {
			 $_SESSION["errormessage"]="ERROR please try again";
			 Redirect_to("categories.php");
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
		<title>Categories</title>
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
	  	 <h1><i class="fas fa-edit" style="color:#3366ff;"></i> Manage Categories</h1>
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
		  <form class="" action="categories.php" method="post">
		   <div class="card bg-secondary text-light mb-3">
		    <div class="card-header">
		     <h1>Add New Categories</h1>
		    </div>
			<div class="card-body bg-dark">
		     <div class="form-group">
		      <label for="title"><span class="FieldInfo">category title:</span></label>
			  <input class="form-control" type="text" name="categorytitle" id="title" placeholder="Type title here" value="">
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
		<table class="table table-striped table-hover">
		<thead class="thead-dark">
		 <tr>
		  <th>#</th>
		  <th>Date & Time</th>
		  <th>category name</th>
		  <th>creator name</th>
		  <th>action</th>
		  </tr>
		</thead>
	<?php
		echo errormessage();
		echo successmessage();
	?>
	<h2>Existing categories</h2>
	<?php
	global $ConnectingDB;
	$sql="SELECT * FROM  category ORDER BY id DESC";
	$execute=$ConnectingDB->query($sql);
	$srno=0;
	while($datarows=$execute->fetch())
	{
		$categoryid=$datarows["id"];
		$categorydate=$datarows["datetime"];
		$categoryname=$datarows["title"];
		$creatorname=$datarows["author"];
		$srno++;
	?>
		<tbody>
		<tr>
		 <td><?php echo htmlentities($srno); ?></td>
		 <td><?php echo htmlentities($categorydate); ?></td>
		 <td><?php echo htmlentities($categoryname); ?></td>
		 <td><?php echo htmlentities($creatorname); ?></td>
		 <td><a href="deletecategory.php?id=<?php echo $categoryid;?>"><span class="btn btn-danger">Delete</span></a></td>
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