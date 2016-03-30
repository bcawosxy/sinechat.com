<?php 

	$data = array();$a_service = array();$a_content = array();	
	$data = Model('servicearea')->where([[[['status', '=', ':status']], 'and']])->param([':status'=>'open'])->order(['seqence'=>'ASC'])->fetchAll();

	foreach($data as $k0 => $v0) {
		$m_service = Model('service')->where([[[['status', '=', ':status'], ['servicearea_id', '=', ':servicearea_id']], 'and']])->param([':status'=>'open', ':servicearea_id'=>$v0['servicearea_id']])->order(['seqence'=>'ASC'])->fetchAll();
		$a_service[$k0] = [
			'service' => $m_service,
			'servicearea_id' => $v0['servicearea_id'],
			'servicearea_name' => $v0['name'],
		];

		foreach ($m_service as $k1 => $v1) {  $tmp[] = $v1; }
	}

	if(!empty($tmp) && is_array($tmp)) {
		foreach($tmp as $k0 => $v0) {
			$a_content[$k0]['service_id'] = $v0['service_id'];
			$a_content[$k0]['content'] = $v0['content'];
		}
	}

	$web_title = '修繕項目'; $web_url =url('service');
	$web_description = '修繕項目';

?>