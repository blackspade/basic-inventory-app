<?php
require_once '../../../php/core/init.php';
require_once '../../../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../../php/classes/'.$class.'.php';
});

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$item_name = strtoupper(hyper_escape($_POST['itemName']));
	$item_numb = hyper_escape($_POST['itemNumber']);
	$mnftr     = strtoupper(hyper_escape($_POST['manufacturer']));
	$model     = strtoupper(hyper_escape($_POST['model']));
	$year      = hyper_escape($_POST['year']);
	$desc      = strtoupper(hyper_escape($_POST['description']));
	$price     = hyper_escape($_POST['price']);
	
	$user_type = hyper_escape($_SESSION['sessionType']);
	$user = hyper_escape($_SESSION['sessionType']."|".$_SESSION['sessionId']."|".$_SESSION['name']);
	$status = "NEW";
	
	$target_dir = "../uploads/images/";
	$target_file = $target_dir.basename($_FILES["masterInventoryImage"]["name"]);
	$check = getimagesize($_FILES["masterInventoryImage"]["tmp_name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$uploadOk = 1;
	
	if($check == false) {
        //redirect::to($_SERVER['PHP_SELF']."?status=1");
    } 
	
	if ($_FILES["masterInventoryImage"]["size"] > 5000000) {
		redirect::to($_SERVER['PHP_SELF']."?status=2");
	}
	
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
		redirect::to($_SERVER['PHP_SELF']."?status=3");
	}
	
	$temp = explode(".",$_FILES["masterInventoryImage"]["name"]);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	
	$arr = [];
	$i = array($newfilename);
	$arr["images"]= $i;
	
	$json_images = json_encode($arr);
	
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	
	$sql = "INSERT INTO `master_inventory`(`item_number`, `item_name`,  `item_status`, `item_image_dir`, `item_price`, `manufacturer`, `model`, `year`, `description`, `created_by`) VALUES (?,?,?,?,?,?,?,?,?,?)";
	
	if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("isssssssss",$item_numb,$item_name,$status,$json_images,$price,$mnftr,$model,$year,$desc,$user)){
		//TEST PURPOSES ONLY
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	if (!$stmt->execute()) {
		//TEST PURPOSES ONLY
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}else{
		move_uploaded_file($_FILES["masterInventoryImage"]["tmp_name"], $target_dir.$newfilename);
		redirect::to($_SERVER['PHP_SELF']."?status=0");
	}
	
}

