<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){
	
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);

	$sql = "SELECT `item_number` FROM `master_inventory` WHERE `item_number` = ?";	
		
	$itemNum = hyper_escape($_GET['i']);
	
	$arr = [];
	
	if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		echo "Prepare failed:";
	}
	
	if (!$stmt->bind_param("i", $itemNum)){
		//$arr["status"] = "Binding parameters failed: (" . $stmt->errno . ") " .$stmt->error;
	}

	if (!$stmt->execute()) {
		//$arr["status"] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
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