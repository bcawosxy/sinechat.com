<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {}
		$column = ['service.*', 'servicearea.name as servicearea_name', 'servicearea.servicearea_id as servicearea_id' ];
		$data = Model('service')->column($column)->join([['left join', 'servicearea', 'USING(`servicearea_id`)']])->where([[[['service.status', '!=', ':status'], ['service.status', '!=', ':status'] ], 'and']])->param([':status'=>'none', ':status'=>'delete'])->fetchAll();
	}
	break;	

	case 'delete' :
		if(is_ajax()) {
			$service_id = (!empty($_POST['service_id'])) ? $_POST['service_id'] : null ;
			if($service_id == null ) json_encode_return(0, '錯誤，請重新操作');
			
			$result = Model('service')->where([[[['service_id', '=', $service_id]], 'and']])->edit(['status'=>'delete']);

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
					$param = [
						'name' => $name,
						'servicearea_id' => $servicearea_id,
						'content' => $content,
						'seqence' => $seqence,
						'status' => $status,
						'inserttime' => inserttime(),
						'modifytime' => inserttime(),
					];
					$result = Model('service')->add($param);

					if(!$result) json_encode_return(0, '新增資料失敗，請重新輸入資料');
					json_encode_return(1, '新增資料完成', url('admin', 'service'));

					break;

				case 'edit':
					$param = [
						'name' => $name,
						'servicearea_id' => $servicearea_id,
						'content' => $content,
						'seqence' => $seqence,
						'status' => $status,
						'modifytime' => inserttime(),
					];
					$result = Model('service')->where([[[['service_id', '=', $service_id]], 'and']])->edit($param);

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
			'modifytime'=>null,
		];
		if($service_id != null && is_numeric($service_id)) {
			$act = 'edit';
			$where = [[[['status', '!=', ':status'], ['status', '!=', ':status'], ['service_id', '=', ':service_id'] ], 'and']];
			$data = Model('service')->where($where)->param([':status'=>'none', ':status'=>'delete', ':service_id'=>$service_id])->fetch();
		}

		/**
		 * 取得servicearea id 
		 */
		$where = [[[['status', '!=', ':status'], ['status', '!=', ':status']], 'and']];
		$servicearea = Model('servicearea')->where($where)->param([':status'=>'none', ':status'=>'delete'])->fetchAll();
	}
	break;
}
?>