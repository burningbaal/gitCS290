<?php 
/*********************
* Keith McKinley
* CS290 Spring 2015
* Assignment 4
This file should accept either a GET or POST for input. 
That GET or POST will have an unknown number of key/value pairs. 
The page should print a JSON object as a string (remember, 
	this is almost identical to an object literal in JavaScript) 
	of the form {"Type":"[GET|POST]","parameters":{"key1":"value1", ... ,"keyn":"valuen"}}. 
Behavior if a key is passed in and no value is specified is undefined. 
If no key value pairs are passed it it should return {"Type":"[GET|POST]", "parameters":null}. 
You are welcome to use built in JSON function in PHP to produce this output. 
http://php.net/manual/en/function.json-encode.php
**********************/

//http://stackoverflow.com/questions/6431106/count-values-in-post
//simple way to retrieve the number of parameters
header('Content-Type: application/json');

$numGet = count($_GET);
$numPost = count($_POST);

$output = "";

if ($numPost == 0 && strlen($_SERVER['QUERY_STRING']) < 1) 
{
	$output .= '{"Type":"null","parameters":null}';
}
elseif ($numGet > 0 )
{
	if($_GET[0] == "" )
	{
		$output = '{"Type":"GET","parameters":null}';
	}
	else{
		$output .= '{"Type":"GET","parameters":{';
		$strGet = $_SERVER['QUERY_STRING']; //http://stackoverflow.com/questions/3141708/php-easiest-way-to-get-get-parameters-string-as-written-in-the-url
		$arrGet = explode("&", $strGet); http://stackoverflow.com/questions/4909830/php-split-string-into-2d-array
		foreach($arrGet as &$arrVal)
		{	
			$arrVal = explode(":", $arrVal);
			foreach($arrVal as &$strVal){
				$strVal = '"' . $strVal . '"';
			} 
		}
		
		//test that explode/implode worked:
		foreach($arrGet as &$arrVal) $arrVal = implode(":", $arrVal);
		$output .= implode(", ", $arrGet);
		$output .= "}}";
	}
}
elseif ($numPost > 0)
{
	if($_POST[0] == "")
	{
		$output = '{"Type":"POST","parameters":null}';
	}
	else
	{
		$output .= '{"Type":"POST","parameters":';
		$output .= json_encode($_POST) . "}";
	}
}
else
{
	print("empty");
}
?>
	<?php echo $output; ?>