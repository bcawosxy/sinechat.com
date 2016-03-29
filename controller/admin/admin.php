<?php 
	if(is_ajax()) {
		$oldpassword = (!empty($_POST['oldpassword'])) ? $_POST['oldpassword'] : null ;
		$newpassword = (!empty($_POST['newpassword'])) ? $_POST['newpassword'] : null ;
		$checkpassword = (!empty($_POST['checkpassword'])) ? $_POST['checkpassword'] : null ;

		$data = Model('admin')->column(['COUNT(1) as `count`'])->where([[[['account', '=', "'admin'"], ['password', '=', ':password']], 'and']])->param([':password'=>$oldpassword])->fetch();
		
		if($data['count'] == 0 ) json_encode_return(0, '舊密碼輸入錯誤，請重新輸入');		
		if($newpassword != $checkpassword) json_encode_return(0, '兩次密碼輸入不相同，請重新操作');
		if(strlen($newpassword) < 8) json_encode_return(0, '密碼至少需要八個字元');
		
		$result = Model('admin')->where([[[['admin_id', '=', 1]], 'and']])->limit(1)->edit(['password'=>$newpassword]);
		if(!$result) json_encode_return(0, '更新失敗，請重新操作', url('admin', 'admin'));
		
		json_encode_return(1, '密碼修改完成，請重新登入', url('admin', 'logout'));
	}

?>