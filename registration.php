<?php
//Run-time error checking:
echo"<br>Run-time error reporting is on!<br>";
error_reporting(E_ERROR|E_PARSE|E_WARNING|E_NOTICE);
ini_set('display errors',1);
//PHP code to connect DB:
include ("account.php");
$db = mysqli_connect($hostname,$username,$password,$project);
if (mysqli_connect_error())
{
	echo "Faild to connect:".mysqli_connect_error();
	exit();
}
echo "Successfully connected!<br>";
mysqli_select_db($db,$project);
//function call:
include("myfunctions.php");
//get data from registration form and print to browser:
$gooddata = true;
$email = safe("email", $gooddata);
echo "After Sanitization email= $email<br>";
$name = safe("name", $gooddata);
echo "After Sanitization name = $name<br>";
$pass = safe("pass",$gooddata);
echo "After Sanitization pass = $pass<br>";
$cell_num = safe("cell_num", $gooddata);
echo "After Sanitization cell_num = $cell_num<br>";
//check if user already exiest:
$exiest = true;
if ($gooddata)
{
	$s1 = "select * from new_users where email = '$email'";
	($t1=mysqli_query($db,$s1)) or die (mysqli_error($db));
		 $email_exiest = mysqli_num_rows($t1);
	echo"<br>query to check if email already exiest: $s1<br>";
	$s2 = "select * from new_users where cell_num = '$cell_num'";
	echo"<br>query to check if cell_num already exiest: $s2<br>";
	($t2=mysqli_query($db,$s2)) or die (mysqli_error($db));
		 $cell_exiest = mysqli_num_rows($t2);
	if ($email_exiest > 0)
	{
		echo "sorry this email is already exiest login with correct credentials!";
		header("refresh:5,url=authenticate.html");
		exit();
	}
	if ($cell_exiest > 0)
	{
		echo "sorry this phone number is already exiest login with correct credentials!";
		header("refresh:5,url=authenticate.html");
		exit();
	}
	else
	{
		$exiest = false;
	}
}

if(!$exiest)
{
	//create hash value of $pass:
    $hash = password_hash( $pass, PASSWORD_DEFAULT );
	$s = "INSERT INTO new_users (email, name, cell_num, pass, hash)
	      VALUES ('$email', '$name','$cell_num', '$pass','$hash')";
    ($t = mysqli_query($db,$s)) or die(mysqli_error($db));
	echo"<br>Insert query: $s<br>";
	echo "<br>Registered Successfully!<br>";
	echo "Please login with your credintials!";
	header("refresh:5, url=authenticate.html");
	exit();
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
<h3> Registration Page </h3>
<form action = "registration.php" method = "GET">
<br><input type=text name="email" autocomplete=off value="<?php echo $email; ?>">Email Address<br>
<br><input type=text name="name" autocomplete=off  value="<?php  echo $name;  ?>">Full Name<br>
<br><input type=Password name="pass" id="pass" autocomplete=off value="<?php echo $pass; ?>">Password<br>
<a href="resetpass.html" >Forget Password</a><br>
<input type=checkbox onclick="hide_pass()">Show Password<br>
<input type=text name="cell_num" autocomplete=off value="<?php echo $cell_num; ?>">Contact Number<br><br>
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
<h5> already registered <a href="authenticate.html" > Login </a><br> </h5>