<?php
/************************************
* Keith McKinley
* CS290 Spring 2015
* Assignment 4
*/
	session_start();
if( PHP_SESSION_ACTIVE != session_status() )
	{
		header( 'Location: http://web.engr.oregonstate.edu/~mckinlek/CS290/assignment4-part1/src/login.php' ) ;
	}
	
	?>
<html>
<head><style type="text/css">
		h1: {font-size: 2em;}
		
	</style>
</head>
<h1>
This is content2.php
</h1>
<body>
	<?php if(strlen($_SESSION['username']) == 0 || !(isset($_SESSION['username'])) ) : ?>
	A username must be entered. Click <a href="login.php">here</a> to return to the login screen.
	<?php else : ?>
	<?php echo $_SESSION['username']; ?>, you are still logged in! </br>
	<a href="content1.php">Click here</a> to visit content1.php
	<?php endif; ?>
</body>
</html>