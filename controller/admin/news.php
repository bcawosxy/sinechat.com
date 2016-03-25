<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {}
		$data = Model('news')->where([[[['`status`', '!=', ':status'], ['`status`', '!=', ':status']], 'and']])->param(['status'=>'none', 'status'=>'delete'])->order(['`release`'=>'DESC'])->fetchAll();
	}
	break;	

	case 'delete' :
		$news_id = (!empty($_POST['news_id'])) ? $_POST['news_id'] : null ;
		if($news_id == null ) json_encode_return(0, '錯誤，請重新操作');
		
		$query = query_despace('DELETE FROM `news` WHERE `news_id`= '.$news_id.' limit 1;');
		$result = mysql_query($query);
		if(!$result) json_encode_return(0, '刪除資料失敗，請重新操作');
		json_encode_return(1, '刪除資料完成', url('admin', 'news'));
	break;

	case 'edit' :
	{
		if(is_ajax()) {
			$act = (!empty($_POST['act'])) ? $_POST['act'] : null ;
			$news_id = (!empty($_POST['news_id'])) ? $_POST['news_id'] : null ;
			$title = (!empty($_POST['title'])) ? $_POST['title'] : null ;
			$release = (!empty($_POST['release'])) ? $_POST['release'] : null ;
			$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
			$content = (!empty($_POST['content'])) ? $_POST['content'] : null ;
			
			if($act == 'edit' && $news_id == null ) json_encode_return(0, '資料不完整，請重新填寫');
			if($act == null || $title == null || $release == null || $status == null || $content == null) json_encode_return(0, '資料不完整，請重新填寫');
			switch ($act) {
				case 'add':
					$param = ['title'=>$title, 'content'=>$content, 'status'=>$status, 'release'=>$release, 'modifytime'=>inserttime()];
					$result = Model('news')->add($param);
					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
					json_encode_return(1, '新增資料完成', url('admin', 'news'));
					break;
				
				case 'edit':
					$edit = [
						'title'=>$title, 
						'content'=>$content ,
						'status'=>$status,
						'release'=>$release,
						'modifytime'=>inserttime()
					];
					$result = Model('news')->where([[[['news_id', '=', $news_id]], 'and']])->edit($edit);
					if(!$result) json_encode_return(0, '更新資料失敗，請重新輸入資料');
					json_encode_return(1, '更新完成', url('admin', 'news/edit', ['news_id'=>$news_id]));
					
					break;
				
				default:
					json_encode_return(0, '錯誤，請重新操作');
					break;
			}

			json_encode_return(0, '錯誤，請重新操作');
		}
		
		$news_id = ( !empty($_GET['news_id']) ) ? $_GET['news_id'] : null ;
		$act = 'add';
		$data = [
			'news_id'=>null,
			'title'=>null,
			'content'=>null,
			'status'=>'open',
			'release'=>null,
			'modifytime'=>null,
		];
		if($news_id != null && is_numeric($news_id)) {
			$act = 'edit';
			$data = Model('news')->where([[[['news_id', '=', ':news_id'], ['status', '!=', ':status']], 'and']])->param(['news_id'=>$news_id, 'status'=>'none'])->fetch();
		}
	}
}
?>