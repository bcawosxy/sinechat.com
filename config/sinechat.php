<?php 
	date_default_timezone_set('Asia/Taipei');
	define('SITE_NAME', 'sinechat');
	//route
	function route_rule($url) {
		$package = null;
		$class = null;
		$function = null;
		$version = null;
		$a_url = explode('/', strtolower($url));
		$level1 = empty($a_url[1])? 'index' : $a_url[1];
		$level2 = empty($a_url[2])? 'index' : $a_url[2];
		$level3 = empty($a_url[3])? 'index' : $a_url[3];
		switch ($level1) {
			case 'admin':
				$package = 'admin';
				define('MAIN', 'admin');
			break;
			
			default :
				$package = $level1;
				$class = $level2;
				define('MAIN', SITE_NAME);
			break;
		}
		
		return array($package, $class, $function, $version);
	}
	
	define('SITE_FOLDER', null);
	$dev_root = $_SERVER['SERVER_NAME'];
	$SITE_FOLDER = constant('SITE_FOLDER');
	$pos = strpos($_SERVER['REQUEST_URI'], $SITE_FOLDER);
	list($url) = explode('?', ($pos !== false)? substr_replace($_SERVER['REQUEST_URI'], '', $pos, strlen($SITE_FOLDER)) : $_SERVER['REQUEST_URI']);
	list($package, $class, $function, $version) = route_rule($url);
	define('_CLASS', $package);
	define('_SUB_CLASS', $class);
	
	
	//不同環境的DB 設定
	switch($dev_root) {
		/**
		 *	開發環境
		 */
		case 'dev.sinechat.com':
			
		break;
		
		/**
		 *	正式環境
		 */
		case 'www.sinechat.com':
		case 'sinechat.com':
		
		break;
		
	}

?>