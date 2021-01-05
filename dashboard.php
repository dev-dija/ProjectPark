<?php include('header.php');include('isvalide.php');
if(! isset($_SESSION['user'])) header('location: login.php');
$id = $_SESSION['user'][0];
if($_SESSION['user'][1]==0) $cmpt = "freelancer";
else $cmpt = "entreprise";
$res = $conn->query("SELECT * FROM $cmpt WHERE id=$id");
$profile = $res->fetch_array();
?>

<div class="page">
	<div class="DashTop">
		<div class="container">
			<div class="row">
				<div class="col-md-6 Bienvenue">
					<h3>Bienvenue <?php echo $profile['prenom'];?></h3>
					<h4><i class="fa fa-tachometer" aria-hidden="true"></i> Tableau de board</h4>
				</div>
				<div class="col-md-6">
					<div class="UserSold">
						<a href="paiement.php">
							<h6>Votre Solde :</h6>
							<span><?php echo number_format($profile['sold'],2);?> <small>DHs</small></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="leftSidebar">
					<div class="boxs">
						<div class="box">
							<div class="boxTitle">
								<h4>Bienvenue sur projectpark.ma</h4>
							</div>
							<div class="boxContent">
								<div class="userBox">
									<div class="row">
										<div class="col-md-3">
											<div class="userImg">
												<img src="<?php echo $profile['avatar'];?>" alt="">
											</div>
										</div>
										<div class="col-md-9">
											<div class="user_info">
												<h4><i class="fa fa-arrow-right" aria-hidden="true"></i> <?php echo $profile['prenom']." ".$profile['nom'];?></h4>
												<h4><i class="fa fa-user" aria-hidden="true"></i> <?php echo ucfirst($cmpt);?></h4>
												<h4><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $profile['address'];?></h4>
											</div>
										</div>
										<?php if($_SESSION['user'][1]==1) {echo "
										<div class='col-md-12'><br>
											<a href='dashboard.php?addnewproject=true'><button class='btn btn-primary btn-identy col-xs-12'><i class='fa fa-plus' aria-hidden='true'></i> Nouveau Projet</button></a>
										</div>";
										 echo "
										<div class='col-md-12'><br>
											<a href='dashboard.php?addnewstage=true'><button class='btn btn-primary btn-identy col-xs-12'><i class='fa fa-users' aria-hidden='true'></i> Publier Un Stage</button></a>
										</div>";}
										?>
										<div class='col-md-12'><br>
											<a href='editprofile.php'><button class='btn btn-primary btn-identy col-xs-12'><i class="fa fa-edit" aria-hidden="true"></i> Editer le profile</button></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end box user -->
						<?php 
						if($_SESSION['user'][1]==0){
							$prc_complete = 0;
							$row = $conn->query("SELECT nom, prenom, address, phone, login, bio, avatar FROM freelancer WHERE id=$id")->fetch_array();
							for($i=0;$i<7;$i++){if($row[$i]!="") $prc_complete++;}
							$prc_complete = number_format((($prc_complete*100)/7), 0);
						?>
						<div class="box">
							<div class="boxTitle">
								<h4><i class="fa fa-cog" aria-hidden="true"></i> Configurer votre compte</h4>
							</div>
							<div class="boxContent">
								<div class="ConfigBox">
									<div class="nnn">
										<?php echo $prc_complete."%";?>
									</div>
									<ul>
										<?php
											$res = $conn->query("SELECT nom, prenom, address, phone, login, bio, avatar FROM freelancer WHERE id=$id");
											while($row = $res->fetch_array()){
												echo "<li><a href='#addAvatar' data-toggle='modal'><i class='fa fa-camera' aria-hidden='true'></i> ";if($row['avatar']=="") echo "Ajouter";else echo "Editer la"; echo " photo de profile</a></li>";
												echo "<li><a href='#addBio' data-toggle='modal'><i class='fa fa-comment' aria-hidden='true'></i> ";if($row['bio']=="") echo "Ajouter une";else echo "Editer la"; echo " biographie</a></li>";
												echo "<li><a href='#addPhone' data-toggle='modal'><i class='fa fa-phone' aria-hidden='true'></i> ";if($row['phone']=="") echo "Ajouter un";else echo "Editer le"; echo " téléphone</a></li>";
												echo "<li><a href='#addLogin' data-toggle='modal'><i class='fa fa-key' aria-hidden='true'></i> ";if($row['login']=="") echo "Ajouter un";else echo "Editer le"; echo " code PIN</a></li>";
												echo "<li><a href='#addAddress' data-toggle='modal'><i class='fa fa-map-marker' aria-hidden='true'></i> ";if($row['address']=="") echo "Ajouter une ";else echo "Editer l'"; echo "adresse</a></li>";
											}
										?>
									</ul>
								</div>
							</div>
						</div>
						<?php };?>
					</div>
				</div>
			</div>
			<?php if(isset($_GET['addnewproject']) && $_SESSION['user'][1]==1){?>
				<div class="col-md-6">
				<div class="mainSection">
					<div class="sections">
						<div class="MainSection">
							<div class="StatChart">
								<div class="MainSectionTitle">
									<h4><i class="fa fa-plus fa-lg"></i> NOUVEAU PROJET</h4>
								</div>
								<div class="MainSectionContent add-project">
									<form method="POST" enctype="multipart/form-data" id="registration-form">
									<?php
										if(isset($_POST['doaddproject'])){
											$pic_name = $_FILES['pic']['name'];
											$pic_tmp = $_FILES['pic']['tmp_name'];
											$pic_size = $_FILES['pic']['size'];
											$titre = $_POST['titre'];
											$prix = $_POST['prix'];
											$duree = $_POST['duree'];
											$catego = $_POST['catego'];
											$desc = $_POST['description'];
											if($pic_name=="" || $titre=="" || $prix=="" || $duree=="" || $catego=="" || $desc==""){
												echo "<div class='alert alert-danger'>Vous devez remplir tous les champs et choisir une image</div>";
											}else{
												if($pic_size>=1024*1024*3){
													echo "<div class='alert alert-danger'>L'image est très volumineuse</div>";
												}else{
													if(strlen($desc)>3600){
														echo "<div class='alert alert-danger'>La description est très long</div>";	
													}else{
														$res = $conn->query("INSERT INTO projet VALUES('', '$titre', 'images/projects/$pic_name', '$desc', CURDATE(), CURTIME(), $prix, $duree, 0, {$_SESSION['user'][0]}, $catego)");
														if($res){
															echo "<div class='alert alert-success'>Le projet à été publié avec succès</div>";
															if(move_uploaded_file($pic_tmp, "images/projects/$pic_name")){
																echo "<div class='alert alert-success'>L'image è été copié avec succès</div>";
															}else{
																echo "<div class='alert alert-danger'>Erreur de copier l'image sélectionné</div>";
															}
														}else{
															echo "<div class='alert alert-danger'>Erreur dans l'enregistrement des données</div>";
														}
													}
												}
											}
										}
									?>
										<div class="row"><center>
											<div class="from-group imgadding">
												<input type="file" id="pic" name="pic" class="hidden" />
												<img src="images/avatars/1.png" for='pic' id="picimg">
												<i class="fa fa-edit edtico"></i><br>
												<label class="filenm"></label>
											</div></center>
										</div>
										<div class="row">
											<div class="form-group  col-sm-12">
											    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="titre" placeholder="Le titre de projet" data-validation="length" data-validation-length="8-90" data-validation-error-msg="de 8 à 90 caractères" name="titre">
											</div>
										</div>	
										<div class="row">
											<div class="form-group col-sm-6">
											    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="prix" placeholder="Le prix" data-validation="number" data-validation-length="" name="prix">
											</div>
											<div class="form-group col-sm-6">
											    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="duree" placeholder="La durée : nombre de jours" data-validation="number length" data-validation-length="1-3" name="duree">
											</div>
										</div>
										<div class="row">
											<div class="form-group col-sm-12">
											    <select name="catego" class="form-control select-field col-xs-12 col-sm-5" id='catego' data-validatio='required'>
												<?php
													$res = $conn->query("SELECT * FROM categorie")	    ;
													while($row = $res->fetch_array()){
														echo "<option value='{$row['id_cat']}'>{$row['titre_cat']}</option>";
													}
												?>
											    </select>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-sm-12">
												<small class="text-danger"><b><span id="pres-max-length">3600</span></b> characters resté</small>
      											<textarea class="col-xs-12" name="description" id="presentation" rows="5" placeholder="décrivez le projet ici"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-sm-12">
												<button type="submit" class="btn btn-primary btn-identy pull-right" name="doaddproject">PUBLIER</button>
												<button type="reset" class="btn btn-default btn-identy pull-right" style="background-color:#bbb;margin-right: 10px;">REPRONDRE</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php }elseif(isset($_GET['addnewstage'])){?>
			<div class="col-md-6">
				<div class="mainSection">
					<div class="sections">
						<div class="MainSection">
							<div class="StatChart">
								<div class="MainSectionTitle">
									<h4><i class="fa fa-users fa-lg"></i> Publier une demande des stagiaires</h4>
								</div>
								<div class="MainSectionContent">
								<?php
									if(isset($_POST['doaddstage'])){
										$pic_name = $_FILES['pic2']['name'];
										$pic_tmp = $_FILES['pic2']['tmp_name'];
										$titre = addslashes($_POST['titre']);
										$description = addslashes($_POST['description']);
										$nbs = $_POST['nbs'];
										if($pic_name=="" || $titre=="" || $description=="" || $nbs==""){
											echo "<div class='alert alert-danger'>Svp, remplir tous les champs</div>";
										}else{
											if(move_uploaded_file($pic_tmp, "images/stages/$pic_name")){
												$ville = $profile['ville'];
												$res = $conn->query("INSERT INTO stage VALUES('', '$titre', '$description', '$ville', 'images/stages/$pic_name', CURDATE(), CURTIME(), $nbs, 0, $id)");
												if($res){
													echo "<div class='alert alert-success'>Le stage à été publié avec succès</div>";
												}else{
													echo "<div class='alert alert-danger'>Erreur dans l'enregistrement des données</div>";
												}
											}else{
												echo "<div class='alert alert-danger'>Erreur de copier l'image</div>";	
											}
										}
									}
								?>
									<form method="POST" enctype="multipart/form-data">
										<div class="row"><center>
											<div class="from-group imgadding">
												<input type="file" id="pic2" name="pic2" class="hidden" />
												<img src="images/avatars/1.png" for='pic2' id="picimg2">
												<i class="fa fa-edit edtico"></i><br>
												<label class="filenm2"></label>
											</div></center>
										</div>
										<div class="row">
											<div class="form-group  col-sm-12">
											    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="titre" placeholder="Le titre de stage" data-validation="length" data-validation-length="8-90" data-validation-error-msg="de 8 à 90 caractères" name="titre">
											</div>
										</div>
										<div class="row">
											<div class="form-group col-sm-12">
												<small class="text-danger"><b><span id="pres-max-length">3600</span></b> caractères resté</small>
      											<textarea class="col-xs-12" name="description" id="presentation" rows="5" placeholder="décrivez le projet ici"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="form-group  col-sm-12">
											    <input type="text" class="form-control text-field col-xs-12 col-sm-5" id="nbs" placeholder="Nombre de stagiaires demandé" data-validation="number" data-validation-length="8-90" data-validation-error-msg="chiffres seulement" name="nbs">
											</div>
										</div>
										<div class="row">
											<div class="form-group col-sm-12">
												<button type="submit" class="btn btn-primary btn-identy pull-right" name="doaddstage">PUBLIER</button>
												<button type="reset" class="btn btn-default btn-identy pull-right" style="background-color:#bbb;margin-right: 10px;">REPRONDRE</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<?php }else{?>
			<div class="col-md-6">
				<div class="mainSection">
					<div class="sections">
						<div class="MainSection">
							<div class="StatChart">
								<div class="MainSectionTitle">
									<h4><i class="fa fa-money fa-lg"></i> MES FONDS</h4>
								</div>
								<div class="MainSectionContent">
									stat GRAPH nombre de realisation par moi
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="col-md-3">
				<div class="rightSidebar">
					<div class="boxs">
						<div class="box">
							<div class="boxTitle">
								<h4><i class="fa fa-comments" aria-hidden="true"></i> Votre messages</h4>
							</div>
							<div class="boxContent">
								<div class="nnn">
									<?php echo $conn->query("SELECT count(*) nb FROM contacter WHERE (id_from_c=$id OR id_to_c=$id) AND type_to_c=0")->fetch_array()['nb'];?>
								</div>
								<div class="messagesTitre">
									NOUVEAUX MESSAGES
								</div>
								<div class="messagesBtn">
									<a href="messages.php" class="btn btn-primary">mes messages</a>
								</div>
							</div>
						</div>
						<div class="box">
							<div class="boxTitle">
								<h4><i class="fa fa-briefcase" aria-hidden="true"></i> Votre realisation</h4>
							</div>
							<div class="boxContent">
								<div class="nnn">
									0
								</div>
								<div class="messagesTitre">
									REALISATION
								</div>
								<div class="messagesBtn">
									<a href="realisations.php" class="btn btn-danger">mes realisations</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<?php if($_SESSION['user'][1]==0){?>
<!-- Modal -->
<div class="modal fade" id="addAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EDITION DE PHOTO DE PROFILE</h4>
      </div>
      <form method='post' id='registration-form' enctype="multipart/form-data">
      <div class="modal-body">
      <?php
      	if(isset($_POST['editAvatar'])){
      		$pic_name = $_FILES['pic1']['name'];
      		$pic_tmp = $_FILES['pic1']['tmp_name'];
      		$pic_size = $_FILES['pic1']['size'];
      		if($pic_name==""){
      			echo "<div class='alert alert-danger'>Aucune images sélectionné</div>";
      		}else{
      			if($pic_size>=1024*1024*3){
      				echo "<div class='alert alert-danger'>L'mages sélectionné est très volumineuse</div>";
      			}else{
      				if(move_uploaded_file($pic_tmp, $profile['avatar'])){
      					echo "<div class='alert alert-success'>La photo de profile à été modifié avec succès</div>";
      				}else{
      					echo "<div class='alert alert-danger'>Erreur de modification de l'image</div>";
      				}
      			}
      		}
      	}
      ?>
      <div class="row"><center>
		<div class="from-group imgadding1">
			<input type="file" id="pic1" name="pic1" class="hidden" />
			<img src="<?php echo $profile['avatar'];?>" for='pic1' id="picimg1">
			<i class="fa fa-edit edtico"></i><br>
			<label class="filenm1"></label>
		</div></center>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type='submit' class='btn btn-primary' name='editAvatar'>Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- Modal -->
<div class="modal fade" id="addBio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EDITER LA BIOGRAPHIE</h4>
      </div>
      <form method='post' id='registration-form'>
      <div class="modal-body">
      <?php
      	if(isset($_POST['editBio'])){
			$bio = addslashes($_POST['mybio']);
			$res = $conn->query("UPDATE $cmpt SET bio='$bio' WHERE id=$id");
			if($res){
				echo "<div class='alert alert-success'>Votre Bio est met à jour aver succès</div>";
			}else{
				echo "<div class='alert alert-danger'>Erreur dans la mis a jour des données</div>";
			}
		}
      ?>
      <small class="text-danger"><b><span id="pres-max-length">160</span></b> characters resté</small>
      	<textarea class="col-xs-12" name="mybio" id="presentation" rows="5" placeholder="décrivez vous ici"><?php echo $profile['bio'];?></textarea>
      </div><div class="clearfix"></div><br>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type='submit' class='btn btn-primary' name='editBio'>Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
<?php }?>
<!-- Modal -->
<div class="modal fade" id="addLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EDITER LE LOGIN</h4>
      </div>
      <form method='post' id='registration-form'>
      <div class="modal-body">
      	<?php 
      		if(isset($_POST['editLogin'])){
      			$pin = $_POST['pin'];
      			$pwd = md5($_POST['pwd']);
      			if($pwd == $profile['pwd']){
      				if(strlen($pin)>=4 && is_numeric($pin)){
      					$res = $conn->query("UPDATE $cmpt SET login='$pin' WHERE id=$id");
      					if($res){
      						echo "<div class='alert alert-success'>Le code PIN à été modifié avec succès</div>";
      					}else{
      						echo "<div class='alert alert-danger'>Erreur de modification de données</div>";
      					}
      				}else{
      					echo "<div class='alert alert-danger'>Le PIN doit être 4 <u>chiffres</u> ou plus</div>";	
      				}
      			}else{
      				echo "<div class='alert alert-danger'>Le mot de passe est incorrect</div>";
      			}
      		}
      	?>
      	<div class="row">
			<div class="form-group col-xs-12">
			    <input type="password" class="form-control text-field" id="pin" placeholder="Entrer un code PIN" data-validation="length number" data-validation-length="4-10" data-validation-error-msg="4 à 10 chiffres" name="pin">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-xs-12">
			    <input type="password" class="form-control text-field" id="phone" placeholder="Mot de passe" data-validation="strength required" data-validation-strength="2" name="pwd">
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type='submit' class='btn btn-primary' name='editLogin'>Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- Modal -->
<div class="modal fade" id="addPhone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EDITER LE NUMERO DE TELEPHONE</h4>
      </div>
      <form method='post' id='registration-form'>
      <div class="modal-body">
      <?php
      	if(isset($_POST['editPhone'])){
			$phone = addslashes($_POST['phone']);
			if(is_numeric($phone)) $res = $conn->query("UPDATE $cmpt SET phone='$phone' WHERE id=$id");
			else echo "<div class='alert alert-danger'>Svp, entrer un numeéro du téléphone valide</div>"; 
			if($res){
				echo "<div class='alert alert-success'>Votre numéro du téléphone à été modiffé aver succès</div>";
			}else{
				echo "<div class='alert alert-danger'>Erreur dans la modification des données</div>";
			}
		}
      ?>
      	<div class="row">
			<div class="form-group col-xs-12">
			    <input type="text" class="form-control text-field" id="phone" placeholder="Votre numéro du téléphone" data-validation="length number" data-validation-length="10-10" value="<?php echo $profile['phone'];?>" data-validation-error-msg="Numéro du téléphone en 10 chiffres" name="phone">
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type='submit' class='btn btn-primary' name='editPhone'>Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- Modal -->
<div class="modal fade" id="addAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EDITION DE L'ADRESSE</h4>
      </div>
      <form method='post' id='registration-form'>
      <div class="modal-body">
      <?php
      	if(isset($_POST['editaddress'])){
      		if(strlen($_POST['address'])<=120){
      			$res = $conn->query("UPDATE $cmpt SET address='{$_POST['address']}' WHERE id=$id");
      			if($res){
      				echo "<div class='alert alert-success'>L'adresse à été modifé avec succès</div>";
      			}else{
      				echo "<div class='alert alert-danger'>Erreur dans la modification des données</div>";
      			}
      		}else{
      			echo "<div class='alert alert-danger'>L'adresse doit être 120 caractère ou moins</div>";
      		}
      	}
      ?>
      	<div class="row">
			<div class="form-group col-xs-12">
			    <input type="text" class="form-control text-field" id="address" placeholder="Votre adresse" data-validation="length required" data-validation-length="5-120" value="<?php echo $profile['address'];?>" data-validation-error-msg="" name="address">
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type='submit' class='btn btn-primary' name='editaddress'>Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
<?php include('footer.php');?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#picimg").click(function(){
			$("#pic").click();
		})
		$("#picimg").mouseenter(function(){$(".edtico").css("display", "inline-block");})
		$("#picimg").mouseleave(function(){$(".edtico").css("display", "none");})
		$("#pic").change(function(){
			$(".filenm").html(this.files[0].name);
		})

		$("#picimg1").click(function(){
			$("#pic1").click();
		})
		$("#picimg1").mouseenter(function(){$(".edtico").css("display", "inline-block");})
		$("#picimg1").mouseleave(function(){$(".edtico").css("display", "none");})
		$("#pic1").change(function(){
			$(".filenm1").html(this.files[0].name);
		})
		$("#picimg2").click(function(){
			$("#pic2").click();
		})
		$("#picimg2").mouseenter(function(){$(".edtico").css("display", "inline-block");})
		$("#picimg2").mouseleave(function(){$(".edtico").css("display", "none");})
		$("#pic2").change(function(){
			$(".filenm2").html(this.files[0].name);
		})
	})
</script>