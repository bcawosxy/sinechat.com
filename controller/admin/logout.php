<?php 
	if(isset($_SESSION['admin'])) {
		unset($_SESSION['admin']) ;
		redirect_php(url('admin', 'login'), '"登出完成。"');
	}
?>