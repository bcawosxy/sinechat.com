<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {
			
		}
		$query = query_despace('select * from `servicearea` where status != "none" order by `servicearea_id` desc;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	}
	break;	

	case 'delete' :
		$servicearea_id = (!empty($_POST['servicearea_id'])) ? $_POST['servicearea_id'] : null ;
		if($servicearea_id == null ) json_encode_return(0, '錯誤，請重新操作');
		
		$query = query_despace('DELETE FROM `servicearea` WHERE `servicearea_id`= '.$servicearea_id.' limit 1;');
		$result = mysql_query($query);
		if(!$result) json_encode_return(0, '刪除資料失敗，請重新操作');
		json_encode_return(1, '刪除資料完成', url('admin', 'servicearea'));
	break;

	case 'edit' :
	{
		if(is_ajax()) {
			$act = (!empty($_POST['act'])) ? $_POST['act'] : null ;
			$servicearea_id = (!empty($_POST['servicearea_id'])) ? $_POST['servicearea_id'] : null ;
			$name = (!empty($_POST['name'])) ? $_POST['name'] : null ;
			$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
			
			if($act == 'edit' && $servicearea_id == null ) json_encode_return(0, '資料不完整，請重新填寫');
			if($act == null || $name == null || $status == null ) json_encode_return(0, '資料不完整，請重新填寫');
			switch ($act) {
				case 'add':
					$query = query_despace('INSERT INTO `servicearea` (`name` , `status`, `modify_time`) VALUES ("'.$name.'", "'.$status.'", NOW());');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
					json_encode_return(1, '新增資料完成', url('admin', 'servicearea'));

					break;

				
				case 'edit':
					$query = query_despace('UPDATE `servicearea` SET  `name` = "'.$name.'" , `status` = "'.$status.'" , `modify_time` = NOW() where `servicearea_id` = "'.$servicearea_id.'";');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '更新資料失敗，請重新輸入資料');
					json_encode_return(1, '更新完成', url('admin', 'servicearea/edit', ['servicearea_id'=>$servicearea_id]));
					
					break;
				
				default:
					json_encode_return(0, '錯誤，請重新操作');
					break;
			}

			json_encode_return(0, '錯誤，請重新操作');
		}
		
		$servicearea_id = ( !empty($_GET['servicearea_id']) ) ? $_GET['servicearea_id'] : null ;
		$act = 'add';
		$data = [
			'servicearea_id'=>null,
			'name'=>null,
			'status'=>'open',
			'modify_time'=>null,
		];
		if($servicearea_id != null && is_numeric($servicearea_id)) {
			$act = 'edit';
			$query = query_despace('select * from `servicearea` where servicearea_id = '.$servicearea_id.' and status != "none";');
			$result = mysql_query($query);
			$data = array();
			while($row = mysql_fetch_assoc($result)){ $data = $row;	}
		}
	}
}
?>