<?php 
	$query = query_despace('select * from `news` where status = "open" order by `release` desc limit 5;');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
?>