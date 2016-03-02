<?php 
if(is_ajax()){
	$account = (!empty($_POST['account'])) ? $_POST['account'] : null;
	$password = (!empty($_POST['password'])) ? $_POST['password'] : null;
	if($account == null || $password == null) json_encode_return(0, '帳號或密碼輸入錯誤');
	$query = 'select * from admin';
	$result = mysql_query($query);
	
	while($row = mysql_fetch_array($result)) {
		print_r( $row );
	}
	
	json_encode_return('a', 'b', 'c', 'd');
}
?>