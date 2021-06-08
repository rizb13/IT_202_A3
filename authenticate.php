<style>h4{ color: red; }</style>
<?php
//Authenticated session start:
session_start();
unset($_SESSION["KBpassed"]);
//Run-time error checking:
echo"<br>Run-time error reporting is on!<br>";
error_reporting(E_ERROR|E_PARSE|E_WARNING|E_NOTICE);
ini_set('display errors',1);
//PHP code to connect DB:
include ("account.php");
$db = mysqli_connect($hostname,$username,$password,$project);
if (mysqli_connect_error())
{	echo "Faild to connect:".mysqli_connect_error();
	exit();}
echo "Successfully connected!<br>";
mysqli_select_db($db,$project);
//function call to authenticate, safe:
include("myfunctions.php");
$gooddata = true;
$email = safe("email", $gooddata);
$pass = safe("pass", $gooddata);
//print email and pass:
echo "<br>after validation email ='$email'<br>";
echo "<br>after validation pass = '$pass'<br>";
//If not authenticate pop up sticky form:
if($gooddata)
{
	if(!authenticate($db,$email,$pass))
	{echo "<h4><br>*Fail to authenticate! please check your credentials.!<br></h4>";}
	else
	{
		echo"<br>Redirecting to KB1.php";
		$_SESSION["KBpassed"]=true;
		$_SESSION["flag"]="play";
		$_SESSION["email"]=$email;
		header("refresh:5,url=pin1.php");
		exit ("<br>Successfully authenticate!!");
	}
}
?>
<style>
form { margin: auto;
       width: 20%;
       border: 1px solid black;
       padding: 40px;
     }
h3 {margin-top: 5em;
	text-align: center;}
h5 {text-align: center;}
</style>
<h3> Authenticate user Id and Password </h3>
<form action = "authenticate.php" method = "GET">
<br><input type=text name="email" autocomplete=off  value="<?php  echo $email;  ?>">Email Address<br>
<br><input type=password name="pass" id="pass" autocomplete=off value="<?php echo $pass; ?>">Password<br>
<a href="resetpass.html" >Forget Password</a><br>
<input type=checkbox onclick="hide_pass()">Show Password<br>
<input type=submit value="Submit"><br>
</form>
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
<h5> Not registered <a href="registration.html" > Register </a><br> </h5>