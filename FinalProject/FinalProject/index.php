<?php 
/*
* Keith McKinley
* CS290 - Spring 2015
* Final Project

*/

$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'mckinlek-db';
$dbuser = 'mckinlek-db';
$dbpass = '5qNWhVs2K36LBXi7';

$mysql_handle = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Error connecting to database server");

mysql_select_db($dbname, $mysql_handle)
    or die("Error selecting database: $dbname");

echo 'Successfully connected to database!';

?>

<html>
<head>
	<?php
	if (!(isset($_GET['logout'])) )
	{
		// destroy the session
		session_unset();
		session_destroy();
	}
	session_start();
	//$_SESSION['count'] = -1; //set the count
	?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap core CSS -->
	<link href="bootstrap.min.css" rel="stylesheet">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="AddressBookStyle.css">
	<title>Login - Address Book</title>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"> <!-- for jquery--></script>
	<script>
		$(document).ready(function(){
		
			//$('#usernameAbsent').empty();
		    $('#loginSubmit').click(function(){
				var loginOutput = "";  
				var loginName = $('#LoginUsername').val();
				loginOutput = uNameValid(loginName);
				var password = $('#LoginPassword').val();
				loginOutput += passwordValid(password);
				
				if (loginOutput.length > 0) {
					//submit to login
				}
				$('#usernameAbsent').html(loginOutput);
			}); 
			
			
			$('#signupSubmit').click(function() {
				var signupOutput = "";
				var userName = $('#signupName').val();
				var pass1 = $('#password1').val();
				var pass2 = $('#password2').val();
				var mail1 = $('#email1').val();
				var mail2 = $('#email2').val();
				signupOutput += pass1 + "<br>";
				signupOutput += uNameValid(userName);
				signupOutput += passwordValid(pass1);
				signupOutput += emailValid(mail1);
				if (pass1 != pass2) {
					signupOutput += 'Passwords must match!<br>';
				}
				if (mail1 != mail2) {
					signupOutput += 'E-mail addresses must match<br> ';// + mail1 + " " + mail2;
				}
				$('#signupOutput').html(signupOutput);
			});
			function uNameValid(uName) {
				var output = "";
				var min_chars = 3;
				var max_chars = 254;
				if(uName.length < min_chars || uName.length > max_chars){  
				//if it is the wrong length
					output += 'Username must be between 3 and 254 characters<br>';  
				} 
				else if (contains(uName, " ~!@#$%^&*()-+=`{}[]\\\|:;'<>?,./\"")){
					output += 'Username can only contain letters and numbers<br>';
				}
				return output;
			}
			function passwordValid(pWord) {
				var output = "";
				var min_chars = 6;
				var max_chars = 254;
				if(pWord.length < min_chars || pWord.length > max_chars){  
				//if it is the wrong length
					output += 'Password must be between 6 and 254 characters<br>';  
				}
				else if (contains(pWord, " ~`{}[]\\\|:;'<>?,./\"")){
					$('#signupOutput').html('RUNNING');
					output += 'Illegal character(s) in password';
				}
				return output;
			}
			function emailValid(eml) {
				var output = "";
				var leadCharCountMin = 2;
				var leadCharCountMax = 100;
				var midCharCountMin = 3;
				var midCharCountMax = 100;
				var trailCharCountMin = 1;
				var trailCharCountMax = 10;
				if (eml.indexOf("@") < leadCharCountMin || eml.indexOf("@") > leadCharCountMax ) {
					output += "There must have between " + leadCharCountMin + " and " + leadCharCountMax + " characters before the '@'<br>";
				}
				var lastTwoThirds = eml.substring(eml.indexOf("@")+1, 1000);
				//alert(lastTwoThirds);
				var mid = lastTwoThirds.substring(0,lastTwoThirds.indexOf("."));
				var end = lastTwoThirds.substring(lastTwoThirds.indexOf(".") + 1, 1000);
				if (mid.length < midCharCountMin || mid.length > midCharCountMax) {
					output += "There must be between " + midCharCountMin + " and " + midCharCountMax + " characters between the '@' and the '.'<br>";
				}
				if (end.length < midCharCountMin || end.length > midCharCountMax) {
					output += "There must be between " + trailCharCountMin + " and " + trailCharCountMax + " characters after the '.'<br>";
				}
				
				return output;
			}
			function contains(inString, badLetters) {
				for (cntr = 0; cntr < badLetters.length; cntr++) {
					if (inString.indexOf(badLetters.substring(cntr,cntr + 1)) >= 0) {
						return true;
					}
				}
				return false;
			}

		});
	</script>
	
</head>
<h1>
Welcome to The Address Book!
</h1>
<body>
	<script type="text/javascript">
		function checkLogin() 
		{
			if(document.login.username.value == "") 
			{
				alert("Please enter a username");
				return false;
			}
			if(document.login.password.value == "") 
			{
				alert("Please enter a password");
				return false;
			}
			alert("form is ok");
			document.login.submit();
			return true;
		}
		function checkSignup(form) {
			if(document.signup.username.value == "") {
				alert("Please enter a username");
				return false;
			}
			if(document.signup.password1.value == "") {
				alert("Please enter a password");
				return false;
			}
			if(document.signup.password1.value != document.signup.password2.value) {
				alert("Passwords do not match");
				return false;
			}
			document.signup.submit();
		}
	</script>
	<fieldset>
	<h3>Returning users, login:</h3>
	<form id="login" method="POST" onsubmit="return checkLogin(this;);">
		<table> <tr>
		<td><b>User name: </td><td><input type="text" id="LoginUsername"></td></tr>
		<tr><td><b>Password: </td><td><input type="password" id="LoginPassword"></td></tr>
		</table>
		<div id='usernameAbsent'></div>
		<input id="loginSubmit" type="button" value="Sign in"">
		<!--input type="submit"-->
	</form>
	</fieldset>
	<a href="MyAddresses.php">Test Link</a>
	<fieldset>
	<h3>New Users, create an account:</h3>
	<form id="signup" method="POST" onsubmit="return checkLogin(this;);">
		<table> <tr>
		<td><b>User name: </td><td><input type="text" id="signupName"></td></tr>
		<tr><td><b>Password: </td><td><input type="password" id="password1"></td></tr>
		
		<tr><td><b>Re-enter<br>Password: </td><td><input type="password" id="password2"></td></tr>
		<tr><td><b>Email Address:</td><td><input type="text" id="email1"></td></tr>
		<tr><td><b>Re-enter<br>Email:</td><td><input type="text" id="email2"></td></tr>
		</table>
		<div id="signupOutput"></div>
		<input id="signupSubmit" type="button" value="Sign up!">
		<!--input type="button" name="signup" value="Sign up!" onclick="checkSignup()"-->
	
	</form>
`	</fieldset>
</body>
</html>