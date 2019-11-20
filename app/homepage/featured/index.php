<?php
require_once '../../../php/core/init.php';
require_once '../../../php/functions/sanitize.php';
require '../../../php/plugins/pagination/Paginator.php';

use BCR\Paginator;

spl_autoload_register(function($class){
    require_once '../../../php/classes/'.$class.'.php';
});


if(!(isset($_SESSION['sessionType']) == 1)){
	redirect::to("../../../login/?status=nosession");
}

$first_connection = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$count_sql = "SELECT COUNT(*) FROM `master_inventory`";
$count = mysqli_query($first_connection,$count_sql);
$r = mysqli_fetch_array($count);

$totalItems = $r[0];
$itemsPerPage = 5;
$currentPage = 0;

if( isset($_GET['page']) ){
	$currentPage = $_GET['page'];
}else{
	$currentPage = 1;
}

$urlPattern = '?page=(:num)';
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

$limit = ($currentPage - 1) * $itemsPerPage.',' .$itemsPerPage;

$con_item = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql_item = "SELECT * FROM `master_inventory` WHERE `item_status` = 'ACTIVE' ORDER BY `date_created` DESC LIMIT ".$limit;
$result_item = mysqli_query($con_item, $sql_item);


$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql = "SELECT * FROM `homepage_featured` WHERE  `id` = 1";
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Homepage Featured</title>
    <link rel="icon" type="image/png" sizes="16x16" href="#">
    <link rel="stylesheet" href="../../assets/css/style.css" >
	<style>
		#hints li{
			font-size: 14px;
			margin-bottom:5px;
			margin-left: 10px;
			list-style-type: circle;
		}
		.upcase{
			text-transform: uppercase;
		}
	</style>
</head>
<body>
<div id="preloader">
	<div class="loader">
		<svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
		</svg>
	</div>
</div>

<div id="main-wrapper">

	<div class="nav-header">
		<div class="brand-logo">
			<a href="../../">
				<b class="logo-abbr"><img src="../../assets/images/logo.png" alt=""> </b>
				<span class="logo-compact"><img src="../../assets/images/logo-compact.png" alt=""></span>
				<span class="brand-title">
					<img src="../../assets/images/logo-text.png" alt="">
				</span>
			</a>
		</div>
	</div>

	<div class="header">    
		<div class="header-content clearfix">
			
			<div class="header-left">
				
			</div>
			<div class="header-right">
				<ul class="clearfix">
				
					<li class="icons dropdown">
						<div class="user-img c-pointer position-relative" data-toggle="dropdown">
							<span class="activity active"></span>
							<img src="../../assets/images/user/1.png" height="40" width="40" alt="">
						</div>
						<div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
							<div class="dropdown-content-body">
								<ul>
									<li>
										<a href="../../profile/"><i class="icon-user"></i> <span>Profile</span></a>
									</li>
									<li>
										<a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a>
									</li>
									<hr class="my-2">
									<li><a href="../../../logout/"><i class="icon-key"></i> <span>Logout</span></a></li>
								</ul>
								<input type="hidden" id="userType" value="<?php echo hyper_escape($_SESSION['sessionType']);?>" />
							</div>
						</div>
					</li>
					
				</ul>
			</div>
		</div>
	</div>

	<div class="nk-sidebar">           
		<div class="nk-nav-scroll">
			<ul class="metismenu" id="menu">			
				<li class="nav-label">Actions</li>
				<li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">Company</span>
                        </a>
                        <ul aria-expanded="false">
						    <li><a href="../profile/">Profile</a></li>
							<li><a href="../settings/">Settings</a></li>
                        </ul>
                    </li>
				<li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false">
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Master Inventory</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="../../master-inventory/view/">View New Item</a></li>
						<li><a href="../../master-inventory/add/">Add New Item</a></li>
						<li><a href="../../master-inventory/edit/">Edit Items</a></li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false">
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Categories</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="../add/">Add Category</a></li>
						<li><a href="../edit">Edit Category</a></li>
					</ul>
				</li>
				
				<li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false">
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Featured Items</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="./">Homepage</a></li>
					</ul>
				</li>
				
			</ul>
		</div>
	</div>

	<div class="content-body">

		<div class="container-fluid mt-3">
		   
			<div class="row page-titles mx-0">
				<div class="col p-md-0">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Homepage</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Featured Items</a></li>
					</ol>
				</div>
			</div>
			
			 <div class="row">
					
				
				<div class="col-lg-8">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>Active Item List</h4>
							</div>
							<div class="table-responsive">
							<table class="table">
									<thead>
										<tr>
											
											<th>Item Name</th>
											<th>Item #</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
									<?php 	
											while ($row = mysqli_fetch_row($result_item)){
												
												echo '<tr>'.													 
													 '<td>'.$row[2].'</td>'.		 
													 '<td>'.$row[1].'</td>'.										
													 '<td>
														<button data-item-num="'.$row[1].'" onclick="itemAction(event);" data-action="PREVIEW" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Preview Item"><span class="fa fa-eye" aria-hidden="true"></span></button>
													 </td>'.
													 '</tr>';
													
											}
											

									?>
									</tbody>
								</table>
								<?php echo $paginator; ?>
							</div>
							
							<div>
								<div class="card-body">
									<h4 class="card-title">Quick Hints</h4>							
									<ul id="hints">
										<li>Only valid item numbers that are not disabled can be saved.</li>
										<li>Items will appear on homepage.</li>
									</ul>
								</div>
							</div>
						</div>
					</div>	
				</div>
				
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>Featured Items</h4>
							</div>
							<div id="featuredErrMsg"></div>
							<div class="table-responsive">
								

									<?php 	
											while ($row = mysqli_fetch_row($result)){
												echo	'<div class="input-group mb-3">'.
														'<div class="input-group-prepend">'.
														'<span class="input-group-text" id="basic-addon3">Featured Item</span>'.
														'</div>'.
														'<input type="text" data-header="item_one" onblur="checkItem(event);" id="one" class="form-control" value="'.$row[1].'">'.
														'</div>';
												echo	'<div class="input-group mb-3">'.
														'<div class="input-group-prepend">'.
														'<span class="input-group-text" id="basic-addon3">Featured Item</span>'.
														'</div>'.
														'<input type="text" data-header="item_two" onblur="checkItem(event);"  id="two" class="form-control" value="'.$row[2].'">'.
														'</div>';	
												echo	'<div class="input-group mb-3">'.
														'<div class="input-group-prepend">'.
														'<span class="input-group-text" id="basic-addon3">Featured Item</span>'.
														'</div>'.
														'<input type="text" data-header="item_three" onblur="checkItem(event);" id="three" class="form-control" value="'.$row[3].'">'.
														'</div>';	
												
												$json = json_decode($row[4]);
												
												switch($json->status){
													case 'disabled':
														echo '<select id="status" class="form-control"> <option value="enabled">Enabled</option> <option value="disabled" selected>Disabled</option> </select>';
													break;
													case 'enabled':
														echo '<select id="status" class="form-control"> <option value="enabled" selected>Enabled</option> <option value="disabled">Disabled</option> </select>';
													break;
												};
												
												echo '<br /><button onclick="saveBtn(event);" class="btn btn-primary">Save</button>';
												
											}											
									?>
									
							</div>
							
				
							
						</div>
						<hr />
							
							
						<div>
							<div class="card-body">
								<div class="card-title">
									<h4>Item Preview</h4>
								</div>
								<div id="itemPreviewLoad" class="table-responsive">
								
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				
			</div>
			
			
		</div>
	</div>
	
	<div class="footer">
		<div class="copyright">
			<p>Copyright &copy; Designed & Developed by <a href="#">BCR Web Developers LLC.</a> 2019</p>
		</div>
	</div>

