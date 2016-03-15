<?php 
	$query = query_despace('select * from `info` where `status` = "open";');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){$data[] = $row;}

	$info = array();
	
	foreach ($data as $k0 => $v0) {
		$info[$v0['name']] = $v0['value'] ;
	};
	
?>