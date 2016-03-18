<?php 
	//get news
	$query = query_despace('select * from `news` where status = "open" order by `release` desc limit 5;');
	$result = mysql_query($query);
	$a_news = array();
	while($row = mysql_fetch_assoc($result)){ $a_news[] = $row;	}

	//get service_ad
	$query = query_despace('select * from `service_ad` where `status` = "open" order by `service_ad_id`;');
	$result = mysql_query($query);
	$a_ad = array();
	while($row = mysql_fetch_assoc($result)){ $a_ad[] = $row;	}

	//get product
	$query = query_despace('select * from `product` where `product`.`status` != "none" order by RAND() limit 5;');
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){ $a_product[] = $row; }

	$web_description = '「免費現場勘估，堅持優良品質，採責任施工；擁有最專業的團隊，在最短時間內完工」';
	$web_url = url('index', 'index');

?>