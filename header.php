<html>
<head>
<style>
/* Add a black background color to the top navigation */
.topnav {
  background-color: #333;
  overflow: hidden;
  color : yellow;
  font-size: 25px;
  float: center;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: right;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
  background-color: yellow;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add an active class to highlight the current page 
.active {
  background-color: #f3f711;
  color: black;
  }
*/
/* Hide the link that should open and close the topnav on small screens */
.topnav .icon {
  display: none;
}
</style>
</head>
<body>
<div class="topnav" id="myTopnav">
MONEY MANAGER
<?php
	//Links for logged in user
	if(isUserLoggedIn()) { ?>
        <a href="logout.php">Logout</a>
        <a href="addBill.php">Add Bills</a>
		<a href="myaccount.php">My account</a>
		
    <?php }
	//Links for users not logged in
	else { ?>
        <a href="login.php" class="active">LOGIN</a>
        <a href="register.php">REGISTER</a>
        <a href="index.php"> HOME</a>
    <?php } ?>
</div>
</body>
</html>