</div>
<script src="../../assets/plugins/common/common.min.js"></script>
<script src="../../assets/js/custom.min.js"></script>
<script src="../../assets/js/settings.js"></script>
<script src="../../assets/js/gleek.js"></script>
<script>
var err = document.getElementById("featuredErrMsg");
var ust = document.getElementById("userType");
var ipl = document.getElementById("itemPreviewLoad");

function saveBtn(e){
	var o = document.getElementById("one");
	var t = document.getElementById("two");
	var r = document.getElementById("three");
	var s = document.getElementById("status");
	
	if(o.value != "" && !(o.length < 6)){
		
	}else{
		err.innerHTML = '<div class="alert alert-info">Item # is invalid!</div>';
		setTimeout(function(){err.innerHTML = "";},3000);
	}
}


function checkItem(e){
	var i   = e.target;
	var a = i.attributes[1].nodeValue;
	var itemNum = i.value;
	if(!(itemNum.length < 6)){
	
		var xhr = new XMLHttpRequest();
		var url = '../../../php/json/featured/check_item_status.php?item=' + itemNum;
		xhr.open('GET',url, true);
		xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4 && xhr.status == 200) {
				var s = JSON.parse(xhr.responseText);
				if(s.status == 'null'){
					err.innerHTML = '<div class="alert alert-info">Item # does not exist</div>';
					setTimeout(function(){err.innerHTML = "";},3000);
					i.value = "";
				}	
			}
		};
		xhr.send();
	}else{
		err.innerHTML = '<div class="alert alert-warning">Please check Item #</div>';
		setTimeout(function(){err.innerHTML = "";},3000);
	}
}

function itemAction(e){
	var evt = e.target;
	var e;
	if(evt.localName != "button"){
		e = evt.parentNode;		
	}else{
		e = evt;
	}
	var itemNum = e.attributes[0].nodeValue;
	var action = e.attributes[2].nodeValue;
	
	
	var xhr = new XMLHttpRequest();
	var url = '../../../php/json/featured/load_featured_preview.php?item=' + itemNum;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = xhr.responseText;
			ipl.innerHTML = s;
		}
	};
	xhr.send();	
	
}

</script>
</body>
</html>