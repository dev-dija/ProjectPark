<!DOCTYPE html>
<html>
<head>
	<title>Project Park</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link href="css/green.css" type="text/css" rel="stylesheet">
    <link href="css/prettify.min.css" type="text/css" rel="stylesheet">
    <link href="css/select2.min.css" type="text/css" rel="stylesheet">
    <link href="css/switchery.min.css" type="text/css" rel="stylesheet">
    <link href="css/starrr.css" type="text/css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>

<div class="header">
	<nav class="navbar navbar-inverse navbar-transparent col-md-12">
		<div class="container">
		  <div class="container-fluid col-md-12">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle nav-btn" data-toggle="collapse" data-target="#myNavbar">
		        <span class="icon-bar" aria-hidden="true"></span>
		        <span class="icon-bar" aria-hidden="true"></span>
		        <span class="icon-bar" aria-hidden="true"></span>
		      </button>
		      <a class="navbar-brand" href="index.php"><font color="#fff">Project</font> <font color="#e5e5e5">Park</font></a>
		    </div>
		    <div class="collapse navbar-collapse" id="myNavbar">
		      <ul class="nav navbar-nav">
		        <li>
		        	<div class="dropdown" style="margin-top: 10px;">
					  <button class="btn btn-primary btn-none dropdown-toggle" type="button" data-toggle="dropdown">
					  <i class="fa fa-bars" data-toggle="tooltip" data-placement="bottom" title="Explorez Catégories"></i></button>
					  <ul class="dropdown-menu plus-menu">
					    <li><a href="#" class="active"><i class="fa fa-paint-brush" aria-hidden="true"></i>Design et Infographie</a></li>
					  </ul><form method="POST" name="frmLocation" action="stagelocal.php">
						</div></li>
			        <li><a href="#">découvrirz les offres</a></li>
			        <li><a href="stages.php">Les Stages</a></li>
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

	<div class="jumbo">
		<div class="container">
			<div class="row">
				<label>Chercher Projects Au Maroc</label>
				<p class="description">
					Recrutez des Freelancers qualifiés, à distance ou sur place, dans tout le Maroc. Trouvez des talents<br>
					en Développement Web/Mobile, Infographie, Marketing, Finance, Rédaction, Traduction...
				</p>
			</div>
		</div>
	</div>

	<div class="search">
		<div class="container">
			<div class="row">
				<div class="search-field">
					<form class="form-horizontal">
						<div class="input-group col-md-6 col-md-offset-3">
						    <span class="input-group-addon search-label">Je cherche un projet </span>
						    <input id="search" type="text" autocomplete="off" class="form-control" name="search" placeholder="wordpress, logo, article ..." onkeydown="">
						    <div class="search-results">
								<ul id="dataSearchResult">
									<li>Wordpress template</li>
									<li>Conception logo</li>
									<li>Rédaction d'articles</li>
								</ul>
							</div>
						    <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
						</div>
					</form>
				</div>
				<div class="popular">
					<div class="container">
						<div class="row">
							<p>Recherches populaires:</p>
						</div>
						<div class="row">
							<a type="button" class="btn btn-primary btn-tag">logo</a>
							<a type="button" class="btn btn-primary btn-tag">wordpress</a>
							<a type="button" class="btn btn-primary btn-tag">php/mysql</a>
							<a type="button" class="btn btn-primary btn-tag">traduction</a>
							<a type="button" class="btn btn-primary btn-tag">article</a>
							<a type="button" class="btn btn-primary btn-tag">montage</a>
						</div>
						<div class="row">
							<a type="button" class="btn btn-primary btn-tag">marketing</a>
							<a type="button" class="btn btn-primary btn-tag">animation</a>
							<a type="button" class="btn btn-primary btn-tag">audio</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="ccm">
	<div class="container">
		<div class="row">
			<div class="title">
				<label>comment ça marche ?</label>
				<p>En 3 étapes faciles et simples. Vous pouvez atteindre vos objectifs.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="brand">
					<i class="fa fa-search" aria-hidden="true"></i>
					<p>
						<label>Publiez votre projet en quelques secondes</label>
					</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="brand">
					<i class="fa fa-check" aria-hidden="true"></i>
					<p>
						<label>Comparez les prix & sélectionnez les soumissionnaires</label>
					</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="brand">
					<i class="fa fa-dollar" aria-hidden="true"></i>
					<p>
						<label>Payez seulement lorsque vous êtes satisfait</label>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="entreprise">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<p>Vous etes une entreprise ?</p>
				<p>
					poster votre projets facillement<br>
					et Trouver les Freelancers rapidement
				</p>

				<div class="publish_m">
					<button type="button" class="btn btn-primary btn-icn"><i class="fa fa-edit" aria-hidden="true"></i> publier une mission</button>
					<br>
					<label>100% Gratuit</label>
				</div>
			</div>
			<div class="right-side col-sm-8"></div>
		</div>
	</div>
</div>


<div class="recent">
	<div class="container cards-row">
		<div class="row row_recent_title">
			<label>Les projets récent</label>
			<span><a href="projects.php">Plus</a></span>
		</div>
		<div class="row">
				<div class='col-sm-6 col-md-3'>
				    <div class='thumbnail'>
				      <img src='{$row['pic_p']}' alt='Thumbnail'>
				      <div class='caption'>
				        <span id='title'><a href='project.php'>Un titre de projet </span></a><br>
				        <span id='by'><a href='profile.php'>John doe</a></span><br>
				        <span id='desc'>par ... date et heur (passed)</span>
				        <p>
				        	<a class='btn btn-info'>categorie</a>
				        </p>
				        <p class='card-description'>
				        	description
				        </p>
				      </div>
				    </div>
				</div>
		</div>
	</div>
</div>

<div class="freelancer">
	<div class="container cards-row">
		<div class="row title">
			<label>Les freelancers populaire</label>
		</div>
		<div class="row cards">
			<div class='col-sm-3 col-md-2 col-xs-6'>
				<div class='thumbnail'>
					<img src='...' alt='Thumbnail'>
					<div class='caption'>
					<a href='profile.php'><span id='title'>John Doe</span></a>
					<p id='fr'></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php' ?>