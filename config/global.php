<?php
/**
 * PATH
 */
define('PATH_ROOT', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('PATH_CSS', PATH_ROOT.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR);
// define('PATH_CACHE', PATH_ROOT.'cache'.DIRECTORY_SEPARATOR);
// define('PATH_LANG', PATH_ROOT.'lang'.DIRECTORY_SEPARATOR);
// define('PATH_LIB', PATH_ROOT.'lib'.DIRECTORY_SEPARATOR);
// define('PATH_LOG', PATH_ROOT.'log'.DIRECTORY_SEPARATOR);
// define('PATH_MODEL', PATH_ROOT.'model'.DIRECTORY_SEPARATOR);
// define('PATH_MODULE', PATH_ROOT.'module'.DIRECTORY_SEPARATOR);
// define('PATH_SDK', PATH_ROOT.'sdk'.DIRECTORY_SEPARATOR);
// define('PATH_STATIC_FILE', PATH_ROOT.'static_file'.DIRECTORY_SEPARATOR);
// define('PATH_STORAGE', PATH_ROOT.'storage'.DIRECTORY_SEPARATOR);
// define('PATH_TTF', PATH_ROOT.'ttf'.DIRECTORY_SEPARATOR);
// define('PATH_UPLOAD', PATH_ROOT.'upload'.DIRECTORY_SEPARATOR);

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
(!is_dir( PATH_ROOT.'view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR._CLASS)) ? redirect('http://'.URL_ROOT) : null;
(!is_file( PATH_ROOT.'controller'.DIRECTORY_SEPARATOR._CLASS.'.php')) ?  : include(PATH_ROOT.'controller'.DIRECTORY_SEPARATOR._CLASS.'.php');

