<style>h4 { color: red;}</style>
<?php
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
//function call:
include("myfunctions.php");
//get data from resetpass form and print to browser:
$gooddata = true;
$email = safe("email", $gooddata);
echo "After Sanitization email= $email<br>";
if($gooddata)
{	//select row for given email:
	$s = "select * from new_users where email = '$email'";
	echo"<br>SQL select statement is: $s<br>";
	($t = mysqli_query($db,$s)) or die (mysqli_error($db));
	$num = mysqli_num_rows($t);
	if ($num == 0)
	{	echo"<h4><br>*This email does not exiest. Please Register.<br></h4>";
		header("refresh:5,url=registration.html");
		exit();
	}
	else
	{	echo"check $email";
		//store pin in session array:
		$_SESSION["KBpassed"]=true;
		$_SESSION["email"] = $email;
		$_SESSION["flag"]="reset";
		header("refresh:3,url=pin1.php");
		exit();	}
}
?>
<style>
form { margin: auto;
       width: 15%;
       border: 1px solid black;
       padding: 20px;
     }
h3 {margin-top: 5em;
	text-align: center;}
h5 {text-align: center;}
</style>
<h3>Reset Password</h3>

<form action = "resetpass.php" method = "GET">

<br><input type=text name="email" autocomplete=off value="<?php echo $email; ?>">Email Address<br>
<br><input type=submit value="Submit"><br>
</form>
