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

$item  = [];

while ($row = mysqli_fetch_row($result)){
	$item['name'] = $row[2];
	$item['price'] = $row[8];
	$item['image'] = $row[5];
	$item['category'] = $row[7];
	$item['description'] = $row[12];
}

$img = json_decode($item['image']);

$img_url = $img->images[0];



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
										<a href="../../preview/"><i class="icon-user"></i> <span>Profile</span></a>
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
					<li class="breadcrumb-item"><a href="javascript:void(0)">Master Inventory</a></li>
						<li class="breadcrumb-item"><a href="../edit/">Edit Item</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Preview</a></li>
					</ol>
				</div>
			</div>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4>Item Preview</h4>
							</div>
							<div class="table-responsive">
								<div id="preview">
									<?php echo "<img src='../uploads/images/{$img_url}' width='400px' />"; ?>
								</div>
								<table style="width:50%" class="table">
									<thead>
										<tr>		
											<th>Item Name</th>
											<th>Category</th>
											<th>Price</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $item['name']; ?></td>
											<td><?php echo $item['category']; ?></td>
											<td><?php echo $item['price']; ?></td>
										</tr>	
									</tbody>
								</table>
								<h4>Description</h4>
								<p><?php echo $item['description']; ?></p>
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

</script>
</body>
</html>