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
top_as.delegatee AS delegatee,
t_meta_data_s1.country_code AS country_code,
t_meta_data_s1.rir AS rir,
t_meta_data_s1.as_name
FROM
(
SELECT
t_delegation_s1.time_stamp  AS time_stamp,
t_delegation_s1.delegatee AS delegatee, 
COUNT(t_delegation_s1.delegatee) AS frequency 
FROM t_delegation_s1
WHERE t_delegation_s1.time_stamp < '2017-01-01'
GROUP BY t_delegation_s1.delegatee 
ORDER BY frequency DESC LIMIT 20
) AS top_as
JOIN t_meta_data_s1
ON top_as.delegatee = t_meta_data_s1.as_num
ORDER BY frequency DESC";

//execute query
$result = $connection->query($sql);
?>
<table width=100% border=' 1px solid black' >
<?php
if ($result->num_rows > 0) {
    // output data of each row
    echo"
        <tr class='theader'>
            <td>AS Number</td>
            <td>Country Code</td>
            <td>RIR</td>
            <td>AS Name</td>
        </tr>
    ";
    while($row = $result->fetch_assoc()) {
    	echo "
    		<tr>
    			<td><a href='asInfoProcessor.php?asNumber={$row[delegatee]}'>$row[delegatee]</a></td>
    			<td>$row[country_code]</td>
    			<td>$row[rir]</td>
    			<td>$row[as_name]</td>
    		</tr>
    	";
    }
} else {
    echo "<tr><td>0 results</td></tr>";
}
?>
</table>
<?php 
//free memory associated with result
$result->close();

//close connection
$connection->close();
?>