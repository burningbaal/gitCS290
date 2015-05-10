<?php
/*******************************
* Keith McKinley
* CS290 - Spring 2015
* Assignment 4 part 2

Description:
Add video
=	There should be text fields for the name, category and length.
=	There should be a button for adding a video
=	When the button is clicked it should attempt to add the video to the list of videos. 
	If there are any invalid values,
		it should say what value was invalid in user readable language. It should not output the standard MySQL or 
		PHP error message.
=There should be a table of videos that list the name, category, length and the words "checked out" or "available".
=	Each row should have a "Delete" button.
=	When clicked, this should delete that video from the table.
=Each video should have a button to check-in/check-out a video. 
=	It should toggle the status from "checked out" to "available" and back.
=There should be a button labeled "Delete All Videos". This is mainly to facilitate testing. When clicked, all videos in the table 
=	should be deleted.
=There should be a drop down menu that shows the categories of movies currently in the database and a category for 'All Movies' 
=	with a button next to it to filter out all movies not of the selected category.
=	Categories should only show up once even if there are several different movies in the category. For example if there are 3 comedies, 
=		the "Comedy" category should only show up once in the menu.
*******************************/

$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'mckinlek-db';
$dbuser = 'mckinlek-db';
$dbpass = '5qNWhVs2K36LBXi7';

$mysql_handle = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Error connecting to database server");

mysql_select_db($dbname, $mysql_handle)
    or die("Error selecting database: $dbname");

//echo 'Successfully connected to database!';

if(isset($_POST["AddVideo"])){
	//echo "captured addVideo\n";
	$AddError = "";
	if(strlen($_POST['name']) == 0 || strlen($_POST['name']) > 255) {
		$AddError .= "Movie name is too long.<br>";
	}
	if(strlen($_POST['category']) == 0 || strlen($_POST['category']) > 255) {
		$AddError .= "Movie category is too long.<br>";
	}
	if(is_numeric($_POST['length']) == 0 || (int)$_POST['length'] != $_POST['length']) {
		$AddError .= "Movie length must be an integer.<br>";
	}
	if(strlen($AddError) < 10) {
		$tempQuery = "INSERT INTO videoStore VALUES(DEFAULT,";
		$tempQuery .= "\"" . $_POST['name'] . "\", \"" . $_POST['category'] . "\", \"" . $_POST['length'] . "\", FALSE);";
		//echo $tempQuery . "\n";
		$query = mysql_query($tempQuery);
		if($query) {
			//added successfully!
		}
		else{
			$message = "Database error:  " . mysql_error() . "\n";
			echo $message;
		}
	}
} 
if(isset($_POST["checkIn"])) {
	$tempQuery = "UPDATE videoStore SET rented=0 WHERE id=" . $_POST['checkIn'];
	//echo $tempQuery;
	$query = mysql_query($tempQuery);
	if($query) {
		//deleted successfully!
	}
}
else if(isset($_POST["checkOut"])) {
	$tempQuery = "UPDATE videoStore SET rented=1 WHERE id=" . $_POST['checkOut'];
	//echo $tempQuery;
	$query = mysql_query($tempQuery);
	if($query) {
		//deleted successfully!
	}
}
if(isset($_POST['deleteRow'])) {
	$tempQuery = "DELETE FROM videoStore WHERE id=" . $_POST['deleteRow'] . ";";
	$query = mysql_query($tempQuery);
	if($query) {
		//deleted successfully!
	}
}

if(isset($_POST['filter']) && $_POST['categories'] != "AllCategories") {
	$selectQuery = "SELECT * from videoStore WHERE category='" . $_POST['categories'] . "';";
}
else {
	$selectQuery = "SELECT * from videoStore;";
}

if(isset($_POST["deleteAll"])) {
	$tempQuery = "Truncate TABLE videoStore;";
	$query = mysql_query($tempQuery);
	if($query) {
		//all rows deleted!
	}
	else {
		$message = "Database error:  " . mysql_error() . "\n";
		echo $message;
	}
}


