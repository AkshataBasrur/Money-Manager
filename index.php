<html>
    <head>
    <title> Money Manager </title>
<?php
require_once("config.php");
require_once("header.php");
//Prevent the user visiting the logged in page if he/she is already logged in

if(isUserLoggedIn()) {
	header("Location: myaccount.php");
	die();
}
?>
<style>

.ptext{
    color: white;
}
</style>
</head>
<body style='background: url("a.jpg") no-repeat '>


<div class="ptext">
<br><br><br>
<H2> Make sure you manage your expenses wisely.</H2> <br>
We understand that it is a headache to keep a track of all the friends 
<br> you owe and the friends who have to pay you back.
<H3>Don't worry, we will help you out.<br></H3>

<b>And the best of all? It's totally free </b><br>
Ready to give it a spin?
</div>
</body>
</html>