<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){

	$value = strtoupper(hyper_escape($_GET['value']));
	$user_type = hyper_escape($_SESSION['sessionType']);
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "UPDATE `company_settings` SET `results_per_page` = ? WHERE `id` = 1";	
	
	$arr = [];
	
	if($user_type == "ADMIN" || $user_type == "STANDARD"){
		
		if($value > 1 && $value < 15){
		
			if (!($stmt = $con->prepare($sql))) {
				$arr['error'] = "PREPARED FAILED";
			}

			if (!$stmt->bind_param("s",$value)){
				$arr['error'] = "BINDING FAILED";
			}

			if (!$stmt->execute()) {
				$arr['error'] = "EXECUTE FAILED";
			}else{
				$con->close();
				$arr["status"] = 1;
				echo json_encode($arr);
			}
		}else{
			$arr["status"] = 3;
			$arr['error'] = "Value has to be between 1 and 15.";
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