<?php 
	//get news
	$a_news = Model('news')->where([[[['status', '=', ':status']], 'and']])->param([':status'=>'open'])->order(['`release`'=>'desc'])->limit(5)->fetchAll();

	//get service_ad
	$a_ad = Model('service_ad')->where([[[['status', '=', ':status']], 'and']])->param([':status'=>'open'])->order(['service_ad_id'=>'desc'])->fetchAll();

	//get product
	$a_product = Model('product')->where([[[['status', '=', ':status']], 'and']])->param([':status'=>'open'])->order(['RAND()'=>'desc'])->limit(5)->fetchAll();

	$web_description = '免費現場勘估，堅持優良品質，採責任施工；擁有最專業的團隊，在最短時間內完工';
	$web_url = url('index', 'index');

?>