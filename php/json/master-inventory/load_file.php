<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){
	
	$item_num = hyper_escape($_GET['item']);
	$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "SELECT `data_json` FROM `master_inventory_advance` WHERE `item_number` = '{$item_num}'";
	$result = mysqli_query($con, $sql);

	$item  = [];
	
	if($result != false){
		
		
		while ($row = mysqli_fetch_row($result)){
			$item['file'] = $row[0];
		}
		
		if($item['file'] != ""){
			$file = json_decode($item['file']);

			$file_url = $file->pdf[0];
			$item['url']= $file_url;
			
			echo json_encode($item);
		}else{
			$item['url'] = "NONE";
			echo json_encode($item);
		}
		
		
	}else{
		$item['url'] = "NONE";
		echo json_encode($item);
	}
	


	
	
}else{
	exit();
}
?>