<?php include('header.php');include('isvalide.php');?>

<div class="page">
	<div class="container">
		<div class="row ref">
			<a href="index.php"><i class="fa fa-home"></i> Accueil</a>
			<span class="ref-current">
				<i class="fa fa-angle-right"></i> s'inscrire
			</span>
		</div>
		<div class="col-md-3"></div>
		<div class="row col-md-6">
			<div class="frame">
				<div class="title">
					<span>S'INSCRIRE</span>
				</div>
				<div class="content reset login">
					<div class="col-right col-xs-11">
					<?php
						if(isset($_POST['doregister'])){
							$typeacc = $_POST['typeacc'];
							$nom = $_POST['nom'];
							$prenom = $_POST['prenom'];
							$email = $_POST['email'];
							$pays = $_POST['pays'];
							$ville = $_POST['ville'];
							$pwd = $_POST['pass_confirmation'];
							$pass = $_POST['pass'];
							$qval = $_POST['qval'];
							if($nom=="" || $prenom=="" || $email=="" || $pwd=="" || $pass=="" || $qval=="" || $pays=="" || $ville==""){
								echo "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> Vous devez rempli tous les champs</div>";
							}else{
								if($pass!=$pwd){
									echo "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> Les deux mot de passe sont différents</div>";
								}else{
									if($typeacc!=0 && $typeacc!=1){
										echo "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> Le type de compte est incorrect</div>";
									}else{
										if($typeacc==0) $cmpt="freelancer";
										else $cmpt="entreprise";
										$rs = $conn->query("SELECT * FROM $cmpt WHERE email='$email'");
										if(mysqli_num_rows($rs)>0){
											echo "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> Ce compte est déjâ existé</div>";
										}else{
											$keycode = generate_pwd(0,0,7);
											$key = md5($keycode);
											$pass = md5($pass);
											if($typeacc==0) $pic="images/avatars/$prenom_$nom.jpg";
											else $pic="images/logos/$prenom_$nom.jpg";
											$sql = "INSERT INTO $cmpt (nom, prenom, avatar, email, pwd, pays, ville, date_insc, activation_key) VALUES('$nom', '$prenom', '$pic','$email', '$pass', '$pays', '$ville', CURDATE(), '$key')";
											$res = $conn->query($sql);
											if(! $res){
												echo "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> Problème d'enregistrement des données</div>";
											}else{
												echo "<div class='alert alert-success'><i class='fa fa-check'></i> Votre compte à été créée avec succès <i class='fa fa-smile'></i><br>
													attendez 3s...</div>";
												echo "<div class='alert alert-success'>
													<div>
														votre code d'activation est : <b>$keycode</b><br>
														vous pouvez activer le compte on cliquant sur le lien :<br>
														<a href='http://localhost/projectpark/activation.php?key=$key' target='_blank'>http://localhost/projectpark/activation.php?key=$key</a>
													</div>
												</div>";
												$_SESSION['user'] = array(mysqli_insert_id($conn), $typeacc);
												echo "<meta http-equiv='refresh' content='3; url=activation.php' />";
											}
										}
									}
								}
							}
						}
					?>
						<form method="POST" id="registration-form">
							<div class="row">
								<label class="col-sm-3 qest">vous êtes</label>
								<div class="" data-toggle="buttons">
								  <button class="btn btn-primary btn-identy rad">
								    <input type="radio" name="typeacc" id="option1" value="1" autocomplete="off"> ENTREPRENEUR
								  </button>
								  <button class="btn btn-primary btn-identy active rad">
								    <input type="radio" name="typeacc" id="option2" value="0" autocomplete="off" checked> FREELANCER
								  </button>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
								    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="nom" placeholder="Nom" data-validation="length alphanumeric" data-validation-length="3-20" data-validation-error-msg="User name has to be an alphanumeric value (3-20 chars)" name="nom">
								  </div>
							</div>
							<div class="row">
								<div class="form-group">
								    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="prenom" placeholder="Prenom" data-validation="length alphanumeric" data-validation-length="3-20" data-validation-error-msg="User name has to be an alphanumeric value (3-20 chars)" name="prenom">
								  </div>
							</div>
							<div class="row">
								<div class="form-group">
								    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="email" placeholder="Email" data-validation="email" autocomplete="off" name="email">
								  </div>
							</div>
							<div class="row">
								<div class="form-group">
								    <input type="password" class="form-control text-field col-xs-12 col-sm-5" id="pwd" placeholder="Mot de passe" data-validation="strength" data-validation-strength="2" name="pass_confirmation">
								  </div>
							</div>
							<div class="row">
								<div class="form-group">
								    <input type="password" class="form-control text-field col-xs-12 col-sm-5" id="pwdconfirm" placeholder="Confirmer le mot de passe" data-validation="confirmation" name="pass">
								  </div>
							</div>
							<div class="row">
								<div class="form-group">
								    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="pays" placeholder="Pays" data-validation="length alphanumeric" data-validation-length="3-20" data-validation-error-msg="User name has to be an alphanumeric value (3-20 chars)" name="pays">
								  </div>
							</div>
							<div class="row">
								<div class="form-group">
								    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="ville" placeholder="Ville" data-validation="length alphanumeric" data-validation-length="3-20" data-validation-error-msg="User name has to be an alphanumeric value (3-20 chars)" name="ville">
								  </div>
							</div>
							<div class="row">
								<label class="col-sm-3 qest">
									<?php 
										$nb1 = rand(1, 40);
										$nb2 = rand(8, 19);
										echo "$nb1 + $nb2 = ";
									?>
								</label>
								<div class="form-group col-xs-12 col-sm-9">
								    <input type="text" class="form-control text-field" id="reponse" placeholder="reponse" data-validation="required number" data-validation-error-msg="Vous devez répondre au question" name="qval">
								  </div>
							</div>
							<div class="row f-right">
								<button type="reset" class="btn btn-default btn-identy bg-gray">CLEAR</button>
								<button type="submit" class="btn btn-primary btn-identy" name="doregister">S'INCRIRE</button>
							</div>
						</form>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>


<?php include('footer.php');?>