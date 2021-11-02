<?php

	// listing all posts
	if(isset($_GET['list'])) {
		$tmp = scandir('data/' . $_GET['list']);
		$arr = array();
		foreach($tmp as $itm) {
			if($itm != '.' && $itm != '..' && is_dir('data/' . $_GET['list'] . '/' . $itm)) {
				$obj = json_decode(file_get_contents('data/' . $_GET['list'] . '/' . $itm . '/postdata.json'));
				$tmp = new stdClass();
				$tmp->id    = $obj->id;
				$tmp->title = $obj->title;
				$tmp->date  = $obj->date;
				$tmp->count = count($obj->body);
				array_push($arr, $tmp);
			}
		}
		echo json_encode($arr);
	}

	// create new item
	if(isset($_GET['make'])) {
		$tmp = new stdClass();
		$tmp->id    = $_GET['id'];
		$tmp->type  = explode('.', $_GET['make'])[0];
		$tmp->title = 'Untitled ' . explode('s', $_GET['make'])[0];
		$tmp->body  = array();
		$tmp->date  = $_GET['date'];
		$dir = 'data/' . $_GET['make'] . '/' . $_GET['id'] . '/';
		mkdir($dir);
		$obj = fopen($dir . 'postdata.json', 'w');
		fwrite($obj, json_encode($tmp));
		fclose($obj);
	}

	// open file
	if(isset($_GET['open'])) {
		$obj = 'data/' . $_GET['open'] . '/' . $_GET['id'] . '/postdata.json';
		echo file_get_contents($obj);
	}

	// save file
	if(isset($_GET['save'])) {
		$postname = $_GET['id'];
		$postdata = $_POST['data'];

		$fold = 'data/' . $_GET['save'] . '/' . $_GET['id'] . '/';
		$json = 'data/' . $_GET['save'] . '/' . $_GET['id'] . '/postdata.json';

		$obj = json_decode($postdata)->body;
		$img = array();
		for($i = 0; $i < count($obj); $i++) {
			if($obj[$i]->type == 'snap') {
				$tmp = explode('/', $obj[$i]->data);
				array_push($img, $tmp[count($tmp) - 1]);
			}
		}

		$arr = scandir($fold);
		for($i = 0; $i < count($arr); $i++) {
			if(!in_array($arr[$i], $img) && $arr[$i] != 'postdata.json' && $arr[$i] != '.' && $arr[$i] != '..') {
				unlink($fold . $arr[$i]);
			}
		}

		$file = fopen($json, 'w');
		fwrite($file, $postdata);
		fclose($file);
	}

	// upload image
	if(isset($_GET['upload'])) {
		$filename = $_GET['name'];
		$postname = $_GET['id'];
		$location = 'data/' . $_GET['upload'] . '/' . $_GET['id'] . '/' . $filename;

		if(move_uploaded_file($_FILES['file']['tmp_name'], $location)) { 
			echo 'OK:' . $filename; 
		}
		else { 
			echo 'ERR:' . $filename; 
		}
	}

	// delete post
	if(isset($_GET['delete'])) {
		$post_idx = $_POST['id'];
		$post_dir = 'data/' . $_GET['delete'] . '/' . $_GET['id'] . '/';

		$arr = scandir($post_dir);
		for($i = 0; $i < count($arr); $i++) {
			$pid = $arr[$i];
			if($pid == '.' || $pid == '..') { continue; }
			unlink($post_dir . $arr[$i]);
		}

		rmdir($post_dir);
	}



?>