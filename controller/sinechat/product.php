<?php 
	$page = (!empty($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
	$per_page_num = 8;
	$start = ($page-1) * $per_page_num;
	
	$query = query_despace('select `product`.*, `service`.`name` as service_name, `service`.`service_id` as service_id from `product` left join `service` using(`service_id`) where `product`.`status` = "open" order by `product`.`seqence` asc limit '.$start.','.$per_page_num.';');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}

	$query = query_despace('select COUNT(1) as num from `product` left join `service` using(`service_id`) where `product`.`status` = "open" order by `product`.`seqence` asc;');
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){ $num = $row['num'];}

	//總頁數 = 數量 / $per_page_num
	$total_pages = ceil($num/$per_page_num);
	
	$web_title = '修繕成果展示'; $web_url =url('product');
	$web_description = '修繕成果展示';

?>