<?php 
	$query = query_despace('select * from about where `id` = 1;');
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){	$data = $row;	}

	
?>