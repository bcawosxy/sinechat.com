<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {}
		$data = Model('servicearea')->where([[[['status', '!=', ':status'], ['status', '!=', ':status']], 'and']])->param(['status'=>'none', 'status'=>'delete'])->fetchAll();
	}
	break;	

	case 'delete' :
		$servicearea_id = (!empty($_POST['servicearea_id'])) ? $_POST['servicearea_id'] : null ;
		if($servicearea_id == null ) json_encode_return(0, '錯誤，請重新操作');

		$result = Model('servicearea')->where([[[['servicearea_id', '=', $servicearea_id]], 'and']])->edit(['status'=>'delete']);

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
					$param = [
						'name' => $name,
						'seqence' => $seqence,
						'status' => $status,
						'inserttime' => inserttime(),
						'modifytime' => inserttime(),
					];
					$result = Model('servicearea')->add($param);

					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
					json_encode_return(1, '新增資料完成', url('admin', 'servicearea'));
					
					break;

				case 'edit':
					$param = [
						'name' => $name,
						'seqence' => $seqence,
						'status' => $status,
						'modifytime' => inserttime(),
					];
					$result = Model('servicearea')->where([[[['servicearea_id', '=', $servicearea_id]], 'and']])->edit($param);

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
			'seqence'=>null,
			'status'=>'open',
			'modify_time'=>null,
		];
		if($servicearea_id != null && is_numeric($servicearea_id)) {
			$act = 'edit';
			$data = Model('servicearea')->where([[[['servicearea_id', '=', ':servicearea_id'], ['status', '!=', ':status'], ['status', '!=', ':status']] ,'and']])->param(['servicearea_id'=>$servicearea_id, ':status'=>'none' , ':status'=>'delete'])->fetch();
		}
	}
}
?>