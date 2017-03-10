<?php
/**
* @author Md Dalwar Hossain Arif
* @copyright 2017
* @email dalwar014@gmail.com
* @website http://www.user.tu-berlin.de/hossainarif
*/
?>
<?php
	//Start the output buffer
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
	include('__functions.php');
	include ('__dbConnection.php');
?>
<?php
	if(isset($_POST['as1']) AND isset($_POST['as2'])){
		$as1 = $_POST['as1'];
		$as2 = $_POST['as2'];
		$bRelQuery = get_bRelation_query($as1, $as2);
		$bRelResult = mysqli_query($connection, $bRelQuery);
		$relRow = mysqli_fetch_assoc($bRelResult);
		if($relRow['as_rel_type']){
			$message = "Reslation between {$as1} and {$as2}: {$relRow['as_rel_type']}";
		}
		else{
			$message = "No relation found!";
		}
	}
	else{
		$message = "";
	}
?>
<html>
	<head>
		<title>Business Relation Query</title>
	</head>
	<body>
		<div class="asquery">
			<form name="asQueryForm" method="POST">
				<table align="center" border="0" width="100%">
					<?php if(isset($_POST['as1']) AND isset($_POST['as2'])){echo "<tr><td align='center' colspan='3' class='message'>{$message}</td></tr>";} ?>
					<tr>
						<td align="center" colspan="2">Please enter AS1 and AS2 (e.g. 987)</td>
					</tr>
					<tr>
						<td align="right"><input type="number" name="as1" minlength="1" required="required" autocomplete="on" autofocus class="txtBox"></td>
						<td align="right"><input type="number" name="as2" minlength="1" required="required" autocomplete="on" autofocus class="txtBox"></td>
						<td align="left"><input type="submit" name="asQuerySubmit" value="Find Business Relation" class="flatButton"></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>