<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request() && isset($_SESSION['sessionType']) == 1){
	
	$first_connection = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$count_sql = "SELECT COUNT(*) FROM `categories` WHERE `status` != 'DELETED'";
	$count = mysqli_query($first_connection,$count_sql);
	$r = mysqli_fetch_array($count);
	$arr = [];

	$arr["count"] = $r[0];
	
	echo json_encode($arr);
	
	mysqli_close($first_connection);
	
	
}else{
	exit;
}
?>