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
		$item['companyName'] = $row[1];
		$item['address'] = $row[2];
		$item['addAddress'] = $row[3];
		$item['city'] = $row[4];
		$item['zip'] = $row[5];
		$item['phone'] = $row[6];
		$item['email'] = $row[7];
		$item['fax'] = $row[8];
		$item['about'] = $row[9];
	}
		
	  
	echo '<div class="col-12 col-md">
          <h5 class="d-block mb-3 text-muted">'.$item['companyName'].'</h5>
          
        </div>
        <div class="col-6 col-md">
          <p class="d-block text-muted">'.$item['address'].'</p>
		  <p class="d-block text-muted">'.$item['city'].', '.$item['zip'].'</p>
		  <p class="d-block text-muted">PHONE: '.$item['phone'].'</p>
		  <p class="d-block text-muted">FAX: '.$item['fax'].'</p>
        </div>';	  
		  
	
}else{
	exit();
}
?>