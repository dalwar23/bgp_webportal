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
            		if(isset($_POST['prefixQuerySubmit'])){
            			$prefix = $_POST['prefix'];
            			$query = get_prefix_query($prefix);
                  $result = mysqli_query($connection,$query);
                  $numRows = mysqli_num_rows($result);
                  
                  if ($numRows > 0) {
                    echo"
                    <div class='prefix-info'>
                    <h2 class='header-highlight'>Prefix Info</h2><br>
                      <table align='center' border='1px solid black' width='100%' class='talign'>
                      <tr class='theader'>
                          <td>Timestamp</td>
                          <td>Prefix</td>
                          <td>Usable host addresses</td>
                          <td>Delegatee</td>
                      </tr>
                  ";
                  $counter = 0;
                  while($row = mysqli_fetch_assoc($result)){
                    if($counter < 20){
                      echo "
                        <tr>
                          <td>$row[dates]</td>
                          <td>$row[prefix_more]</td>
                          <td>$row[pm_usable_addresses]</td>
                          <td>$row[delegatee]</td>
                        </tr>
                      ";
                    }
                    $counter++;
                    }
?>
                      <tr><td colspan="5">
                        <form name="result" method="POST" action="export.php">
                          <input type="hidden" name="query" value="<?php echo $query;?>">
                          <input type="hidden" name="fileName" value="prefixInfo">
                          <input type="submit" name="export" value="Export full data to CSV" class="flatButton">
                        </form>
                      </td></tr>
<?php
                    echo "</table>";
                    echo "<span class='highlight'> Total number of result found: <strong>{$numRows}</strong><br>
                    This is a <strong>partial view</strong> of the actual result. Please <strong>click export button</strong> to get the full data into a (.csv) file.<br>
                    Time for creating of CSV file varies with the size of the result.</span>";
                    //mysqli_close($connection);
                    echo "</div>";
                  }
                  else{
                    echo "<strong>Requested prefix is not found. Please try with a valid prefix.</strong>";
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