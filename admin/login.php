<?php

	// login server and user data
	$login_key = 'dc_login';
	$login_htm = 'login.html';
	$login_acc = array(
		array(
			"username" => "admin",
			"password" => "1234",
			"usertype" => "1"
		),
		array(
			"username" => "admin_opa",
			"password" => "1234",
			"usertype" => "2"
		)
	);

	// global variables for account identification
	$account_name = "";
	$account_type = "";

	// sql database login
	$srvrname = "localhost";
	$username = "root";
	$password = "";
	$conn = new mysqli($srvrname, $username, $password);
	if($conn->connect_error) { echo "0"; exit(); }

	function sql_run($commands) {
		global $conn;
		if($conn->query($commands) === TRUE) { return 1; }
		else { return $conn->error; }
	}

	function sql_get($commands) {
		global $conn;
		$res = mysqli_query($conn, $commands);
		if(!$res) { return mysqli_error($conn); }
		else { return $res; }
	}

	// sql login database creation
	sql_run("CREATE DATABASE IF NOT EXISTS {$login_key}");
	sql_run("USE {$login_key}");
	if(sql_run("CREATE TABLE login(
		username VARCHAR(30) PRIMARY KEY,
		password VARCHAR(30),
		usertype VARCHAR(10),
		loginkey VARCHAR(30))
	") == 1) {
		// set default accounts to table
		for($i = 0; $i < count($login_acc); $i++) {
			sql_run("INSERT INTO login(username, password, usertype, loginkey) VALUES(
				'{$login_acc[$i]['username']}',
				'{$login_acc[$i]['password']}',
				'{$login_acc[$i]['usertype']}',
				''
			)");
		}
	}
	
	// random key for loginkey
	function get_rnd() {
		$today = date('YmdHi');
		$startDate = date('YmdHi', strtotime('2012-03-14 09:06:00'));
		$range = $today - $startDate;
		$rand = rand(0, $range);
		$fold =  $startDate . $rand;
		return $startDate . $rand;
	}

	// login form display function
	function frm_log() {
		global $login_htm;
		if(file_exists($login_htm)) {
			echo file_get_contents($login_htm);
		}
		exit();
	}

	// logout request check
	if(isset($_GET['logout']) || isset($_POST['logout'])) {
		sql_run("UPDATE login SET loginkey = '' WHERE username = '{$account_name}'");
		setcookie($login_key, "", time() - 3600, "/");
		echo "LOGOUT_OK";
		exit();
	}

	// form submission check
	if(isset($_POST['username']) && isset($_POST['password'])) {

		$username = $_POST['username'];
		$password = $_POST['password'];
		$uchecked = "";

		$dbresult = sql_get("SELECT * FROM login WHERE username = '{$username}' AND password = '{$password}'");
		while($user = $dbresult->fetch_assoc()) {
			if($user['username'] == $username && $user['password'] == $password) {
				global $account_name;
				global $account_type;
				$account_name = $user['username'];
				$account_type = $user['usertype'];
			}
		}

		if($account_name == "") {
			// invalid username or password
			echo "LOGIN_ERR"; exit();
		} else {
			// username and password matched
			$randkey = get_rnd();
			sql_run("UPDATE login SET loginkey = '{$randkey}' WHERE username = '{$account_name}'");
			setcookie($login_key, $randkey, time() + (86400 * 30 * 30), "/");
			echo "LOGIN_OK"; exit();
		}

	} else {
		// cookie check
		if(isset($_COOKIE[$login_key])) {
			$loginkey = $_COOKIE[$login_key];
			// check sql for matching account
			$dbresult = sql_get("SELECT * FROM login WHERE loginkey = '{$loginkey}' AND loginkey != ''");
			while($user = $dbresult->fetch_assoc()) {
					global $account_name;
					global $account_type;
					$account_name = $user['username'];
					$account_type = $user['usertype'];
			}
		} else {
			// no cookies and show login
			frm_log();
		}
	}

	// change password
	if(isset($_GET['change'])) {
		$username = $_POST['usn'];
		$password = $_POST['pwd'];
		$newpword = $_POST['npw'];

		$dbresult = sql_get("SELECT * FROM login WHERE username = '{$username}' AND password = '{$password}'");
		while($user = $dbresult->fetch_assoc()) {
			if($user['username'] == $username && $user['password'] == $password) {
				sql_run("UPDATE login SET password = '{$newpword}' WHERE username = '{$username}'");
				echo 'CHANGED_OK';
				exit();
			}
		}
	}

?>