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

if(!(isset($_GET['item'])) || strlen($_GET['item']) < 6 ){
	redirect::to("../edit/");
}

$item_num = hyper_escape($_GET['item']);
$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql = "SELECT * FROM `master_inventory_advance` WHERE `item_number` = '{$item_num}'";
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Advance</title>
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
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Master Inventory</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="./">View New Item</a></li>
						<li><a href="../add/">Add New Item</a></li>
						<li><a href="../edit/">Edit Items</a></li>
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
						<li class="breadcrumb-item"><a href="javascript:void(0)">Master Inventory</a></li>
						<li data-toggle="tooltip" data-placement="bottom" title="Return back to previous page." class="breadcrumb-item"><a href="../edit/">Edit Item</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Advance Description</a></li>
					</ol>
				</div>
			</div>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>Advance Description Item Table</h4>
							</div>
							<div class="table-responsive">
								<div id="advanceErrMsg"></div>
								<table class="table">
									<thead>
										<tr>
											<th>Item #</th>
											<th data-toggle="tooltip" data-placement="bottom" title="Horsepower" >HP</th>
											<th data-toggle="tooltip" data-placement="bottom" title="Cubic Feet/Min." >CFM</th>
											<th>Design</th>
											<th data-toggle="tooltip" data-placement="bottom" title="Pounds/Sq. Inch" >PSI</th>
											<th>Series</th>
											<th data-toggle="tooltip" data-placement="bottom" title="Computer Numerical Control" >CNC</th>
											<th data-toggle="tooltip" data-placement="bottom" title="Revolutions/Min." >RPM</th>
											<th>Type</th>
											<th>Features</th>
											<th data-toggle="tooltip" data-placement="bottom" title="Max Length of 1500 Charaters" >Long Description</th>											
										</tr>
									</thead>
									<tbody>
									<?php 	
											while ($row = mysqli_fetch_row($result)){
												
												echo '<tr>'.
														'<td  >'.$row[1].'</td>'.
														'<td data-item="'.$row[1].'" data-header="hp" ondblclick="updateAdvance(event,'.$row[0].');"  >'.$row[2].'</td>'.
														'<td data-item="'.$row[1].'" data-header="cfm" ondblclick="updateAdvance(event,'.$row[0].');"  >'.$row[3].'</td>'.
														'<td data-item="'.$row[1].'" data-header="design" ondblclick="updateAdvance(event,'.$row[0].');" >'.$row[4].'</td>'.
														'<td data-item="'.$row[1].'" data-header="psi" ondblclick="updateAdvance(event,'.$row[0].');" >'.$row[5].'</td>'.
														'<td data-item="'.$row[1].'" data-header="series" ondblclick="updateAdvance(event,'.$row[0].');" >'.$row[6].'</td>'.
														'<td data-item="'.$row[1].'" data-header="cnc" ondblclick="updateAdvance(event,'.$row[0].');" >'.$row[7].'</td>'.
														'<td data-item="'.$row[1].'" data-header="rmp" ondblclick="updateAdvance(event,'.$row[0].');" >'.$row[9].'</td>'.
														'<td data-item="'.$row[1].'" data-header="type" ondblclick="updateAdvance(event,'.$row[0].');">'.$row[10].'</td>'.
														'<td data-item="'.$row[1].'" data-header="features" ondblclick="updateAdvance(event,'.$row[0].');">'.$row[11].'</td>'.
														'<td data-item="'.$row[1].'" data-header="long_description" ondblclick="updateAdvance(event,'.$row[0].');">'.$row[8].'</td>'.
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
								<li>Double click the <u>HP</u>, <u>CFM</u>, <u>Design</u>, <u>PSI</u>, <u>Series</u> , <u>CNC</u> , <u>RMP</u> and <u>Logn Description</u> to update the text. Press the (ESC) key to cancel change and (ENTER) key to save.</li>
								<li>Click <u>Edit Item</u> in the bread crumb to return to the previous page.</li>
							</ul>
						</div>
					</div>	
				</div>  
				
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Item Preview</h4>	
							<div id="preivewLoad" class="table-responsive">
							
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
var err = document.getElementById("advanceErrMsg");
var ust = document.getElementById("userType");
var editTrigger = false;

window.onload = function(){
	var item = location.search.split('item=')[1];	
	loadPreview(item);
}

function loadPreview(i){
	var item = i;
	var container = document.getElementById("preivewLoad");
	var xhr = new XMLHttpRequest();
	var url = '../../../php/json/master-inventory/load_preview.php?item=' + item;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);			
			container.innerHTML = "<div id=\'preview\'><img src=\'../uploads/images/" + s.url + "\' width=\'250px\' /></div><table style=\'width:100%\' class=\'table\'><thead><tr><th>Item Name</th><th>Category</th><th>Price</th></tr></thead><tbody><tr><td>" + s.name + "</td><td>"+ s.category + "</td><td>" + s.price + "</td></tr></tbody></table><h4>Description</h4>" + s.description + "</p>";	
		}
	};
	xhr.send();	
}

