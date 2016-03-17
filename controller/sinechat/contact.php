<?php 
	if(is_ajax()) {
		$name = (!empty($_POST['name'])) ? $_POST['name'] : null ;
		$email = (!empty($_POST['email'])) ? $_POST['email'] : null ;
		$tel = (!empty($_POST['tel'])) ? $_POST['tel'] : null ;
		$gender = (!empty($_POST['gender'])) ? $_POST['gender'] : null ;
		$memo = (!empty($_POST['memo'])) ? $_POST['memo'] : null ;
		if($name == null || $tel == null || $gender == null || $memo == null ) json_encode_return(0, '資料不完整，請重新填寫');

		$query = query_despace('INSERT INTO `contact` (`name` , `email`, `tel`,`gender`, `memo`, `status`, `reading`, `ip`, `inserttime`, `modifytime` )
						VALUES ("'.$name.'", "'.$email.'", "'.$tel.'","'.$gender.'", "'.$memo.'", "open", "unread", "'.remote_ip().'", "'.inserttime().'", "'.inserttime().'");');

		$result = mysql_query($query);
		if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
		json_encode_return(1, '新增資料完成', url('index', 'index'));

	}
	
	$query = query_despace('select * from `info`;');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){$data[] = $row;}
	$info = array();
	foreach ($data as $k0 => $v0) {	
		if($v0['status'] == 'open') {
			switch ($v0['name']) {
				case 'address':
					$tmp = '<li class="icon fa-home">'.$v0['value'].'</li>';
					break;
				
				case 'tel':
					$tmp = '<li class="icon fa-phone">'.$v0['value'].'</li>';
					break;
				
				case 'cellphone':
					$tmp = '<li class="icon fa-mobile-phone">'.$v0['value'].'</li>';
					break;
				
				case 'email':
					$tmp = '<li class="icon fa-envelope">'.$v0['value'].'</li>';
					break;
				
				case 'facebook':
					$tmp = '<li class="icon fa-facebook">'.$v0['value'].'</li>';
					break;
			}
		}
		$info[$v0['name']]  = $tmp;
	};
	
	$web_title = '聯絡資訊 | 聯絡新誠'; $web_url =url('contact');
	$web_description = '新誠聯絡資訊 | 聯絡新誠';

?>