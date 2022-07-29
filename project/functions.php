<?php
 function Redirect_to($New_location)
 {
  header("Location:".$New_location);
  exit;
 }
 function checkusernameexist($username)
 {
	 global $ConnectingDB;
	 $sql="SELECT username FROM admins WHERE username=:username";
	 $stmt=$ConnectingDB->prepare($sql);
	 $stmt->bindValue(':username',$username);
	 $stmt->execute();
	 $result=$stmt->rowcount();
	 if($result==1)
	 {
		 return true;
	 }		 
	 else
	 {
		 return false;
	 }
	
 }
  function loginattempt($username,$password)
 {
	global $ConnectingDB;
	$sql="SELECT * FROM admins WHERE username=:username AND password=:password LIMIT 1";
	$stmt=$ConnectingDB->prepare($sql);
	$stmt->bindValue(':username',$username);
	$stmt->bindValue(':password',$password);
	$stmt->execute();
	$result=$stmt->rowcount();
	if($result==1)
	{
		return $foundaccount=$stmt->fetch();
	}
	else
	{
		return null;
	}
 }
 function confirm_login()
 {
	if(isset($_SESSION["userid"]))
	{
		return true;
	}
	else
	{
		$_SESSION["errormessage"]="login required";
		Redirect_to("login.php");
	}
 }
 function approvecomment($id)
 {
	global $ConnectingDB;
	$sqlapprove="SELECT COUNT(*)FROM comments WHERE post_id='$id' AND status='ON'";
	$stmtapprove=$ConnectingDB->query($sqlapprove);
	$total=$stmtapprove->fetch();
	$total=array_shift($total);
	return $total;
 }
 function disapprovecomment($id)
 {
	global $ConnectingDB;
	$sqlapprove="SELECT COUNT(*)FROM comments WHERE post_id='$id' AND status='OFF'";
	$stmtapprove=$ConnectingDB->query($sqlapprove);
	$total=$stmtapprove->fetch();
	$total=array_shift($total);
	return $total;
 }
 
 
?>