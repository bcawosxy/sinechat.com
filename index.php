<?php session_start() ?>
<?php 
include('./config/sinechat.php');
include('./config/function.php');
include('./config/model.php');
include('./config/global.php');
?>
<!DOCTYPE HTML>
<!--
	Strongly Typed by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<?php 	
	switch(MAIN) {
		/**
		 * 前台
		 */
		default : ?>
			<head>

		<!-- Head --><?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'head.phtml') ?><!-- end Head -->
				<title>新誠修繕工程 <?php if(!is_null($web_title)) echo ' | '.$web_title ;?></title>
				<meta charset="utf-8" />
				<?php if(ENV != 'production' || _CLASS != 'index') echo '<meta name="robots" content="none">'; ?>

				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<meta name="description" content="<?php echo $web_description; ?>">
				<meta property="og:title" content="新誠修繕工程 <?php if(!is_null($web_title)) echo ' | '.$web_title ;?>" />
				<meta property="og:type" content='website' />
				<meta property="og:url" content="<?php echo $web_url; ?>" />
				<meta property="og:description" content="<?php echo $web_description; ?>"/>
				<meta property="og:image" content="<?php echo $web_image ?>"/>
				<meta property="og:site_name" content="新誠修繕工程" />
			</head>
			<body class="homepage">
				<div id="page-wrapper">
					<!-- Headbar --><?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'headbar.phtml') ?> <!-- end Headbar -->
					<!-- Banner --> <?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'banner.phtml') ?> <!-- end Banner -->		
					<!-- Main -->
					<div id="main-wrapper">
						<div id="main" class="container">
							<?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR._CLASS.DIRECTORY_SEPARATOR._SUB_CLASS.'.phtml') ?>
						</div>
					</div>
					<!-- end main -->
					<!-- Footer -->	<?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'footbar.phtml') ?> <!-- end ooter -->
				</div>
				<!-- Foot --> <?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'foot.phtml') ?> <!-- end Foot -->
			</body>
		<?php 
		break;
		
		case 'admin' :
		/**
		 * 後台
		 */
			//login 頁面
			if(_SUB_CLASS =='login') {
				include('./view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._SUB_CLASS.DIRECTORY_SEPARATOR._FUNCTION.'.phtml');
			} else {
		?>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<title>Sinechat.com | Admin System</title>
				<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
				<!-- Head -->	<?php include('./view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR.'head.phtml') ?> <!-- end Head -->
			</head>
			<body class="hold-transition skin-blue sidebar-mini">
				<div class="wrapper">
					<!-- Headbar --> <?php include('./view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR.'headbar.phtml'); ?> <!-- ecd Headbar -->
					<!-- navbar --> <?php include('./view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR.'navbar.phtml'); ?> <!-- echo navbar -->
						<div class="content-wrapper">
							<?php include('./view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR._SUB_CLASS.DIRECTORY_SEPARATOR._FUNCTION.'.phtml'); ?>
						</div>
					<!-- Footbar --> <?php include('./view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR.'footbar.phtml'); ?> <!-- end Footbar -->
				</div>
			</body>
			<!-- Foot -->
			<?php include('./view'.DIRECTORY_SEPARATOR.MAIN.DIRECTORY_SEPARATOR.'foot.phtml'); ?>
			<!-- end Foot -->
		<?php 
		}
		break;	
	}
?>
</html>