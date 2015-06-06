<?php 
/*
* Keith McKinley
* CS290 - Spring 2015
* Final Project

*/

session_start();
	if( !(isset($_POST['user']) ) && !(isset($_POST['newUser']) ) && !(isset($_SESSION['username'])) )
	{
		header( 'Location: http://web.engr.oregonstate.edu/~mckinlek/CS290/assignment4-part1/src/login.php' ) ;
	}
	$badLogin = 0;
	//var_dump($_POST);
	$dbhost = 'oniddb.cws.oregonstate.edu';
	$dbname = 'mckinlek-db';
	$dbuser = 'mckinlek-db';
	$dbpass = '5qNWhVs2K36LBXi7';

	$mysql_handle = mysql_connect($dbhost, $dbuser, $dbpass)
		or die("Error connecting to database server");

	mysql_select_db($dbname, $mysql_handle)
		or die("Error selecting database: $dbname");
	if (!(isset($_SESSION['username'])))  {
		//http://stackoverflow.com/questions/9154719/check-whether-post-value-is-empty trimming whitespace from the POST is a clever way to check that the variable isn't empty
		$badLogin = 1;
		echo "NOT LOGGED IN!";
	}
	if (isset($_SESSION['newUser']) ) {
		$welcomeMessage = "Welcome, " . $_SESSION['username'] . ".  We hope you like using this address book!<br>";
	}
	$selectQuery = "SELECT ab.Name, ab.houseSize, ab.Address, ab.City, ab.State, ab.Zip FROM addressBook as ab INNER JOIN addressBookUsers as users ON ab.FK_userId=users.id WHERE users.username='" . $_SESSION['username'] . "';";
	//echo $selectQuery;
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
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"> <!-- for jquery--></script>
	<script>
		$(document).ready(function(){
			$(document).on('click', '.newEntry', function(){
				//check if 'Name' already exists in DB
				//alert("in function!");
				var newName = $('#newName').val();
				var url = 'http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/queries.php';
				
				//add get data to request
				url += '?check=1&Name=' + encodeURIComponent(newName);
				console.log("ajax to " + url);
				$.ajax({
					type: 'GET',
					url: url,           
					success: function(data)
						{
						//got response
						if (data != "0") {
							//this Name already exists, they could edit it?
							console.log(newName + " already exists!");
							console.log(data);
						} else {
							console.log(newName + " does not exist!");
							var url = 'http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/queries.php';
							
							//add get data to request
							url += '?Insert=1&Name=' + encodeURIComponent(newName);
							url += '&houseSize=' + encodeURIComponent($('#houseSize').val());
							url += '&Address=' + encodeURIComponent($('#Address').val());
							url += '&City=' + encodeURIComponent($('#City').val());
							url += '&State=' + encodeURIComponent($('#State').val());
							url += '&Zip=' + encodeURIComponent($('#Zip').val());
							console.log(url);
							 $.ajax({
								type: 'GET',
								url: url,           
								success: function(data)
								{
									console.log(data);
									$('#mainTable').html(data);
									$('#newName').val('');
									$('#houseSize').val('');
									$('#Address').val('');
									$('#City').val('');
									$('#State').val('');
									$('#Zip').val('');
								}
							 });
							}
						}
				   });
				
			});
			$(document).on('click', '.updateEntry', function(){
				//check if 'Name' already exists in DB
				//alert("in function!");
				var newName = $('#newName').val();
				var url = 'http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/queries.php';
				
				//add get data to request
				url += '?check=1&Name=' + encodeURIComponent(newName);
				console.log("ajax to " + url);
				$.ajax({
					type: 'GET',
					url: url,           
					success: function(data)
						{
						//got response
						if (data == "0") {
							//this Name doesn't exists, we should ask if they want to enter a new one
							console.log(newName + " doesn't exist!");
							console.log(data);
						} else {
							//console.log(newName + " does not exist!");
							var url = 'http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/queries.php';
							
							//add get data to request
							url += '?Update=1&Name=' + encodeURIComponent(newName);
							url += '&houseSize=' + encodeURIComponent($('#houseSize').val());
							url += '&Address=' + encodeURIComponent($('#Address').val());
							url += '&City=' + encodeURIComponent($('#City').val());
							url += '&State=' + encodeURIComponent($('#State').val());
							url += '&Zip=' + encodeURIComponent($('#Zip').val());
							console.log(url);
							 $.ajax({
								type: 'GET',
								url: url,           
								success: function(data)
								{
									console.log(data);
									//$('#mainTable').html(data);
								}
							 });
							 selectUrl = "http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/queries.php?Select=1;"
							 $.ajax({
								type: 'GET',
								url: selectUrl,           
								success: function(data)
								{
									console.log(data);
									$('#mainTable').html(data);
									$('#newName').val('');
									$('#houseSize').val('');
									$('#Address').val('');
									$('#City').val('');
									$('#State').val('');
									$('#Zip').val('');
								}
							 });
							}
						}
				   });
				
			});
			$('#mainTable').on('click', 'th', function(e) {  //concept from http://stackoverflow.com/questions/21778477/get-column-header-and-row-header-on-cell-click
				
				$('html, body').scrollTop($('#TitleBar').offset().top);
				if (e.delegateTarget.tHead.rows[0].cells[this.cellIndex] != this) {
						//make sure they didn't click on the top row
					var column = e.delegateTarget.tHead.rows[0].cells[this.cellIndex];
					var name = this.parentNode.cells[0];
					$('#newName').val($(name).text() );
					$('#newName').attr("disabled", "disabled"); 
					$('#newEntry').attr('value', 'Change ' + $(name).text() + '\'s Address');
					$('#newEntry').removeClass('newEntry').addClass('updateEntry'); //http://stackoverflow.com/questions/10388492/jquery-change-button-id
					//alert("button class: " + $('.updateEntry').val());
					
					//alert($('#newEntry').text());
				} else {
					//clear the form if they did click on the top row
					$('#newName').val("");
					$('#newName').removeAttr("disabled"); 
					$('#newEntry').attr('value', 'Add New Address');
					$('#newEntry').removeClass('updateEntry').addClass('newEntry'); //http://stackoverflow.com/questions/10388492/jquery-change-button-id
					//alert("button class: " + $('.newEntry').val());
				}
			});
		});
	</script>
