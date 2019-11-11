<?php
require_once '../../../php/core/init.php';
require_once '../../../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../../php/classes/'.$class.'.php';
});


if(!(isset($_SESSION['sessionType']) == 1)){
	redirect::to("../../../login/?status=nosession");
}

$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql = "SELECT * FROM `company_settings` WHERE `id` = 1";
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Company Settings</title>
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
							<li><a href="./">Settings</a></li>
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
				
			</ul>
		</div>
	</div>

	<div class="content-body">

		<div class="container-fluid mt-3">
		   
			<div class="row page-titles mx-0">
				<div class="col p-md-0">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Company</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Settings</a></li>
					</ol>
				</div>
			</div>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>Company Profile</h4>
							</div>
							<div class="table-responsive">
								<div id="profileErrMsg"></div>
								<table class="table">
									<thead>
										<tr>
											<th>Support Email</th>
											<th>Home Page Count</th>
											<th>Catalog Page Count</th>
											<th>Results Per Page</th>
											<th>Date Created</th>
										</tr>
									</thead>
									<tbody>
									<?php 	
											while ($row = mysqli_fetch_row($result)){
												echo '<tr>'.
													 '<td><a href="mailto:'.$row[1].'">'.$row[1].'</a></td>'.
													 '<td>'.$row[2].'</td>'.		 
													 '<td>'.$row[3].'</td>'.
													 '<td data-id="'.$row[0].'" data-header="results_per_page" ondblclick="updateSettings(event,'.$row[0].');" >'.$row[4].'</td>'.
													 '<td>'.date("M-d-Y", strtotime($row[5])).'</td>'.
													'</tr>';
											}											
									
									?>
									</tbody>
								</table>	
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
								<li>Double click <u>Results Per Page</u> to update the value. Press the (ESC) key to cancel change and (ENTER) key to save.</li>
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
var err = document.getElementById("profileErrMsg");
var ust = document.getElementById("userType");

var editTrigger = false;

function updateSettings(e,id){
	var ee = e.target;
	var id = ee.attributes[0].nodeValue;
	var header = ee.attributes[1].nodeValue;
	var currentValue = ee.innerText;
		
	if(editTrigger != true){

		editTrigger = true;

		var inp = document.createElement("input");
			inp.type = "text";
			inp.value = currentValue;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("data-id",id);
			inp.setAttribute("data-header",header);
			inp.setAttribute("data-now",currentValue);
			inp.setAttribute("onkeyup", "settingsSave(event);");
						
			ee.innerHTML = "";
			ee.innerText = "";
			ee.appendChild(inp);
		

	}else{
		e.preventDefault();
	}
	
	
}

function settingsSave(e){
	
	if(e.keyCode === 13){
		var i = e.target;
		var head = i.attributes[1].nodeValue
		var newValue = encodeURI(i.value.toUpperCase());
		var p = i.parentNode;

		if(i.attributes[4].nodeValue != newValue){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/company/update_settings.php?value='+ newValue;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Profile has been updated successfully.</div>';
						setTimeout(function(){err.innerHTML="";},3000);
						p.innerHTML = decodeURI(newValue);
					}else if(s.status == 2){
						err.innerHTML = '<div class="alert alert-warning">Your account does not have permission to make the change.</div>';
						setTimeout(function(){err.innerHTML="";},3000);
					}else if(s.status == 3){
						err.innerHTML = '<div class="alert alert-warning">'+ s.error +'</div>';
						setTimeout(function(){err.innerHTML="";},3000);
					}
					
				}
			};
			xhr.send();
			
			editTrigger = false;
		}else{
			p.innerHTML = i.attributes[4].nodeValue.toUpperCase();
			editTrigger = false;
		}

		
		
	}else if(e.keyCode === 27){
		var i = e.target;
		var p = i.parentNode;
			p.innerHTML = i.attributes[4].nodeValue.toUpperCase();
			editTrigger = false;
	}
}
</script>
</body>
</html>