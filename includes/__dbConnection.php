<?php
/**
 * @author Md Dalwar Hossain Arif
 * @copyright 2017
 * @email dalwar014@gmail.com
 * @website http://www.user.tu-berlin.de/hossainarif
 */
//variables for database connection
$host = "localhost";
$username = "root";
$password = "inetnpa";
$db_name = "bgp_data";

//connection to database
$connection = mysqli_connect($host, $username, $password, $db_name);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
