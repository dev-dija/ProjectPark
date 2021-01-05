<?php include('header.php'); ?>

<div class="page">
	<div class="container">
		<div class="row ref">
			<a href="index.php"><i class="fa fa-home"> Accueil</i></a>
			<span class="ref-current">
				> s'identifier
			</span>
		</div>

		<div class="col-sm-3 col-md-4"></div>
		<div class="row col-sm-6 col-md-4">
			<div class="frame">
				<div class="title">
					<span>S'identifier</span>
				</div>
				<div class="content col-xs-11 login">
					<form method="POST">
						<div class="row">
							<div class="form-group">
							    <input type="email" name="login" class="form-control text-field col-xs-12 col-sm-5" id="email" placeholder="Votre email ici">
							  </div>
						</div>
						<div class="row">
							<div class="form-group">
							    <input type="password" name="pwd" class="form-control text-field col-xs-12 col-sm-5" id="pwd" placeholder="Mot de passe ici">
							  </div>
						</div>
						<div class="row">
							<div class="checkbox">
	                            rester connecté? <label>
	                              <input type="checkbox" class="flat" name="stayLogin" checked="checked"> Checked
	                            </label>
	                          </div>
						</div>
						<div class="row">
							<button type="submit" name="getConn" class="btn btn-primary btn-identy">S'IDENTIFIER </button>
							 Ou <a href="register.php" class="simple-link"> s'inscrire</a>
						</div>
						<div class="row">
							<div class="alert alert-success">
								<i class="fa fa-check-square"></i> 
								<span class="title">vous avez s'dentifié avec succée.</span><br>
								<span class="description" id="wait">attendez 3s ...</span>
							</div>
							<div class="alert alert-danger" >
								<i class="fa fa-exclamation-triangle"></i> 
								<span class="title">les informations sont incorrect.</span><br>
								<span class="description">
									<ul>
										<li><a href="resetpass.php" class="simple-link">mot de pass oblié?</a></li>
										<li><a href="register.php" class="simple-link">s'inscrire</a></li>
									</ul>
								</span>
							</div>
						</div>
					</form>
				</div><div class="clearfix"></div>
			</div>
		</div>
		
		<div class="row col-sm-6 col-md-4">
			<div class="frame">
				<div class="title">
					<span>Unlock</span>
					<small><a href="login.php?deletePin=true" class="simple-link">(supprimer le compte)</a></small>
				</div>
				<div class="content col-xs-11 login center-block">
					<div class="userImg imgLgn">
                    	<img src="..." class="img-responsive img-circle getUnlock" alt="...">

                	</div>
                	<div class="pinUnlocker" style="display: none;">
                		<form method="POST">
                			<div class="row">
								<div class="form-group col-xs-10"><br>
								    <input type="password" class="form-control text-field col-xs-12 col-sm-5" id="pin" placeholder="Entrer un code PIN" data-validation="length number" data-validation-length="4-10" data-validation-error-msg="4 à 10 chiffres" name="pin">
								</div>
								<div class="form-group col-xs-2"><br>
									<button class="btn btn-info btn-circle" type="submit" name="getConnPin"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
								</div>
							</div>
                		</form>
                	</div>
				</div><div class="clearfix"></div><br>
			</div>
		</div>
		<div class="col-sm-3 col-md-4"></div>
	</div>
</div>
<br>

<?php include('footer.php');?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".getUnlock").click(function(){
			$(".pinUnlocker").toggle('medium');
		})
	})
</script>