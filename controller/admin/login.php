<?php 
if(is_ajax()){
	$account = (!empty($_POST['account'])) ? $_POST['account'] : null;
	$password = (!empty($_POST['password'])) ? $_POST['password'] : null;
	if($account == null || $password == null) json_encode_return(0, '帳號或密碼輸入錯誤');

	$result = Model('admin')->where([[[['account', '=', ':account'], ['password', '=', ':password']] ,'and']])->param([':account'=>$account, ':password'=>$password])->fetch();
	if(empty($result)) {
		json_encode_return(0, '登入失敗，請重新登入。');
	}else{	
		$_SESSION['admin']['id'] = $result['admin_id'];
		$_SESSION['admin']['account'] = $result['account'];
		$_SESSION['admin']['passwd'] = $result['password'];	
		$_SESSION['admin']['name'] = $result['name'];
		$_SESSION['admin']['email'] = $result['email'];

		json_encode_return(1, '登入成功', url('admin', 'index')); 
		
	}

}
?>