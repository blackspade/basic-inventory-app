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

	$img = json_decode($item['image']);

	$img_url = $img->images[0];
	$item['url']= $img_url;
	
	/*
	if (strlen($item['description']) > 150) {

		// truncate string
		$stringCut = substr($item['description'], 0, 150);
		$endPoint = strrpos($stringCut, ' ');

		//if the string doesn't contain any space then it will cut without word basis.
		$item['description'] = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
		$item['description'] .= '... <a href="./catalog/quote-view/?item='.$item["number"].'">Read More</a>';
	}
	
	
	echo '<div class="card mb-4 box-shadow">
			<img class="card-img-top" src="./app/master-inventory/uploads/images/'.$item['url'].'" alt="">
			<div class="card-body">
			  <p class="card-text"><u>Name</u>: '.$item['name'].'</p>
			  <p class="card-text"><u>Item #</u>: '.$item['number'].'</p>
			  <p class="card-text"><u>Description</u>: '.$item['description'].'</p>
			  <p class="card-text"><u>Category</u>: '.$item['category'].'</p> 
			  <div class="d-flex justify-content-between align-items-center">
				<div class="btn-group">
                      <a href="./catalog/quote-view/?item='.$item["number"].'" class="btn btn-sm btn-outline-secondary">View</a>
                </div>
				<p class="card-text">Price: '.$item['price'].'</p>			
			  </div>
			</div>
		  </div>';
	*/
}else{
	exit();
}
?>