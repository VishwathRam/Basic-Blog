<?php
date_default_timezone_set("Asia/Kolkata");
$Currenttime=time();
$datetime=strftime("%Y-%m-%d %H:%M:%S",$Currenttime);
$datetime=strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
echo $datetime;


?>