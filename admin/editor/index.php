<!DOCTYPE html>
<html>
<head>
	<title>Post Editor</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="bin/dnjs.min.js"></script>
	<script type="text/javascript"><?php echo file_get_contents('bin/main.js'); ?></script>
	<style type="text/css"><?php echo file_get_contents('bin/main.css'); ?></style>
</head>
<body>
	<div id="make" title="Create">&#60545;</div>
	<div id="list"></div>
	<div id="edit">
		<div id="ribn"></div>
		<input type="text" id="name" placeholder="Type title here..." autocomplete="off" maxlength="50">
		<input type="date" id="date" onchange="upd_dat()">
		<div id="opts">
			<div class="opt" id="opt_text" onclick="new_opt('text')" title="Text">&#60254;</div>
			<div class="opt" id="opt_snap" onclick="new_opt('snap')" title="Image">&#60151;</div>
			<div class="opt" id="opt_link" onclick="new_opt('link')" title="Link">&#60850;</div>

			<div class="opt" id="opt_delt" onclick="delt()" title="Delete Post">&#60882;</div>
			<div class="opt" id="opt_undo" onclick="undo()" title="Undo Changes">&#60256;</div>
			<div class="opt" id="opt_save" onclick="save()" title="Save Changes">&#60890;</div>
		</div>
		<div id="tray"></div>
	</div>
</body>
</html>