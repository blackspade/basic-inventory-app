<?php
require_once '../core/init.php';
require_once '../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../classes/'.$class.'.php';
});

if(is_ajax_request()){
	
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);

	$sql = "SELECT `email` FROM `users` WHERE `email` = ?";	
	
	$email = hyper_escape($_GET['e']);
	
	$arr = [];
	
	if (!($stmt = $con->prepare($sql))) {
		$arr["error"] = "Prepare failed";
	}

	if (!$stmt->bind_param("s", $email)){
		$arr["error"] = "Binding parameters failed";
	}

	if (!$stmt->execute()) {
		$arr["error"] = "Execute failed";
	}else{
	    $stmt->store_result();
		$c = $stmt->num_rows;
		$arr["status"] = $c;	
		echo json_encode($arr);
		$con->close();
	}
	
}else{
	exit;
}
?>