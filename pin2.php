<?php
//session start:
session_start();
unset($_SESSION["pinpassed"]);
//Run-time error checking:
error_reporting(E_ERROR|E_PARSE|E_WARNING|E_NOTICE);
ini_set('display errors',1);

//check if pin generated and stored in session array otherwise start with new security question:

if(!isset($_SESSION["pin"]))
{
	echo"<h4><br>This email does not exiest. Please Register.<br></h4>";
	header("refresh:5,url=registration.html");
	exit();
}
//retrive randomely generated pin from session array:
$real_pin=$_SESSION["pin"];
//retrive user pin from get array:
$user_pin=$_GET["pin"];
//check if user pin matched with original pin redirect to service1.php:
if($real_pin == $user_pin)
{
	echo "<br>Succefully verified!<br>";
	$_SESSION["pinpassed"]=true;
	echo "<br>redirect to service1.php<br>";
	header("refresh:5,url=service1.php");
	exit();
}
//otherwise regenerate pin:
else
{
	 echo "<br>your pin does not match!<br>";
	 echo "<br>redirect to pin1.php<br>";
	 header("refresh:5,url=pin1.php");
	 exit();
}
?>
