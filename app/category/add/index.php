<?php
require_once '../../../php/core/init.php';
require_once '../../../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../../php/classes/'.$class.'.php';
});

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);

	$sql = "INSERT INTO `categories`(`category`, `status`, `created_by`) VALUES (?,?,?)";	
	
	$user = hyper_escape($_SESSION['sessionType']."|".$_SESSION['sessionId']."|".$_SESSION['name']);

	$cat = strtoupper(hyper_escape($_POST['category']));
	
	$status = "ACTIVE";
	
	if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("sss",$cat,$status,$user)){
		//TEST PURPOSES ONLY
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		//TEST PURPOSES ONLY
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}else{
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
    <title>Inventory | Category Add</title>
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
                            <li><a href="./">Add Category</a></li>
                            <li><a href="../edit/">Edit Category</a></li>
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
							<li class="breadcrumb-item"><a href="javascript:void(0)">Categories</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
						</ol>
					</div>
				</div>
				
				<div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form id="categoryAddForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="categoryName">Category Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
												<div id="categoryErrMsg"></div>
                                                <input style="text-transform: uppercase;" type="text" onblur="st(event);" class="form-control" id="categoryName" name="category" placeholder="Enter Category Name" maxlength="35">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="button" id="categoryAddBtn" class="btn btn-primary">Submit</button>
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
								<li>Categories can be edited on the <u>Edit Category</u> page.</li>
								<li>WARNING: If the item have already been assigned a category please find the item and reassign the category.</li>
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
<script>
var cat = document.getElementById("categoryName");
var frm = document.getElementById("categoryAddForm");
var err = document.getElementById("categoryErrMsg");
var btn = document.getElementById("categoryAddBtn");

window.onload = function(){
	var myParam = location.search.split('status=')[1];
	if(myParam == "0"){
		err.innerHTML = "<div class='alert alert-success'>Category has been created successfully.</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}
}

btn.addEventListener("click",function(e){
	if(cat.value != ""){
		frm.submit();
	}else{
		err.innerHTML = "<div class='alert alert-warning'>Please type in a category to add.</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}
});

function st(event){
  var str = event.target.value;
  var i = str.replace(/[&\/\\,'"?<>!@#$%^&*()]/g, '');
  event.target.value = i;
}
</script>
</body>
</html>