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
// Get the posted value and run it throught python script
if(isset($_POST['prefix'])){
  $prefix = $_POST['prefix'];
}
$addressBlock = shell_exec("/usr/bin/python3 pyScripts/longestPrefixMatch.py $prefix");
// echo "$prefix -> $addressBlock";
if ($addressBlock != 'None'){
  header("Location: prefixInfoProcessor.php?prefix=urlencode($addressBlock)&search=urlencode($prefix)");
}
// else{
// 	$addressBlock = '0.0.0.0';
// 	header("Location: prefixInfoProcessor.php?prefix=" . $addressBlock);
// }
?>
<?php
	//Flush Output Buffer
	ob_flush();
?>
