<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request()){
	
	$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "SELECT * FROM `company_profile` WHERE `id` = 1";
	$result = mysqli_query($con, $sql);

	$item  = [];

	while ($row = mysqli_fetch_row($result)){
		$item['about'] = $row[9];
	}
		
	
	echo '<h5 class="d-block mb-3 text-muted">About</h5><p class="d-block text-muted">'.$item['about'].'</p>';
	
}else{
	exit();
}
?>