<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){
	
	$o    = hyper_escape($_GET['one']);
	$t    = hyper_escape($_GET['two']);
	$r    = hyper_escape($_GET['three']);
	$s    = hyper_escape($_GET['status']);
	
	
	$status = "";
	switch($s){
		case "enabled":
			$status = "{\"status\":\"enabled\"}";
		break;
		
		case "disabled":
			$status  = "{\"status\":\"disabled\"}";
		break;
			
	}
	
	$user_type = hyper_escape($_SESSION['sessionType']);
	$user = hyper_escape($_SESSION['sessionType']."|".$_SESSION['sessionId']."|".$_SESSION['name']);
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "UPDATE `homepage_featured` SET `item_one`= ? ,`item_two`= ?,`item_three`= ?, `data_json`= '{$status}' WHERE `id` = 1";
	
	$arr = [];
	
	if($user_type == "ADMIN" || $user_type == "STANDARD"){
		
		if (!($stmt = $con->prepare($sql))) {
			$arr['error'] = "PREPARED FAILED";
		}

		if (!$stmt->bind_param("sss",$o,$t,$r)){
			$arr['error'] = "BINDING FAILED";
		}

		if (!$stmt->execute()) {
			$arr['error'] = "EXECUTE FAILED";
		}else{
			$con->close();
			$arr["status"] = 0;
			echo json_encode($arr);
		}
		
	}else{
		$con->close();
		$arr["status"] = 1;
		echo json_encode($arr);
	}
	
}else{
	exit;
}
?>