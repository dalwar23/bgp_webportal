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
$connection = new mysqli($host, $username, $password, $db_name);
if($connection->connect_error){
	die("Database connection failed!".$connection->connect_error);
}
