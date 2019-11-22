<?php
require_once '../../php/core/init.php';
require_once '../../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../php/classes/'.$class.'.php';
});

if(!(isset($_GET['item'])) ){
	redirect::to("../../");
}else{

	$item = hyper_escape($_GET['item']);
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "SELECT * FROM `master_inventory` WHERE `item_number` = ?";	
	

	if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("s",$item)){
		//TEST PURPOSES ONLY
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		//TEST PURPOSES ONLY
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}else{
		$stmt->bind_result($id, $item_number,$name,$clicks,$status,$image,$video,$cat, $price, $man, $model, $year,$desc,$created,$last,$date);

	}

}
/*
$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql = "SELECT * FROM `categories` WHERE `status` = 'ACTIVE'";
$result = mysqli_query($con, $sql);
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="../../app/assets/css/homepage.css" >
	<title>Inventory Demo | Quote View</title>
	<style>
		#navBarTop{
			margin-top:30px;
		}
	</style>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="../../">Demo Inventory App</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
	  <ul class="navbar-nav ml-auto">
		<li class="nav-item">
		  <a class="nav-link" href="../">Catalog <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="../../create-account/">Create Account</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="../../login/">Login</a>
		</li>
	  </ul>
	</div>
  </nav>
</header>



<div class="container">
	<div id="navBarTop" class="row">
		<div class="col-md-12">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="../../">Home</a></li>
			<li class="breadcrumb-item"><a href="../">Catalog</a></li>
			<li class="breadcrumb-item active" aria-current="page">Quote View</li>
		  </ol>
			
		</nav>
		</div>
	</div>
	<div class="row">	
		<?php
				while ($stmt->fetch()) {
					
					$img = json_decode($image);

					$img_url = $img->images[0];	
					
					$url = "";
					
					echo "<div class='col-md-6'>
							 <img src='../../app/master-inventory/uploads/images/".$img_url."' width='100%' >	
							  
						  </div>
							
							<div class='col-md-6'>
								<div class='card card-widget'>
									<div class='card-body'>
										
											<h5 class='text-muted'>Item Details</h5>
											<p class='card-text'>Item Name: {$name}</p>
											<p class='card-text'>Item #: {$item_number}</p>
											<p class='card-text'>Description: {$desc}</p>
											<div class='d-flex justify-content-between align-items-center'>
												<div class='btn-group'>									  
												  <button type='button' data-item='{$item_number}' onclick='askQuestion(event);' class='btn btn-sm btn-outline-secondary'><i class='fa fa-question-circle-o' aria-hidden='true'></i>
 Ask Question</button>
												  <button type='button' data-item='{$item_number}' onclick='loadMoreInfo(event);' class='btn btn-sm btn-outline-primary'><i class='fa fa-info-circle' aria-hidden='true'></i>
 More Info</button>
												</div>
												<p class='card-text'>Price: {$price}</p>
											</div>
											<div id='loadMoreInfoSection'>
											
											</div>

									</div>    
									
								</div>		
							</div>";
	
				}
				
		?>			
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script>
<script>

window.onload = function(){
	var itemNum = location.search.split('item=')[1];
	logCountItem(itemNum);	
}

function loadMoreInfo(e){
	var more = document.getElementById("loadMoreInfoSection");
	var i = e.target;
	var itemNum = i.attributes[1].nodeValue;
	
	more.innerHTML  = "<div style='width:100%;margin-top:30px;' ><img class='mx-auto d-block' src='../../app/assets/images/loader.gif'></div>";
	setTimeout(function(){more.innerHTML = "";loadAdvance(itemNum, more);},1500);
	
}

function loadAdvance(i,m){
	var xhr = new XMLHttpRequest();
	var url = '../../php/json/quote/load_advance_item.php?item=' + i;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = xhr.responseText;
			m.innerHTML = s;
		}
	};
	xhr.send();
}

function askQuestion(e){
	var i = e.target;
	var itemNum = i.attributes[1].nodeValue;
	console.log(itemNum);
}

function logCountItem(i){
	var xhr = new XMLHttpRequest();
	var url = '../../php/json/catalog/update_count_item.php?item=' + i;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);
		}
	};
	xhr.send();	
}
</script>
</body>
</html>