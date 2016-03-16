<?php 

switch (_FUNCTION) {

	case 'index' :

		if(is_ajax()) {}
		$query = query_despace('select `product`.*, `service`.`name` as service_name, `service`.`service_id` as service_id from `product` left join `service` using(`service_id`) where `product`.`status` != "none" order by `product`.`product_id` desc;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
	
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