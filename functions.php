<?php

//Check if a user is logged in
/**
 * @return bool
 */
function isUserLoggedIn()
{
	global $loggedInUser, $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		UserID,
		Password
		FROM " . $db_table_prefix . "UserDetails
		WHERE
		UserID = ?
		AND
		Password = ?
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if($loggedInUser == NULL) {
		return false;
	} else {
		if($num_returns > 0) {
			return true;
		} else {
			destroySession("ThisUser");
			return false;
		}
	}
}


//Destroys a session as part of logout
/**
 * @param $name
 */
function destroySession($name)
{
	if(isset($_SESSION[$name])) {
		$_SESSION[$name] = NULL;
		unset($_SESSION[$name]);
	}
}

/**
 * @param $username
 * @param $firstname
 * @param $lastname
 * @param $email
 * @param $password
 * @return bool
 */
function createNewUser($username, $firstname, $lastname, $email, $password)
{
	global $mysqli, $db_table_prefix;
	//Generate A random userid
	$character_array = array_merge(range(a, z), range(0, 9));
	$rand_string = "";
	for($i = 0; $i < 6; $i++) {
		$rand_string .= $character_array[rand(0, (count($character_array) - 1))];
	}
	//echo $rand_string;
	//echo $username;
	//echo $firstname;
	//echo $lastname;
	//echo $email;
	//echo $password;
	$newpassword = generateHash($password);
	//echo $newpassword;
	
	$stmt = $mysqli->prepare(
		"INSERT INTO " . $db_table_prefix . "UserDetails (
		UserID,
		UserName,
		FirstName,
		LastName,
		Email,
		Password
		)
		VALUES (
		'" . $rand_string . "',
		?,
		?,
		?,
		?,
		?
		)"
	);
	$stmt->bind_param("sssss", $username, $firstname, $lastname, $email, $newpassword);
	//print_r($stmt);
	$result = $stmt->execute();
	//print_r($result);
	$stmt->close();
	return $result;
}

/**
 * @param $plainText
 * @param null $salt
 * @return string
 */
function generateHash($plainText, $salt = NULL)
{
	if($salt === NULL) {
		$salt = substr(md5(uniqid(rand(), TRUE)), 0, 25);
	} else {
		$salt = substr($salt, 0, 25);
	}
	return $salt . sha1($salt . $plainText);
}


//Retrieve complete user information by username
/**
 * @param $username
 * @return array
 */
function fetchUserDetails($username)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		UserID,
		UserName,
		FirstName,
		LastName,
		Email,
		Password
		FROM " . $db_table_prefix . "UserDetails
		WHERE
		UserName = ?
		LIMIT 1");
	$stmt->bind_param("s", $username);
	
	$stmt->execute();
	$stmt->bind_result($UserID, $UserName, $FirstName, $LastName, $Email, $Password);
	while($stmt->fetch()) {
		$row = array('UserID' => $UserID,
			'UserName' => $UserName,
			'FirstName' => $FirstName,
			'LastName' => $LastName,
			'Email' => $Email,
			'Password' => $Password);
	}
	$stmt->close();
	return ($row);
}


//Retrieve complete user information of all users
/**
 * @return array
 */
function fetchAllUsers()
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		UserName
		FROM " . $db_table_prefix . "UserDetails");
	
	$stmt->execute();
	$stmt->bind_result($UserName);
	while($stmt->fetch()) {
		$row[] = array('UserName' => $UserName);
	}
	$stmt->close();
	return ($row);
}

function funcAddBill($friends, $mon)
{
	global $loggedInUser, $mysqli, $db_table_prefix;
	echo sizeof($friends);
	$each_contri=round($mon/sizeof($friends),2);
	echo $each_contri;
	foreach($friends as $friend)
	{
	$stmt = $mysqli->prepare("SELECT UserId FROM UserDetails WHERE UserName =? ");
	$stmt->bind_param("s", $friend);
	$stmt->execute();
	$stmt->bind_result($UserId);
	while($stmt->fetch()) {
		$user = array('UserId' =>$UserId);
	}
	echo $user['UserId'];
		$stmt = $mysqli->prepare(
			"INSERT INTO oweTable (
			UserId,
			owes_UserId,
			money
			)
			VALUES (
			?,
			?,
			?
			)"
		);
		$stmt->bind_param("sss", $user['UserId'], $loggedInUser->user_id,$each_contri);
		$result = $stmt->execute();
		echo $user['UserId'];
		$stmt = $mysqli->prepare(
			"INSERT INTO lentTable (
			UserId,
			lent_UserId,
			money
			)
			VALUES (
			?,
			?,
			?
			)"
		);
		$stmt->bind_param("sss", $loggedInUser->user_id, $user['UserId'], $each_contri);
		$result = $stmt->execute();
		$stmt = $mysqli->prepare(
			"UPDATE UserDetails
			SET
			OwesTotal = OwesTotal +?
			WHERE
			userid = ?
			LIMIT 1"
		);
		$stmt->bind_param("ss", $each_contri,$user['UserId']);
		$result = $stmt->execute();
	}
	
	$stmt = $mysqli->prepare(
		"UPDATE UserDetails
		SET
		lentTotal = lentTotal +?
		WHERE
		userid = ?
		LIMIT 1"
	);
	$stmt->bind_param("ss", $mon,$loggedInUser->user_id);
	$result = $stmt->execute();
	$stmt->close();
}
// only fetch the list of people who the logged in user owes money. Notice that we have used $loggedInUser
/**
 * @return array
 */
