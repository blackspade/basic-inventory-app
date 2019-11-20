<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){
	
	$item_num = hyper_escape($_GET['item']);
	$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "SELECT * FROM `master_inventory` WHERE `item_number` = '{$item_num}'";
	$result = mysqli_query($con, $sql);

	$item  = [];

	while ($row = mysqli_fetch_row($result)){
		$item['status'] = $row[4];
	}
	
	if($item['status'] != ""){
		echo json_encode($item);
	}else{
		$item['status'] = 'null';
		echo json_encode($item);
	}
		
	
	

}else{
	exit();
}
?>