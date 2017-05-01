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
                  /*$business_rel_query = get_business_rel_query($asNumber);
                  $bResult = mysqli_query($connection,$business_rel_query);
                  $bNumRows = mysqli_num_rows($bResult);*/
                  //----------------------------------------

                  echo "
                  <div id='as'>
                  <h2 class='header-highlight'>AS Info</h2><br>";
                  if ($numRows > 0) {
                    set_time_limit(0);
                    $as_info = mysqli_fetch_assoc($result);
                    echo "
                    <strong>AS Number:</strong> {$as_info['as_num']}<br>
                    <strong>AS Name:</strong> {$as_info['as_name']}<br>
                    <strong>Customer Conesize:</strong> {$as_info['conesize']}<br>
                    <strong>Country Code:</strong> {$as_info['country_code']}<br>
                    <strong>RIR:</strong> {$as_info['rir']}
                    ";
                  }
                  else{
                    echo "<strong>There is no current inforamtion available for the requested AS number.<br> Possible reasons:<br>1. Not a valid AS number.<br>2. This AS is not active anymore.</strong>";
                  }
                    echo "</div><br><hr><br>";
                    echo"
                    <div class='asinfo'>
                    <h2 class='header-highlight'>Delegation Info</h2><br>";
                  if ($dNumRows > 0) {
                    echo"
                      <p>Total number of results found:&nbsp;<strong>{$dNumRows}</strong></p><br>
                      <table align='center' border='1px dotted black' width='100%' class='talign'>
                      <tr class='theader'>
                          <td>Timestamp</td>
                          <td>More Specific Prefix</td>
                          <td>Delegator</td>
                          <td>Delegatee</td>
                          <td>Relation</td>
                      </tr>";
                  while($row = mysqli_fetch_assoc($dResult)){
                    set_time_limit(0);
                      echo "
                        <tr>
                          <td>$row[dates]</td>
                          <td><a href='prefixInfoProcessor.php?prefix={$row[prefix_more]}'>$row[prefix_more]</a></td>";
                          if($asNumber == $row[delegator]){
                            echo "<td>$row[delegator]</td>";
                          }
                          else{
                            echo "<td><a href='asInfoProcessor.php?asNumber={$row[delegator]}'>$row[delegator]</a></td>";
                          }
                          if($asNumber == $row[delegatee]){
                            echo "<td>$row[delegatee]</td>";
                          }
                          else{
                            echo "<td><a href='asInfoProcessor.php?asNumber={$row[delegatee]}'>$row[delegatee]</a></td>";
                          }
                      echo"
                          <td>$row[as_rel]</td>  
                        </tr>
                      ";
                  }
                    echo "</table>";
                    echo "</div>";
                  }
                  else{
                    echo "<strong>Requested AS number is not found. Please try with a valid AS number.</strong>";
                  }
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
