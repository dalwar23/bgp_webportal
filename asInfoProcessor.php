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
  </head>
  <title>BGP| Prefix Delegation Data</title>
  <body>
    <div id="wrapper">
        <div id="header">
          <h1> Welcome to BGP (IPv4) Prefix Delegation Structure </h1>
          <h2> Inet - TU Berlin, Germany - 2017 </h2>
          <h4><a href="http://www.inet.tu-berlin.de" target="_blank">www.inet.tu-berlin.de</a></h4>
        </div>
        <div id="main-content">
        	<div id="prefix-data">
            	<?php
                if (isset($_GET['asNumber'])){
                  $asNumber = $_GET['asNumber'];
                }
                elseif(isset($_POST['asQuerySubmit']))
                {
                  $asNumber = $_POST['asNumber'];
                }
            		if($asNumber){
            			$query = get_as_query($asNumber);
                  $result = mysqli_query($connection,$query);
                  $numRows = mysqli_num_rows($result);
                  //----------------------------------------
                  $dQuery = get_delegation_query($asNumber);
                  $dResult = mysqli_query($connection,$dQuery);
                  $dNumRows = mysqli_num_rows($dResult);
                  //----------------------------------------
                  $business_rel_query = get_business_rel_query($asNumber);
                  $bResult = mysqli_query($connection,$business_rel_query);
                  $bNumRows = mysqli_num_rows($bResult);
                  //----------------------------------------
                  echo "
                  <div id='as'>
                  <h2 class='header-highlight'>AS Info</h2><br>";
                  if ($numRows > 0) {
                    set_time_limit(0);
                    $as_info = mysqli_fetch_assoc($result);
                    echo "
                    <strong>AS Number:</strong> {$as_info['as_num']}<br>
                    <strong>Customer Conesize:</strong> {$as_info['conesize']}<br>
                    <strong>Country Code:</strong> {$as_info['country_code']}<br>
                    <strong>RIR:</strong> {$as_info['rir']}<br>
                    <strong>AS Name:</strong> {$as_info['as_name']}";
                  }
                  else{
                    echo "<strong>There is no current inforamtion available for the requested AS number.</strong>";
                  }
                    echo "</div><br><hr><br>";
                    echo"
                    <div class='asinfo'>
                    <h2 class='header-highlight'>Delegation Info</h2><br>";
                  if ($dNumRows > 0) {
                    echo"
                      <table align='center' border='1px solid black' width='100%' class='talign'>
                      <tr class='theader'>
                          <td>Timestamp</td>
                          <td>More Specific Prefix</td>
                          <td>Delegator</td>
                          <td>Delegatee</td>";
                          if($bNumRows > 0){
                            echo"<td>Relation</td>";
                          }
                    echo"
                      </tr>
                  ";
                  $counter = 0;
                  while($row = mysqli_fetch_assoc($dResult)){
                    set_time_limit(0);
                    if($counter < 50){
                      echo "
                        <tr>
                          <td>$row[dates]</td>
                          <td><a href='prefixInfoProcessor.php?prefix={$row[prefix_more]}'>$row[prefix_more]</a></td>
                          <td><a href='asInfoProcessor.php?asNumber={$row[delegator]}'>$row[delegator]</a></td>
                          <td><a href='asInfoProcessor.php?asNumber={$row[delegatee]}'>$row[delegatee]</a></td>";
                          if($bNumRows > 0){
                            $rQuery = get_business_relation_query($row[delegator], $row[delegatee]);
                            $rResult = mysqli_query($connection, $rQuery);
                            $rRow = mysqli_fetch_assoc($rResult);
                            echo"
                            <td>$rRow[as_rel_type]</td>";
                          }
                      echo"
                        </tr>
                      ";
                    }
                    $counter++;
                    }
?>
                      <tr><td colspan="5">
                        <form name="result" method="POST" action="export.php">
                          <input type="hidden" name="query" value="<?php echo $dQuery;?>">
                          <input type="hidden" name="fileName" value="asDelegationInfo">
                          <input type="submit" name="export" value="Export full data to CSV" class="flatButton">
                        </form>
                      </td></tr>
<?php
                    echo "</table>";
                    echo "<span class='highlight'> Total number of result found: <strong>{$dNumRows}</strong><br>
                    This is a <strong>partial view</strong> of the actual result. Please <strong>click export button</strong> to get the full data into a (.csv) file.<br>
                    Time for creating of CSV file varies with the size of the result.</span>";
                    echo "</div>";
                    //mysqli_close($connection);
                  }
                  else{
                    echo "<strong>Requested AS number is not found. Please try with a valid AS number.</strong>";
                  }
            	?>
            	</div>
              <div class="business">
              <?php
                echo"<h2 class='header-highlight'>Business Relationship Info</h2><br>";
                  if($bNumRows > 0){
                    echo"
                      <table align='center' border='1px solid black' width='100%' class='talign'>
                      <tr class='theader'>
                          <td>AS-1</td>
                          <td>AS-2</td>
                          <td>Relationship</td>
                      </tr>
                    ";
                  $bCounter = 0;
                  while($bRow = mysqli_fetch_assoc($bResult)){
                    if($bCounter < 50){
                      echo "
                        <tr>
                          <td>$bRow[as_1]</td>
                          <td>$bRow[as_2]</td>
                          <td>$bRow[as_rel_type]</td>
                        </tr>
                      ";
                    }
                    $bCounter++;
                  }
              ?>
                      <tr><td colspan="3">
                        <form name="result" method="POST" action="export.php">
                          <input type="hidden" name="query" value="<?php echo $business_rel_query;?>">
                          <input type="hidden" name="fileName" value="asBusinessRelationshipInfo">
                          <input type="submit" name="export" value="Export full data to CSV" class="flatButton">
                        </form>
                      </td></tr>
              <?php
                    echo "</table>";
                    echo "<span class='highlight'> Total number of result found: <strong>{$bNumRows}</strong><br>
                    This is a <strong>partial view</strong> of the actual result. Please <strong>click export button</strong> to get the full data into a (.csv) file.<br>
                    Time for creating of CSV file varies with the size of the result.</span>";
                  }
                  else{
                    echo "<strong>There is no current inforamtion available for the requested AS number.</strong>";
                  }
              }
              else{
                 // Show error message
                 echo "<tr><td>Server could not understand the request. Please try again!";
                 echo "<br/><br/><a href='index.php'>Back</a><tr><td>";
              }
              ?>
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