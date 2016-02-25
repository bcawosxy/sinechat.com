<?php
/**
 * PATH
 */
define('PATH_ROOT', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('PATH_CSS', PATH_ROOT.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR);

/**
 * URL
 */
define('URL_CSS', 'http://'.URL_ROOT.'/assets/css/');
define('URL_IMG', 'http://'.URL_ROOT.'/assets/images/');
define('URL_JS', 'http://'.URL_ROOT.'/assets/js/');
define('URL_UPLOAD', 'http://'.URL_ROOT.'upload/');



/**
 * 引入[view][controller]判斷
 */
(!is_dir( PATH_ROOT.'view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._CLASS)) ? redirect('http://'.URL_ROOT) : null;
(!is_file( PATH_ROOT.'controller'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._CLASS.'.php')) ?  : include(PATH_ROOT.'controller'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._CLASS.'.php');

