<?php 
	//get news
	$a_news = Model('news')->where([[[['status', '=', ':status']], 'and']])->param([':status'=>'open'])->order(['`release`'=>'desc'])->limit(5)->fetchAll();

	//get service_ad
	$a_ad = Model('service_ad')->where([[[['status', '=', ':status']], 'and']])->param([':status'=>'open'])->order(['service_ad_id'=>'desc'])->fetchAll();

	//get product
	$a_product = Model('product')->where([[[['status', '=', ':status']], 'and']])->param([':status'=>'open'])->order(['RAND()'=>'desc'])->limit(5)->fetchAll();

	$web_url = url('index', 'index');

?>