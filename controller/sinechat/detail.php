<?php 
	$product_id = (!empty($_GET['id'])) ? $_GET['id'] : null;
	if($product_id == null || !is_numeric($product_id)) redirect(url('prodcut', 'index'), '錯誤的要求,請重新操作。') ;
	$query = query_despace('select `product`.*, `service`.`name` as service_name, `service`.`service_id` as service_id from `product` left join `service` using(`service_id`) where `product`.`status` = "open" and `product_id` = '.$product_id.';');
	$result = mysql_query($query);
	if( mysql_num_rows($result) == 0 ) redirect(url('index', 'index') , '錯誤的要求,請重新操作。');
	while($row = mysql_fetch_assoc($result)){ $data = $row;	}
	$a_image = (!empty($data['image'])) ? explode(',', $data['image']) : null;
	$web_title = '成果展示 | '.$data['name'];
	$web_description = $data['description'];
	$web_image = $data['cover'];
	
	
	$query = query_despace('select * from `product` where `product`.`status` != "none" and `product`.`product_id` != "'.$product_id.'" order by RAND() limit 8;');
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){ $other[] = $row; }
	
?>