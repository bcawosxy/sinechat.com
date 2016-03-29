<?php 
	if(is_ajax()) {
		$act = !empty($_POST['act']) ? $_POST['act'] : null ;
		$data = !empty($_POST['data']) ? $_POST['data'] : null ;
		if($act == null) json_encode_return(0, '請求來源錯誤');
		if($data == null) json_encode_return(0, '未輸入內容');
		
		$data = json_decode($data, true);
		foreach ($data as $k0 => $v0) {	
			$param = [
				'value' => $v0['value'],
				'status' => $v0['status'],
				'modifytime' => inserttime(),
			];
			$result = Model('info')->where([[[['info_id', '=', $v0['id']]], 'and']])->edit($param);
			if(!$result) json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', url('admin', 'info'));
		}
		json_encode_return(1, '修改成功',  url('admin', 'info'));
	}

	$data = Model('info')->fetchAll();
	$a_icon = [
		'address' => 'fa-home',
		'tel' => 'fa-phone',
		'cellphone' => 'fa-mobile-phone',
		'email' => 'fa-envelope',
		'facebook' => 'fa-facebook',
		'host' => 'fa-user',
	];
?>