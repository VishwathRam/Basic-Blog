<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php 
	if(isset($_GET["id"]))
	{
		$searchqueryparameter=$_GET["id"];
		global $ConnectingDB;
		$sql="DELETE FROM category WHERE id=$searchqueryparameter";
		$execute=$ConnectingDB->query($sql);
		if($execute)
		{
			$_SESSION["successmessage"]="category deleted successfully";
			Redirect_to("category.php");
		}
		else
		{
			$_SESSION["errormessage"]="ERROR! Please try again.";
			Redirect_to("category.php");
		}
	}
?>