<?php 
if(is_ajax()){
	$account = (!empty($_POST['account'])) ? $_POST['account'] : null;
	$password = (!empty($_POST['password'])) ? $_POST['password'] : null;
	if($account == null || $password == null) json_encode_return(0, '帳號或密碼輸入錯誤');
	
	$query = 'select * from admin where `account` = "'.$account.'" and `password` = "'.$password.'";';
	$result = mysql_query(query_despace($query));
	if(mysql_num_rows($result) == 0) {
		json_encode_return(0, '登入失敗，請重新登入。');
	}else{
		$a_admin = array();
		while($row = mysql_fetch_array($result)) {
			$_SESSION['admin']['id'] = $row['admin_id'];
			$_SESSION['admin']['account'] = $row['account'];
			$_SESSION['admin']['passwd'] = $row['password'];	
			$_SESSION['admin']['name'] = $row['name'];
			$_SESSION['admin']['email'] = $row['email'];
		}
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		$query = 'update `admin` set last_login_time = NOW() , 
			last_login_ip = "'.$ip.'"
			where admin_id = "'.$_SESSION['admin']['id'].'" limit 1;';
		$query = query_despace($query);
		if($result = mysql_query($query)){ json_encode_return(1, '登入成功', url('admin', 'index')); }	
		
		json_encode_return(0, '異常，請重新登入。');
	}

}
?>