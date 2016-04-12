<?php 
$column = ['service.*','COUNT(1) as num'];
$join =[['left join', 'service', 'using(`service_id`)']];
$param = ['status'=>'open'];
$data =  null;
$pie_data = array(array('value'=> '0', 'color'=>'#fffff', 'highlight'=>'#FF5A5E', 'label'=>'案件'));
$data = Model('product')->column($column)->join($join)->where([[[['product.status', '=', ':status' ]], 'and']])->param($param)->group(['service_id'])->fetchAll();

$color=[
	'0'=> [
		'color' => '#F7464A',
		'highlight' => '#FF5A5E',
	],
	'1'=> [
		'color' => '#46BFBD',
		'highlight' => '#5AD3D1',
	],
	'2'=> [
		'color' => '#FDB45C',
		'highlight' => '#FFC870',
	],
	'3'=> [
		'color' => '#5B90BF',
		'highlight' => '#76B5ED',
	],
	'4'=> [
		'color' => '#96b5b4',
		'highlight' => '#B8DFDE',
	],
	'5'=> [
		'color' => '#a3be8c',
		'highlight' => '#D1F3B3',
	],
	'6'=> [
		'color' => '#ab7967',
		'highlight' => '#DDBFB5',
	],
	'7'=> [
		'color' => '#d08770',
		'highlight' => '#EDBCAD',
	],
	'8'=> [
		'color' => '#b48ead',
		'highlight' => '#EFD1EA',
	],
	'9'=> [
		'color' => '#1F8F95',
		'highlight' => '#3FBDC4',
	],
];

if($data != null) {
	$pie_data = array();
	foreach ($data as $k0=> $v0) {
		if($k0 > count($color)) $k0 = 0;
		$tmp = [
			'value'=>$v0['num'],
			'color' =>$color[$k0]['color'],
			'highlight'=>$color[$k0]['highlight'],
			'label'=>$v0['name'],
		];

		$pie_data[] = $tmp;
	}
}
$pie_data = json_encode($pie_data);


/*LineChart 人次統計*/
$viewed = Model('viewed')->order(['`date`'=>'desc'])->limit('30')->fetchAll();
$line_data = array_reverse($viewed, false);

?>