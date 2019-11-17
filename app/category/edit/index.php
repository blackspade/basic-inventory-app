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
$count_sql = "SELECT COUNT(*) FROM `categories`";
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

$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql = "SELECT * FROM `categories` ORDER BY `date_created` DESC LIMIT ".$limit;
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Edit Categories</title>
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
						<li><a href="../../company/profile/">Profile</a></li>
						<li><a href="../../company/settings/">Settings</a></li>
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
						<li><a href="./">Edit Category</a></li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false">
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Featured Items</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="../../homepage/featured/">Homepage</a></li>
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
						<li class="breadcrumb-item"><a href="javascript:void(0)">Categories</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
					</ol>
				</div>
			</div>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>Category Table</h4>
							</div>
							<div class="table-responsive">
								<div id="catEditErrMsg"></div>
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Category Name</th>
											<th>Status</th>
											<th>Click Count</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
									<?php 	
											while ($row = mysqli_fetch_row($result)){
												echo '<tr>'.
													 '<td>'.$row[0].'</td>'.
													 '<td ondblclick="ucn(event,'.$row[0].');" >'.$row[1].'</td>'.		 
													 '<td>'.create_select_box($row[2],$row[0]).'</td>'.
													 '<td>'.$row[3].'</td>'.
													 '<td><button class="btn btn-danger" type="button" onclick="deleteCat('.$row[0].',\''.$row[2].'\');"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'.
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
								<li>Double click the <u>Category Name</u> to update the text. Press the (ESC) key to cancel change and (ENTER) key to save.</li>
								<li>Only an admin can delete a category.</li>
								<li>The column <u>Click Count</u> keeps track of how many times the category has been clicked on the front-end.</li>
								<li>WARNING: If the item have already been assigned a category please find the item and reassign the category.</li>
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
var err = document.getElementById("catEditErrMsg");
var ust = document.getElementById("userType");

var editTrigger = false;

function ucns(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[3].nodeValue;
		var nv = i.value.toUpperCase();
		var p = i.parentNode;
		
		if(i.attributes[2].nodeValue != nv){
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/category/update_category_name.php?id=' + id + "&c=" + nv;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Category #'+ id + ' has been updated.</div>';
						setTimeout(function(){err.innerHTML="";},3000);
						p.innerHTML = nv;
					}else if(s.status == 2){
						err.innerHTML = '<div class="alert alert-warning">Your account does not have permission to make the change.</div>';
						setTimeout(function(){err.innerHTML="";},3000);
					}
				}
			};
			xhr.send();
			editTrigger = false;
		}else{
			p.innerHTML = i.attributes[2].nodeValue.toUpperCase();
			editTrigger = false;
		}

		
		
	}else if(e.keyCode === 27){
		var i = e.target;
		var p = i.parentNode;
			p.innerHTML = i.attributes[2].nodeValue.toUpperCase();
			editTrigger = false;
	}
}

function ucn(e,id){
	var t = e.target;
	var cn = e.target.innerText;
	
	if(editTrigger != true){
	
		editTrigger = true;
	
		var inp = document.createElement("input");
			inp.type = "text";
			inp.value = cn;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("cat-pre",cn);
			inp.setAttribute("id",id);
			inp.setAttribute("onkeyup", "ucns(event);");
			t.innerHTML = "";
			t.innerText = "";
		
		t.appendChild(inp);
	}else{
		e.preventDefault();
	}
}

function deleteCat(i,s){
	if(s != "DELETED" && ust.value == "ADMIN"){
		var r = confirm("Please confirm to delete this category.");
		if(r == true){
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/category/delete_category.php?id=' + i + "&s=" + s;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Item #'+ i + ' has been deleted.</div>';
						setTimeout(function(){location.reload();},1000);
					}
				}
			};
			xhr.send();
		}
	}else{
		err.innerHTML = '<div class="alert alert-warning">Only an admin can delete a category.</div>';
		setTimeout(function(){err.innerHTML="";},3000);
	}
}

function us(e){
	var i = e.target.id;
	var s = e.target.value;
	var xhr = new XMLHttpRequest();
	var url = '../../../php/json/category/update_status.php?id=' + i + "&s=" + s;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);
			if(s.status == 1){
				err.innerHTML = '<div class="alert alert-success">Item #'+ i + ' has been updated.</div>';
				setTimeout(function(){err.innerHTML="";},3000);
			}
		}
	};
	xhr.send();
}
</script>
</body>
</html>