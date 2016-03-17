<?php 
	$query = query_despace('select * from about where `about_id` = 1;');
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){	$data = $row;	}
	
	$web_title = '關於新誠修繕工程'; $web_url =url('about');
	$web_description = '關於新誠居家修繕';
?>