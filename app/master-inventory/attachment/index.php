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



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$user = hyper_escape($_SESSION['sessionType']."|".$_SESSION['sessionId']."|".$_SESSION['name']);
	
	$item_num = hyper_escape($_POST['itemNum']);
	
	$target_dir = "./uploads/files/";
	$target_file = $target_dir.basename($_FILES["attachmentFile"]["name"]);
	$pdfFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	if($pdfFileType != "pdf"){
		redirect::to($_SERVER['PHP_SELF']."?item=".$item_num."&status=1");
	}
	
	
	$temp = explode(".",$_FILES["attachmentFile"]["name"]);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	
	$arr = [];
	$i = array($newfilename);
	$arr["pdf"]= $i;
	$json_pdf = json_encode($arr);
	
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	
	$sql = "UPDATE `master_inventory_advance` SET `data_json`= ?, `last_edit_by`= ? WHERE `item_number` = ?";
	
	$error = [];
	
	if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		$error["msg"] = "PREPARE FAILED";
	}

	if (!$stmt->bind_param("ssi",$json_pdf,$user, $item_num)){
		//TEST PURPOSES ONLY
		$error["msg"] = "BIND FAILED";
	}
	
	if (!$stmt->execute()) {
		//TEST PURPOSES ONLY
		$error["msg"] = "STATEMENT FAILED";
	}else{
		move_uploaded_file($_FILES["attachmentFile"]["tmp_name"], $target_dir.$newfilename);
		redirect::to($_SERVER['PHP_SELF']."?item=".$item_num."&status=0");
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory | Add Attachment</title>
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
		#currentAttachment{
			color:grey;
			font-size:1.2em;
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
                                            <a href="../../profile/"><i class="icon-user"></i> <span>Profile</span></a>
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

        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">            				
                    <li class="nav-label">Actions</li>
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

        <div class="content-body">

            <div class="container-fluid mt-3">
                <div class="row page-titles mx-0">
					<div class="col p-md-0">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="javascript:void(0)">Master Inventory</a></li>
							<li class="breadcrumb-item"><a href="../edit/">Edit Item</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Add Attachment</a></li>
						</ol>
					</div>
				</div>
				
				<div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
									<div id="attachErrMsg"></div>
                                    <form id="attachForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                                        
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="attachmentFile">Select Attachment <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="file" id="attachFile" class="form-control-file"  name="attachmentFile" />
												<input type="hidden" value="<?php echo hyper_escape($_GET['item']); ?>" name="itemNum" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="button" id="attchBtn" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
									
									<div>
										<span id="currentAttachment" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Attachment: <span id="filePull">None</span> </span>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Quick Hints</h4>							
								<ul id="hints">
									<li>The only attachment allowed are <a href="./dummy.pdf" download><u>PDF</u></a> files.</li>
									<li>Download a sample PDF file by clicking <a href="./dummy.pdf" download>here</a></li>
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
var file    = document.getElementById("attachFile"); 

var frm = document.getElementById("attachForm");
var err = document.getElementById("attachErrMsg");
var btn = document.getElementById("attchBtn");

window.onload = function(){
	var stat = location.search.split('status=')[1];
	var item = location.search.split('item=')[1];
	if(stat == "0"){
		err.innerHTML = "<div class='alert alert-success'>Attachment has been added successfully</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}else if(stat == "1"){
		err.innerHTML = "<div class='alert alert-warning'>Invalid extension. Please try different file.</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}
	loadPreview(item);
	loadFile(item);
}

btn.addEventListener("click",function(e){
	
	if(file.value != ""){
		frm.submit();
	}else{
		err.innerHTML = "<div class='alert alert-warning'>Please add an attachment to upload</div>";
		setTimeout(function(){err.innerHTML="";},3000);
	}				
	
});
function loadFile(i){
	var item = i;
	var box = document.getElementById("filePull");
	var xhr = new XMLHttpRequest();
	var url = '../../../php/json/master-inventory/load_file.php?item=' + item;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);		
			if(s.url != null){
				box.innerHTML = "<a href='./uploads/files/"+ s.url + "' target='_blank' >View "+ s.url +"</a>";
			}
		}
	};
	xhr.send();
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

</script>
</body>
</html>