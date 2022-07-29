<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php 
	if(isset($_GET["id"]))
	{
		$searchqueryparameter=$_GET["id"];
		global $ConnectingDB;
		$sql="DELETE FROM comments WHERE id=$searchqueryparameter";
		$execute=$ConnectingDB->query($sql);
		if($execute)
		{
			$_SESSION["successmessage"]="comment deleted successfully";
			Redirect_to("comments.php");
		}
		else
		{
			$_SESSION["errormessage"]="ERROR! Please try again.";
			Redirect_to("comments.php");
		}
	}
?>