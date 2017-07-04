<?php
/**
* @author Md Dalwar Hossain Arif
* @copyright 2017
* @email dalwar014@gmail.com
* @website http://www.user.tu-berlin.de/hossainarif
*/
?>
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
	include('includes/__functions.php');
  include ('includes/__dbConnection.php');
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' >
    <meta name='robots' content='index,follow' >
    <meta name='description' content='BGP delegation data' >
    <meta name='keywords' content='bgp,delegation,tu-berlin,inet,inet.tu-berlin' >
    <meta name='author' content='dalwar014@gmail.com' >
    <meta name='copyright' content='dalwar hossain, www.inet.tu-berlin.de' >
    <link type="text/CSS" href="css/style.css" rel="stylesheet" media="all"/>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
  </head>
  <title>BGP| Prefix Delegation Data</title>
  <body>
    <div id="wrapper">
        <div id="header">
          <h1> Welcome to BGP (IPv4) Prefix Delegation Structure </h1>
          <h2> INET - TU Berlin, Germany - 2017 </h2>
          <h4><a href="http://www.inet.tu-berlin.de" target="_blank">www.inet.tu-berlin.de</a></h4>
        </div>
        <div id="main-content">
        	<div id="prefix-data">
            <div class="menu">
              <a href="index.php"><img src="images/home.png">&nbsp;&nbsp;Home</a>
            </div>
            	<?php
							# POST values
							if(isset($_POST['prefixQuerySubmit'])){
								$table_name = "v_current_prefix";
								$search = $_POST['prefix'];
								$data = shell_exec("/usr/bin/python3 pyScripts/longestPrefixMatch.py $search");
								if($data){
									$cleanData = trim($data);
									list($column_name, $prefix) = explode("|", $cleanData);
								}
								else{
									$prefix = '0.0.0.0';
								}
              }
							# GET values
							elseif(isset($_GET['prefix']) && isset($_GET['column_name'])){
								$table_name = "t_delegation_s1";
								$column_name = $_GET['column_name'];
								$prefix = $_GET['prefix'];
								$search = $_GET['prefix'];
              }
							else{
								echo "Server could not understand the request. Please try again!";
							}
							# Now check the variables and run query
							if($search && $prefix){
								$query = get_prefix_query($column_name, $prefix, $table_name);
								try{
									$result = mysqli_query($connection,$query);
									$numRows = mysqli_num_rows($result);
								}
								catch (Exception $e){
									echo ($e);
								}
								if($numRows > 0){
									echo"<div class='prefix-info'>
									<h2 class='header-highlight'>Prefix Info</h3><br>
									<p>Searched prefix/address block : &nbsp;<strong>[ $search ]</strong></p>
									<p>Matched longest delegated address block:&nbsp;<strong>[ $prefix ]</strong></p>
									<p>Total number of results found:&nbsp;<strong>{$numRows}</strong></p><br>
									<table align='center' border='1px solid black' width='100%' class='talign'>
									<tr class='theader'>
									<td>Timestamp</td>
									<td>Prefix Less</td>
									<td>Prefix More</td>
									<td>Delegator</td>
									<td>Delegatee</td>
									<td>Relation</td>";
									if(isset($_POST['prefixQuerySubmit'])){
										echo "<td>Action</td>";
									}
									echo"
									</tr>
									";
									while($row = mysqli_fetch_assoc($result)){
										set_time_limit(0);
										echo "<tr>
										<td>$row[dates]</td>
										<td><a href='prefixInfoProcessor.php?prefix={$row[prefix_less]}&column_name=prefix_less'>$row[prefix_less]</a></td>
										<td><a href='prefixInfoProcessor.php?prefix={$row[prefix_more]}&column_name=prefix_more'>$row[prefix_more]</a></td>
										<td><a href='asInfoProcessor.php?asNumber={$row[delegator]}'>$row[delegator]</a></td>
										<td><a href='asInfoProcessor.php?asNumber={$row[delegatee]}'>$row[delegatee]</a></td>
										<td>$row[as_rel]</td>";
										if(isset($_POST['prefixQuerySubmit'])){
											echo "<td><a href='prefixInfoProcessor.php?prefix={$prefix}&column_name={$column_name}'>TimeSeries</a></td>";
										}
										echo"
										</tr>
										";
									}
									echo "</table>";
									echo "</div>";
								}
								else{
									echo "<strong>Requested prefix is not delegated.</strong>";
								}
							}
							else{
								// Show error message
								echo "<tr><td>Server could not understand the request. Please try again!";
								echo "<br/><br/><a href='index.php'>Back</a><tr><td>";
							}
            	?>
            	</div>
              <div class="business">
              <!-- Graph -->
              </div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="footer">
          <?php include_once('includes/__footer.php');?>
        </div>
    </div>
  </body>
</html>
<?php
	//Flush Output Buffer
	ob_flush();
?>
