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
		
		//send mail
		require_once(PATH_ROOT.'assets/sdk/phpmailer/PHPMailerAutoload.php');
		$body = '聯絡人姓名：'.$name.'<br>';
		$body .= '聯絡人信箱：'.$email.'<br>';
		$body .= '聯絡人電話：'.$tel.'<br>';
		$body .= '聯絡人性別：'.$gender.'<br>';
		$body .= '備註：'.$memo.'<br>';
		$body .= '聯絡時間：'.inserttime().'<br>';
		$subject = '新誠修繕工程 - 客戶連絡提醒 - '.$name;
		$send = email(EMAIL_ADDRESS, EMAIL_PASSWORD, '新誠修繕工程', EMAIL_TO,  $subject, $body);				
		json_encode_return(1, '我們已收到您的聯絡資料,將盡快與您聯繫。', url('index', 'index'));
		
	}
	
	$query = query_despace('select * from `info`;');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){$data[] = $row;}
	$a_info = array();
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
					$tmp = '<li class="icon fa-facebook"><a href="'.$v0['value'].'">新誠粉絲專頁</a></li>';
					break;

				case 'host':
					$tmp = '<li class="icon fa-user">'.$v0['value'].'</li>';
					break;
			}
		}
		$a_info[$v0['name']]  = $tmp;
	};
	
	//調整順序
	$info = [
		'host' => $a_info['host'],
		'address' => $a_info['address'],
		'tel' => $a_info['tel'],
		'cellphone' => $a_info['cellphone'],
		'email' => $a_info['email'],
		'facebook' => $a_info['facebook'],
	];
	
	$web_title = '聯絡資訊 | 聯絡新誠'; $web_url =url('contact');
	$web_description = '新誠聯絡資訊 | 聯絡新誠';

?>