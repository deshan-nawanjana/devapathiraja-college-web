<!DOCTYPE html>
<html>
<head>
	<title>News | Devapathiraja College</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="bin/dnjs.min.js"></script>
	<link rel="shortcut icon" type="image/png" href="bin/fav_dnc.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript">
		var type = 'news';
		<?php echo file_get_contents('bin/main.js'); ?>
		<?php echo file_get_contents('bin/news.js'); ?>
	</script>
	<style type="text/css">
		<?php echo file_get_contents('bin/main.css'); ?>
		<?php echo file_get_contents('bin/navbar.css'); ?>
		<?php echo file_get_contents('bin/ribbon.css'); ?>
		<?php echo file_get_contents('bin/slider.css'); ?>
		<?php echo file_get_contents('bin/quotes.css'); ?>
		<?php echo file_get_contents('bin/button.css'); ?>
		<?php echo file_get_contents('bin/notice.css'); ?>
		<?php echo file_get_contents('bin/galery.css'); ?>
		<?php echo file_get_contents('bin/footer.css'); ?>
		<?php echo file_get_contents('bin/article.css'); ?>
		<?php echo file_get_contents('bin/events.css'); ?>
	</style>
</head>
<body>

	<?php include 'navbar.php'; ?>

	<div class="ribbon">
		<div class="rbnico"></div>
		<div class="rbntxt" id="title"></div>
	</div>

	<div id="ntcbox" class="secrgh"><span id="load">Loading...</span></div>
	<div class="mre" id="mre" onclick="more(this)">Load More</div>

</body>