function updateAdvance(e,id){
	var ee = e.target;
	var itemNum = ee.attributes[0].nodeValue;
	var header = ee.attributes[1].nodeValue;
	var currentValue = ee.innerText;
	
	if(editTrigger != true){
	
		if(header != "long_description"){
			
			editTrigger = true;
	
			var inp = document.createElement("input");
				inp.type = "text";
				inp.value = currentValue;
				inp.setAttribute("class", "form-control upcase");
				inp.setAttribute("data-item",itemNum);
				inp.setAttribute("data-header",header);
				inp.setAttribute("data-previous",currentValue);
				inp.setAttribute("data-id",id);
				inp.setAttribute("onkeyup", "advanceSave(event);");
				
				switch(header) {
				  case "hp":
					inp.setAttribute("maxlength",20);
					break;
				  case "cfm":
					inp.setAttribute("maxlength",20);
					break;
				  case "design":
					inp.setAttribute("maxlength",20);
					break;
				  case "psi":
					inp.setAttribute("maxlength",20);
					break;
				 case "cnc":
					inp.setAttribute("maxlength",20);
					break;	
				 case "rpm":
					inp.setAttribute("maxlength",20);
					break;	
			 	 case "type":
					inp.setAttribute("maxlength",20);
					break;	
				 case "series":
				 	inp.setAttribute("maxlength",30);
					break;	
				 case "features":
				 	inp.setAttribute("maxlength",150);
					break;	
				} 
				
				
				
				ee.innerHTML = "";
				ee.innerText = "";
				ee.appendChild(inp);
				
		}else{
			
			editTrigger = true;
			
			var inp = document.createElement("textarea");
				inp.type = "text";
				inp.value = currentValue;
				inp.setAttribute("class", "form-control upcase");
				inp.setAttribute("data-item",itemNum);
				inp.setAttribute("data-header",header);
				inp.setAttribute("data-previous",currentValue);
				inp.setAttribute("data-id",id);
				inp.setAttribute("onkeyup", "longDescriptionSave(event);");
				ee.innerHTML = "";
				ee.innerText = "";
		
			ee.appendChild(inp);
			
		}

		
	}else{
		e.preventDefault();
	}
	
}

function longDescriptionSave(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[4].nodeValue;
		var item = i.attributes[1].nodeValue;
		var newValue = encodeURI(i.value.toUpperCase());
		var p = i.parentNode;
		var head = i.attributes[2].nodeValue
		
		if(i.attributes[4].nodeValue != newValue){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_advance.php?id=' + id + "&update=" + newValue + "&head=" + head + "&item=" + item;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Item Name has been updated.</div>';
						setTimeout(function(){err.innerHTML="";},3000);
						p.innerHTML = decodeURI(newValue);
					}else if(s.status == 2){
						err.innerHTML = '<div class="alert alert-warning">Your account does not have permission to make the change.</div>';
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
			p.innerHTML = i.attributes[3].nodeValue.toUpperCase();
			editTrigger = false;
	}
}

function advanceSave(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[5].nodeValue;
		var item = i.attributes[2].nodeValue;
		var newValue = encodeURI(i.value.toUpperCase());
		var p = i.parentNode;
		var head = i.attributes[3].nodeValue
		
		
		
		if(i.attributes[4].nodeValue != newValue){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_advance.php?id=' + id + "&update=" + newValue + "&head=" + head + "&item=" + item;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Item Name has been updated.</div>';
						setTimeout(function(){err.innerHTML="";},3000);
						p.innerHTML = decodeURI(newValue);
					}else if(s.status == 2){
						err.innerHTML = '<div class="alert alert-warning">Your account does not have permission to make the change.</div>';
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