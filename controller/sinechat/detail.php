<?php 
	$product_id = (!empty($_GET['id'])) ? $_GET['id'] : null;
	if($product_id == null || !is_numeric($product_id)) redirect(url('prodcut', 'index'), '錯誤的要求,請重新操作。') ;

	$column = ['`product`.*', '`service`.`name` as service_name', '`service`.`service_id` as service_id'];
	$join = [['left join', 'service', 'USING(`service_id`)']];
	$where = [[[['`product`.`status`', '=', ':status'], ['`product_id`', '=', ':product_id']] ,'and']];
	$param = [':status'=>'open', ':product_id'=>$product_id];
	$product = Model('product')->column($column)->join($join)->where($where)->param($param)->fetch();
	
	if( empty($product) || count($product) == 0 ) redirect(url('index', 'index') , '錯誤的要求,請重新操作。');
	$a_image = (!empty($product['image'])) ? explode(',', $product['image']) : null;

	$other = Model('product')->column(['product.*', 'service.name as service_name'])->join($join)->where([[[['`product`.`status`', '=', ':status'], ['`product`.`product_id`', '!=', ':product_id']], 'and']])->param([':status'=>'open', ':product_id'=>$product_id])->order(['RAND()'=>'ASC'])->limit(8)->fetchAll();

	$web_title = '成果展示 | '.$product['name'];
	$web_description = $product['description'];
	$web_url = url('detail', 'index', ['id'=>$product['product_id']]);
	$web_image = URL_FILES.'product/'.$product['product_id'].'/'.sinechat_Thumbnail($product['cover'], 750, 500);
	
?>