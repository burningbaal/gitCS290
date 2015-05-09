<?php
/*******************************
* Keith McKinley
* CS290 - Spring 2015
* Assignment 4 part 2
*******************************/

$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'mckinlek-db';
$dbuser = 'mckinlek-db';
$dbpass = '5qNWhVs2K36LBXi7';

$mysql_handle = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Error connecting to database server");

mysql_select_db($dbname, $mysql_handle)
    or die("Error selecting database: $dbname");

echo 'Successfully connected to database!';

mysql_close($mysql_handle);

?>