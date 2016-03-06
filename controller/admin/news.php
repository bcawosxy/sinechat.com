<?php 

switch (_FUNCTION) {

	case 'index' :
	{
		if(is_ajax()) {
			
		}
		$query = query_despace('select * from `news` where status != "none" order by `date` desc;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	}
	break;	

	case 'edit' :
	{
		if(is_ajax()) {
			
		}
		
		$id = ( !empty($_GET['id']) ) ? $_GET['id'] : null ;
		$act = 'add';
		$data = [
			'id'=>null,
			'title'=>null,
			'content'=>null,
			'status'=>null,
			'date'=>null,
		];
		if($id != null && is_numeric($id)) {
			$act = 'edit';
			$query = query_despace('select * from `news` where id = '.$id.' and status != "none";');
			$result = mysql_query($query);
			$data = array();
			while($row = mysql_fetch_assoc($result)){ $data = $row;	}
		}
	}
}
?>