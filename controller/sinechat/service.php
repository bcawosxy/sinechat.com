<?php 
	$query = query_despace('SELECT * FROM `servicearea` where `servicearea`.`status` = "open" order by `seqence` ASC;');
	$result = mysql_query($query);
	$data = array();$a_service = array();$a_content = array();
	while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	foreach($data as $k0 => $v0) {
		$query = query_despace('SELECT * FROM `service` where `service`.`status` = "open" and `servicearea_id` = '.$v0['servicearea_id'].' order by `seqence` asc;');
		$result = mysql_query($query);
		$data_service = array();
		
		$a_service[$k0]['servicearea_id'] = $v0['servicearea_id'];
		$a_service[$k0]['servicearea_name'] = $v0['name'];
		while($row = mysql_fetch_assoc($result)){ $a_service[$k0]['service'][] = $row;	$tmp[] = $row;}
	}

	if(!empty($tmp) && is_array($tmp)) {
		foreach($tmp as $k0 => $v0) {
			$a_content[$k0]['service_id'] = $v0['service_id'];
			$a_content[$k0]['content'] = $v0['content'];
		}
	}

	$web_title = '修繕項目'; $web_url =url('service');
	$web_description = '修繕項目';

?>