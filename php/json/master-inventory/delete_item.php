<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){
	
	$item_num = hyper_escape($_GET['item']);
	$status = "DELETED";
	$user_type = hyper_escape($_SESSION['sessionType']);
	$user = hyper_escape($_SESSION['sessionType']."|".$_SESSION['sessionId']."|".$_SESSION['name']);
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "UPDATE `master_inventory` SET `item_status`= ?, `last_edit_by`= ? WHERE `item_number` = ?";	
	
	$s = "";
	$arr = [];
	
	if($user_type == "ADMIN"){
		
		if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		$arr["error"] = "PREPARE FAILED";
		}

		if (!$stmt->bind_param("sss",$status,$user,$item_num)){
			//TEST PURPOSES ONLY
			//echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			$arr["error"] = "BINDING FAILED";
		}

		if (!$stmt->execute()) {
			//TEST PURPOSES ONLY
			//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			$arr["error"] = "EXECUTE FAILED";
		}else{
			$con->close();
			$arr["status"] = 1;
			echo json_encode($arr);
		}
		
	}else{
		$con->close();
		$arr["status"] = 2;
		echo json_encode($arr);
	}
	
}else{
	exit;
}
?>