<?php
/**
* @author Md Dalwar Hossain Arif
* @copyright 2017
* @email dalwar014@gmail.com
* @website http://www.user.tu-berlin.de/hossainarif
*/
//setting header to json
header('Content-Type: application/json');

// get database credentials
include('__dbConnection.php');

//query to get data from the table
$sql = "SELECT
        time_stamp, total_prefixes
        FROM t_historical_s1
        WHERE time_stamp LIKE '%01' ORDER BY time_stamp ASC";

//execute query
$result = $connection->query($sql);

//loop through the returned data
$data = array();
foreach ($result as $row) {
$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$connection->close();

//now print the data
print json_encode($data);