function fetchMyGiveList()
{
	global $loggedInUser, $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		UserDetails.UserID,
        UserDetails.UserName,
	    UserDetails.FirstName,
	    UserDetails.LastName,
	    UserDetails.Email,
	    oweTable.money

        FROM oweTable INNER JOIN UserDetails ON oweTable.owes_UserId = UserDetails.UserID
	                  
		WHERE oweTable.UserId = ? AND oweTable.money > 0

		ORDER BY oweTable.money DESC");
	$stmt->bind_param("s", $loggedInUser->user_id);
	$stmt->execute();
	$stmt->bind_result($UserID,$UserName, $FirstName, $LastName, $Email, $money);
	while($stmt->fetch()) {
		$row []= array('UserID' => $UserID,
			'UserName' => $UserName,
			'FirstName' => $FirstName,
			'LastName' => $LastName,
			'Email' => $Email,
			'money' => $money
		);
	}
	$stmt->close();
	return ($row);
}


// only fetch the list of people who the logged in user owes money. Notice that we have used $loggedInUser
/**
 * @return array
 */
function fetchMyTakeList()
{
	global $loggedInUser, $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		lenttable.uniqueid,
		UserDetails.UserID,
        UserDetails.UserName,
	    UserDetails.FirstName,
	    UserDetails.LastName,
	    UserDetails.Email,
	    lenttable.money

        FROM lenttable INNER JOIN UserDetails ON lenttable.lent_UserId = UserDetails.UserID
	                  
		WHERE lenttable.UserId = ? AND lenttable.money > 0

		ORDER BY lenttable.money DESC");
	$stmt->bind_param("s", $loggedInUser->user_id);
	$stmt->execute();
	$stmt->bind_result($uniqueid,$UserID,$UserName, $FirstName, $LastName, $Email, $money);
	while($stmt->fetch()) {
		$row[] = array('uniqueid' => $uniqueid,
			'UserID' => $UserID,
			'UserName' => $UserName,
			'FirstName' => $FirstName,
			'LastName' => $LastName,
			'Email' => $Email,
			'money' => $money
		);
	}
	$stmt->close();
	return ($row);
}
function getOwe()
{
	global $loggedInUser, $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT OwesTotal FROM UserDetails WHERE UserID =? ");
	$stmt->bind_param("s", $loggedInUser->user_id);
	$stmt->execute();
	$stmt->bind_result($OwesTotal);
	while($stmt->fetch()) {
		$row = array('OwesTotal' =>$OwesTotal);
	}
	$stmt->close();
	echo $row['OwesTotal'];
}

function getLent()
{
	global $loggedInUser, $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT lentTotal FROM UserDetails WHERE UserID =? ");
	$stmt->bind_param("s", $loggedInUser->user_id);
	$stmt->execute();
	$stmt->bind_result($lentTotal);
	while($stmt->fetch()) {
		$row = array('lentTotal' =>$lentTotal);
	}
	$stmt->close();
	echo $row['lentTotal'];
}

function deleteTakeExpense($uniqueid)
{
	global $loggedInUser, $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
	 UserId,
	 lent_UserId,
	 money FROM lenttable WHERE uniqueid =? ");
	$stmt->bind_param("s", $uniqueid);
	$stmt->execute();
	$stmt->bind_result($UserId, $lent_UserId, $money);
	while($stmt->fetch()) {
		$row = array('UserId' =>$UserId,
		'lent_UserId' => $lent_UserId,
		'money' => $money);
	}
	
	$stmt = $mysqli->prepare(
		"UPDATE UserDetails
		SET
		lentTotal = lentTotal -?
		WHERE
		userid = ?
		LIMIT 1"
	);
	$stmt->bind_param("ss", $money,$UserId);
	$result = $stmt->execute();

	$stmt = $mysqli->prepare(
		"UPDATE UserDetails
		SET
		OwesTotal = OwesTotal -?
		WHERE
		userid = ?
		LIMIT 1"
	);
	$stmt->bind_param("ss", $money,$lent_UserId);
	$result = $stmt->execute();

	$stmt = $mysqli->prepare("DELETE FROM oweTable WHERE 
							(UserId=? AND owes_UserId=? AND money=?)");
	$stmt->bind_param("sss",$UserId, $owes_UserId, $money);
	$stmt->execute();

	$stmt = $mysqli->prepare("DELETE FROM lenttable WHERE uniqueid=?");
	$stmt->bind_param("s",$uniqueid); 
	$stmt->execute();
	$stmt->close();
}
?>