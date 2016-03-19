<?php 
	if(is_ajax()) {
		$content = !empty($_POST['content']) ? $_POST['content'] : null ;
		if($content == null) json_encode_return(0, '未輸入內容');
		$content = stripslashes(htmlspecialchars($content));
		$query = 'UPDATE `about` SET  `content` =  \''.$content.'\' , `modifyname` = "'.$_SESSION['admin']['name'].'" ,`modifytime` = "'.inserttime().'" WHERE  `about`.`about_id` = 1 LIMIT 1 ; ';
		$query = query_despace($query);
		$result = mysql_query($query);
		(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', url('admin', 'about')) : json_encode_return(1, '修改成功',  url('admin', 'about'));
	}

	$query = query_despace('select * from about where `about_id` = 1;');
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){ $data = $row;	}

?>