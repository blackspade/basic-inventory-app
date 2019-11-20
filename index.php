<?php
require_once 'php/core/init.php';
require_once 'php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once 'php/classes/'.$class.'.php';
});

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="description" content=""/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
	<link rel="stylesheet" href="./app/assets/css/homepage.css" >
	<title>Inventory Demo | Home Page</title>
	<style>
	
	</style>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="./">Demo Inventory App</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
	  <ul class="navbar-nav ml-auto">
		<li class="nav-item">
		  <a class="nav-link" href="./catalog/">Catalog <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="./create-account/">Create Account</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link disabled" href="./login/">Login</a>
		</li>
	  </ul>
	</div>
  </nav>
</header>

<main role="main">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
		  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		</ol>
		<div class="carousel-inner">
		  <div class="carousel-item active">
			<img class="first-slide" src="./app/assets/images/warehouse.jpg" alt="Inventory App Background Image">
			<div class="container">
			  <div class="carousel-caption text-left">
				<h1 style="margin-left:10px;" ><mark>Explore the Catalog</mark></h1>
				<p style="margin-left:10px;"><mark>Browse our large selection of products.</mark></p>
				<p style="margin-left:40px;"><a class="btn btn-lg btn-primary" href="./catalog/" role="button">View Catalog</a></p>
			  </div>
			</div>
		  </div>
		  
		</div>
	</div>
	
	<section class="jumbotron text-center">
		<div class="container">
			<h1 class="jumbotron-heading">Reliable Solutions</h1>
			<p class="lead text-muted">Whether you’re searching for machinery you need or looking to sell machinery you no longer use, we can help you get the best possible value.</p>
			<p>
				<a href="./create-account/" class="btn btn-secondary my-2">Create Account</a>
				<a href="./catalog/" class="btn btn-primary my-2">View Catalog</a>
			</p>
		</div>
	</section>
		
	<div id="mainContainer" class="album py-5 bg-light">
        <div class="container">
		  <h1 align="center">Featured Products</h1>	
		  <span id="mainItemLoading" class="img-container">
			<img style="margin:0 auto;" src="./app/assets/images/loader.gif">
		  </span>
		  <br />
          <div id="mainItemContainer" class="row">
			
			<!--
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>	
			-->
			
			</div>
		
		</div>	
	</div>
	
</main>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
<script>
var mc = document.getElementById("mainContainer");
var ml = document.getElementById("mainItemLoading");
var mf = document.getElementById("mainItemContainer");

window.onload = function(){
	checkFeaturedStatus();
}

function checkFeaturedStatus(){
	var xhr = new XMLHttpRequest();
	var url = './php/json/homepage/check_featured_status.php';
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			//var s = JSON.parse(xhr.responseText);
			var s = JSON.parse(xhr.responseText);
			console.log(s);
			if(s.status != "disabled"){
				
				for (var key in s) {
					if (p.hasOwnProperty(key)) {
						console.log(key + " -> " + s[key]);
					}
				}
				
			}else{
				mc.innerHTML = "";
				mc.className = "";
			}
					
		}
	};
	xhr.send();
}

</script>
</body>
</html>