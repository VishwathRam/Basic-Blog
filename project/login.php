<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php 
	if(isset($_SESSION["userid"]))
	{
		Redirect_to("dashboard.php");
	}

	if(isset($_POST["submit"]))
	{
		$username=$_POST["username"];
		$password=$_POST["password"];
		if(empty($username)||empty($password))
		{
			$_SESSION["errormessage"]="All fields must be filled out";
			Redirect_to("login.php");
		}
		else
		{
			$foundaccount=loginattempt($username,$password);
			if($foundaccount)
			{
				$_SESSION["userid"]=$foundaccount["id"];
				$_SESSION["username"]=$foundaccount["username"];
				$_SESSION["adminname"]=$foundaccount["aname"];
				$_SESSION["successmessage"]="Welcome ".$_SESSION["adminname"];
				if(isset($_SESSION["TrackingURL"]))
				{
				Redirect_to($_SESSION["TrackingURL"]);
				}	
				else
				{
					Redirect_to("dashboard.php");
				}
			}
			else
			{
				$_SESSION["errormessage"]="Incorrect username or password";
				Redirect_to("login.php");
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
		<title>Login</title>
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
	  	 <h1></h1>
		</div>
	  </div>
	 </div>
	</header>
	<!-- header end-->
	<!-- main area begin-->
	<section class="container py-2 mb-4">
	 <div class="row">
	  <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
	  <br><br><br>
	  	  	<?php
		echo errormessage();
		echo successmessage();
		?>
	   <div class="card bg-secondary text-light">
	   <div class="card-header">
	    <h4>Welcome Back    !</h4>
		</div>
		<div class="card-body bg-dark">
		<form class="" action="login.php" method="post">
		<div class="form-group" >
		 <label for="username"><span class="FieldInfo">Username:</span></label>
	 	 <div class="input-group mb-3">
		  <div class="input-group-prepend">
		   <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
		  </div>
		  <input type="text" class="form-control" name="username" id="username" value="">
		 </div>
		</div>
		<div class="form-group" >
		 <label for="password"><span class="FieldInfo">Password</span></label>
	 	 <div class="input-group mb-3">
		  <div class="input-group-prepend">
		   <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
		  </div>
		  <input type="password" class="form-control" name="password" id="password" value="">
		 </div>
		</div>
		<input type="submit" class="btn btn-info btn-block" name="submit" value="Login">
		</form>
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
			This site is created for fun. Go to udemy to learn more about how to do this.<br>Vishwath.com | NASA | Udemy<br>
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