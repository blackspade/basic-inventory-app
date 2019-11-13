<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request()){
	
	$item_number = strtoupper(hyper_escape($_GET['item']));
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "UPDATE `master_inventory` SET `item_clicks` = `item_clicks` + 1  WHERE `item_number` = ?";	
	
	$arr = [];

	if (!($stmt = $con->prepare($sql))) {
		$arr["error"] = "PREPARE FAILED";
	}

	if (!$stmt->bind_param("i",$item_number)){
		$arr["error"] = "BINDING FAILED";
	}

	if (!$stmt->execute()) {
		$arr["error"] = "EXECUTE FAILED";
	}else{
		$arr['status'] = 0;
		echo json_encode($arr);
		$con->close();
	}
}else{
	exit();
}
?>