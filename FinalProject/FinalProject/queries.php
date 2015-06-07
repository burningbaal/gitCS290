<?php
	session_start();
	$dbhost = 'oniddb.cws.oregonstate.edu';
	$dbname = 'mckinlek-db';
	$dbuser = 'mckinlek-db';
	$dbpass = '5qNWhVs2K36LBXi7';
	//echo 'running';
	$mysql_handle = mysql_connect($dbhost, $dbuser, $dbpass)
		or die("Error connecting to database server");
	$sortByName = " ORDER BY name";
	$sortByLocation = " ORDER BY State, City, Address, name";
	mysql_select_db($dbname, $mysql_handle)
		or die("Error selecting database: $dbname");
	//var_dump($_GET);
	//echo "<br>";
	$selectQuery = "SELECT id FROM addressBookUsers WHERE username='" . $_SESSION['username'] . "';";
	//echo $selectQuery . "<br>";
	$result = mysql_query($selectQuery);
	$userId = mysql_fetch_array($result)[id];
	if (isset($_GET['check'] ) && isset($_GET['Name'] )) {
		//echo 'in check';
		$tmpQuery = "SELECT * FROM `$dbname`.addressBook WHERE name='" . $_GET['Name'] . "' AND FK_userId='$userId';";
		//echo $tmpQuery . "<br>\n";
		$result = mysql_query($tmpQuery);
		//var_dump($result);
		if (mysql_num_rows($result) > 0) {
			//print rows
			echo mysql_num_rows($result);
			die;
		} else {
			echo mysql_num_rows($result);
			die;
		}
	} 
	else if(isset($_GET['Insert'] ) && isset($_GET['Name']) && isset($_GET['houseSize']) && isset($_GET['Address']) && isset($_GET['City']) && isset($_GET['State']) && isset($_GET['Zip']) ) {
		//get user's PK for use during insert
		$selectQuery = "SELECT id FROM addressBookUsers WHERE username='" . $_SESSION['username'] . "';";
		//echo $selectQuery . "<br>";
		$result = mysql_query($selectQuery);
		$userId = mysql_fetch_array($result)[id];
		//echo "user ID is:  " . $userId . "<br>\n";
		//run insert query
		$insertQuery = "INSERT INTO `$dbname`.`addressBook` (`id`, `Name`, `houseSize`, `Address`, `City`, `State`, `Zip`, `FK_userId`, `private`) VALUES (";
		$insertQuery .= "NULL,";
		$insertQuery .= "'" . mysql_real_escape_string($_GET['Name']) . "',";
		$insertQuery .= "'" . $_GET['houseSize'] . "',";
		$insertQuery .= "'" . mysql_real_escape_string($_GET['Address']) . "',";
		$insertQuery .= "'" . mysql_real_escape_string($_GET['City']) . "',";
		$insertQuery .= "'" . mysql_real_escape_string($_GET['State']) . "',";
		$insertQuery .= "'" . mysql_real_escape_string($_GET['Zip']) . "',";
		$insertQuery .= "'" . $userId . "',";
		if(isset($_GET['private'])) {
			$insertQuery .= "'1');";
		}
		else {
			$insertQuery .= "'0');";
		}
		//echo $insertQuery . "<br>";
		$inserted = mysql_query($insertQuery);
		//var_dump($inserted);
		//echo "<br>\n";
		
		$selectQuery = "SELECT * FROM addressBook WHERE FK_userId='" . $userId . "'" . $sortByName . ";";
		$result = mysql_query($selectQuery);
		echo "<table><thead><tr>
			<th>Name</th>
			<th width=\"75\">House Size</th>
			<th>Address</th>
			<th width=\"150\">City</th>
			<th width=\"10\">State</th>
			<th width=\"30\">Zip Code</th>
			<th width=\"40\">Private</th>
		</tr></thead>";
		while($row = mysql_fetch_array($result)){
			echo "<tr><th class=\"button\">$row[Name]</th><td>$row[houseSize]</td><td>$row[Address]</td><td>$row[City]</td><td>$row[State]</td><td>$row[Zip]</td>";
			if($row['private'] != '0') {
				echo "<td>Private</td></tr>\n";
			} else {
				echo "<td>Public</td></tr>\n";
			}
		}
		echo "</table>";
	} 
	else if(isset($_GET['Update'] ) && isset($_GET['Name']) && isset($_GET['houseSize']) && isset($_GET['Address']) && isset($_GET['City']) && isset($_GET['State']) && isset($_GET['Zip']) ) {
		//get user's PK for use during insert
		$selectQuery = "SELECT id FROM addressBookUsers WHERE username='" . $_SESSION['username'] . "';";
		//echo $selectQuery . "<br>";
		$result = mysql_query($selectQuery);
		$userId = mysql_fetch_array($result)[id];
		//echo "user ID is:  " . $userId . "<br>\n";
		//run insert query
		$updateQuery = "UPDATE `$dbname`.`addressBook` SET ";
		$updateQuery .= "`houseSize`='" . $_GET['houseSize'] . "',";
		$updateQuery .= "`Address`='" . mysql_real_escape_string($_GET['Address']) . "',";
		$updateQuery .= "`City`='" . mysql_real_escape_string($_GET['City']) . "',";
		$updateQuery .= "`State`='" . mysql_real_escape_string($_GET['State']) . "',";
		$updateQuery .= "`Zip`='" . mysql_real_escape_string($_GET['Zip']) . "',";
		if(isset($_GET['private'])) {
			$updateQuery .= "`private`=1";
		}
		else {
			$updateQuery .= "`private`=0";
		}
		$updateQuery .= " WHERE `Name`='" . mysql_real_escape_string($_GET['Name']) . "';";
		
		echo $updateQuery . "<br>";
		$updated = mysql_query($updateQuery);
		echo mysql_num_rows($updated);
		die;
	}
	if (isset($_GET['Select']) ) {
		$selectQuery = "SELECT * FROM addressBook WHERE FK_userId='" . $userId . "'" . $sortByName . ";";
		$result = mysql_query($selectQuery);
		echo "<thead><tr>
			<th>Name</th>
			<th width=\"75\">House Size</th>
			<th>Address</th>
			<th width=\"150\">City</th>
			<th width=\"10\">State</th>
			<th width=\"30\">Zip Code</th>
			<th width=\"40\">Private</th>
			
		</tr></thead>";
		while($row = mysql_fetch_array($result)){
			echo "<tr><th class=\"button\">$row[Name]</th><td>$row[houseSize]</td><td>$row[Address]</td><td>$row[City]</td><td>$row[State]</td><td>$row[Zip]</td>";
			if($row['private'] != '0') {
				echo "<td>Private</td></tr>\n";
			} else {
				echo "<td>Public</td></tr>\n";
			}
		}
		die;
	}
	if (isset($_GET['sortByName']) ) {
		echo "<thead><tr>
			<th>Name</th>
			<th width=\"75\">House Size</th>
			<th>Address</th>
			<th width=\"150\">City</th>
			<th width=\"10\">State</th>
			<th width=\"30\">Zip Code</th>
			<th width=\"40\">Private</th>
			<th width\"20\">Delete</th>
			</tr></thead>";
		$selectQuery = "SELECT * FROM addressBook WHERE FK_userId='$userId' $sortByName;";
		$result = mysql_query($selectQuery);
		while($row = mysql_fetch_array($result)){
			echo "<tr><th class=\"button\">$row[Name]</th><td>$row[houseSize]</td><td>$row[Address]</td><td>$row[City]</td><td>$row[State]</td><td>$row[Zip]</td>";
			if($row['private'] != '0') {
				echo "<td>Private</td>";
			} else {
				echo "<td>Public</td>";
			}
			echo "<td><input id=\"delete$row[id]\" class=\"delete\" type=\"button\" value=\"Delete\"></td></tr>\n";
		}
		if(isset($_GET['withPublic'])) {
			$selectQuery = "SELECT * FROM addressBook WHERE FK_userId<>'" . $userId;
			$selectQuery .= "' AND `private` = 0 " . $sortByName . ";";
			$result = mysql_query($selectQuery);
			echo "<tr><th class=\"thead\">Public Addresses:</th></tr>";
			while($row = mysql_fetch_array($result)){
				echo "<tr><th class=\"button\">$row[Name]</th><td>$row[houseSize]</td><td>$row[Address]</td><td>$row[City]</td><td>$row[State]</td><td>$row[Zip]</td>";
				if($row['private'] != '0') {
					echo "<td>Private</td></tr>\n";
				} else {
					echo "<td>Public</td></tr>\n";
				}
			}
		}
		die;
	} 
	if(isset($_GET['Delete'])) {
		//var_dump($_GET);
		$deleteQuery = "DELETE FROM `$dbname`.`addressBook` WHERE `id`='" . $_GET['deleteId'] . "' AND `FK_userId`='" . $userId . "';";
		echo $deleteQuery;
		$deleteResult = mysql_query($deleteQuery);
		
	}
	if (isset($_GET['sortByLocation']) ) {
		echo "<thead><tr>
			<th>Name</th>
			<th width=\"75\">House Size</th>
			<th>Address</th>
			<th width=\"150\">City</th>
			<th width=\"10\">State</th>
			<th width=\"30\">Zip Code</th>
			<th width=\"40\">Private</th>
			<th width\"20\">Delete</th>
			</tr></thead>";
		$selectQuery = "SELECT * FROM addressBook WHERE FK_userId='$userId' $sortByLocation;";
		$result = mysql_query($selectQuery);
		while($row = mysql_fetch_array($result)){
			echo "<tr><th class=\"button\">$row[Name]</th><td>$row[houseSize]</td><td>$row[Address]</td><td>$row[City]</td><td>$row[State]</td><td>$row[Zip]</td>";
			if($row['private'] != '0') {
				echo "<td>Private</td>";
			} else {
				echo "<td>Public</td>";
			}
			echo "<td><input id=\"delete$row[id]\" class=\"delete\" type=\"button\" value=\"Delete\"></td></tr>\n";
		}
		if(isset($_GET['withPublic'])) {
			$selectQuery = "SELECT * FROM addressBook WHERE FK_userId<>'" . $userId;
			$selectQuery .= "' AND `private` = 0 " . $sortByLocation . ";";
			$result = mysql_query($selectQuery);
			echo "<tr><th class=\"thead\">Public Addresses:</th></tr>";
			while($row = mysql_fetch_array($result)){
				echo "<tr><th class=\"button\">$row[Name]</th><td>$row[houseSize]</td><td>$row[Address]</td><td>$row[City]</td><td>$row[State]</td><td>$row[Zip]</td>";
				if($row['private'] != '0') {
					echo "<td>Private</td></tr>\n";
				} else {
					echo "<td>Public</td></tr>\n";
				}
			}
		}
		die;
	} 
	

?>