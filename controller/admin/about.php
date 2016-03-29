<?php 
	if(is_ajax()) {
		$content = !empty($_POST['content']) ? $_POST['content'] : null ;
		if($content == null) json_encode_return(0, '未輸入內容');
		$content = stripslashes(htmlspecialchars($content));

		$param = [
			'content'=> $content,
			'modifytime'=>inserttime(),
			'modifyname'=>$_SESSION['admin']['name'],
		];
		$result = Model('about')->where([[[['about_id', '=', 1]], 'and']])->edit($param);

		(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', url('admin', 'about')) : json_encode_return(1, '修改成功',  url('admin', 'about'));
	}

	$data = Model('about')->where([[[['about_id', '=', ':about_id']], 'and']])->param(['about_id'=>1])->fetch();

?>