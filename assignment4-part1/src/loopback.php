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

?>