<?php
/**
* @author Md Dalwar Hossain Arif
* @copyright 2017
* @email dalwar014@gmail.com
* @website http://www.user.tu-berlin.de/hossainarif
*/

// get database credentials
include('__dbConnection.php');

//query to get data from the table
$sql = "SELECT
top_as.delegator AS delegator,
t_meta_data_s1.country_code AS country_code,
t_meta_data_s1.rir AS rir,
t_meta_data_s1.as_name
FROM
(
SELECT
t_delegation_s1.delegator AS delegator, 
COUNT(t_delegation_s1.delegator) AS frequency 
FROM t_delegation_s1 
GROUP BY t_delegation_s1.delegator 
ORDER BY frequency DESC LIMIT 20
) AS top_as
JOIN t_meta_data_s1
ON top_as.delegator = t_meta_data_s1.as_num
ORDER BY frequency DESC";

//execute query
$result = $connection->query($sql);
?>
<table>
<?php
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	//echo "<tr><td>$row[delegator]</td></tr>";
    }
} else {
    echo "<tr><td>0 results</td></tr>";
}
?>
<?php
</table>
//free memory associated with result
$result->close();

//close connection
$connection->close();
?>