</head>
<body>
	<div id="TitleBar" class="TitleBar"><h1><?php echo $_SESSION['username'] . "'s Address Book";?></h1></div>
	<div class="logout"><a class="button" href="http://web.engr.oregonstate.edu/~mckinlek/CS290/FinalProject/index.php?logout=1">Logout</a></div>
	<form action="MyAddresses.php" method="POST">
		
	
		<table> <tr>
		<td><b>Name: </td><td colspan="5"><input id="newName" type="text" name="inName" size="100" maxlength="254"></td></tr>
		<td><b>Household Size: </td><td colspan="5"><input id="houseSize" type="number" name="inSize"></td></tr>
		<tr><td><b>Address:</td><td colspan="5"><input id="Address" type="text" name="inAddress" size="100"  maxlength="254"></td></tr>
		<tr>
			<td><b>City:</td><td><input id="City" type="text" name="inCity"  maxlength="254"></td>
			<td><b>State:</td><td><select id="State" name="inState">
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
			<td><b>Zip Code:</td><td><input id="Zip"t ype="text" name="inZip" maxlength="5"></td>
		</tr>
		</table>
		<input id="newEntry" class="newEntry" type="button" value="Add new address">
		</form>
	<br>
	<table id="mainTable" class="table table-striped table-bordered">
		<thead><tr>
			<th>Name</th>
			<th width="75">House Size</th>
			<th>Address</th>
			<th width="150">City</th>
			<th width="10">State</th>
			<th width="30">Zip Code</th>
		</tr></thead>
		<tbody>
			<?php
				$result = mysql_query($selectQuery);
				if (mysql_num_rows($result) > 0) {
					//var_dump($result);
					//print rows
					while($row = mysql_fetch_array($result)){
						echo "<tr><th class=\"button\">$row[Name]</th><td>$row[houseSize]</td><td>$row[Address]</td><td>$row[City]</td><td>$row[State]</td><td>$row[Zip]</td></tr>\n";
					}
				} else {
					//no rows for user
					echo "<tr><td colspan=\"4\">Nothing in the database</th></tr>\n";
				}
			?>
		</tbody>
	</table>
<body>