<?php
define('URL_PROTOCOL', is_https()? 'https://' : 'http://');
define('URL_ROOT', URL_PROTOCOL.$dev_root);	
define('URL_ADMIN_ROOT', URL_PROTOCOL.$dev_root.'/admin');	

/**
 * PATH
 */
define('PATH_ROOT', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('PATH_CSS', PATH_ROOT.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR);
define('PATH_UPLOAD', PATH_ROOT.'upload'.DIRECTORY_SEPARATOR);
define('PATH_FILES', PATH_ROOT.'files'.DIRECTORY_SEPARATOR);
define('PATH_STATIC_FILE', null);
define('PATH_STORAGE', null);

/**
 * URL
 */
define('URL_ASSETS', URL_ROOT.'/assets/');
define('URL_UPLOAD', URL_ROOT.'/upload/');
define('URL_CSS', URL_ASSETS.'css/');
define('URL_IMG', URL_ASSETS.'images/');
define('URL_JS', URL_ASSETS.'js/');
define('URL_FILES', URL_ROOT.'/files/');
define('URL_STATIC_FILE', null);
define('URL_STORAGE', null);

$web_title = null;$web_image = null;$web_description = null;

/**
 * 引入[view][controller]判斷
 */
if(MAIN != 'admin') {
	(!is_dir( PATH_ROOT.'view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._CLASS)) ? redirect(URL_ROOT) : null;
	(!is_file( PATH_ROOT.'view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._CLASS.DIRECTORY_SEPARATOR._SUB_CLASS.'.phtml')) ? redirect(URL_ROOT) : null;
	(!is_file( PATH_ROOT.'controller'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._CLASS.'.php')) ?  : include(PATH_ROOT.'controller'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._CLASS.'.php');
} else if(MAIN =='admin'){
	if(_SUB_CLASS != 'login' && empty($_SESSION['admin'])) redirect(url('admin', 'login')) ;
	(!is_file( PATH_ROOT.'controller'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._SUB_CLASS.'.php')) ?  : include(PATH_ROOT.'controller'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._SUB_CLASS.'.php');
	(!is_dir( PATH_ROOT.'view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._SUB_CLASS)) ? redirect(URL_ADMIN_ROOT) : null;
	(!is_file( PATH_ROOT.'view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._SUB_CLASS.DIRECTORY_SEPARATOR._FUNCTION.'.phtml')) ? redirect(URL_ADMIN_ROOT) : null;
}
