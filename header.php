<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Project Park</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <!-- <link href="css/green.css" type="text/css" rel="stylesheet"> -->
    <!-- <link href="css/prettify.min.css" type="text/css" rel="stylesheet"> -->
    <link href="css/select2.min.css" type="text/css" rel="stylesheet">
    <!-- <link href="css/switchery.min.css" type="text/css" rel="stylesheet"> -->
    <!-- <link href="css/starrr.css" type="text/css" rel="stylesheet"> -->
    <link href="css/theme-default.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-tagsinput.css">

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
<nav class="navbar navbar-inverse col-md-12">
	<div class="container">
	  <div class="container-fluid col-md-12">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle nav-btn" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar" aria-hidden="true"></span>
	        <span class="icon-bar" aria-hidden="true"></span>
	        <span class="icon-bar" aria-hidden="true"></span>
	      </button>
	      <a class="navbar-brand" href="index.php"><font color="#5a88ca">Project</font> <font color="#ccc">Park</font></a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <li>
	        	<div class="dropdown" style="margin-top: 10px;">
				  <button class="btn btn-none dropdown-toggle" type="button" data-toggle="dropdown">
				  <i class="fa fa-bars" data-toggle="tooltip" data-placement="bottom" title="Explorez Catégories" aria-hidden="true"></i></button>
				  <ul class="dropdown-menu plus-menu">
				    	<li><a href='#' class=''><i class='fa fa-user' aria-hidden='true'></i>catregorie</a></li>";
				    	
				  </ul><form method="POST" name="frmLocation" action="stagelocal.php">
				</div></li>
	        <li><a href="#">découvrirz les offres</a></li>
	        <li><a href="stages.php">Les stages</a></li>
	        <li>
        		<div class="dropdown" style="margin-top: 10px;">
				  <button class="btn btn-none dropdown-toggle" type="button" data-toggle="dropdown">PLUS 
				  <i class="fa fa-angle-down" aria-hidden="true"></i></button>
				  <ul class="dropdown-menu plus-menu">
				    <li><a href="blog/index.php" class="active">Blog</a></li>
				    <li class='hidden' onclick="javascript:frmLocation.submit()" style="cursor: pointer;"><a><i class="fa fa-location" id="btnlocation" aria-hidden="true"></i> Localisation</a></li>
				    <li><input type="hidden" name="myLocation" id="myLocation"></li>
				    </form>
				  </ul>
				</div>
	        </li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
		        <li><a href="login.php">Connexion</a></li>
		        <li><a href="register.php" class="btn btn-default btn-inscrire">S'inscrire</a></li>
				<li>
					<div class="dropdown" style="margin-top: 10px;">
						<button class="btn btn-none dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-paw"></i></button>
						<div class="dropdown-menu plus-menu mnu">
						<div class="mnu-profile">
							<div class="mnu-profile-header"></div>
							<center><img src="..."></center>
							<span class="title">John Doe</span>
							<div class="mnu-controls">
								<a href='profile.php' class="btn bg-none" data-toggle='tooltip' title="Profile"><i class="fa fa-user" aria-hidden="true"></i></a>
								<a href='dashboard.php' class="btn bg-none" data-toggle='tooltip' title="Paneau de contrôl"><i class="fa fa-dashboard" aria-hidden="true"></i></a>
								<a href='?logout=true' class="btn bg-none" data-toggle='tooltip' title="Déconnexion"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
							</div>
						</div>
						</div>
					</div>
				</li>
		      </ul>
	    </div>
	  </div>
	</div>
</nav>