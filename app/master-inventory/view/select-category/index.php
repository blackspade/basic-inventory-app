<?php
require_once '../../../../php/core/init.php';
require_once '../../../../php/functions/sanitize.php';
require '../../../../php/plugins/pagination/Paginator.php';

use BCR\Paginator;

spl_autoload_register(function($class){
    require_once '../../../../php/classes/'.$class.'.php';
});


if(isset($_SESSION['sessionType']) == 1){

}else{
	redirect::to("../../../../login/?status=nosession");
}

$first_connection = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$count_sql = "SELECT COUNT(*) FROM `categories`";
$count = mysqli_query($first_connection,$count_sql);
$r = mysqli_fetch_array($count);

$totalItems = $r[0];
$itemsPerPage = 15;
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
$sql = "SELECT * FROM `categories` WHERE `status` != 'DELETED' LIMIT ".$limit;
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Select Category</title>
    <link rel="icon" type="image/png" sizes="16x16" href="#">
    <link rel="stylesheet" href="../../../assets/css/style.css" >
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
				<b class="logo-abbr"><img src="../../../assets/images/logo.png" alt=""> </b>
				<span class="logo-compact"><img src="../../../assets/images/logo-compact.png" alt=""></span>
				<span class="brand-title">
					<img src="../../../assets/images/logo-text.png" alt="">
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
							<img src="../../../assets/images/user/1.png" height="40" width="40" alt="">
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
						<li><a href="../">View New Item</a></li>
						<li><a href="../../add/">Add New Item</a></li>
						<li><a href="../../edit/">Edit Items</a></li>
					</ul>
				</li>
				
				<li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false">
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Categories</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="../../../category/add/">Add Category</a></li>
						<li><a href="../../../category/edit/">Edit Category</a></li>
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
						<li class="breadcrumb-item"><a href="javascript:void(0)">New Item</a></li>
						<li class="breadcrumb-item"><a href="../">View</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Select Category</a></li>
					</ol>
				</div>
			</div>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>New Item Table</h4>
							</div>
							<div class="table-responsive">
								<div id="viewErrMsg"></div>
								<table class="table">
									<thead>
										<tr>
											<th>#</th>										
											<th>Item #</th>											
											<th>Select Category</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php 	
											echo '<tr>'.
												 '<td>'.hyper_escape($_GET['id']).'</td>'.
												 '<td>'.hyper_escape($_GET['item']).'</td>'.		 
												 '<td><select onchange="updateCategory(event);" id="category" class="form-control"><option value="0">--Please Select Category--</option>';
												 
									
											while ($row = mysqli_fetch_row($result)){
												
												echo "<option value='".$row[1]."'>".$row[1]."</option>";
													
											}
											
											echo '</select></td><td><button onclick="saveCategory(event);" type="button" class="btn mb-1 btn-primary">Save</button></td>'.
												  '</tr>';
											
											/*
											function switcher($id,$cat){
												if(empty($cat)){
													return '<button onclick="setCategory(event,'.$id.')" type="button" class="btn mb-1 btn-warning">Select Category <span class="btn-icon-right"><i class="fa fa-archive"></i></span>
                                    </button>';
												}else{
													return '<button onclick="createNewItem(event,'.$id.')" type="button" class="btn mb-1 btn-primary">Create Item <span class="btn-icon-right"><i class="fa fa-check"></i></span>
                                    </button>';
												}
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
											*/
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
								<li>Once the category has been selected press the save button. To return back to the previous page press <u>View</u> in the bread crumb.</li>
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
<script src="../../../assets/plugins/common/common.min.js"></script>
<script src="../../../assets/js/custom.min.js"></script>
<script src="../../../assets/js/settings.js"></script>
<script src="../../../assets/js/gleek.js"></script>
<script>
var err = document.getElementById("viewErrMsg");
var ust = document.getElementById("userType");
var cat = "";
var num = 0;
var id  = 0;

function updateCategory(e){
	var i = e.target;
	cat = e.target.value;
	var p = i.parentNode.parentNode.children;
	num = p[1].innerText;
	id  = p[0].innerText;
}

function saveCategory(e){
	if(cat != ""){
		var xhr = new XMLHttpRequest();
		var url = '../../../../php/json/master-inventory/update_category_new_item.php?id=' + id + "&item=" + num + "&category=" + cat;
		xhr.open('GET',url, true);
		xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4 && xhr.status == 200) {
				var s = JSON.parse(xhr.responseText);
				if(s.status == 1){
					err.innerHTML = '<div class="alert alert-success">Category has been assigned successfully.</div>';
					e.target.disabled = "disabled";
					setTimeout(function(){window.location.href="../";},2000);				
				}else if(s.status == 2){
					err.innerHTML = '<div class="alert alert-warning">Your account does not have permission to make the change.</div>';
					setTimeout(function(){err.innerHTML="";},3000);
				}
			}
		};
		xhr.send();
	}else{
		err.innerHTML = '<div class="alert alert-warning">Please select a category to save.</div>';
		setTimeout(function(){err.innerHTML="";},3000);
	}
}

</script>
</body>
</html>