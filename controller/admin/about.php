<?php 
	if(is_ajax()) {
		$value = !empty($_POST['value']) ? $_POST['value'] : null ;

		if($value == null) json_encode_return(0, '未輸入內容');

		$value = stripslashes(htmlspecialchars($value));
		$new_id = 1;
		$query = 'UPDATE `about` SET  `value` =  \''.$value.'\' , `modify_name` = "'.$_SESSION['admin']['name'].'" ,`modify_time` = NOW() WHERE  `about`.`id` = "'.$new_id.'" LIMIT 1 ; ';
		$query = query_despace($query);
		$result = mysql_query($query);
		(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', url('admin', 'about')) : json_encode_return(1, '修改成功',  url('admin', 'about'));
	}

	$query = query_despace('select * from about where `id` = 1;');
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){	$data = $row;	}
?>