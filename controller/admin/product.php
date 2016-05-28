<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {}
		$column = ['product.*', 'service.name as service_name', 'service.service_id as service_id' ];
		$data = Model('product')->column($column)->join([['left join', 'service', 'USING(`service_id`)']])->where([[[['product.status', '!=', ':status'], ['product.status', '!=', ':status'] ], 'and']])->param([':status'=>'none', ':status'=>'delete'])->order(['product.product_id'=>'DESC'])->fetchAll();
	}
	break;	

	case 'delete' :
		if(is_ajax()) {
			$product_id = (!empty($_POST['product_id'])) ? $_POST['product_id'] : null ;
			if($product_id == null ) json_encode_return(0, '錯誤，請重新操作');
			
			$result = Model('product')->where([[[['product_id', '=', $product_id]], 'and']])->edit(['status'=>'delete']);
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
			$sort_date = (!empty($_POST['sort_date'])) ? $_POST['sort_date'] : null ;
			$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
			$content = stripslashes(htmlspecialchars($content));
			$cover = null;
			if($act == 'edit' && $product_id == null ) json_encode_return(0, '資料不完整，請重新填寫');
			if($act == null || $name == null || $status == null  || $description == null ) json_encode_return(0, '資料不完整，請重新填寫');
			
			//若以時間排序則忽略seqence
			if($sort_date == 'true') $seqence = 0;
			
			switch($act){
				case 'add' :
					$param = [
						'name' => $name,
						'cover' => $cover,
						'image' => $image,
						'service_id' => $service_id,
						'status' => $status,
						'content' => $content,
						'description' => $description,
						'seqence' => $seqence,
						'inserttime' => inserttime(),
						'modifytime' => inserttime(),
					];
					$result = Model('product')->add($param);

					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料[001]');
					$insert_id = $result ;
					
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
							image_remake(PATH_FILES.$dir.basename($file), 'jpg', 750, 495, 'w'); //製造燈箱大圖
							image_reformat(PATH_FILES.$dir.basename($file), 'jpg', 72, 72); //前台燈箱縮圖
						}
						
						//clean tmp dir
						$files = glob(PATH_FILES.$tmp_dir.'*'); 
						foreach($files as $file){
							if(is_file($file)) unlink($file); 
						}
					}

					$param = [
						'name' => $name,
						'cover' => $cover,
						'image' => implode(',', $a_image),
						'modifytime' => inserttime(),
					];
					$result = Model('product')->where([[[['product_id', '=', $insert_id]], 'and']])->edit($param);

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
									if(!file_exists(PATH_FILES.$dir.$v0['filename'])) json_encode_return(0, '檔案不存在, 請重新檢查['.$v0['filename'].']');
									
									//原圖檔名
									if(!rename(PATH_FILES.$dir.$v0['filename'], PATH_FILES.$tmp_dir.$v0['filename']))  json_encode_return(0, '檔案處理異常, 請重新操作[old]');
									
									/**
									 * A: 為了避免舊圖片的各種size重新被處理, 這邊需要移動其他size圖片來避掉這個問題
									 * @這裡只是負責將有相關聯的resize圖片往tmp放及取回來,不負責產生"所有"新的size 
									 */
									$a_resize = ['750x495', '72x72', '150x100', '228x152', '249x166', '371x248', '370x493'];
									admin_resized_img_move(PATH_FILES.$dir.$info['basename'], $a_resize);
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
						
						//copy all file
						$files = glob(PATH_FILES.$tmp_dir.'*'); 
						foreach($files as $file){
							if(is_file($file)) rename($file, PATH_FILES.$dir.basename($file));
						}
						
						/**
						 * 承A - 這裡檢查是否已經產生resize圖 如果存在則不重新產生, 但並非所有size都由這邊處理
						 */
						foreach ($a_image as $k0 => $v0) {
							$_info = fileinfo($v0);
							
							//檢查是否存在750x495圖
							$img_check = $_info['filename'].'_750x495'.'.'.$_info['extension'];
							if(!file_exists(PATH_FILES.$dir.$img_check)) {
								image_remake(PATH_FILES.$dir.basename($v0), 'jpg', 750, 495, 'w');	//製造燈箱大圖
							}

							//檢查是否存在72x72圖
							$img_check2 = $_info['filename'].'_72x72'.'.'.$_info['extension'];
							if(!file_exists(PATH_FILES.$dir.$img_check2)) {
								image_remake(PATH_FILES.$dir.basename($v0), 'jpg', 72, 72, 'w');	//前台燈箱縮圖
							}
						}

						//clean tmp dir
						$files = glob(PATH_FILES.$tmp_dir.'*'); 
						foreach($files as $file){
							if(is_file($file)) unlink($file); 
						}
					}
					
					$param = [
						'name' => $name,
						'cover' => $cover,
						'image' => implode(',', $a_image),
						'service_id' => $service_id,
						'status' => $status,
						'content' => $content,
						'description' => $description,
						'seqence' => $seqence,
						'modifytime' => inserttime(),
					];
					$result = Model('product')->where([[[['product_id', '=', $product_id]], 'and']])->edit($param);

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
			'seqence'=>0,
			'status'=>'open',
			'inserttime'=>'open',
			'modifytime'=>null,
		];
		if($product_id != null && is_numeric($product_id)) {
			$act = 'edit';
			$where = [[[['status', '!=', ':status'], ['status', '!=', ':status'], ['product_id', '=', ':product_id'] ], 'and']];
			$data = Model('product')->where($where)->param([':status'=>'none', ':status'=>'delete', ':product_id'=>$product_id])->fetch();
			$a_image = (!empty($data['image'])) ? explode(',', $data['image']) : null;
		}
		
		/**
		 * 取得service id 
		 */
		$where = [[[['status', '!=', ':status'], ['status', '!=', ':status']], 'and']];
		$service = Model('service')->where($where)->param([':status'=>'none', ':status'=>'delete'])->fetchAll();

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