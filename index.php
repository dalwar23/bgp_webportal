<?php
/**
* @author Md Dalwar Hossain Arif
* @copyright 2017
* @email dalwar014@gmail.com
* @website http://www.user.tu-berlin.de/hossainarif
*/
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
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
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
          <p class="intro">
            On behalf of INET, TU Berlin, Germany we welcome you to BGP (IPv4) Prefix Delegation Structure data analysis
            project. This website provieds IPv4 prefix delegation data in a very easy way to understand and human readable format.
            It visualizes data in form of graphs and user can make queries depending on the need. Please remember that it is an ongoing
            project and this project results might have some bugs. Please take into considaration that we are trying
            our best to fix the bugs. Please feel free to contact us <a href="mailto:karim@campus.tu-berlin.de">here</a> if you find any bugs.<br/>
          </p>
          <div id="prefix-data">
            <div class="historical">
              <h2>BGP Delegation Data Stream</h2>
              <h5>(Click on the color legends for filter)</h5>
              <canvas id="mycanvas-historical"></canvas>
            </div>
            <div class="current">
              <h2>BGP Delegation Prefix Growth</h2>
              <h5>(Click on the color legends for filter)</h5>
              <canvas id="mycanvas-current"></canvas>
            </div>
            <div class="clear"></div>
            <!-- ****************************************** -->
            <div class="leftQuery">
              <h2>AS Query</h2>
              <br/>
              <?php include('includes/__searchAS.php');?>
            </div>
            <!--
            <div class="middleQuery">
              <h2>Business Relation Query</h2>
              <br/>
              This is the place for business relation query
              include __searchBusinessRelationship.php
            </div>
            -->
            <div class="rightQuery">
              <h2>Prefix Query</h2>
              <br/>
              <?php include('includes/__searchPrefix.php');?>
            </div>
            <div class="clear"></div>
            <!-- ******************************************** -->
            <div class="historical">
              <h2>Top 20 Delegator AS</h2>
              <br/>
              <div class="tab">
                <a href="javascript:void(0)" class="tablinks" id="defaultOpen" onclick="openDelegator(event, 'delegator-2017')">Current</a>
                <a href="javascript:void(0)" class="tablinks" onclick="openDelegator(event, 'delegator-2016')">Historical</a>
              </div>
              <div id="delegator-2017" class="tabcontent">
                <?php include('includes/__delegatorC.php');?>
              </div>
              <div id="delegator-2016" class="tabcontent">
                <?php include('includes/__delegatorH.php');?>
              </div>
            </div>
            <div class="current">
              <h2>Top 20 Delegatee AS</h2>
              <br/>
              <div class="tab">
                <a href="javascript:void(0)" class="tablinks2" id="defaultOpen2" onclick="openDelegatee(event, 'delegatee-2017')">Current</a>
                <a href="javascript:void(0)" class="tablinks2" onclick="openDelegatee(event, 'delegatee-2016')">Historical</a>
              </div>
              <div id="delegatee-2017" class="tabcontent2">
                <?php include('includes/__delegateeC.php');?>
              </div>
              <div id="delegatee-2016" class="tabcontent2">
                <?php include('includes/__delegateeH.php');?>
              </div>
            </div>
            <!-- ******************************************** -->
          </div>
          <div class="clear"></div>
        </div>
        <div id="footer">
          <?php include_once('includes/__footer.php');?>
        </div>
    </div>
    <!-- javascript -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/Chart.min.js"></script>
		<script type="text/javascript" src="js/historicalLineGraph.js"></script>
    <script type="text/javascript" src="js/currentLineGraph.js"></script>
    <script>
      function openDelegator(evt, type) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(type).style.display = "block";
          evt.currentTarget.className += " active";
      }
      // Get the element with id="defaultOpen" and click on it
      document.getElementById("defaultOpen").click();
    </script>
    <script>
      function openDelegatee(evt, type) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent2");
          for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks2");
          for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(type).style.display = "block";
          evt.currentTarget.className += " active";
      }
      // Get the element with id="defaultOpen" and click on it
      document.getElementById("defaultOpen2").click();
    </script>
  </body>
</html>
