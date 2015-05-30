<?php 
/*
* Keith McKinley
* CS290 - Spring 2015
* Final Project

*/

session_start();
	if( !(isset($_POST['username']) ) && !(isset($_SESSION['username'])) )
	{
		//header( 'Location: http://web.engr.oregonstate.edu/~mckinlek/CS290/assignment4-part1/src/login.php' ) ;
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
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap core CSS -->
	<link href="bootstrap.min.css" rel="stylesheet">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="AddressBookStyle.css">
	<title>Address Book</title>
	

</head>
<body>
	<h1>Your Address Book</h1>
	<form action="MyAddresses.php" method="POST">
		<table> <tr>
		<td><b>Name: </td><td colspan="5"><input type="text" name="inName" size="100" maxlength="254"></td></tr>
		<td><b>Household Size: </td><td colspan="5"><input type="number" name="inSize"></td></tr>
		<tr><td><b>Address:</td><td colspan="5"><input type="text" name="inAddress" size="100"  maxlength="254"></td></tr>
		<tr>
			<td><b>City:</td><td><input type="text" name="inCity"  maxlength="254"></td>
			<td><b>State:</td><td><select name="inState">
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District Of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>			
				</td>
			<td><b>Zip Code:</td><td><input type="text" name="inZip" maxlength="5"></td>
		</tr>
		</table>
		<input type="submit">
	</form>
	<br>
	<table class="table table-striped table-bordered">
		<thead><tr>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip Code</th>
		</tr></thead>
		<tbody>
			<tr><th>test</th><td>testing</td></tr>
			<tr><th>test</th><td>testing</td></tr>
		</tbody>
	</table>
<body>