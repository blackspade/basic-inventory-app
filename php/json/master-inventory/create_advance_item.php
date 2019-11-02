<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){
	
	$id = hyper_escape($_GET['id']);
	$item_num = strtoupper(hyper_escape($_GET['itemNum']));

	$user_type = hyper_escape($_SESSION['sessionType']);
	$user = hyper_escape($_SESSION['sessionType']."|".$_SESSION['sessionId']."|".$_SESSION['name']);
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	
	$sql = "UPDATE `master_inventory` SET `item_status` = ?, `last_edit_by`= ? WHERE `id` = ?";	
	
	$status = "ACTIVE";
	
	$arr = [];
	
	if($user_type == "ADMIN" || $user_type == "STANDARD"){
		
		if (!($stmt = $con->prepare($sql))) {
			//TEST PURPOSES ONLY
			//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			$arr['error'] = "PREPARED FAILED";
		}

		if (!$stmt->bind_param("sss",$status,$user,$id)){
			//TEST PURPOSES ONLY
			//echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			$arr['error'] = "BINDING FAILED";
		}

		if (!$stmt->execute()) {
			//TEST PURPOSES ONLY
			//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			$arr['error'] = "EXECUTE FAILED";
		}else{
			$con2 = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
			$sql2 = "INSERT INTO `master_inventory_advance`(`item_number`, `created_by`,`qty`) VALUES ('{$item_num}','{$user}',1)";
			mysqli_query($con2,$sql2);
			mysqli_close($con2);
			
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
	exit();
}
?>