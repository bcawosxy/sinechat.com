<?php 

switch (_FUNCTION) {

	case 'index' :

		if(is_ajax()) {
			$image = (!empty($_POST['image'])) ? $_POST['image'] : null ;
			
			$dir = _SUB_CLASS.'/';
			$tmp_dir = $dir.'tmp/';
			if(!is_dir(PATH_FILES.$tmp_dir)) mkdir_p(PATH_FILES, $tmp_dir);
			
			//處理圖片
			if(!empty($image)) {
				$a_image = array();
				$image = json_decode($image, true);
				foreach($image as $k0 => $v0) {
					$info = fileinfo($v0['filename']);
					switch($v0['set']) {
						//新增圖片
						case 'new' :
							//copy檔案 刪除動作交由jquery file upload
							if(!file_exists(PATH_UPLOAD.'fileupload'.DIRECTORY_SEPARATOR.$v0['filename'])) json_encode_return(0, '檔案不存在, 請重新檢查['.$v0['filename'].']');
							if(!copy(PATH_UPLOAD.'fileupload'.DIRECTORY_SEPARATOR.$v0['filename'], PATH_FILES.$tmp_dir.$v0['filename'] )) json_encode_return(0, '檔案處理異常, 請重新操作[new]');
						break;
						
						//原有圖片
						case 'old' :
							//檔名 = 順序名 故可能要重新命名
							if(!file_exists(PATH_FILES.$dir.$v0['filename'])) json_encode_return(0, '檔案不存在, 請重新檢查['.$v0['filename'].']');
							if(!rename(PATH_FILES.$dir.$v0['filename'], PATH_FILES.$tmp_dir.$v0['filename']))  json_encode_return(0, '檔案處理異常, 請重新操作[old]');
						break;
					}
					$a_image[] = $v0['filename'];
				}
				
				//clean dir
				$files = glob(PATH_FILES.$dir.'*'); 
				foreach($files as $file){
					if(is_file($file)) unlink($file); 
				}
				
				//copy file
				$files = glob(PATH_FILES.$tmp_dir.'*'); 
				foreach($files as $file){
					$_info = fileinfo($file);
					if(is_file($file)) rename($file, PATH_FILES.$dir.basename($file));
				}
				
				//clean tmp dir
				$files = glob(PATH_FILES.$tmp_dir.'*'); 
				foreach($files as $file){
					if(is_file($file)) unlink($file); 
				}
			}
			$query = query_despace('UPDATE `setbanner` SET `image` = "'.implode(',', $a_image).'" , `modifytime` = NOW() where `setbanner_id` = 1;');
			$result = mysql_query($query);
			if(!$result) json_encode_return(0, '更新資料失敗，請重新輸入資料');
			json_encode_return(1, '更新完成', url('admin', 'setbanner'));

		}

		$query = query_despace('select * from `setbanner` where `setbanner_id` = 1 limit 1 ;');
		$result = mysql_query($query);
		$a_image = array();
		while($row = mysql_fetch_assoc($result)){ $data = $row;	}
		
		$a_image = explode(',',  $data['image']);
	
	break;
	
	case 'fileupload' :
		if(is_ajax()) {
			require(dirname(__FILE__).'/UploadHandler.php');
			$upload_handler = new UploadHandler();
			die();
		}
	break;
}
?>