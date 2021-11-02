<?php require 'login.php'; ?><!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="bin/dnjs.min.js"></script>
	<script type="text/javascript"><?php echo file_get_contents('bin/main.js'); ?></script>
	<style type="text/css"><?php echo file_get_contents('bin/main.css'); ?></style>
</head>
<body>
	<div id="ribbon">
		<?php
			if($account_type == "1") {
				echo '
				<div class="lbl">Admin (Main)</div>
				<div class="btn" onclick="opn(this)" lang="notices">Notices</div>
				<div class="btn" onclick="opn(this)" lang="events">Events</div>
				<div class="btn" onclick="opn(this)" lang="news">News</div>
				<div class="btn" onclick="opn(this)" lang="albums">Albums</div>';
			} else {
					echo '
					<div class="lbl">Admin (OPA)</div>
					<div class="btn" onclick="opn(this)" lang="notices.opa">Notices</div>
					<div class="btn" onclick="opn(this)" lang="events.opa">Events</div>
					<div class="btn" onclick="opn(this)" lang="news.opa">News</div>
					<div class="btn" onclick="opn(this)" lang="albums.opa">Albums</div>';
			}
		?>
			<div class="btn btr" onclick="logout()">Logout</div>
			<div class="btn btr" onclick="option()" lang="opt">Options</div>
	</div>
	<iframe id="frame" onload="chk()"></iframe>
</body>
</html>