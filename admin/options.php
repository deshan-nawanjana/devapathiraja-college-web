<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="bin/dnjs.min.js"></script>
	<style type="text/css">
		* {
			outline: none;
			user-select: none;
			font-family: Rubik Regular, LineIcons Regular;
		}

		body {
			margin: 30px 25px;
			overflow: hidden;
		}

		input {
			display: block;
			height: 35px;
			border: 2px solid #AAA;
			padding: 0px 10px;
			margin-bottom: 10px;
			width: 210px;
		}

		input[type=button] {
			background: #4d94ff;
			border: none;
			width: 134px;
			height: 40px;
			color: #FFF;
			cursor: pointer;
		}
		input[type=button]:hover { opacity: 0.8; }
		input[type=button]:active {
			opacity: 1;
			background: #3270cd;
		}
	</style>
	<script type="text/javascript">
		parent.postMessage("opt", "*");

		function msg(x, c) {
			id('message').style.color = c;
			id('message').innerHTML = x;
			setTimeout(function(){
				id('message').innerHTML = "";
			}, 2500);
		}

		function change() {
			var inputs = [
				id('username'),
				id('password'),
				id('newpword'),
				id('newrword')
			];

			for(var i = 0; i < inputs.length; i++) {
				if(inputs[i].value == "") {
					inputs[i].focus();
					msg("Input all the fields.", "#F00");
					return;
				}
			}

			if(inputs[2].value != inputs[3].value) {
				msg("Check new passwords again.", "#F00");
				return;
			}

			DNJS.ajax.send('login.php?change', {
				"usn" : inputs[0].value,
				"pwd" : inputs[1].value,
				"npw" : inputs[2].value
			}, function(e){
				if(e == 'CHANGED_OK') {
					msg("Password changed.", "#009933");
					inputs.forEach(function(e){
						e.value = "";
					});
				} else {
					msg("Invalid Username or Password", "#F00");
				}
			});
		}
	</script>
</head>
<body>
	<input id="username" maxlength="30" autocomplete="off" placeholder="Username" type="text">
	<input id="password" maxlength="30" autocomplete="off" placeholder="Password" type="password">
	<input id="newpword" maxlength="30" autocomplete="off" placeholder="New Password" type="password">
	<input id="newrword" maxlength="30" autocomplete="off" placeholder="Re-Enter New Password" type="password">
	<input type="button" value="Change Password" onclick="change()">
	<div id="message"></div>
</body>
</html>