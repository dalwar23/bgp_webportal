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
		<title>Prefix Query</title>
	</head>
	<body>
		<div class="prefixquery">
			<form name="prefixQueryForm" method="POST" action="prefixInfoProcessor.php">
				<table align="center" border="0" width="100%">
					<tr>
						<td align="right" width="50%">Please enter a prefix (e.g. 1.2.3.4/8):</td>
						<td align="left"><input type="text" name="prefix" maxlength="18" required="required" autocomplete="on" autofocus class="txtBox"></td>
						<td align="left"><input type="submit" name="prefixQuerySubmit" value="Find Prefix" class="flatButton"></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>