?>

<html>
	<head>
		<style>
			table {
				border: 1px solid black;
				border-collapse: collapse; 
			}
			th, td {
				padding: 5px;
				text-align: center;
				border: 1px solid black;
			}
			th {
				font-size: 1.4em;
				font-weight: bold;
				background-color: Gainsboro;
			}
		</style>
	</head>
	<h1 style ="font-size: 2em;">
	Keith's Video Store
	</h1>
	<br>
	<br>
	<table id="allVideos" >
		<col width="250">
		<col width="100">
		<col width="50">
		<col width="200">
		<tr>
			<th>Name</th>
			<th>Category</th>
			<th>Length</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
		<form id="deleteRow" method="POST" action="mainPage.php">
		<?php 
			//get rows
			$tempQuery = $selectQuery;
			$query = mysql_query($tempQuery);
			if($query) {
				//got rows!
				while($row = mysql_fetch_assoc($query)) { //iterate through the received rows
					echo "<td>" . mysql_real_escape_string($row['name']) . "</td>\n\t" . 
					"<td>" . mysql_real_escape_string($row['category']) . "</td>\n\t" . 
					"<td>" . mysql_real_escape_string($row['length']) . "</td>\n\t";
					if ($row['rented']) {
						echo "<td>checked Out</td>\n\t";
						echo "<td><button type=\"submit\" name=\"checkIn\"  value=\"" . $row['id'] . "\">check-in</button>";
					}
					else  {
						echo "<td>available</td>\n\t";
						echo "<td><button type=\"submit\" name=\"checkOut\"  value=\"" . $row['id'] . "\">check-out</button>";
					}
					echo "<button type=\"submit\" name=\"deleteRow\"  value=\"" . $row['id'] . "\">Delete this</button></td>\n";
					//echo "<td><input type=\"submit\" value=\"Delete This Movie\" name=\"" . mysql_real_escape_string($row['id']) . "\"></td>\n";
					echo "</tr>\n";
				}
			}
			else {
				die('Invalid query: ' . mysql_error());
			}
			//mysql_free_result($query); //http://php.net/manual/en/function.mysql-query.php to release the resource on the server
			
		?>
		</form>
	</table>
	<br>
	<div style="width: 700px; overflow: hidden; border: 1px solid black;">
		<div style="width: 320px; float: left;"> 
			<h2 style="font-size: 1.5em; font-weight: bold;"> 
				Add a new Video
			</h2>
			<br>
			<form id="AddingVideo" method="POST" action="mainPage.php">
			<?php 
				if(strlen($AddError) > 0) {
					echo $AddError;
					echo "<br>";
				}
			?>
				Name: &nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="name" ><br><br>
				Category: <input type="text" name="category" ><br><br>
				Length: &nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="length" ><br><br>
				<button type="submit" name="AddVideo" value="1">Add video</button>
			</form>
		</div>
		<br>
		<div id="Add Video" style="margin-left: 305px; width: 250px">
			<br><br><br>
			<form id="General" method="POST" action="mainPage.php">
				<select name="categories">
					<option value="AllCategories">All Categories</option>
					<?php
						$tempQuery = "SELECT DISTINCT category FROM videoStore;";
						$query = mysql_query($tempQuery);
						if($query) {
							//got rows!
							while($row = mysql_fetch_assoc($query)) { //iterate through the received rows
								echo "<option value=\"" . $row['category'] . "\">" . $row['category'] . "</option>";
							}
						}
					?>
				</select>
				<button type="submit" name="filter" value="filterCategories">Filter on category</button>
				<br><br>
				<button type="submit" name="deleteAll" value="DeleteAllVideos">Delete All Videos</button>
			</form>
		</div>
	</div>
		<br>
		<br>
</html>
<?php
	mysql_close($mysql_handle);
?>