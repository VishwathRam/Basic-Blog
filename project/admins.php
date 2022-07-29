<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
confirm_login();?>
<?php 
	if(isset($_POST["submit"]))
	{
	 $username=$_POST["username"];
	 $name=$_POST["name"];
	 $password=$_POST["password"];
	 $confirmpassword=$_POST["confirmpassword"];
	 $admin=$_SESSION["username"];
	 date_default_timezone_set("Asia/Kolkata");
	 $Currenttime=time();
	 $datetime=strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
	 
	 
	 if(empty($username)||empty($password)||empty($confirmpassword))
	 {
	  $_SESSION["errormessage"]="All fields must be filled out";
	  Redirect_to("admins.php");
	 }
	 elseif(strlen($password)<4)
	 {
		$_SESSION["errormessage"]="Title must be greater than 3 characters";
		Redirect_to("admins.php"); 
	 }
	 elseif($password!==$confirmpassword)
	 {
		$_SESSION["errormessage"]="Confirm password does not match";
		Redirect_to("admins.php"); 
	 }
	 elseif(checkusernameexist($username))
	 {
		$_SESSION["errormessage"]="Username exists";
		Redirect_to("admins.php"); 
	 }
	 else
	 {
		 global $ConnectingDB;
		 $sql= "INSERT INTO admins(datetime,username,password,aname,addedby)";
		 $sql.="VALUES(:datetime,:username,:password,:aname,:addedby)";
		 $stmt=$ConnectingDB->prepare($sql);
		 $stmt->bindValue(':datetime',$datetime);
		 $stmt->bindValue(':username',$username);
		 $stmt->bindValue(':password',$password);
 		 $stmt->bindValue(':aname',$name);
		 $stmt->bindValue(':addedby',$admin);

		 $execute=$stmt->execute();
		 if($execute)
		 {
			 $_SESSION["successmessage"]="Admin added successfully";
			 Redirect_to("admins.php");
		 }
		 else
		 {
			 $_SESSION["errormessage"]="ERROR please try again";
			 Redirect_to("admins.php");
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
		<title>Admin Page</title>
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
	  	 <h1><i class="fas fa-user" style="color:#3366ff;"></i> Manage Admins</h1>
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
		  <form class="" action="Admins.php" method="post">
		   <div class="card bg-secondary text-light mb-3">
		    <div class="card-header">
		     <h1>Add New Admin</h1>
		    </div>
			<div class="card-body bg-dark">
		     <div class="form-group">
		      <label for="username"><span class="FieldInfo">Username:</span></label>
			  <input class="form-control" type="text" name="username" id="username" value="">
		     </div>
			 <div class="form-group">
		      <label for="name"><span class="FieldInfo">Name:</span></label>
			  <input class="form-control" type="text" name="name" id="name" value="">
		      <small class="text-danger text-muted">*Optional</small>
			 </div>
			  <div class="form-group">
		      <label for="password"><span class="FieldInfo">Password:</span></label>
			  <input class="form-control" type="password" name="password" id="name" value="">
		     </div>
			 <div class="form-group">
		      <label for="confirmpassword"><span class="FieldInfo">Confirm password:</span></label>
			  <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" value="">
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
		  <th>Username</th>
		  <th>Admin name</th>
		  <th>Added By</th>
		  <th>Action</th>
		  </tr>
		</thead>
	<?php
		echo errormessage();
		echo successmessage();
	?>
	<h2>Existing admins</h2>
	<?php
	global $ConnectingDB;
	$sql="SELECT * FROM  admins ORDER BY id DESC";
	$execute=$ConnectingDB->query($sql);
	$srno=0;
	while($datarows=$execute->fetch())
	{
		$adminid=$datarows["id"];
		$datetime=$datarows["datetime"];
		$adminusername=$datarows["username"];
		$adminname=$datarows["aname"];
		$addedby=$datarows["addedby"];
		$srno++;
	?>
		<tbody>
		<tr>
		 <td><?php echo htmlentities($srno); ?></td>
		 <td><?php echo htmlentities($datetime); ?></td>
		 <td><?php echo htmlentities($adminusername); ?></td>
		 <td><?php echo htmlentities($adminname); ?></td>
		 <td><?php echo htmlentities($addedby); ?></td>
		 <td><a href="deleteadmin.php?id=<?php echo $adminid;?>"><span class="btn btn-danger">Delete</span></a></td>
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