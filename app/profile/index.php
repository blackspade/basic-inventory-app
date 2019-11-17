<?php
require_once '../../php/core/init.php';
require_once '../../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../php/classes/'.$class.'.php';
});


if(!(isset($_SESSION['sessionType']) == 1)){
	redirect::to("../../login/?status=nosession");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Profile</title>
    <link rel="icon" type="image/png" sizes="16x16" href="#">
    <link href="../assets/css/style.css" rel="stylesheet">
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
                <a href="../">
                    <b class="logo-abbr"><img src="../assets/images/logo.png" alt=""> </b>
                    <span class="logo-compact"><img src="../assets/images/logo-compact.png" alt=""></span>
                    <span class="brand-title">
                        <img src="../assets/images/logo-text.png" alt="">
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
                                <img src="../assets/images/user/1.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="./"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
										<li>
                                            <a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="../../logout/"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
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
							<li><a href="../company/profile/">Profile</a></li>
							<li><a href="../company/settings/">Settings</a></li>
						</ul>
					</li>
					<li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">Master Inventory</span>
                        </a>
                        <ul aria-expanded="false">
						    <li><a href="../master-inventory/view/">View New Item</a></li>
                            <li><a href="../master-inventory/add/">Add New Item</a></li>
	                        <li><a href="../master-inventory/edit/">Edit Items</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">Categories</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="../category/add/">Add Category</a></li>
                            <li><a href="../category/edit/">Edit Category</a></li>
                        </ul>
                    </li>
                    <li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false">
						<i class="icon-menu menu-icon"></i> <span class="nav-text">Featured Items</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="../homepage/featured/">Homepage</a></li>
					</ul>
				</li>
                </ul>
            </div>
        </div>

        <div class="content-body">
			<div class="container-fluid mt-3">
				<div class="row">
					<div class="col-lg-6 ">
					
                        <div class="card">
                            <div class="card-body">
                                <div class="media align-items-center mb-4">
                                    <img class="mr-3" src="../assets/images/avatar/default.png" width="80" height="80" alt="">
                                    <div class="media-body">
                                        <h3 class="mb-0"><?php echo hyper_escape($_SESSION['name']);?></h3>
                                        <p class="text-muted mb-0"><?php echo hyper_escape($_SESSION['sessionType']);?></p>
                                    </div>
                                </div>
                                
                                <ul class="card-profile__info">                                    
                                    <li><strong class="text-dark mr-4">Email: </strong> <span><?php echo hyper_escape($_SESSION['email']);?></span></li>
                                </ul>
                            </div>
                        </div>		

                        
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-6">
					
                        <div class="card">
                            <div class="card-body">
                                <div class="media align-items-center mb-4">
                                    <div id="passwordErrMsg"></div>
									<form id="passwordForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
										<div class="form-group row">
                                            <label class="col-lg-5 col-form-label" for="currentPassword">Current Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-7">					
                                                <input type="password" class="form-control" name="currentPass" id="currentPassword" placeholder="Current Password" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-5 col-form-label" for="newPassword">New Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-7">
												
                                                <input type="password" class="form-control" name="newPass" id="newPassword" placeholder="New Password" />
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-5 col-form-label" for="confirmPassword">Confirm Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-7">
												
                                                <input type="password" class="form-control" name="confirmPass" id="confirmPassword" placeholder="Comfirm Password" />
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <div class="col-lg-7 ml-auto">
                                                <button type="button" id="passwordBtn" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
									</form>
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

<script src="../assets/plugins/common/common.min.js"></script>
<script src="../assets/js/custom.min.js"></script>
<script src="../assets/js/settings.js"></script>
<script src="../assets/js/gleek.js"></script>
<script>
var crp = document.getElementById("currentPassword");
var nwp = document.getElementById("newPassword");
var cfp = document.getElementById("confirmPassword");


var frm = document.getElementById("passwordForm");
var err = document.getElementById("passwordErrMsg");
var btn = document.getElementById("passwordBtn");
</script>
</body>
</html>