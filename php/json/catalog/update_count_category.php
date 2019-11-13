<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request()){
	
	$id = strtoupper(hyper_escape($_GET['id']));
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "UPDATE `categories` SET `category_clicks`= `category_clicks` + 1  WHERE `id` = ?";	
	
	$arr = [];

	if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		$arr["error"] = "PREPARE FAILED";
	}

	if (!$stmt->bind_param("i",$id)){
		//TEST PURPOSES ONLY
		//echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		$arr["error"] = "BINDING FAILED";
	}

	if (!$stmt->execute()) {
		//TEST PURPOSES ONLY
		//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
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