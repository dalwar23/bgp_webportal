<?php
/**
* @author Md Dalwar Hossain Arif
* @copyright 2017
* @email dalwar014@gmail.com
* @website http://www.user.tu-berlin.de/hossainarif
*/
?>
<?php
	//Start the output buffer
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
function get_as_query($asNumber){
	$asQuery = "
	SELECT *
	FROM t_meta_data_s1
	WHERE t_meta_data_s1.as_num ='{$asNumber}'
	";
	return $asQuery;
}
?>
<?php
function get_delegation_query($asNumber){
	$dQuery = "
	SELECT
	top_as.dates	AS dates,
	top_as.prefix_less AS prefix_less,
	top_as.prefix_more AS prefix_more,
	top_as.delegator	AS delegator,
	top_as.delegatee	AS delegatee
	FROM
	(SELECT
	t_delegation_s1.time_stamp			AS 	dates,
	t_delegation_s1.prefix_less			AS	prefix_less,
	t_delegation_s1.prefix_more			AS	prefix_more,
	t_delegation_s1.delegator			AS	delegator,
	t_delegation_s1.delegatee			AS	delegatee
	FROM t_delegation_s1
	WHERE t_delegation_s1.delegator = '{$asNumber}'
	GROUP BY t_delegation_s1.delegatee
	UNION
	SELECT
	t_delegation_s1.time_stamp			AS 	dates,
	t_delegation_s1.prefix_less			AS	prefix_less,
	t_delegation_s1.prefix_more			AS	prefix_more,
	t_delegation_s1.delegator			AS	delegator,
	t_delegation_s1.delegatee			AS	delegatee
	FROM t_delegation_s1
	WHERE t_delegation_s1.delegatee = '{$asNumber}'
	GROUP BY t_delegation_s1.delegator) AS top_as
	ORDER BY top_as.dates DESC
	";

	return $dQuery;
}
?>
<?php
function get_business_rel_query($asNumber){
	$business_rel_query = "
	SELECT *
	FROM t_business_rel_s1
	WHERE
	t_business_rel_s1.as_1 = '{$asNumber}' OR t_business_rel_s1.as_2 = '{$asNumber}'
	";

	return $business_rel_query;
}
?>
<?php
function get_prefix_query($prefix){
	$prefixQuery = "
	SELECT
	t_delegation_s1.time_stamp	AS dates,
	t_delegation_s1.prefix_more	AS prefix_more,
	t_delegation_s1.delegator	AS delegator,
	t_delegation_s1.delegatee	AS delegatee
	FROM t_delegation_s1
	WHERE
	t_delegation_s1.prefix_more ='{$prefix}'
	ORDER BY dates DESC
	";

	return $prefixQuery;
}
?>
<?php
function get_bRelation_query($as1, $as2){
	$rQuery = "
	SELECT
	t_business_rel_s1.as_rel_type	AS as_rel_type
	FROM t_business_rel_s1
	WHERE
	t_business_rel_s1.as_1 = '{$as1}' AND t_business_rel_s1.as_2 = '{$as2}'
	";

	return $rQuery;
}
?>
<?php
	//flush the output buffer
	ob_flush();
?>
