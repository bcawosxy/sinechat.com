<!DOCTYPE HTML>
<!--
	Strongly Typed by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php 
include('./config/sinechat.php');
include('./config/function.php');
include('./config/global.php');
?>

<script>
console.log('Execute:<?php echo $_SERVER['PHP_SELF']?>');
console.log('Uri:<?php echo $_SERVER['REQUEST_URI']?>');
console.log('CLASS:<?php echo _CLASS; ?>');
</script>
<html>
<?php 
	switch(MAIN) {
		/**
		 * 前台
		 */
		default : ?>
			<head>
				<title>Strongly Typed by HTML5 UP</title>
				<meta charset="utf-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<!-- Head -->	<?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'head.phtml') ?> <!-- end Head -->
			</head>
			<body class="homepage">
				<div id="page-wrapper">
					<!-- Headbar --><?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'headbar.phtml') ?> <!-- end Headbar -->
					<!-- Banner --> <?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR.'banner.phtml') ?> <!-- end Banner -->		
					<!-- Main -->
					<div id="main-wrapper">
						<div id="main" class="container">
							<?php include('./view'.DIRECTORY_SEPARATOR.SITE_NAME.DIRECTORY_SEPARATOR._CLASS.DIRECTORY_SEPARATOR.'index.phtml') ?>
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
		?>
			welcome to Sinechat		
		<?php 
		break;	
	}

?>
</html>