<?php

require_once('../Boundio.php');

Boundio::configure('userSerialId', '');
Boundio::configure('appId', '');
Boundio::configure('authKey', '');

echo date('Y-m-d H:i:s'). "\n";

switch($_POST['action']) {
	case 'call':
		call();
		break;
	case 'status':
		status();
		break;
	case 'convert':
		convert();
		break;
	case 'upload':
		upload();
		break;
}

function call() {
	$tel_to = $_POST['tel_to'];
	$cast = explode(',', $_POST['cast']); // split by comma
	
	$result = Boundio::call($tel_to, $cast);
	var_dump($result);
}

function status() {
	$id = $_POST['_id'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	
	$result = Boundio::status($id, $start, $end);
	var_dump($result);
}

function convert() {
	$text = $_POST['text'];
	$filename = $_POST['filename'];
	
	$result = Boundio::file($text, '', $filename);
	var_dump($result);
}

function upload() {
	$file = $_POST['file'];
	$filename = $_POST['filename'];
	
	$result = Boundio::file('', $file, $filename);
	var_dump($result);
}


?>