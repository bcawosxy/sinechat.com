<?php 

switch (_FUNCTION) {

	case 'archive' :
		if(is_ajax()) {
			$contact_id = ( !empty($_POST['contact_id']) ) ? $_POST['contact_id'] : null ;
			if($contact_id == null ) json_encode_return(0, '錯誤，請重新操作');
			$query = query_despace('UPDATE `contact` SET `status` = "archive" where `contact_id` = "'.$contact_id.'";');
			$result = mysql_query($query);
			json_encode_return(1, '封存完成', url('admin', 'contact/edit', ['contact_id'=>$contact_id]));
		}
	break;

	case 'delete' :
		if(is_ajax()) {
			$contact_id = (!empty($_POST['contact_id'])) ? $_POST['contact_id'] : null ;
			if($contact_id == null ) json_encode_return(0, '錯誤，請重新操作');
			$query = query_despace('DELETE FROM `contact` WHERE `contact_id`= '.$contact_id.' limit 1;');
			$result = mysql_query($query);
			if(!$result) json_encode_return(0, '刪除資料失敗，請重新操作');
			json_encode_return(1, '刪除資料完成', url('admin', 'contact'));
		}
	break;

	case 'edit' :
		$contact_id = ( !empty($_GET['contact_id']) ) ? $_GET['contact_id'] : null ;
		if($contact_id != null && is_numeric($contact_id)) {
			$query = query_despace('select * from `contact` where contact_id = '.$contact_id.' and status != "delete";');
			$result = mysql_query($query);
			$data = array();
			while($row = mysql_fetch_assoc($result)){ $data = $row;	}

			if($data['status'] == 'open') $status_text  = '一般';
			if($data['status'] == 'archive') $status_text  = '封存';
			$data['status_text'] = $status_text;

			//初次讀取時進行資料更新
			if($data['reading'] == 'unread') {
				$query = query_despace('UPDATE `contact` SET `reading` = "reading", `readtime` = NOW() where `contact_id` = "'.$contact_id.'";');
				$result = mysql_query($query);
			}
		}
	break;

	case 'index' :
		if(is_ajax()) {}

		$query = query_despace('select * from `contact` where status != "delete" order by `inserttime` desc;');
		$result = mysql_query($query);
		$data = $a_open = $a_archive = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}

		foreach ($data as $k0 => $v0) {
			$reading = ($v0['reading'] == 'reading')  ? '<span class="label label-success">Read</span>' : '<span class="label label-warning">Unread</span>' ;
			$gender = ($v0['gender'] ='male')  ? '<i class="fa fa-male">&nbsp;&nbsp;Male</i>' : '<i class="fa fa-female">&nbsp;&nbsp;Female</i>' ;
			$data[$k0]['reading'] = $reading;
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
		$tab1 = 'active';
		if(!empty($_GET['tab'])) {
			$tab1 = ($_GET['tab'] != 'archive') ? 'active' : null;
			$tab2 = ($_GET['tab'] == 'archive') ? 'active' : null;
		}

	break;	

}
?>