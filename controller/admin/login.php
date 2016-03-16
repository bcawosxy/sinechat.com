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
		json_encode_return(1, '登入成功', url('admin', 'index')); 
		
	}

}
?>