<?php 

/**
 * 總數統計
 */
$c_service = Model('service')->column(['COUNT(1) as count'])->where([[[['status', '!=', ':status' ]], 'and']])->param(['status'=>'delete'])->fetch();
$service_count = $c_service['count'];

$c_product = Model('product')->column(['COUNT(1) as count'])->where([[[['status', '!=', ':status' ]], 'and']])->param(['status'=>'delete'])->fetch();
$product_count = $c_product['count'];

/**
 * Pie Charts 統計
 */
$column = ['service.*','COUNT(1) as num'];
$join =[['left join', 'service', 'using(`service_id`)']];
$param = ['status'=>'open'];
$data =  null;
$data = Model('product')->column($column)->join($join)->where([[[['product.status', '=', ':status' ]], 'and']])->param($param)->group(['service_id'])->fetchAll();

if($data != null) {
	$pie_data = array();
	foreach ($data as $k0=> $v0) {
		$tmp = [
			'value'=>$v0['num'],
			'label'=>$v0['name'],
		];
		$pie_data[] = $tmp;
	}
}

/**
 * Bar Charts 統計
 */

//本周最後一天(星期日)
$this_week = date('Y-m-d', strtotime('+7 day', time()-86400*date('w')));
$series_line = []; $rate = 7;
for($i=1; $i<8; $i = $i+1) {$tmp[] = date('Y-m-d 23:59:59', strtotime('-'.($i*$rate).' day', strtotime($this_week)));}
array_unshift($tmp,$this_week);
$week = array_reverse($tmp);
$bar_data = [];
foreach ($week as $k0 => $v0) {
	if($k0 == 0) continue;
	$param = ['status'=>'delete'];
	$where = [[[['product.status', '!=', ':status' ], ['TO_DAYS(`product`.`inserttime`)', '>', 'TO_DAYS("'.$week[$k0-1].'")'], ['TO_DAYS(`product`.`inserttime`)', '<', 'TO_DAYS("'.$v0.'")']], 'and']];
	$m_product = Model('product')->column(['COUNT(1) as count'])->where($where)->param($param)->fetch();

	$bar_data[] = [	
		'data' => $m_product['count'],
		'date' => $v0,
	];
}

$bar_data[5]['date'] = '上周';
$bar_data[6]['date'] = '本周';

/**
 * LineChart 人次統計
 */
$a_line_product_num = [];
$viewed = Model('viewed')->order(['`date`'=>'desc'])->limit('30')->fetchAll();
$line_data = array_reverse($viewed, false);


/**
 *  LineChart 每日新增案件統計
 */
foreach ($line_data as $k0 => $v0) {
	$product_num = Model('product')->column(['COUNT(1) as count'])->where([[[['TO_DAYS(`product`.`inserttime`)', '=', 'TO_DAYS("'.$v0['date'].'")']], 'and']])->fetch();
	$a_line_product_num[] = $product_num['count'];
}
?>