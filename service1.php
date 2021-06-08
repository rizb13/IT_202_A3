<style>h4 { color: red;}</style>
<?php
session_start();
//Run-time error checking:
echo"<br>Run-time error reporting is on!<br>";
error_reporting(E_ERROR|E_PARSE|E_WARNING|E_NOTICE);
ini_set('display errors',1);

//PHP code to connect DB:
include ("account.php");
include ("myfunctions.php");
$db = mysqli_connect($hostname,$username,$password,$project);
if (mysqli_connect_error())
{
	echo "Faild to connect:".mysqli_connect_error();
	exit();
}
echo "Successfully connected!<br>";
mysqli_select_db($db,$project);

$flag = $_SESSION["flag"];
$email= $_SESSION["email"];

if($flag == "reset")
{
	$gooddata = true;
	//<input type="submit" name="test" id="test" value="RUN" /><br/>	
	echo"<form action='service1.php' method= 'GET'>
	     <br><input type=password name='pass' id='pass' autocomplete=off>password<br>
		 <input type=checkbox onclick='hide_pass()'>Show Password<br>
		 <br><input type=submit name='test' value='submit'><br>
		 </form>";
	if(array_key_exists('test',$_GET))
	{		
		$pass = safe("pass",$gooddata);
		echo "After Sanitization pass = $pass<br>";
		if($gooddata)
		{
			$s = "select * from new_users where email = '$email'";
			($t = mysqli_query($db,$s)) or die (mysqli_error($db));
			$r = mysqli_fetch_array ( $t, MYSQLI_ASSOC );
			$hash = $r['hash'];
			//varify $hash against plaintext password in in $pass:
			if (password_verify($pass, $hash))
			{
				echo"<h4><br>*can't use old password.
				         <br>*use diffrent password.</h4>";				
			}
			else
			{
				//create hash value of $pass:
				$hash = password_hash( $pass, PASSWORD_DEFAULT );
				echo"hash = $hash<br>";
				$s = "UPDATE new_users SET pass='$pass', hash='$hash'
				      WHERE email='$email'";
				($t = mysqli_query($db,$s)) or die (mysqli_error($db));
				echo"<br>update pass query: $s<br>";
				echo "<br>Password reset Successfully!<br>";
				echo "Please login with your credintials!";
				header("refresh:5, url=authenticate.html");
				exit();
			}
		}
	}
}
if($flag == "play")
{
	echo"<br>Admitted to gameroom<br>";
	header("refresh:5, url=gameroom.html");
}


?>
<script>
function hide_pass()
{
var p = document.getElementById("pass");
if(p.type === "text")
{
p.type = "password";
}
else
{
p.type = "text";
}
}
</script>