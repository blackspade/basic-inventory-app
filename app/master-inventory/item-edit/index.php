<?php
require_once '../../../php/core/init.php';
require_once '../../../php/functions/sanitize.php';

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
$sql = "SELECT * FROM `master_inventory` WHERE `item_number` = '{$item_num}'";
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Item Edit</title>
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
						<li><a href="../view">View New Item</a></li>
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
						<li class="breadcrumb-item"><a href="../edit/">Active Item</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Item Edit</a></li>
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
								<div id="newEditErrMsg"></div>
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Item Name</th>
											<th>Item #</th>
											<th>Manufacturer</th>
											<th>Model</th>
											<th>Year</th>
											<th>Price</th>
											<th>Description</th>
											
										</tr>
									</thead>
									<tbody>
									<?php 	
											while ($row = mysqli_fetch_row($result)){
												
												echo '<tr>'.
													 '<td data-toggle="tooltip" data-placement="top" title="'.$row[7].'">'.$row[0].'</td>'.
													 '<td ondblclick="uin(event,'.$row[0].');" >'.$row[2].'</td>'.		 
													 '<td>'.$row[1].'</td>'.
													 '<td ondblclick="um(event,'.$row[0].');" >'.$row[9].'</td>'.	
													 '<td ondblclick="umd(event,'.$row[0].');" >'.$row[10].'</td>'.
													 '<td ondblclick="uy(event,'.$row[0].');" >'.$row[11].'</td>'.
													 '<td ondblclick="up(event,'.$row[0].');" >'.$row[8].'</td>'.
													 '<td ondblclick="ud(event,'.$row[0].');">'.$row[12].'</td>'.
													 
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
								<li>Double click the <u>Item Name</u>, <u>Manufacturer</u>, <u>Model</u>, <u>Year</u>, <u>Price</u> and <u>Description</u> to update the text. Press the (ESC) key to cancel change and (ENTER) key to save.</li>
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
var err = document.getElementById("newEditErrMsg");
var ust = document.getElementById("userType");
var editTrigger = false;

window.onload = function(){
	var stat = location.search.split('status=')[1];
	var item = location.search.split('item=')[1];
	if(stat == "0"){
		err.innerHTML = "<div class='alert alert-success'>Item has been created successfully.</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}
	
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

function uin(e,id){
	var t = e.target;
	var itn = e.target.innerText;
	
	if(editTrigger != true){
	
		editTrigger = true;
	
		var inp = document.createElement("input");
			inp.type = "text";
			inp.value = itn;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("cat-pre",itn);
			inp.setAttribute("id",id);
			inp.setAttribute("onkeyup", "uins(event);");
			t.innerHTML = "";
			t.innerText = "";
		
		t.appendChild(inp);
	}else{
		e.preventDefault();
	}
}

function uins(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[3].nodeValue;
		var nv = i.value.toUpperCase();
		var p = i.parentNode;
		var table = "item_name";
		
		if(i.attributes[2].nodeValue != nv){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_new_item_table.php?id=' + id + "&update=" + nv + "&table=" + table;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Item Name has been updated.</div>';
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

function um(e,id){
	var t = e.target;
	var itn = e.target.innerText;
	
	if(editTrigger != true){
	
		editTrigger = true;
	
		var inp = document.createElement("input");
			inp.type = "text";
			inp.value = itn;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("cat-pre",itn);
			inp.setAttribute("id",id);
			inp.setAttribute("onkeyup", "ums(event);");
			t.innerHTML = "";
			t.innerText = "";
		
		t.appendChild(inp);
	}else{
		e.preventDefault();
	}
}

function ums(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[3].nodeValue;
		var nv = i.value.toUpperCase();
		var p = i.parentNode;
		var table = "manufacturer";
		
		if(i.attributes[2].nodeValue != nv){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_new_item_table.php?id=' + id + "&update=" + nv + "&table=" + table;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Manufacturer has been updated.</div>';
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

function umd(e,id){
	var t = e.target;
	var itn = e.target.innerText;
	
	if(editTrigger != true){
	
		editTrigger = true;
	
		var inp = document.createElement("input");
			inp.type = "text";
			inp.value = itn;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("cat-pre",itn);
			inp.setAttribute("id",id);
			inp.setAttribute("onkeyup", "umds(event);");
			t.innerHTML = "";
			t.innerText = "";
		
		t.appendChild(inp);
	}else{
		e.preventDefault();
	}
}

function umds(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[3].nodeValue;
		var nv = i.value.toUpperCase();
		var p = i.parentNode;
		var table = "model";
		
		if(i.attributes[2].nodeValue != nv){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_new_item_table.php?id=' + id + "&update=" + nv + "&table=" + table;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Model has been updated.</div>';
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

function uy(e,id){
	var t = e.target;
	var itn = e.target.innerText;
	
	if(editTrigger != true){
	
		editTrigger = true;
	
		var inp = document.createElement("input");
			inp.type = "text";
			inp.value = itn;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("cat-pre",itn);
			inp.setAttribute("id",id);
			inp.setAttribute("onkeyup", "uys(event);");
			t.innerHTML = "";
			t.innerText = "";
		
		t.appendChild(inp);
	}else{
		e.preventDefault();
	}
}

function uys(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[3].nodeValue;
		var nv = i.value.toUpperCase();
		var p = i.parentNode;
		var table =  "year";
		
		if(i.attributes[2].nodeValue != nv){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_new_item_table.php?id=' + id + "&update=" + nv + "&table=" + table;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Year has been updated.</div>';
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

function up(e,id){
	var t = e.target;
	var itn = e.target.innerText;
	
	if(editTrigger != true){
	
		editTrigger = true;
	
		var inp = document.createElement("input");
			inp.type = "text";
			inp.value = itn;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("cat-pre",itn);
			inp.setAttribute("id",id);
			inp.setAttribute("onkeyup", "ups(event);");
			t.innerHTML = "";
			t.innerText = "";
		
		t.appendChild(inp);
	}else{
		e.preventDefault();
	}
}

function ups(e){
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[3].nodeValue;
		var nv = i.value.toUpperCase();
		var p = i.parentNode;
		var table = "item_price";
		
		if(i.attributes[2].nodeValue != nv){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_new_item_table.php?id=' + id + "&update=" + nv + "&table=" + table;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Price has been updated.</div>';
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

function ud(e,id){
	var t = e.target;
	var itn = e.target.innerText;
	
	if(editTrigger != true){
	
		editTrigger = true;
	
		var inp = document.createElement("textarea");
			inp.type = "text";
			inp.value = itn;
			inp.setAttribute("class", "form-control upcase");
			inp.setAttribute("cat-pre",itn);
			inp.setAttribute("id",id);
			inp.setAttribute("onkeyup", "uds(event);");
			t.innerHTML = "";
			t.innerText = "";
		
		t.appendChild(inp);
		
	}else{
		e.preventDefault();
	}
}

function uds(e){
	
	if(e.keyCode === 13){
		var i = e.target;
		var id = i.attributes[2].nodeValue;
		var nv = i.value.toUpperCase();
		var p = i.parentNode;
		var table = "description";
		
		if(i.attributes[2].nodeValue != nv){
			
			var xhr = new XMLHttpRequest();
			var url = '../../../php/json/master-inventory/update_new_item_table.php?id=' + id + "&update=" + nv + "&table=" + table;
			xhr.open('GET',url, true);
			xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					var s = JSON.parse(xhr.responseText);
					if(s.status == 1){
						err.innerHTML = '<div class="alert alert-success">Description has been updated.</div>';
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
			p.innerHTML = i.attributes[1].nodeValue.toUpperCase();
			editTrigger = false;
	}
}
</script>
</body>
</html>