<?php 
	if(is_ajax()) {
		$act = !empty($_POST['act']) ? $_POST['act'] : null ;
		$data = !empty($_POST['data']) ? $_POST['data'] : null ;
		if($act == null) json_encode_return(0, '請求來源錯誤');
		if($data == null) json_encode_return(0, '未輸入內容');
		
		$data = json_decode($data, true);
		foreach ($data as $k0 => $v0) {
			$query = 'UPDATE `info` SET  `value` =  "'.$v0['value'].'", `status` =  "'.$v0['status'].'" , `modify_time` = NOW() WHERE  `info`.`info_id` = "'.$v0['id'].'" LIMIT 1 ; ';
			$query = query_despace($query);
			$result = mysql_query($query);
			if(!$result) json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', url('admin', 'info'));
		}
		json_encode_return(1, '修改成功',  url('admin', 'info'));
	}

	$query = query_despace('select * from `info`;');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){	$data[] = $row;	}

	$a_icon = [
		'address' => 'fa-home',
		'tel' => 'fa-phone',
		'cellphone' => 'fa-mobile-phone',
		'email' => 'fa-envelope',
		'facebook' => 'fa-facebook',
	];
?>