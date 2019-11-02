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
$itemsPerPage = 10;
$currentPage = 0;

if( isset($_GET['page']) ){
	$currentPage = $_GET['page'];
}else{
	$currentPage = 1;
}

$urlPattern = '?page=(:num)';
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

$limit = ($currentPage - 1) * $itemsPerPage.',' .$itemsPerPage;

$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql = "SELECT * FROM `master_inventory` WHERE `item_status` = 'ACTIVE' ORDER BY `date_created` DESC LIMIT ".$limit;
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Edit Item</title>
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
										<a href="#"><i class="icon-user"></i> <span>Profile</span></a>
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
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Master Inventory</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="../view">View New Item</a></li>
						<li><a href="../add/">Add New Item</a></li>
						<li><a href="./">Edit Items</a></li>
					</ul>
				</li>
				
				<li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false">
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Categories</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="../../category/add/">Add Category</a></li>
						<li><a href="../../category/edit/">Edit Category</a></li>
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
						<li class="breadcrumb-item"><a href="javascript:void(0)">Active Item</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
					</ol>
				</div>
			</div>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>Edit Item Table</h4>
							</div>
							<div class="table-responsive">
								<div id="EditErrMsg"></div>
								<table class="table">
									<thead>
										<tr>
											
											<th>Item Name</th>
											<th>Item #</th>
											<th># of Clicks</th>
											<th>Current Status</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
									<?php 	
											while ($row = mysqli_fetch_row($result)){
												
												echo '<tr>'.													 
													 '<td>'.$row[2].'</td>'.		 
													 '<td>'.$row[1].'</td>'.
													 '<td>'.$row[3].'</td>'.
													 '<td>'.create_select_box($row[4],$row[0]).'</td>'.											
													 '<td>
														<button data-item-num="'.$row[1].'" onclick="itemAction(event);" data-action="PREVIEW" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Preview Item"><span class="fa fa-eye" aria-hidden="true"></span></button>
														<button data-item-num="'.$row[1].'" onclick="itemAction(event);" data-action="ADD" class="btn btn-info"  data-toggle="tooltip" data-placement="top" title="Add Advance Data"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
														<button data-item-num="'.$row[1].'" onclick="itemAction(event);" data-action="EDIT" class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Edit Item"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
														<button data-item-num="'.$row[1].'" onclick="itemAction(event);" data-action="DELETE" class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Deleted Item"><i class="fa fa-trash" aria-hidden="true"></i></button>
													 </td>'.
													 '</tr>';
													
											}
											
											function create_select_box($status,$id){
												switch ($status) {
													
													case "ACTIVE":
														return "<select id='{$id}' onchange='us(event);' name='status' class='form-control-sm'><option value='ACTIVE' selected='selected'>Active</option><option value='DISABLED' >Disabled</option></select>";
														break;
													case "DISABLED":
														return "<select id='{$id}' onchange='us(event);' name='status' class='form-control-sm'><option value='ACTIVE'>Active</option><option value='DISABLED' selected='selected'>Disabled</option></select>";
														break;
													case "DELETED":
														return "<select id='{$id}' disabled='disabled' name='status' class='form-control-sm'><option value='ACTIVE'>Active</option><option value='DISABLED'>Disabled</option><option value='DELETED' selected='selected'>Deleted</option></select>";
														break;
												}		
											}
									?>
									</tbody>
								</table>
								<?php echo $paginator; ?>
							</div>
						</div>
					</div>
				</div>	
			</div>
			
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Quick Hints</h4>							
							<ul id="hints">
								<li>Hover over the action buttons to see what operations can be performed.</li>
							</ul>
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
var err = document.getElementById("EditErrMsg");
var ust = document.getElementById("userType");
var editTrigger = false;

window.onload = function(){
	var myParam = location.search.split('status=')[1];
	if(myParam == "0"){
		//err.innerHTML = "<div class='alert alert-success'>Item has been created successfully.</div>";
		//setTimeout(function(){err.innerHTML="";},3000);
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
	
	
	switch(action) {
	  case "PREVIEW":
		window.location.href="../preview/?item=" + itemNum;
		break;
	  case "ADD":
		window.location.href="../advance/?item=" + itemNum;
		break;
	  case "EDIT":
		console.log(itemNum + "E");
		break;
      case "DELETE":
		console.log(itemNum + "D");
		break; 		
	  default:
		console.log("CASE SWITCH FAILED!");
	} 
	
}

function us(e){
	var i = e.target.id;
	var ss = e.target.value;

	
	var xhr = new XMLHttpRequest();
	var url = '../../../php/json/master-inventory/update_status.php?id=' + i + "&s=" + ss;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);
			if(s.status == 1){
				err.innerHTML = '<div class="alert alert-success">Status has been updated successfully.</div>';
				setTimeout(function(){err.innerHTML="";},3000);
			}
		}
	};
	xhr.send();	
	
}

</script>
</body>
</html>