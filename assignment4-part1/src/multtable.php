<?php 
/*********************
* Keith McKinley
* CS290 Spring 2015
* Assignment 4

This file should accept 4 parameters passed via the URL in a GET request.

min-multiplicand
max-multiplicand
min-multiplier
max-multiplier
All these number can come from the set of Whole numbers (numbers {0, 1, 2, 3, ...}).
It should check than the min is in fact less than or equal to the max multiplicand and multiplier respectively. 
If it is not, it should print the message "Minimum [multiplicand|multiplier] larger than maximum.". 
It should also check that the values returned are integers for each parameter. 
If it is not it should print 1 message for each invalid input "[min-multiplicand...max-multiplier] must be an integer.". 
It should check that all 4 parameters exist for each missing parameter it should print 
	"Missing parameter [min-multiplicand ... max-multiplier].".

If all of the above conditions are met, it should produce a multiplication table that is 
	(max-multiplicand - min-multiplicand + 2) tall and (max-multiplier - min-multiplier + 2) wide. 
	The upper left cell should be empty. 
	The left column should have integers running from min-multiplicand through max-multiplicand inclusive. 
	The top row should have integers running from min-multiplier to max-multiplier inclusive. 
	Every cell within the table should be the product of the corresponding multiplicand and multiplier.

To accomplish the above task you will want to work with loops to dynamically create rows and 
	within each row, loop to create the cells. It should output as a valid HTML5 document.
**********************/

?>
<?php 	$allOk = "";
			if ( empty($_GET['min-multiplicand']) )
			{
				$allOk .= "Missing parameter min-multiplicand <br>";
			} else {
				$min1 = $_GET['min-multiplicand'];
				if ( is_numeric($min1) && intval($min1) == $min1) //http://php.net/manual/en/function.intval.php, evaluate is_numeric first because intval can return an integer if it's not a number
				{
					$min1 = intVal($min1);
					//print("min-multiplicand: " . $min1 . "<br>");
				}else {
					$allOk .= "min-multiplicand must be an integer. <br>";
				}
			} 
			if ( empty($_GET['max-multiplicand']) )
			{
				$allOk .= "Missing parameter max-multiplicand<br>";
			}else {
				$max1 = $_GET['max-multiplicand'];
				if ( is_numeric($max1) && intval($max1) == $max1) 
				{
					$max1 = intVal($max1);
					//print("max-multiplicand: " . $max1 . "<br>");
					if ($max1 <= $min1)
					{
						$allOk .= "Minimum multiplicand larger than maximum.<br>";
					}
				}else {
					$allOk .= "max-multiplicand must be an integer. <br>";
				}
			}
			if ( empty($_GET['min-multiplier']) )
			{
				$allOk .= "Missing parameter min-multiplier <br>";
			} else {
				$min2 = $_GET['min-multiplier'];
				if ( is_numeric($min2) && intval($min2) == $min2)
				{
					$min2 = intVal($min2);
					//print("min-multiplier: " . $min2 . "<br>");
				}else {
					$allOk .= "min-multiplier must be an integer. <br>";
				}
			}
			if ( empty($_GET['max-multiplier']) )
			{
				$allOk .= "Missing parameter max-multiplier";
			} else {
				$max2 = $_GET['max-multiplier'];
				if ( is_numeric($max2) && intval($max2) == $max2) 
				{
					$max2 = intVal($max2);
					//print("max-multiplier: " . $max2 . "<br>");
					if ($max2 <= $min2)
					{
						$allOk .= "Minimum multiplier larger than maximum.<br>";
					}
				}else {
					$allOk .= "max-multiplier must be an integer. <br>";
					if ($max2 <= $min2 )
					{
						$allOk .= "Minimum multiplier larger than maximum.";
					}
				}
			}
			?>
<html>
<head>
	<style type="text/css">
		h1: {font-size: 2em;}
		table {border-collapse: collapse;}
		th, td {
			border: 1px solid black;
			/*width: <?php print(100 / ($max2 - $min2 + 3)); ?>%;*/
			padding: 5px;
			height: 20px;
			text-align: center;
			vertical-align: middle; 
		}
		th {
			border: 1px solid black;
			font-weight: bold;
		}
	</style>
</head>

<h1>This is the multiplication table!</h1>
<body>
	
	<?php if($allOk === "") : ?>
	<table id="multtable" >
		<tr>
			<th> </th>
			<?php for($cols = $min2; $cols <= ($max2); $cols ++)
				//print top row
			{
			echo "<th> $cols </th>";
			} ?>
		</tr>
		<?php for($rows = $min1; $rows < ($max1 + 1); $rows ++ )
					//print each row
		{ 
			echo "<tr>
				";
			for($cols = $min2 - 1; $cols < ($max2 + 1); $cols ++ )
				//print each col
			{
				if ($cols < $min2 ){ 
					echo "<th> $rows </th>";
				 }
				 else {
					echo "<td>" . $rows * $cols . "</td>"; 
				 }
			} 
			echo "</tr>
				";
		} ?>
		
	</table>
	<?php else : ?>
		<p><?php echo "<br> $allOk <br>"; ?></p>
	<?php endif; ?>
</body>
</html>