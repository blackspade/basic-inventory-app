<?php
require_once '../php/core/init.php';
require_once '../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../php/classes/'.$class.'.php';
});

$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
$sql = "SELECT * FROM `categories` WHERE `status` = 'ACTIVE'";
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="description" content=""/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<title>Anonymous | Catalog</title>
	<style>
	.loading-show{
		
	}
	.loading-hide{
		visibility:hidden;
	}
	#searchBar{
		margin:top:10px;
	}
	</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../">Homepage</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
	  <li class="nav-item">
        <a class="nav-link" href="./">Catalog <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../create-account/">Create Account <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../login/">Login</a>
      </li>

    </ul>
  </div>
</nav>

<div class="container-fluid">
	<div  class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-9">
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search Options</button>
				<div class="dropdown-menu">
				  <a class="dropdown-item" href="#">Exact</a>
				  <a class="dropdown-item" href="#">Like</a>
				  <a class="dropdown-item" href="#">Item #</a>
				</div>
			  </div>
			  <input type="text" class="form-control" aria-label="Text input with dropdown button">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<?php
			
				while ($row = mysqli_fetch_row($result)){
					echo "<button onclick='loadCatalog(event);' data-cat='".$row[1]."' data-id='".$row[0]."' class='btn btn-primary bnt-sm btn-block'>".$row[1]."</button>";
				}
			
			?>
			<input type="hidden" id="session" value="<?php echo hyper_escape($_SESSION['catalog']);?>" />
		</div>
		<div class="col-md-9">
			<div id="loader" class="loading-hide">
				<img src="../app/assets/images/loader.gif">
			</div>
			<div id="catalogResults">
			
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<script>
var s = document.getElementById("session");
var l = document.getElementById("loader");

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

function loadCatalog(e){
	var i = e.target;
	var c = i.attributes[1].nodeValue;
	var id = i.attributes[2].nodeValue;
	var container = document.getElementById("catalogResults");
	var xhr = new XMLHttpRequest();
	var url = '../php/json/catalog/load_items.php?category=' + c;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			//var s = JSON.parse(xhr.responseText);			
			var s = xhr.responseText;		
			container.innerHTML = s;	
		}
	};
	xhr.send();	
}

function loadQuote(e){
	var i = e.target;
	var itemNum = i.attributes[1].nodeValue;
	console.log(itemNum);
}
</script>
</body>
</html>