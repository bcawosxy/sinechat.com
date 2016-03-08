<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {
			
		}
		$query = query_despace('select * from `news` where status != "none" order by `date` desc;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	}
	break;	

	case 'edit' :
	{
		if(is_ajax()) {
			$act = (!empty($_POST['act'])) ? $_POST['act'] : null ;
			$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
			$title = (!empty($_POST['title'])) ? $_POST['title'] : null ;
			$date = (!empty($_POST['date'])) ? $_POST['date'] : null ;
			$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
			$content = (!empty($_POST['content'])) ? $_POST['content'] : null ;
			
			if($act == 'edit' && $id == null ) json_encode_return(0, '資料不完整，請重新填寫');
			if($act == null || $title == null || $date == null || $status == null || $content == null) json_encode_return(0, '資料不完整2，請重新填寫');
			
			if($act == 'edit') {
				$query = query_despace('UPDATE `news` SET  `title` = "'.$title.'" , `content` = "'.$content.'", `status` = "'.$status.'" , `date` = "'.$date.'" , `modify_time` = NOW() where `id` = "'.$id.'";');
				$result = mysql_query($query);
				if(!$result) json_encode_return(0, '更新資料失敗，請重新輸入資料');
				json_encode_return(1, '更新完成', url('admin', 'news/edit', ['id'=>$id]));
			}elseif($act == 'add') {
				$query = query_despace('INSERT INTO `news` (`title` , `content` , `status`, `date` , `modify_time`) VALUES ("'.$title.'", "'.$content.'", "'.$status.'", "'.$date.'", NOW());');
				$result = mysql_query($query);
				if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
				json_encode_return(1, '新增資料完成', url('admin', 'news'));
			}
			
			json_encode_return(0, '錯誤，請重新操作');
		}
		
		$id = ( !empty($_GET['id']) ) ? $_GET['id'] : null ;
		$act = 'add';
		$data = [
			'id'=>null,
			'title'=>null,
			'content'=>null,
			'status'=>null,
			'date'=>null,
			'modify_time'=>null,
		];
		if($id != null && is_numeric($id)) {
			$act = 'edit';
			$query = query_despace('select * from `news` where id = '.$id.' and status != "none";');
			$result = mysql_query($query);
			$data = array();
			while($row = mysql_fetch_assoc($result)){ $data = $row;	}
		}
	}
}
?>