<?php 
/*********************
* Keith McKinley
* CS290 Spring 2015
* Assignment 4
login.php should have a form where a user can enter a username. 
It should have a button that says "Login". Upon clicking the login button 
	the page should POST the username to the page content1.php. 
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

content1.php must have a link to content2.php that is displayed only after a user has logged in (this includes subsequent visits not from login.php). content2.php should have a link back to content1.php. Both content1.php and content2.php should require that a user at some point logged in to access them. Otherwise they should redirect back to login.php.content1.php must have a link to content2.php that is displayed only after a user has logged in (this includes subsequent visits not from login.php). content2.php should have a link back to content1.php. Both content1.php and content2.php should require that a user at some point logged in to access them. Otherwise they should redirect back to login.php.
*******************/
?>