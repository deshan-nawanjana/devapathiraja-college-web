<?php

	if(isset($_GET['list'])) {
		$type = $_GET['list'];
		$page = $_GET['page'];
		$list = scandir('editor/data/' . $type);
		$post = array();
		$dout = array();
		for($i = count($list) - 1; $i > -1; $i--) {
			if($list[$i] != '.' && $list[$i] != '..' && is_dir('editor/data/' . $type . '/' . $list[$i])) {
				array_push($post, $list[$i]);
			}
		}
		$indx = intval($page) * 5; // 5 = once load count
		for($i = $indx; $i < ($indx + 5) && $i < count($post); $i++) {
			$obj = json_decode(file_get_contents('editor/data/' . $type . '/' . $post[$i] . '/postdata.json'));
			array_push($dout, $obj);
		}
		echo json_encode($dout);
	}

	if(isset($_GET['post'])) {
		$type = $_GET['post'];
		$ptid = $_GET['ptid'];
		echo file_get_contents('editor/data/' . $type . '/' . $ptid . '/postdata.json');
	}

?>