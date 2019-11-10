<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){

	$string = strtoupper(hyper_escape($_GET['update']));
	$head = hyper_escape($_GET['head']);
	$user_type = hyper_escape($_SESSION['sessionType']);
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "UPDATE `company_profile` SET `{$head}` = ? WHERE `id` = 1";	
	
	$arr = [];
	
	if($user_type == "ADMIN" || $user_type == "STANDARD"){
		
		if (!($stmt = $con->prepare($sql))) {
			$arr['error'] = "PREPARED FAILED";
		}

		if (!$stmt->bind_param("s",$string)){
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
		$con->close();
		$arr["status"] = 2;
		echo json_encode($arr);
	}
	
}else{
	exit;
}
?>