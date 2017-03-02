
<?php 
	//Start the output buffer
	ob_start();
?>
<?php
	//check the browser doesn't cache the page
	header ("Expires: Thu, 17 May 2001 10:17:17 GMT");    // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
	
?>
<?php 
	//include libraries
	include ('includes/__dbConnection.php');
	include ('includes/__export_to_csv.php');
?>
<?php
	if(isset ($_POST['export'])){
		$query = $_POST['query'];
		$fileName = $_POST['fileName'];

	    $filename = $fileName.".csv";
    	$result = mysqli_query($connection,$query);
    	
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/csv");
		$flag = false;
		while ($row = mysqli_fetch_assoc($result)) {
		    if (!$flag) {
		        // display field/column names as first row
		        echo implode("\t", array_keys($row)) . "\r\n";
		        $flag = true;
		    }
		    echo implode("\t", array_values($row)) . "\r\n";
		}
	}
?>
<?php
	//Flush output buffer
	ob_flush();
?>