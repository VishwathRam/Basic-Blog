<?php require_once("DB.php");?>
<?php require_once("functions.php");?>
<?php require_once("sessions.php");?>
<?php

$_SESSION["userid"]=null;
$_SESSION["username"]=null;
$_SESSION["adminname"]=null;
session_destroy();
Redirect_to("login.php");
?>