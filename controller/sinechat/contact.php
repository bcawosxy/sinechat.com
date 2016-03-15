<?php 
	$query = query_despace('select * from `info`;');
	$result = mysql_query($query);
	$data = array();
	while($row = mysql_fetch_assoc($result)){$data[] = $row;}
	$info = array();
	foreach ($data as $k0 => $v0) {	
		if($v0['status'] == 'open') {

			switch ($v0['name']) {
				case 'address':
					$tmp = '<li class="icon fa-home">'.$v0['value'].'</li>';
					break;
				
				case 'tel':
					$tmp = '<li class="icon fa-phone">'.$v0['value'].'</li>';
					break;
				
				case 'cellphone':
					$tmp = '<li class="icon fa-mobile-phone">'.$v0['value'].'</li>';
					break;
				
				case 'email':
					$tmp = '<li class="icon fa-envelope">'.$v0['value'].'</li>';
					break;
				
				case 'facebook':
					$tmp = '<li class="icon fa-facebook">'.$v0['value'].'</li>';
					break;
			}
		}
		$info[$v0['name']]  = $tmp;
	};
	
?>