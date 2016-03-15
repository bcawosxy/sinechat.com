<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {
			
		}
		$query = query_despace('select * from `contact` where status != "delete" order by `inserttime` desc;');
		$result = mysql_query($query);
		$data = $a_open = $a_archive = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}

		foreach ($data as $k0 => $v0) {
			$read = ($v0['read'] == 'read')  ? '<span class="label label-success">Read</span>' : '<span class="label label-warning">Unread</span>' ;
			$gender = ($v0['gender'] ='male')  ? '<i class="fa fa-male">&nbsp;&nbsp;Male</i>' : '<i class="fa fa-female">&nbsp;&nbsp;Female</i>' ;
			$data[$k0]['read'] = $read;
			$data[$k0]['gender'] = $gender;
			switch ($v0['status']) {
				case 'open':
					$a_open[] = $data[$k0];
				break;
				
				case 'archive' :
					$a_archive[] = $data[$k0];
				break;
			}
		}
		
		//預設開啟標籤
		// $tab1 = ($_GET['tab'] != 'tab2') ? 'active' : null;
		// $tab2 = (isset($_GET['tab']) && $_GET['tab'] == 'tab2') ? 'active' : null;
		$tab1 = 'active';
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
			$seqence = (!empty($_POST['seqence'])) ? $_POST['seqence'] : null ;
			$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
			
			if($act == 'edit' && $servicearea_id == null ) json_encode_return(0, '資料不完整，請重新填寫');
			if( $seqence == null || !is_numeric($seqence)) json_encode_return(0, '排序數值錯誤，請重新填寫');
			if($act == null || $name == null|| $status == null ) json_encode_return(0, '資料不完整，請重新填寫');
			switch ($act) {
				case 'add':
					$query = query_despace('INSERT INTO `servicearea` (`name`, `seqence` , `status`, `insert_time`, `modify_time`) VALUES ("'.$name.'", "'.$seqence.'" ,"'.$status.'", NOW(), NOW());');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
					json_encode_return(1, '新增資料完成', url('admin', 'servicearea'));

					break;

				
				case 'edit':
					$query = query_despace('UPDATE `servicearea` SET  `name` = "'.$name.'" , `seqence` = "'.$seqence.'",`status` = "'.$status.'" , `modify_time` = NOW() where `servicearea_id` = "'.$servicearea_id.'";');
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
		
		$contact_id = ( !empty($_GET['contact_id']) ) ? $_GET['contact_id'] : null ;

		if($contact_id != null && is_numeric($contact_id)) {
			$query = query_despace('select * from `contact` where contact_id = '.$contact_id.' and status != "delete";');
			$result = mysql_query($query);
			$data = array();
			while($row = mysql_fetch_assoc($result)){ $data = $row;	}

			//初次讀取時進行資料更新
			if($data['read'] == 'unread') {
				$query = query_despace('UPDATE `contact` SET `read` = "read", `read_time` = NOW() where `contact_id` = "'.$contact_id.'";');
				$result = mysql_query($query);
			}

		}

	}
}
?>