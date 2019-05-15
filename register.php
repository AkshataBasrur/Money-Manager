<html>
<head>
<title> Registeration page </title>
<style>
/* Style inputs with type="text", select elements and textareas */
input[type=text], input[type=password] {
  width: 75%; /* Full width */
  padding: 12px; /* Some padding */  
  border: 1px solid #ccc; /* Gray border */
  border-radius: 4px; /* Rounded borders */
  box-sizing: border-box; /* Make sure that padding and width stays in place */
  margin-top: 6px; /* Add a top margin */
  margin-bottom: 16px; /* Bottom margin */
  resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
}

/* Style the submit button with a specific background color etc */
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

/* When moving the mouse over the submit button, add a darker green color */
input[type=submit]:hover {
  background-color: #45a049;
}

/* Add a background color and some padding around the form */
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<style type="text/css">
body,html{
	height:100%;
}
.form-style-3{
	max-width: 550px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form-style-3 label{
	display:block;
	margin-bottom: 10px;
}
.form-style-3 label > span{
	float: left;
	width: 100px;
	color: black;
	font-weight: bold;
	font-size: 13px;
	text-shadow: 1px 1px 1px #fff;
}
.form-style-3 fieldset{
	border-radius: 10px;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	margin: 0px 0px 10px 0px;
	border: 1px solid #FFD2D2;
	padding: 20px;
	background: #f8ff84;
	box-shadow: inset 0px 0px 15px #515144;
	-moz-box-shadow: inset 0px 0px 15px #515144;
	-webkit-box-shadow: inset 0px 0px 15px #515144;
}
.form-style-3 fieldset legend{
	color: black;
	border-top: 1px solid #FFD2D2;
	border-left: 1px solid #FFD2D2;
	border-right: 1px solid #FFD2D2;
	border-radius: 5px 5px 0px 0px;
	-webkit-border-radius: 5px 5px 0px 0px;
	-moz-border-radius: 5px 5px 0px 0px;
	background: #f8ff84;
	padding: 0px 8px 3px 8px;
	box-shadow: -0px -1px 2px #515144;
	-moz-box-shadow:-0px -1px 2px #515144;
	-webkit-box-shadow:-0px -1px 2px #515144;
	font-weight: normal;
	font-size: 12px;
}

.form-style-3 input[type=text],
.form-style-3 input[type=password],
.form-style-3 input[type=email]{
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border: 1px solid #FFC2DC;
	outline: none;
	color: black;
	padding: 5px 8px 5px 8px;
	box-shadow: inset 1px 1px 4px #515144;
	-moz-box-shadow: inset 1px 1px 4px #515144;
	-webkit-box-shadow: inset 1px 1px 4px #515144;
	background: #e8fffd;
	width:50%;
}
.form-style-3  input[type=submit],
.form-style-3  input[type=button]{
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
}
.required{
	color:red;
	font-weight:normal;
}
</style>
</head>
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
	
	$email = trim($_POST["email"]);
	$username = trim($_POST["username"]);
	$firstname = trim($_POST["firstname"]);
	$lastname = trim($_POST["lastname"]);
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	
	if($username == "") {
		$errors[] = "enter valid username";
	}
	
	if($firstname == "") {
		$errors[] = "enter valid first name";
	}
	
	if($lastname == "")
	{
		$errors[] = "enter valid last name";
	}
	
	
	if($password =="" && $confirm_pass =="") {
		$errors[] = "enter password";
	}
	else if($password != $confirm_pass) {
		$errors[] = "password do not match";
	}
	
	//End data validation
	if(count($errors) == 0) {
		$user = createNewUser($username, $firstname, $lastname, $email, $password);
		
		print_r($user);
		if($user <> 1) {
			$errors[] = "registration error";
		}
	}
	if(count($errors) == 0) {
		$successes[] = "registration successful";
	}
}
?>
<body style='background: url("a.jpg") no-repeat '>
<div class="form-style-3">
<blockquote>
	<?php print_r($errors); ?>
</blockquote>
<form name="newUser" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
<fieldset><legend>Personal Details</legend>
<label><span>User Name: <span class="required">*</span></span><input type="text" class="input-field" name="username" value="" /></label>
<label><span>First Name: <span class="required">*</span></span><input type="text" class="input-field" name="firstname" value="" /></label>
<label><span>Last Name: <span class="required">*</span></span><input type="text" class="input-field" name="lastname" value="" /></label>
<label><span>Password: <span class="required">*</span></span><input type="password" class="input-field" name="password" value="" /></label>
<label><span>Confirm Password: <span class="required">*</span></span><input type="password" class="input-field" name="passwordc" value="" /></label>
<label><span>Email:<span class="required">*</span></span><input type="text" class="input-field" name="email" value="" /></label>
</fieldset>
<label><span> </span><input type="submit" value="Register" /></label>
</fieldset>
</form>
</div>

</body>
</html>