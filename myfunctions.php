<style> tbad { color : black; } th { color : black ; } </style>
<style> tr:nth-child(even) { background-color: #cccccc } </style>
<style> h4{ color: red;}</style>
<?php
function safe($fieldname,&$gooddata)
{	$validate = true;
	$regex = '/^[a-zA-Z]+/';
	$input = $_GET[$fieldname];
	echo "<br>$fieldname is: $input<br>";
	if ($fieldname == "email")
	{	$emailSanitized = filter_var($input, FILTER_SANITIZE_EMAIL);
		if ((filter_var($emailSanitized, FILTER_VALIDATE_EMAIL)) == false)
		{	$validate = false;
			echo "<h4><br>$emailSanitized is Not a valid email address<br></h4>";		}
		if(((filter_var($emailSanitized, FILTER_VALIDATE_EMAIL)) != false) and (preg_match('/\w*.edu\b/',$emailSanitized,$matches) == 0))
		{   $validate = false;
			echo "<br>$emailSanitized is Not a valid email address.<br>";
			echo"<h4><br>*Must be a school email address.(i.e xyz@abc.edu)</h4>";	}	}
	if($fieldname == "name")
	{	$nameSanitized = filter_var($input, FILTER_SANITIZE_STRING);
		if ((filter_var($nameSanitized, FILTER_VALIDATE_REGEXP,array("options" => array("regexp" => $regex)))) == false)
		{	$validate = false;
			echo "<h4><br>$nameSanitized is Not a valid Name!<br></h4>";		}
		if (((filter_var($nameSanitized, FILTER_VALIDATE_REGEXP,array("options" => array("regexp" => $regex)))) != false) 
			and (preg_match('/^[A-Za-z]+\s[A-za-z]+$/',$nameSanitized,$matches) == 0)) 
		{	$validate = false;
			echo "<br>$nameSanitized is Not a valid Name.<br>";
			echo"<h4><br>*Must be a Full Name.(i.e First Last)</h4>";}	}
    if($fieldname == "pass")
	{	$passSanitized = filter_var($input, FILTER_SANITIZE_EMAIL);
		if (((filter_var($passSanitized,FILTER_VALIDATE_INT)) == false) and ((filter_var($passSanitized,FILTER_VALIDATE_INT)) != 0))
		{   $validate = false;
		    echo "<h4><br>$passSanitized is Not a valid password!<br></h4>";		}
		if ((((filter_var($passSanitized,FILTER_VALIDATE_INT)) != false)
			or ((filter_var($passSanitized,FILTER_VALIDATE_INT)) == 0))
			and (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{12}$/',$passSanitized,$matches) == 0)) 
		{	$validate = false;
			echo "<br>$passSanitized is Not a valid password!<br>";
			echo "<h4><br>*Password doesn't meet following requirnment.
				 <br>*Must be 12 character long.
			     <br>*Must contain atleast one special character.
				 <br>*Must contain atleast one upper-case letter.
				 <br>*Must contain atleast one lower-case letter.
				 <br>*Must contain atleast one degite.
				 <br>*Must not contain any white spaces.</h4>";		}	}
	if ($fieldname == "cell_num")
	{	$cell_numSanitized = filter_var($input, FILTER_SANITIZE_EMAIL);
		if (((filter_var($cell_numSanitized,FILTER_VALIDATE_INT)) == false) and ((filter_var($cell_numSanitized,FILTER_VALIDATE_INT)) != 0))
		{   $validate = false;
			echo "<h4><br>$cell_numSanitized is Not a valid phone number<br></h4>";		}
		if((((filter_var($cell_numSanitized,FILTER_VALIDATE_INT)) != false)
					or ((filter_var($cell_numSanitized,FILTER_VALIDATE_INT)) == 0)) and
			(preg_match('/^[0-9]{10}$/',$cell_numSanitized,$matches) == 0))
		{	$validate = false;
			echo "<br>$cell_numSanitized is Not a valid phone number<br>";
			echo"<h4><br>*contact number must be a 10 degits number.</h4>";		}	}
	if(!$validate)
	{	echo "<br>$fieldname is invalid, please try again!<br>";
		$gooddata = false;	}
return $input;	}

//Boolean function to authenticate ID and Pass entered by user:
function authenticate ($db, $email, $pass)
{
  global $t;
  
  //create hash value of $pass:
  $hash = password_hash( $pass, PASSWORD_DEFAULT );
  echo"hash = $hash<br>";
  
  //select row for given email:
  $s = "select * from new_users where email = '$email'";
  echo"<br>SQL select statement is: $s<br>";
  ($t = mysqli_query($db,$s)) or die (mysqli_error($db));
  $num = mysqli_num_rows($t); 
  if($num == 0) {return false;}
  else
  {
  $r = mysqli_fetch_array ( $t, MYSQLI_ASSOC );
  $hash = $r['hash'];
  //varify $hash against plaintext password in in $pass:
    if (password_verify($pass, $hash)){ return true; }
    else                             { return false; }
  }
}
?>