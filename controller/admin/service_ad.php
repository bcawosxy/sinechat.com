<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {
			$data = (!empty($_POST['data'])) ? $_POST['data'] : null ;
			$param = json_decode($data, true);


			foreach ($param as $k0 => $v0) {
				$query = query_despace('UPDATE `service_ad` SET  `name` = "'.$v0['title'].'" , `status` = "'.$v0['status'].'" ,`content` = "'.$v0['content'].'" , `modifytime` = NOW() where `service_ad_id` = "'.$v0['service_ad_id'].'";');
				$result = mysql_query($query);
				if(!$result) json_encode_return(0, '更新資料失敗，請重新輸入資料');
			}
			json_encode_return(1, '更新完成', url('admin', 'service_ad'));
		}
		$query = query_despace('select * from `service_ad` ;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	}
	break;	
}
?>