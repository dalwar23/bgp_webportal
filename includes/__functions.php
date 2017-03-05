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
	SELECT
	t_delegation_s1.time_stamp AS dates,
	t_meta_data_s1.as_num AS as_num,
	t_meta_data_s1.conesize AS conesize,
	t_meta_data_s1.country_code AS country_code,
	t_meta_data_s1.rir AS rir,
	t_meta_data_s1.as_name 	AS as_name,
	t_delegation_s1.prefix_less AS prefix_less,
	t_delegation_s1.prefix_more AS prefix_more,
	t_delegation_s1.delegator AS delegator,
	t_delegation_s1.delegatee AS delegatee
	FROM t_meta_data_s1
	JOIN t_delegation_s1
	ON
	t_delegation_s1.delegatee=t_meta_data_s1.as_num OR t_delegation_s1.delegator=t_meta_data_s1.as_num
	WHERE
	t_meta_data_s1.as_num = '{$asNumber}' AND t_delegation_s1.time_stamp >='2017-01-01'";

	return $asQuery;
}
?>
<?php
function get_business_rel_query($asNumber){
	$business_rel_query = "
	SELECT *
	FROM t_business_rel_s1
	WHERE 
	t_business_rel_s1.as_1 = '{$asNumber}' OR t_business_rel_s1.as_2 = '{$asNumber}'";

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
	t_delegation_s1.prefix_more ='{$prefix}';
	";
	
	return $prefixQuery;
}
?>
<?php
	//flush the output buffer
	ob_flush();
?>