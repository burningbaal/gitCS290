<?php 
/*
* Keith McKinley
* CS290 - Spring 2015
* Final Project

*/
	//ECHO "starting";
	if( !(isset($_POST['name']) ) || !(isset($_POST['pass'])) )
	{
		//header( 'Location: http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/index.php' ) ;
		echo "didn't get the right POST values.";
		die;
	} else {
		$dbhost = 'oniddb.cws.oregonstate.edu';
		$dbname = 'mckinlek-db';
		$dbuser = 'mckinlek-db';
		$dbpass = '5qNWhVs2K36LBXi7';

		$mysql_handle = mysql_connect($dbhost, $dbuser, $dbpass)
			or die("Error connecting to database server");

		mysql_select_db($dbname, $mysql_handle)
			or die("Error selecting database: $dbname");

		//echo 'Successfully connected to database!\n';
		$username = mysql_real_escape_string($_POST['name']); 
		$password = mysql_real_escape_string($_POST['pass']); 
		$email = mysql_real_escape_string($_POST['email']);
		if (!(isset($_POST['email']))) {
			$tmpQuery = "SELECT * FROM addressBookUsers WHERE username = '" . $username . "' AND password = '" . $password . "';";
			$query = mysql_query($tmpQuery);
			if (mysql_num_rows($query) > 0) {
				echo "http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/MyAddresses.php";
				
				session_start();
				$_SESSION['username'] = $username;
				die;
			}
			else {
				echo "Invalid username or password.";
				die;
			}
		} else {
			$tmpQuery = "SELECT * FROM addressBookUsers WHERE username = '" . $username . "';";
			$query = mysql_query($tmpQuery); // check if username already exists
			if (mysql_num_rows($query) > 0) {
				echo "Sorry, $username is already in use.";
				die;
			} 
			$tmpQuery = "SELECT * FROM addressBookUsers WHERE email = '" . $email . "';";
			$query = mysql_query($tmpQuery);
			if (mysql_num_rows($query) > 0) {
				//check if that email is in use
				echo "Sorry, $email is already in use.";
				die;
			} 
			//php would have died if account is not in use
			
			//echo "trying to create a new account" . $username . " " . $password . " " . $email . "<br>";
			$tmpQuery = "INSERT INTO addressBookUsers (username, password, email) VALUES('$username', '$password', '$email');";
			//echo $tmpQuery;
			$query = mysql_query($tmpQuery);
			if ($query > 0) {
				//check account created
				echo "http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/MyAddresses.php?newUser=" . $username;
				
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['newUser'] = 1;
				die;
			} 
			die;
		}
	}
	echo $tmpQuery . "       " . $query;
	echo "didn't get anything done";
?>