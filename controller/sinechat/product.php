<?php 
	$query = query_despace('select `product`.*, `service`.`name` as service_name, `service`.`service_id` as service_id from `product` left join `service` using(`service_id`) where `product`.`status` = "open" order by `product`.`seqence` asc;');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}

	$web_title = '修繕成果展示'; $web_url =url('product');
	$web_description = '修繕成果展示';

?>