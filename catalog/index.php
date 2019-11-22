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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="../app/assets/css/homepage.css" >
	<title>Inventory Demo | Catalog</title>
	<style>
	.loading-show{
		
	}
	.loading-hide{
		visibility:hidden;
	}
	#searchBar{
		margin:top:10px;
	}
	#catalog-container{
		margin-top:50px;
	}
	#categoryFilterSearch{
		margin-bottom:10px;
	}
	
	</style>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="../">Demo Inventory App</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
	  <ul class="navbar-nav ml-auto">
		<li class="nav-item active">
		  <a class="nav-link" href="./">Catalog <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="../create-account/">Create Account</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="../login/">Login</a>
		</li>
	  </ul>
	</div>
  </nav>
</header>


<div id="catalog-container" class="container-fluid">
	<div  class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-9">
			<div id="searchErrMsg"></div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search Type</button>
				<div class="dropdown-menu">
				  <a onclick="setSearchType(event)" data-type="exact" class="dropdown-item" >Exact</a>
				  <a onclick="setSearchType(event)" data-type="like" class="dropdown-item" >Like</a>
				  <a onclick="setSearchType(event)" data-type="itemNum" class="dropdown-item" >Item #</a>
				</div>
			  </div>
			  <input id="search" data-toggle='tooltip' data-placement='bottom' title='Press (Enter) to start search.'  type="text" class="form-control" placeholder="Exact Search" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<input id="categoryFilterSearch" onkeyup="searchFilter();" class="form-control" type="search" placeholder="Category Filter" />
			<table id="categorySelection" width="100%">
			<tbody>
			<?php
			
				while ($row = mysqli_fetch_row($result)){
					echo "<tr><td><button onclick='loadCatalog(event);' data-cat='".$row[1]."' data-id='".$row[0]."' class='btn btn-primary bnt-sm btn-block'>".$row[1]."</button></td></tr>";
				}
			
			?>
			</tbody>
			</table>
			<input type="hidden" id="session" value="<?php echo hyper_escape($_SESSION['catalog']);?>" />
		</div>
		<div class="col-md-9">
			<div>
				<img id="loader" class="loading-hide" src="../app/assets/images/loader.gif">
				<div id="categoryNameHolder">
				</div>
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
var n = document.getElementById("categoryNameHolder");
var err = document.getElementById("searchErrMsg");

function searchFilter() {

  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("categoryFilterSearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("categorySelection");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
  
}

function loadCatalog(e){
	l.className = "loading-show";
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
			var s = xhr.responseText;
			n.innerHTML = "<p>" + c +"</p>";
			setTimeout(function(){
			l.className = "loading-hide";},500);
			container.innerHTML = s;	
			logCountCat(id);
		}
	};
	xhr.send();	
}

function logCountCat(i){
	var xhr = new XMLHttpRequest();
	var url = '../php/json/catalog/update_count_category.php?id=' + i;
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);
		}
	};
	xhr.send();	
}

function setSearchType(e){
	var s = document.getElementById("search");
	var i = e.target;
	var t = i.attributes[1].nodeValue;
	var type;
	
	switch(t){
		case "exact":
			type = "exact";
			s.placeholder = "Exact Search";
		break;
		case "like":
			type = "like";
			s.placeholder = "Like Search";
		break;
		case "itemNum":
			type = "itemNum";
			s.placeholder = "Item # Search";
		break;
	}
	console.log(type);
}


function loadQuote(e){
	var i = e.target;
	var itemNum = i.attributes[1].nodeValue;
	location.href = "./quote-view/?item=" + itemNum;
}

/*
https://www.w3schools.com/howto/howto_js_filter_table.asp
*/
</script>
</body>
</html>