<?php 
	$page = (!empty($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
	$per_page_num = 8;
	$start = ($page-1) * $per_page_num;
	$page_range = $start.','.$per_page_num;

	$column = ['`product`.*', '`service`.`name` as service_name', '`service`.`service_id` as service_id'];
	$join = [['left join', 'service', 'USING(`service_id`)']];
	$where = [[[['`product`.`status`', '=', ':status']] ,'and']];
	$param = [':status'=>'open'];
	$data = Model('product')->column($column)->join($join)->where($where)->param($param)->order(['`product`.`seqence`'=>'ASC'])->limit($page_range)->fetchAll();
	$num = count(Model('product')->join($join)->where($where)->param($param)->order(['`product`.`seqence`'=>'ASC'])->fetchAll());
	
	//總頁數 = 數量 / $per_page_num
	$total_pages = ceil($num/$per_page_num);
	
	$web_title = '修繕成果展示'; $web_url =url('product');
	$web_description = '修繕成果展示';

?>