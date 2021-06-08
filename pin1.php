<?php
//start session:
session_start();
//Run-time error checking:
error_reporting(E_ERROR|E_PARSE|E_WARNING|E_NOTICE);
ini_set('display errors',1);
//check if KBpassed otherwise redirect to KB1.php for another question:
if(!isset($_SESSION["KBpassed"]))
{
	echo"<h4><br>This email does not exiest. Please Register.<br></h4>";
	header("refresh:5,url=registration.html");
	exit();
}
//you only get here if you have passed personal knowledge inquiry  
echo "<br>Admitted to pin1.php<br>";
//randomely generate 4 degit pin:
$pin = mt_rand(1000,9999);
//store pin in session array:
$_SESSION["pin"]=$pin;
//data to send to mail function:
$to = "rb46@njit.edu";
$subject = "varify your email";
$message = "<br>Enter following pin to varify your email: <br> $pin<br>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//send pin to user email:
mail($to,$subject,$message,$headers);
//print pin on broweser:
echo "<h3><br>NOTE:only for instructor's grading convenience<br> pin is: $pin<br></h3>";
?>
<br><br><br>
<h3>Varify your email address</h3>
<form action="pin2.php" method="GET">
<input type=text name="pin" autocomplete=off>PIN<br>
<input type=submit value="submit">
</form>

