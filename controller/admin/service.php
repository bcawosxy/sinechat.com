<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {
			
		}
		$query = query_despace('select `service`.*, `servicearea`.`name` as servicearea_name from `service` left join `servicearea` using(`servicearea_id`) where `service`.`status` != "none" order by `service`.`service_id` desc;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	}
	break;	

	case 'delete' :
		if(is_ajax()) {
			$service_id = (!empty($_POST['service_id'])) ? $_POST['service_id'] : null ;
			if($service_id == null ) json_encode_return(0, '錯誤，請重新操作');
			
			$query = query_despace('DELETE FROM `service` WHERE `service_id`= '.$service_id.' limit 1;');
			$result = mysql_query($query);
			if(!$result) json_encode_return(0, '刪除資料失敗，請重新操作');
			json_encode_return(1, '刪除資料完成', url('admin', 'service'));
		}
	break;

	case 'edit' :
	{
		if(is_ajax()) {
			$act = (!empty($_POST['act'])) ? $_POST['act'] : null ;
			$service_id = (!empty($_POST['service_id'])) ? $_POST['service_id'] : null ;
			$name = (!empty($_POST['name'])) ? $_POST['name'] : null ;
			$content = (!empty($_POST['content'])) ? $_POST['content'] : null ;
			$servicearea_id = (!empty($_POST['servicearea_id'])) ? $_POST['servicearea_id'] : null ;
			$seqence = (!empty($_POST['seqence'])) ? $_POST['seqence'] : null ;
			$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
			$content = stripslashes(htmlspecialchars($content));
			
			if($act == 'edit' && $service_id == null ) json_encode_return(0, '資料不完整，請重新填寫');
			if($act == null || $name == null || $status == null || $servicearea_id == null || $seqence == null ) json_encode_return(0, '資料不完整，請重新填寫');
			switch ($act) {
				case 'add':
					$query = query_despace('INSERT INTO `service` (`name` , `servicearea_id`, `content`,`seqence`, `status`, `modify_time`) VALUES ("'.$name.'", "'.$servicearea_id.'", "'.$content.'","'.$seqence.'", "'.$status.'", NOW());');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
					json_encode_return(1, '新增資料完成', url('admin', 'service'));

					break;

				case 'edit':
					$query = query_despace('UPDATE `service` SET  `name` = "'.$name.'" , `status` = "'.$status.'" ,`content` = "'.$content.'" ,`servicearea_id` = "'.$servicearea_id.'" , `seqence` = "'.$seqence.'" , `modify_time` = NOW() where `service_id` = "'.$service_id.'";');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '更新資料失敗，請重新輸入資料');
					json_encode_return(1, '更新完成', url('admin', 'service/edit', ['service_id'=>$service_id]));
					
					break;
				
				default:
					json_encode_return(0, '錯誤，請重新操作');
					break;
			}

			json_encode_return(0, '錯誤，請重新操作');
		}
		
		$service_id = ( !empty($_GET['service_id']) ) ? $_GET['service_id'] : null ;
		$act = 'add';
		$data = [
			'service_id'=>null,
			'name'=>null,
			'content'=>null,
			'status'=>'open',
			'modify_time'=>null,
		];
		if($service_id != null && is_numeric($service_id)) {
			$act = 'edit';
			$query = query_despace('select * from `service` where service_id = '.$service_id.' and status != "none";');
			$result = mysql_query($query);
			$data = array();
			while($row = mysql_fetch_assoc($result)){ $data = $row;	}			
		}

		/**
		 * 取得servicearea id 
		 */
		$query = query_despace('select * from `servicearea` where status != "none";');
		$result = mysql_query($query);
		$servicearea = array();
		while($row = mysql_fetch_assoc($result)){ $servicearea[] = $row;	}

	}
	break;
}
?>