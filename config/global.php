<?php
/**
 * PATH
 */
define('PATH_ROOT', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('PATH_CONFIG', PATH_ROOT.'config'.DIRECTORY_SEPARATOR);
define('PATH_CACHE', PATH_ROOT.'cache'.DIRECTORY_SEPARATOR);
define('PATH_LANG', PATH_ROOT.'lang'.DIRECTORY_SEPARATOR);
define('PATH_LIB', PATH_ROOT.'lib'.DIRECTORY_SEPARATOR);
define('PATH_LOG', PATH_ROOT.'log'.DIRECTORY_SEPARATOR);
define('PATH_MODEL', PATH_ROOT.'model'.DIRECTORY_SEPARATOR);
define('PATH_MODULE', PATH_ROOT.'module'.DIRECTORY_SEPARATOR);
define('PATH_SDK', PATH_ROOT.'sdk'.DIRECTORY_SEPARATOR);
define('PATH_STATIC_FILE', PATH_ROOT.'static_file'.DIRECTORY_SEPARATOR);
define('PATH_STORAGE', PATH_ROOT.'storage'.DIRECTORY_SEPARATOR);
define('PATH_TTF', PATH_ROOT.'ttf'.DIRECTORY_SEPARATOR);
define('PATH_UPLOAD', PATH_ROOT.'upload'.DIRECTORY_SEPARATOR);

/**
 * URL
 */
define('URL_CSS', URL_ROOT.'css/'.SITE_LANG.'/');
define('URL_IMG', URL_ROOT.'img/'.SITE_LANG.'/');
define('URL_JS', URL_ROOT.'js/');
define('URL_STATIC_FILE', URL_ROOT.'static_file/');
define('URL_STORAGE', URL_ROOT.'storage/');
define('URL_UPLOAD', URL_ROOT.'upload/');

/**
 * X_site
 */
//news.act
$CONFIG['NEWS_ACT'] = array('close'=>_('Close'), 'preview'=>_('Preview'), 'open'=>_('Open'));

//news.class (目前 magazine 有獨立的顯示頁面)
$CONFIG['NEWS_CLASS'] = array('blog'=>_('婚享名人'), 'company'=>_('婚享好友'), 'event'=>_('婚享優惠'), 'fan'=>_('婚享報報'), 'lectures'=>_('婚享講座'), 'magazine'=>_('婚享誌'));

//newsarea.act
$CONFIG['NEWSAREA_ACT'] = array('close'=>_('Close'), 'preview'=>_('Preview'), 'open'=>_('Open'));