<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {}
		$query = query_despace('select `product`.*, `service`.`name` as service_name, `service`.`service_id` as service_id from `product` left join `service` using(`service_id`) where `product`.`status` != "none" order by `product`.`product_id` desc;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	}
	break;	

	case 'delete' :
		if(is_ajax()) {
			$product_id = (!empty($_POST['product_id'])) ? $_POST['product_id'] : null ;
			if($product_id == null ) json_encode_return(0, '錯誤，請重新操作');
			
			$query = query_despace('DELETE FROM `product` WHERE `product_id`= '.$product_id.' limit 1;');
			$result = mysql_query($query);
			if(!$result) json_encode_return(0, '刪除資料失敗，請重新操作');
			json_encode_return(1, '刪除資料完成', url('admin', 'product'));
		}
	break;

	case 'edit' :
	{
		if(is_ajax()) {
			$act = (!empty($_POST['act'])) ? $_POST['act'] : null ;
			$product_id = (!empty($_POST['product_id'])) ? $_POST['product_id'] : null ;
			$image = (!empty($_POST['image'])) ? $_POST['image'] : null ;
			$service_id = (!empty($_POST['service_id'])) ? $_POST['service_id'] : null ;
			$name = (!empty($_POST['name'])) ? $_POST['name'] : null ;
			$content = (!empty($_POST['content'])) ? $_POST['content'] : null ;
			$description = (!empty($_POST['description'])) ? $_POST['description']   : null ;
			$seqence = (!empty($_POST['seqence'])) ? $_POST['seqence'] : null ;
			$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
			$content = stripslashes(htmlspecialchars($content));
			$cover = null;
			if($act == 'edit' && $product_id == null ) json_encode_return(0, '資料不完整，請重新填寫');
			if($act == null || $name == null || $status == null || $seqence == null || $description == null ) json_encode_return(0, '資料不完整，請重新填寫');
			
			switch($act){
				case 'add' :
					$query = query_despace('INSERT INTO `product` (`name` , `cover`, `image`,`service_id`, `status`, `content`, `description`, `seqence` , `inserttime` ,`modifytime`) VALUES ("'.$name.'", "null", "null", "'.$service_id.'", "'.$status.'" ,"'.$content.'","'.$description.'","'.$seqence.'", NOW(), NOW());');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料[001]');
					$insert_id = mysql_insert_id();
					
					//建立dir / tmp_dir
					$dir = _SUB_CLASS.'/'.$insert_id.'/';
					$tmp_dir = $dir.'tmp/';
					if(!is_dir(PATH_FILES.$tmp_dir)) mkdir_p(PATH_FILES, $tmp_dir);
					
					//處理圖片
					if(!empty($image)) {
						$a_image = array();
						$image = json_decode($image, true);
						if(count($image) < 1)  json_encode_return(0, '至少需要上傳一張圖片。');
						foreach($image as $k0 => $v0) {
							$info = fileinfo($v0['filename']);
							switch($v0['set']) {
								//新增圖片
								case 'new' :
									//copy檔案 刪除動作交由jquery file upload
									if(!file_exists(PATH_UPLOAD.'fileupload'.DIRECTORY_SEPARATOR.$v0['filename'])) json_encode_return(0, '檔案不存在, 請重新檢查['.$v0['filename'].']');
									if(!copy(PATH_UPLOAD.'fileupload'.DIRECTORY_SEPARATOR.$v0['filename'], PATH_FILES.$tmp_dir.$v0['filename'] )) json_encode_return(0, '檔案處理異常, 請重新操作[new]');
								break;
							}
							
							if($k0 == 0) $cover = $v0['filename'];
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
					
					$query = query_despace('UPDATE `product` SET `cover` = "'.$cover.'" ,`image` = "'.implode(',', $a_image).'" , `modifytime` = NOW() where `product_id` = "'.$insert_id.'";');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料[002]');
					json_encode_return(1, '新增資料完成', url('admin', 'product'));
				break;
				
				case 'edit' :
					//建立dir / tmp_dir
					$dir = _SUB_CLASS.'/'.$product_id.'/';
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
							
							if($k0 == 0) $cover = $v0['filename'];
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
					
					$query = query_despace('UPDATE `product` SET  `name` = "'.$name.'" , `cover` = "'.$cover.'" ,`image` = "'.implode(',', $a_image).'" ,`service_id` = "'.$service_id.'" ,  `status` = "'.$status.'" ,`content` = "'.$content.'" ,`description` = "'.$description.'" , `seqence` = "'.$seqence.'" , `modifytime` = NOW() where `product_id` = "'.$product_id.'";');
					$result = mysql_query($query);
					if(!$result) json_encode_return(0, '更新資料失敗，請重新輸入資料');
					json_encode_return(1, '更新完成', url('admin', 'product/edit', ['product_id'=>$product_id]));
				break;
			}
		}

		$product_id = ( !empty($_GET['product_id']) ) ? $_GET['product_id'] : null ;
		$act = 'add'; $a_image = null;
		$data = [
			'product_id'=>null,
			'name'=>null,
			'cover'=>null,
			'image'=>null,
			'content'=>null,
			'service_id'=>null,
			'description'=>null,
			'seqence'=>null,
			'status'=>'open',
			'inserttime'=>'open',
			'modifytime'=>null,
		];
		if($product_id != null && is_numeric($product_id)) {
			$act = 'edit';
			$query = query_despace('select * from `product` where product_id = '.$product_id.' and status != "none";');
			$result = mysql_query($query);
			$data = array();
			while($row = mysql_fetch_assoc($result)){ $data = $row;	}
			$a_image = (!empty($data['image'])) ? explode(',', $data['image']) : null;
		}
		
		/**
		 * 取得service id 
		 */
		$query = query_despace('select * from `service` where status != "none";');
		$result = mysql_query($query);
		$service = array();
		while($row = mysql_fetch_assoc($result)){ $service[] = $row;	}

	}
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