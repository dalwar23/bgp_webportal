<?php
	//Start output buffer
	ob_start();
?>
<?php
	//check the browser doesn't cache the page
	header ("Expires: Thu, 17 May 2001 10:17:17 GMT");    // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
	header ("Pragma: no-cache");                          // HTTP/1.0
?>
<?php	
	include ("includes/__dbConnection.php");
?>
<table width=100% border=' 1px solid black' >
<?php
	//Check for POSTed Values
	if(isset($_POST['asQuerySubmit'])){
		$asNumber = $_POST['asNumber'];
		//Query to get as details
		$asQuery = "SELECT * FROM t_meta_data_s1 WHERE as_num = '{$asNumber}'";
		$result = $connection->query($asQuery);
		//confirmQuery($asResult, 1);
		
		//Show the result
		if ($result->num_rows > 0) {
		    // output data of each row
		    echo"
		        <tr class='theader'>
		            <td>AS Number</td>
		            <td>Customer Conesize</td>
		            <td>Country Code</td>
		            <td>RIR</td>
		            <td>AS Name</td>
		        </tr>
		    ";
		    while($row = $result->fetch_assoc()) {
		    	echo "
		    		<tr>
		    			<td>$row[as_num]</td>
		    			<td>$row[conesize]</td>
		    			<td>$row[country_code]</td>
		    			<td>$row[rir]</td>
		    			<td>$row[as_name]</td>
		    		</tr>
		    	";
		    }
		} else {
		    echo "<tr><td>0 results<tr><td>";
		}		
	}
	else{
		// Show error message
		echo "<tr><td>AS not found in the database. Please try again with valid AS number!";
		echo "
			<br/><br/><a href='index.php'>Back</a><tr><td>
		";
	}
?>
</table>
<?php
	//This function confirms the query is executed perfectly
	function confirmQuery($resultSet,$queryNumber){
		if(!$resultSet){
			die("Database Query failed ! " . "</br>Query Number: " . $queryNumber . "<br> Error no: " . mysql_errno() . "<br>Error: ". mysql_error());
		}
		else{
			return TRUE;
		}
	}
?>
<?php
	//Flush Output Buffer
	ob_flush();
?>