<?php
/**
 * @author Md Dalwar Hossain Arif
 * @copyright 2017
 * @email dalwar014@gmail.com
 * @website http://www.user.tu-berlin.de/hossainarif
 * @date 29.01.2017 21:46
 */

//variables for database connection
$host = "localhost";
$username = "root";
$password = "inetnpa";
$db_name = "bgp_data";

//connection to the database....
$connect = @mysql_connect($host,$username,$password) or die("Can't connect to the Database! Try again later!");

//select the database to use...
$select = @mysql_select_db($db_name,$connect) or die("Can't select the specified Database! Try again later");

?>
