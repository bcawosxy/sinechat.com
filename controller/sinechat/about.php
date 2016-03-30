<?php 

	$data = Model('about')->where([[[['about_id', '=', ':about_id']], 'and']])->param([':about_id'=>'1'])->fetch();

	$web_title = '關於新誠修繕工程'; $web_url =url('about');
	$web_description = '關於新誠居家修繕';
?>