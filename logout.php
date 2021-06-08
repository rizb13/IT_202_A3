<?php
session_start();

$sidvalue = session_id(); 
echo "<br>Your session id: " . $sidvalue . "<br>";

$_SESSION = array();		//Make $_SESSION  empty
session_destroy();			//Terminate session on server
setcookie("PHPSESSID", "", time()-3600); ;

echo "Your session is terminated."; 

echo "This uses the default 'path' for a session - <br>it should actually be a more specific path!";


?>