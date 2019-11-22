<?php
require_once '../php/core/init.php';
require_once '../php/functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../php/classes/'.$class.'.php';
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
	<link rel="stylesheet" href="../app/assets/css/homepage.css" >
	<title>Anonymous | Password Reset</title>
	<style>
	.top-justify{
		margin-top:50px;
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
		<li class="nav-item">
		  <a class="nav-link" href="../catalog/">Catalog <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item active">
		  <a class="nav-link" href="./">Create Account</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="../login/">Login</a>
		</li>
	  </ul>
	</div>
  </nav>
</header>

<div class="container top-justify">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<!-- form card reset password -->
            <div class="card card-outline-secondary">
              <div class="card-header">
                <h3 class="mb-0">Password Reset</h3>
              </div>
              <div class="card-body">
                <form autocomplete="off" class="form" role="form">
                  <div class="form-group">
                    <label for="inputResetPasswordEmail">Email</label> 
						<input class="form-control" id="inputResetPasswordEmail" required="" type="email"> 
						<span class="form-text small text-muted" id="helpResetPasswordEmail">Password reset instructions will be sent to this email address.</span>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-success btn-lg float-right" type="submit">Reset</button>
                  </div>
                </form>
              </div>
            </div>
			<!-- /form card reset password -->				
		</div>
	</div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
<script>
</script>
</body>
</html>