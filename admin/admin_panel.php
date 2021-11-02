<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<style type="text/css">
		body {
			margin: 0px;
			overflow: hidden;
		}
		#frame {
			width: 100vw;
			height: 100vh;
			border: none;
			position: fixed;
			top: 0px;
			left: 0px;
			z-index: 0;
		}
		select, option {
			border: 1px solid #cccccc;
			width: 160px;
			height: 40px;
			outline: none;
			position: fixed;
			top: 0px;
			left: 0px;
			z-index: 1;
			padding: 0px 10px;
			background: #cccccc;
		}
	</style>
	<script type="text/javascript" src="bin/dnjs.min.js"></script>
	<script type="text/javascript">
		function loadManager(x) {
			id('frame').src = 'bin/m/' + x + '/?' + Date.now();
		}
		window.addEventListener('load', function(){
			loadManager('n');
		});
	</script>
</head>
<body>

	<select onchange="loadManager(this.value)">
		<option value="n">Notices Manager</option>
		<option value="e">Events Manager</option>
		<option value="a">Albums Manager</option>
	</select>

	<iframe id="frame"></iframe>

</body>
</html>