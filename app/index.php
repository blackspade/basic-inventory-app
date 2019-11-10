<?php
require_once '../php/core/init.php';
require_once '../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../php/classes/'.$class.'.php';
});


if(!(isset($_SESSION['sessionType']) == 1)){
	redirect::to("../../../login/?status=nosession");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory Dashboard</title>
    <link rel="icon" type="image/png" sizes="16x16" href="#">
    <link href="./assets/css/style.css" rel="stylesheet">
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
                <a href="#">
                    <b class="logo-abbr"><img src="./assets/images/logo.png" alt=""> </b>
                    <span class="logo-compact"><img src="./assets/images/logo-compact.png" alt=""></span>
                    <span class="brand-title">
                        <img src="./assets/images/logo-text.png" alt="">
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
                                <img src="./assets/images/user/1.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="./profile/"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
										<li>
                                            <a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="../logout/"><i class="icon-key"></i> <span>Logout</span></a></li>
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
						    <li><a href="./company/profile/">Profile</a></li>
                            <li><a href="#">Settings</a></li>
                        </ul>
                    </li>
					
					<li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">Master Inventory</span>
                        </a>
                        <ul aria-expanded="false">
						    <li><a href="./master-inventory/view/">View New Item</a></li>
                            <li><a href="./master-inventory/add/">Add New Item</a></li>
	                        <li><a href="./master-inventory/edit/">Edit Items</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">Categories</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./category/add/">Add Category</a></li>
                            <li><a href="./category/edit/">Edit Category</a></li>
                        </ul>
                    </li>
					<li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">Featured Items</span>
                        </a>
                        <ul aria-expanded="false">
						    <li><a href="#">Homepage</a></li>
                        </ul>
                    </li>
					<li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">User Management</span>
                        </a>
                        <ul aria-expanded="false">
						    <li><a href="#">Active Users</a></li>
                            <li><a href="#">Customers</a></li>
                        </ul>
                    </li>
					<li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-menu menu-icon"></i> <span class="nav-text">SEO</span>
                        </a>
                        <ul aria-expanded="false">
						    <li><a href="#">Add Keywords</a></li>
                            <li><a href="#">Create HTML</a></li>
							<li><a href="#">Directory</a></li>
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
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">
                                <h3 class="card-title text-white">Inventory Items</h3>
                                <div id="inventoryCount" class="d-inline-block">
                                    <h2 class="text-white"></h2>
                                    <p class="text-white mb-0"></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-archive"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <h3 class="card-title text-white">Categories</h3>
                                <div id="categoryCount" class="d-inline-block">
                                    <h2 class="text-white"></h2>
                                    <p class="text-white mb-0"></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-th-large"></i></span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                

                

                <div class="row">
                           
                        <div class="col-lg-3 col-md-6">
                            <div class="card card-widget">
                                <div class="card-body">
                                    <h5 class="text-muted">Quick Links</h5>
                                    
                                    <div class="mt-4">
										</span><i class="fa fa-plus" aria-hidden="true"></i><a href="./master-inventory/add/"> Add New Item</a></span>	
                                    </div>
                                    <div class="mt-4">

                                    </div>
                                    <div class="mt-4">

                                    </div>
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

<script src="./assets/plugins/common/common.min.js"></script>
<script src="./assets/js/custom.min.js"></script>
<script src="./assets/js/settings.js"></script>
<script src="./assets/js/gleek.js"></script>
<script src="./assets/js/dashboard/dashboard-1.js"></script>
</body>
</html>