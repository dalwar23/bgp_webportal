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
<html>
	<head>
		<title>AS Query</title>
	</head>
	<body>
		<div class="asquery">
			<form name="asQueryForm" method="POST" action="dataProcess.php">
				<table align="center" border="0" width="100%">
					<tr>
						<td align="right" width="50%">Please enter an autonomous system (AS) number (e.g. 35487):</td>
						<td align="center"><input type="number" name="asNumber" minlength="1" required="required" autocomplete="on" autofocus class="txtBox"></td>
						<td align="right"><input type="submit" name="asQuerySubmit" value="Find AS" class="flatButton"></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>