if(isset($_SESSION['sessionType']) == 1){

	
}else{
	redirect::to("../../../login/?status=nosession");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Add New Item</title>
    <link rel="icon" type="image/png" sizes="16x16" href="#">
    <link rel="stylesheet" href="../../assets/plugins/pg-calendar/css/pignose.calendar.min.css" >
    <link rel="stylesheet" href="../../assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="../../assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
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
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
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
                                </div>
                            </div>
                        </li>
						
                    </ul>
                </div>
            </div>
        </div>


        <!--**********************************
            Sidebar start
        ***********************************-->
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
						    <li><a href="../view/">View New Item</a></li>
                            <li><a href="./">Add New Item</a></li>
	                        <li><a href="../edit/">Edit Items</a></li>
                        </ul>
                    </li>
					
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">Categories</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a  href="../../category/add/">Add Category</a></li>
                            <li><a href="../../category/edit/">Edit Category</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="container-fluid mt-3">
                <div class="row page-titles mx-0">
					<div class="col p-md-0">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="javascript:void(0)">Master Inventory</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Add New Item</a></li>
						</ol>
					</div>
				</div>
				
				<div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
									<div id="masterErrMsg"></div>
                                    <form id="masterAddForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Item Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
												
                                                <input type="text" class="form-control upcase" name="itemName" id="itemName" placeholder="Enter Item Name" maxlength="90" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Item # <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" onblur="checkItemNumberChange(event);" id="itemNum" class="form-control" name="itemNumber"  maxlength="6" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Manufacturer <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control upcase" id="manufacturer" name="manufacturer" placeholder="Manufacturer Name" maxlength="50" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Model <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control upcase" name="model" id="model" placeholder="Model" maxlength="50" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Year 
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="number" class="form-control upcase" name="year" id="year"  placeholder="Year" maxlength="4" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Brief Description <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control upcase" id="description" name="description" rows="5" placeholder="Brief Description: 250 characters max"></textarea>
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Price <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" maxlength="15" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Select Display Image <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="file" id="fileImage" class="form-control-file"  name="masterInventoryImage" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="button" id="masterAddBtn" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
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
									<li><u>Item #</u> is auto-generated.</li>
									<li>Only 1 image can be loaded on this page. Once the item has been created more images can be added on the advance edit page.</li>
									<li>Download this default image template clicking <u><a href="../uploads/defaultImage.jpg" download>here</a></u>.</li>
								</ul>
							</div>
						</div>
						
					</div>  
				</div>	
				
				
            </div>
        </div>
		
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="#">BCR Web Developers LLC.</a> 2019</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>

<script src="../../assets/plugins/common/common.min.js"></script>
<script src="../../assets/js/custom.min.js"></script>
<script src="../../assets/js/settings.js"></script>
<script src="../../assets/js/gleek.js"></script>
<script src="../../assets/js/styleSwitcher.js"></script>
<script src="../../assets/plugins/chart.js/Chart.bundle.min.js"></script>
<script src="../../assets/plugins/circle-progress/circle-progress.min.js"></script>
<script src="../../assets/plugins/d3v3/index.js"></script>
<script src="../../assets/plugins/topojson/topojson.min.js"></script>
<script src="../../assets/plugins/raphael/raphael.min.js"></script>
<script src="../../assets/plugins/morris/morris.min.js"></script>
<script src="../../assets/plugins/moment/moment.min.js"></script>
<script src="../../assets/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
<script src="../../assets/plugins/chartist/js/chartist.min.js"></script>
<script src="../../assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
<script>
var item    = document.getElementById("itemNum");
var mnfr    = document.getElementById("manufacturer");
var modl 	= document.getElementById("model");
var year    = document.getElementById("year");
var desc 	= document.getElementById("description");
var prce  	= document.getElementById("price");
var itmName = document.getElementById("itemName");
var file    = document.getElementById("fileImage"); 

var frm = document.getElementById("masterAddForm");
var err = document.getElementById("masterErrMsg");
var btn = document.getElementById("masterAddBtn");

window.onload = function(){
	var myParam = location.search.split('status=')[1];
	if(myParam == "0"){
		err.innerHTML = "<div class='alert alert-success'>Item has been created successfully.</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}else if(myParam == "1"){
		err.innerHTML = "<div class='alert alert-warning'>Image size is greater than 4 mb.</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}
	createItemNumber();
}

btn.addEventListener("click",function(e){
	
	if(itmName.value != ""){
		
		if(mnfr.value != ""){
			
			if(modl.value != ""){
				
				if(desc.value.length > 5){
					
					if(prce.value != "" && prce.value.length > 3){
						if(file.value != ""){
							frm.submit();
						}else{
							err.innerHTML = "<div class='alert alert-warning'>Please attach an image or add a default image.</div>";
							setTimeout(function(){err.innerHTML="";},3000);
						}
					}else{
						err.innerHTML = "<div class='alert alert-warning'>Please enter an aprox. price</div>";
						setTimeout(function(){err.innerHTML="";},3000);
					}
					
				}else{
					err.innerHTML = "<div class='alert alert-warning'>Please enter a brief description.</div>";
					setTimeout(function(){err.innerHTML="";},3000);
				}
				
			}else{
				err.innerHTML = "<div class='alert alert-warning'>Please enter a model name or #.</div>";
				setTimeout(function(){err.innerHTML="";},3000);
			}
			
		}else{
			err.innerHTML = "<div class='alert alert-warning'>Please enter the manufacturer name.</div>";
			setTimeout(function(){err.innerHTML="";},3000);
		}
		
	}else{
		err.innerHTML = "<div class='alert alert-warning'>Please enter the item name.</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}
	
});

function checkItemNumberChange(e){
	var i = e.target.value;
	if(!(i.length < 6)){
		createItemNumber(i);
	}else{
		err.innerHTML = "<div class='alert alert-warning'>Item # has to be 6 digits long.</div>";
		setTimeout(function(){err.innerHTML="";e.target.focus();},2000);
	}
} 

function createItemNumber(n){
	var itemNum = n ? n: Math.floor(100000 + Math.random() * 900000);

	var xhr = new XMLHttpRequest();
	var url = '../../../php/json/master-inventory/check_duplicate_item_number.php?i=' + itemNum;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);
			if(s.status == 0){
				item.value = itemNum;
			}else if(s.status == 1){
				createItemNumber();
			}
		}
	};
	xhr.send();
}

function st(event){
  var str = event.target.value;
  var i = str.replace(/[&\/\\,'"?<>!@#$%^&*()]/g, '');
  event.target.value = i;
}
</script>
</body>
</html>