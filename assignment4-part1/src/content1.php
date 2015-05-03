<?php
/************************************
* Keith McKinley
* CS290 Spring 2015
* Assignment 4

The username should be posted via a parameter called username. 
	If the username is an empty string or null, content1.php should display the message 
		"A username must be entered. Click here to return to the login screen.". 
		The text 'here' should be a link that links back to login.php. 
	If the username is any other string it should display the text 
		"Hello [username] you have visited this page [n] times before. Click here to logout.".
		n should display 0 on the first visit, 1 on the 2nd and so on. 
		The text 'here' should log the user out, destroying the session, and return them to the login screen.

If the user navigates away from the page and returns, the session should persist. 
The user may not navigate back via a POST. 
This is OK, the count should persist. The POST is only needed for the initial login.

If a user tries to access either content1.php or content2.php without going through the login page 
	at some previous point in time the user should should simply be redirected back to login.php. 
There are different ways to accomplish this. 
One might be to set a variable when a session is started the 'correct' way and check if that variable exists when loading the page.

content1.php must have a link to content2.php that is displayed only after a user has logged in 
	(this includes subsequent visits not from login.php). content2.php should have a link back to content1.php. 
Both content1.php and content2.php should require that a user at some point logged in to access them. 
Otherwise they should redirect back to login.php.content1.php must have a link to content2.php that is displayed 
	only after a user has logged in (this includes subsequent visits not from login.php). 
content2.php should have a link back to content1.php. 
Both content1.php and content2.php should require that a user at some point logged in to access them. 
	Otherwise they should redirect back to login.php.
*******************/
	session_start();
	if( !(isset($_POST['username']) ) && !(isset($_SESSION['username'])) )
	{
		header( 'Location: http://web.engr.oregonstate.edu/~mckinlek/CS290/assignment4-part1/src/login.php' ) ;
	}
	$badLogin = 0;
	if( strlen(trim($_POST['username']) )  == 0 && !(isset($_SESSION['username'])))//&& PHP_SESSION_ACTIVE != session_status() ) 
	{
		//http://stackoverflow.com/questions/9154719/check-whether-post-value-is-empty trimming whitespace from the POST is a clever way to check that the variable isn't empty
		$badLogin = 1;
	}
	
	if( $badLogin == 0 )  {
		if(strlen(trim($_POST['username']) ) > 0 )
		{	//set the user name if it's new
			$_SESSION['username'] = $_POST['username'];
			unset($_SESSION['count']);
		}
	if (!(isset($_SESSION["count"])) ) {
		  $_SESSION["count"] = 0;
		} 
		else 
		{
		  $_SESSION["count"]++;
		}
	}
	else{
		$_SESSION["count"] = -1;
	}
	?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		h1: {font-size: 2em;}
		
	</style>
	
	

</head>
<h1>
This is content1.php
</h1>
<body>
	<?php if($badLogin != 0 ) : ?>
	A username must be entered. Click <a href="http://web.engr.oregonstate.edu/~mckinlek/CS290/assignment4-part1/src/login.php?logout=1">here</a> to return to the login screen.
	<?php else : ?>
	Hello <?php echo $_SESSION["username"]; ?> you have visited this page <?php echo $_SESSION["count"]; ?> times before. Click <a href="login.php">here</a> to logout. <br>
	<br>
	<a href="content2.php">Click here</a> to visit content2.php
	<?php endif; ?>
</body>
</html>