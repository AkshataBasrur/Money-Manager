<?php

require_once("config.php");
require_once("header.php");
//Prevent the user visiting the logged in page if he/she is already logged in

if(isUserLoggedIn()) {
	header("Location: myaccount.php");
	die();
}

//Forms posted
if(!empty($_POST)) {
	$errors = array();
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	
	//Perform some validation
	
	if($username == "") {
		$errors[] = "enter username";
	}
	
	if($password == "") {
		$errors[] = "enter password";
	}
	
	if(count($errors) == 0) {
		//retrieve the records of the user who is trying to login
		$userdetails = fetchUserDetails($username);
		
		//See if the user"s account is activated
		if($userdetails==null) {
			$errors[] = "account inactive";
		} else {
			//Hash the password and use the salt from the database to compare the password.
			$entered_pass = generateHash($password, $userdetails["Password"]);
			
			if($entered_pass != $userdetails["Password"]) {
				$errors[] = "invalid password";
			} else {
				//Passwords match! we"re good to go"
				$loggedInUser = new loggedInuser();
				$loggedInUser->email = $userdetails["Email"];
				$loggedInUser->user_id = $userdetails["UserID"];
				$loggedInUser->hash_pw = $userdetails["Password"];
				$loggedInUser->first_name = $userdetails["FirstName"];
				$loggedInUser->last_name = $userdetails["LastName"];
				$loggedInUser->username = $userdetails["UserName"];
				
				//pass the values of $loggedInUser into the session -
				// you can directly pass the values into the array as well.
				
				$_SESSION["ThisUser"] = $loggedInUser;
				
				//now that a session for this user is created
				//Redirect to this users account page
				header("Location: myaccount.php");
				die();
			}
		}
	}
}

?>
<html>
<head>
<title>Login page </title>
<style type="text/css">
.form-style-4{
	width: 450px;
	font-size: 16px;
	background: #f8ff84;
	padding: 30px 30px 15px 30px;
	border: 5px solid #515144;
    box-shadow: inset 0px 0px 15px #515144;
	-moz-box-shadow: inset 0px 0px 15px #515144;
	-webkit-box-shadow: inset 0px 0px 15px #515144;
}
.form-style-4 input[type=submit],
.form-style-4 input[type=text],
.form-style-4 input[type=password],
.form-style-4 label
{
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 16px;
	color: black;
    font-weight: bold;

}
.form-style-4 label {
	display:block;
	margin-bottom: 10px;
}
.form-style-4 label > span{
	display: inline-block;
	float: left;
	width: 150px;
}
.form-style-4 input[type=text],
.form-style-4 input[type=password] 
{
	background: transparent;
	border: none;
	border-bottom: 1px dashed #83A4C5;
	width: 275px;
	outline: none;
	padding: 0px 0px 0px 0px;
	font-style: italic;
}
.form-style-4 input[type=text]:focus,
.form-style-4 input[type=password]:focus
{
	border-bottom: 1px dashed #D9FFA9;
}

.form-style-4 input[type=submit]{
	background: #efdb26;
	border: 1px solid #C94A81;
	padding: 5px 15px 5px 15px;
	color: black;
	box-shadow: inset -1px -1px 3px #ef8025;
	-moz-box-shadow: inset -1px -1px 3px #ef8025;
	-moz-box-shadow: inset -1px -1px 3px #ef8025;
	-webkit-box-shadow: inset -1px -1px 3px #ef8025;
	border-radius: 3px;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;	
	font-weight: bold;
	border-radius: 5px;
}
.form-style-4 input[type=submit]:hover,
.form-style-4 input[type=button]:hover{
background: #394D61;
}
</style>
</head>
<body style='background: url("a.jpg") no-repeat '>
<blockquote>
	<?php print_r($errors); ?>
</blockquote>

<form class="form-style-4" name="login" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
<label for="field1">
<span>Username</span><input type="text" name="username" required="true" />
</label>
<label for="field2">
<span>Password</span><input type="password" name="password" required="true" />
</label>
<label>
<span> </span><input type="submit" value="Login" />
</label>
</form>
</body>
</html>