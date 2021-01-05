<?php include('header.php');include('isvalide.php');
if(! isset($_SESSION['user'])) header("location: index.php");
$id = $_SESSION['user'][0];
if($_SESSION['user'][1]==0) $cmpt = "freelancer";
else $cmpt = "entreprise";
$res = $conn->query("SELECT * FROM $cmpt WHERE id=$id");
$profile = $res->fetch_array();

if(isset($_GET['section'])) $page_type=$_GET['section'];
else $page_type = "general";
?>

<?php if($_SESSION['user'][1]==0){?>
<div class="page editprofile">
	<div class="container">
		<div class="col-sm-4">
			<div class="col-content col-left">
				<div class="title">
					<span>Mon compte</span>
				</div>

				<div class="content">
					<ul>
						<li <?php if($page_type=="general") echo "class='active'";?>><a href="editprofile.php?section=general">Infomations Personnels</a></li>
						<li <?php if($page_type=="password") echo "class='active'";?>><a href="editprofile.php?section=password">Mot de passe</a></li>
						<li <?php if($page_type=="diplome") echo "class='active'";?>><a href="editprofile.php?section=diplome">Diplômes et Expériences</a></li>
						<li <?php if($page_type=="verify") echo "class='active'";?>><a href="editprofile.php?section=verify">Verifier mon compte</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-sm-8">
			<div class="col-content col-right">
			<?php
			if(isset($_POST['btnsave'])){
				$nom = addslashes($_POST['nom']);
				$prenom = addslashes($_POST['prenom']);
				$email = addslashes($_POST['email']);
				$phone = addslashes($_POST['phone']);
				$address = addslashes($_POST['address']);
				$website = addslashes($_POST['website']);
				$pays = addslashes($_POST['pays']);
				$dnais = $_POST['dnais'];
				$sexe =addslashes($_POST['sexe']);
				$bio = addslashes($_POST['bio']);
				$fb = addslashes($_POST['fb']);
				$yt = addslashes($_POST['yt']);
				$tw = addslashes($_POST['tw']);
				$gp = addslashes($_POST['gp']);
				$gh = addslashes($_POST['gh']);
				$ins = addslashes($_POST['ins']);
				$email_changed=false;
				if($email!==$profile['email']) $email_changed=true;
				if($nom=="" || $prenom=="" || $email=="" || $pays==""){
					echo "<div class='alert alert-danger'>vous devez replir les champs obligé(nom, prenom, email, pays)</div>";
				}else{
					/*if($email_changed){
						$keycode = generate_pwd(0,0,7);
						$key = md5($keycode);
						echo "<div class='alert alert-success'>
								<div>
									votre code d'activation est : <b>$keycode</b><br>
									vous pouvez activer le compte on cliquant sur le lien :<br>
									<a href='http://localhost/projectpark/activation.php?key=$key' target='_blank'>http://localhost/projectpark/activation.php?key=$key</a>
								</div>
							</div>";
					}*/
					$res = $conn->query("UPDATE freelancer SET nom='$nom', prenom='$prenom', phone='$phone', address='$address', pays='$pays', email='$email', date_nais='$dnais', bio='$bio', fb='$fb', gh='$gh', tw='$tw', yt='$yt', gp='$gp', ins='$ins', siteweb='$website', sexe='$sexe' WHERE id=$id");
					if($res){
						echo "<div class='alert alert-success'>Les informations personnels sont modifié avec succès</div>";	
						if($_FILES['pic']['name']!=""){
							$pic_size = $_FILES['pic']['size'];
							$pic_tmp = $_FILES['pic']['tmp_name'];
							if(move_uploaded_file($pic_tmp, $profile['avatar'])){
								echo "<div class='alert alert-success'>La photo de profile est modifié avec succès</div>";	
							}else{
								echo "<div class='alert alert-danger'>Problème de modifier la photo de profile</div>";
							}
						}
						$rs = $conn->query("DELETE FROM langue WHERE id=$id");
						$rs = $conn->query("DELETE FROM loisir WHERE id=$id");
						foreach($_POST['lang'] as $i=>$lang){
							$rs = $conn->query("INSERT INTO langue VALUES('', $id, '$lang', '{$_POST['val'][$i]}')");
						}
						foreach($_POST['loisir'] as $loisir){
							$rs = $conn->query("INSERT INTO langue VALUES('', '$loisir', $id");
						}
					}else{
						echo "<div class='alert alert-danger'>Erreur d'enregistrement des informations, essayer plus tard</div>";
					}
				}
			}
			if(isset($_GET['dellang'])){
				$del = $_GET['dellang'];
				$rs = $conn->query("DELETE FROM langue WHERE id_l=$del");
				if($rs){
					echo "<div class='alert alert-success'>La langue è été supprimé</div>";
					echo "<meta http-equiv='refresh' content='0, editprofile.php?section=general'>";
				}else{
					echo "<div class='alert alert-danger'>Erreur dans la supprission de langue, essayer plus tard</div>";
				}
			}
			?>
				<?php if($page_type=="general") echo "<div class='title'><span>Les informations personnels</span></div>";
				elseif($page_type=="password") echo "<div class='title'><span>Paramêtres de sécurité</span></div>";
				elseif($page_type=="diplome") echo "<div class='title'><span>Mes Diplômes et Expériences</span></div>";
				elseif($page_type=="verify") echo "<div class='title'><span>Verifier Votre Email</span></div>";?>

				<div class="content c2">
					<form method="POST" enctype="multipart/form-data">
					<?php if($page_type=="general"){?>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="nom">Nom</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="nom" placeholder="Nom" data-validation="length alphanumeric" data-validation-length="3-20" name="nom" value="<?php echo $profile['nom'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="phone">Tele</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="phone" placeholder="Nom" data-validation="length alphanumeric" data-validation-length="10-10" name="phone" value="<?php echo $profile['phone'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="prenom">Prénom</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="prenom" placeholder="Prénom" data-validation="length alphanumeric" data-validation-length="3-20" name="prenom" value="<?php echo $profile['prenom'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="website">Site web</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="website" placeholder="Votre site web" data-validation="length" data-validation-length="3-50" name="website" value="<?php echo $profile['siteweb'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="email">E-mail</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="nom" placeholder="Nom" data-validation="length email" data-validation-length="3-50" name="email" value="<?php echo $profile['email'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="address">Adresse</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="address" placeholder="Votre adresse" data-validation="length" data-validation-length="3-60" name="address" value="<?php echo $profile['address'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="pay">Pays</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="pay" placeholder="Votre pays" data-validation="length" data-validation-length="3-20" name="pays" value="<?php echo $profile['pays'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="dnais">Naissance</label></div>
								<div class="col-md-9">
									<input type="date" class="form-control text-field col-xs-12 col-sm-5" id="dnais" placeholder="Date de naissance" data-validation="length" data-validation-length="3-20" name="dnais" value="<?php echo $profile['date_nais'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="pay">Sexe</label></div>
								<div class="col-md-9">
									<input type="radio" name="sexe" value="homme" <?php if($profile['sexe']=="homme")echo "checked";?>/> Homme
									<input type="radio" name="sexe" value="homme" <?php if($profile['sexe']=="femme")echo "checked";?>/> Femme
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-12"><label class="col-md-12" for="dnais" id="pdp">Photo de profile</label></div>
								<div class="col-md-12 imgadding"><center>
									<input type="file" id="pic" name="pic" class="hidden" />
									<img src="<?php echo $profile['avatar'];?>" class='img-circle' for='pic' id="picimg">
									<i class="fa fa-edit edtico"></i><br>
									<label class="filenm">parcourir</label></center>
								</div>
							</div>
						</div>
						<div class="title"><span>Bio</span></div>
						<div class="row">
							<div class="form-group col-sm-12">
								<small class="text-danger pull-right"><b><span id="pres-max-length">160</span></b> characters resté</small>
      							<textarea class="col-xs-12" name="bio" id="presentation" rows="4" placeholder="décrivez vous ici"><?php echo $profile['bio'];?></textarea>
							</div>
						</div>	
						<div class="title"><span>Social Profiles</span></div><br>
						<div class="row">
							<div class="form-group col-sm-4">
								<div class="input-group">
					                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
					                <input type="text" class="form-control" id="fb" placeholder="lien facebook" name="fb" value="<?php echo $profile['fb'];?>">
					            </div>
					        </div>
					        <div class="form-group col-sm-4">
								<div class="input-group">
					                <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
					                <input type="text" class="form-control" id="gp" placeholder="lien google plus" name="gp" value="<?php echo $profile['gp'];?>">
					            </div>
					        </div>
					        <div class="form-group col-sm-4">
								<div class="input-group">
					                <span class="input-group-addon"><i class="fa fa-github"></i></span>
					                <input type="text" class="form-control" id="gh" placeholder="lien github" name="gh" value="<?php echo $profile['gh'];?>">
					            </div>
					        </div>
						</div>
						<div class="row">
							<div class="form-group col-sm-4">
								<div class="input-group">
					                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
					                <input type="text" class="form-control" id="ins" placeholder="lien instagram" name="ins" value="<?php echo $profile['ins'];?>">
					            </div>
					        </div>
					        <div class="form-group col-sm-4">
								<div class="input-group">
					                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
					                <input type="text" class="form-control" id="tw" placeholder="lien twitter" name="tw" value="<?php echo $profile['tw'];?>">
					            </div>
					        </div>
					        <div class="form-group col-sm-4">
								<div class="input-group">
					                <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
					                <input type="text" class="form-control" id="yt" placeholder="lien youtube" name="yt" value="<?php echo $profile['yt'];?>">
					            </div>
					        </div>
						</div><br>
						<div class="title"><span>Loisirs</span></div>
						<div class="row"><br>
							<div class="form-group">
								<div class="input-group col-sm-5" style="margin-left: 15px;">
									<input type="text" class="form-control text-field" id="loiItem">
									<span class="input-group-addon addn" id="additem"><i class="fa fa-plus"></i></span>
								</div>
							</div>
							<br>
							<div class="form-group col-sm-12">
								<select multiple data-role="tagsinput" id="loisir" name="loisir[]" multiple maxtags="10" maxChars="50">
									<?php
										$rs = $conn->query("SELECT * FROM loisir WHERE id=$id");
										while($rw = $rs->fetch_array()){
											echo "<option value='{$rw['titre_loi']}'>{$rw['titre_loi']}</option>";
										}
									?>
								</select>	
							</div>
						</div><br>
						<div class="title"><span>Langues metrise</span> <button type="button" class="btn btn-none text-info" onclick="addVal()"><i class="fa fa-plus"></i></button></div><br>
						<div class="row">
							<div class="form-group col-sm-12">
								<span id='Vals'>
								<?php 
								$nblang=0;
									$rs = $conn->query("SELECT * FROM langue WHERE id=$id");
									while($rw = $rs->fetch_array()){
										echo "<input type='text' class='form-control text-field' name='lang[]' style='width: 40%;float: left;' placeholder='langue' value='{$rw['title_l']}'> <input type='text'  class='form-control text-field' name='val[]' value='{$rw['prc']}' style='width: 30%;float: right;' placeholder='pourcentage de métrise'> <a href='editprofile.php?section=general&dellang={$rw['id_l']}' title='supprimer'><i class='fa fa-trash'></i></a> <br><br>";
										$nblang++;
									}
								?>
								</span>
							</div>
						</div>
						<div class="row">
							<button type="submit" id="btnsave" name="btnsave" class="btn btn-primary btn-identy pull-right"  style="margin-right: 20px;">Enregistrer</button>
						</div>
					<?php }elseif($page_type=="password"){
							if(isset($_POST['savepwd'])){
								$pass = $_POST['pass'];
								$pass_confirmation = $_POST['pass_confirmation'];
								$oldpwd = $_POST['oldpwd'];
								if(md5($oldpwd)==$profile['pwd']){
									if($pass==$pass_confirmation){
										$pass = md5($pass);
										$res = $conn->query("UPDATE $cmpt SET pwd='$pass' WHERE id=$id");
										if($res){
											echo "<div class='alert alert-success'>Le mot de passe è été modifié avec succès</div>";
										}else{
											echo "<div class='alert alert-danger'>Problème de modifier le mot de passe, essayer plus tard</div>";
										}
									}else{
										echo "<div class='alert alert-danger'>Les deux mots de passe sont différents</div>";
									}
								}else{
									echo "<div class='alert alert-danger'>L'anciant mot de passe est incorrect</div>";
								}
							}
						?>
						<div class="row">
							<div class="col-sm-3"></div>
							<div class="form-group col-sm-6 center-block">
								<label for='oldpwd'>Anciant mot de passe</label>
								<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="oldpwd" data-validation="length" data-validation-length="8-30" name="oldpwd" placeholder="Anciant mot de passe">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"></div>
							<div class="form-group col-sm-6 center-block">
								<label for='pwd'>Nouveau mot de passe</label>
							    <input type="password" class="form-control text-field col-xs-12 col-sm-5" id="pwd" placeholder="Mot de passe" data-validation="length strength" data-validation-length="8-30" data-validation-strength="2" name="pass_confirmation">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"></div>
							<div class="form-group col-sm-6 center-block">
								<label for='pwdconfirm'>Retapper mot de passe</label>
							    <input type="password" class="form-control text-field col-xs-12 col-sm-5" id="pwdconfirm" placeholder="Confirmer le mot de passe" data-validation="confirmation" name="pass">
							</div>
						</div>
						<div class="row">
							<button type="submit" id="btnsave" name="savepwd" class="btn btn-primary btn-identy pull-right"  style="margin-right: 20px;">Enregistrer</button>
						</div>
					<?php }elseif($page_type=="diplome"){
						if(isset($_GET['deldexp'])){
							$del = $_GET['deldexp'];
							if($deldexp>=1 && is_numeric($deldexp)){
								$rs = $conn->query("DELETE FROM diplomexp WHERE id_dexp=$del");
							}
						}
						if(isset($_POST['savediplome'])){
							$titre = $_POST['titre'];
							$type = $_POST['type'];
							$debut = $_POST['debut'];
							$fin = $_POST['fin'];
							if($titre=="" || $type=="" || $debut=="" || $fin==""){
								echo "<div class='alert alert-danger'>Remplir tous les champs</div>";
							}else{
								$res = $conn->query("INSERT INTO diplomexp VALUES('', '$titre', $type, '$debut', '$fin')");
								if(!$res){
									echo "<div class='alert alert-danger'>Erreur d'ajout de données, essayer plus tard</div>";
								}
							}
						}
						?>
						<div class="row">
							<div class="form-group">
								<table class="table-striped tbldexp" width="100%">
									<thead>
										<tr style="height: 50px;">
											<th>Titre</th>
											<th>type</th>
											<th>Début</th>
											<th>Fin</th>
											<th></th>
											<th><a href="editprofile.php?section=diplome&addnew=true"><button class="btn btn-none" type="button"><i class="fa fa-plus"></i></button></a></th>
										</tr>
									</thead>

									<tbody>
										<?php
											$rs = $conn->query("SELECT * FROM diplomexp");
											while($rw = $rs->fetch_array()){
												echo "<tr style='height:40px;'>
													<td class='nocenter'>{$rw['title_dexp']}</td>
													<td>";if($rw['type_dexp']==0)echo "diplome";else echo "expérience"; echo "</td>
													<td>{$rw['debut']}</td>
													<td>{$rw['fin']}</td>
													<td><a href='editprofile.php?section=diplome&deldexp={$rw['id_dexp']}' title='supprimer'><i class='fa fa-trash text-danger'></i></a>
												</tr>";
											}
											if(isset($_GET['addnew'])){
												echo "<tr>
													<td><input type='text' name='titre' class='form-control text-field'></td>
													<td><select name='type' class='form-group select-field'>
														<option value='0'>diplôme</option>
														<option value='1'>expérience</option>
													</select></td>
													<td><input type='text' name='debut' class='form-control text-field'></td>
													<td><input type='text' name='fin' class='form-control text-field'></td>
												</tr>";
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
						<?php
							if(isset($_GET['addnew'])){
								echo "<button type='submit' id='btnsave' name='savediplome' class='btn btn-primary btn-identy pull-right'  style='margin-right: 20px;'>Enregistrer</button>";
								echo "<a href='editprofile.php?section=diplome'><button type='button' id='btnsave' name='savediplome' class='btn btn-identy btn-none pull-right'  style='margin-right: 20px;'>Annuler</button></a>";
							}
						?>
						</div>
					<?php }?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{?>

<div class="page editprofile">
	<div class="container">
		<div class="col-sm-4">
			<div class="col-content col-left">
				<div class="title">
					<span>Mon compte</span>
				</div>

				<div class="content">
					<ul>
						<li <?php if($page_type=="general") echo "class='active'";?>><a href="editprofile.php?section=general">Infomations Personnels</a></li>
						<li <?php if($page_type=="password") echo "class='active'";?>><a href="editprofile.php?section=password">Mot de passe</a></li>
						<li <?php if($page_type=="verify") echo "class='active'";?>><a href="editprofile.php?section=verify">Verifier mon compte</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-sm-8 col-content col-right">
			<?php
			if(isset($_POST['saveentr'])){
				$nom = addslashes($_POST['nom']);
				$prenom = addslashes($_POST['prenom']);
				$email = addslashes($_POST['email']);
				$phone = addslashes($_POST['phone']);
				$address = addslashes($_POST['address']);
				$website = addslashes($_POST['website']);
				$pays = addslashes($_POST['pays']);
				$ville = addslashes($_POST['ville']);
				$raison = $_POST['raison'];
				$email_changed=false;
				if($email!==$profile['email']) $email_changed=true;
				if($nom=="" || $prenom=="" || $email=="" || $pays=="" || $ville==""){
					echo "<div class='alert alert-danger'>vous devez replir les champs obligé(nom, prenom, <b>email</b>, pays, <b>ville</b>)</div>";
				}else{
					/*if($email_changed){
						$keycode = generate_pwd(0,0,7);
						$key = md5($keycode);
						echo "<div class='alert alert-success'>
								<div>
									votre code d'activation est : <b>$keycode</b><br>
									vous pouvez activer le compte on cliquant sur le lien :<br>
									<a href='http://localhost/projectpark/activation.php?key=$key' target='_blank'>http://localhost/projectpark/activation.php?key=$key</a>
								</div>
							</div>";
					}*/
					$res = $conn->query("UPDATE entreprise SET nom='$nom', prenom='$prenom', phone='$phone', address='$address', pays='$pays', email='$email', raison='$raison', siteweb='$website', ville='$ville' WHERE id=$id");
					if($res){
						echo "<div class='alert alert-success'>Les informations personnels sont modifié avec succès</div>";	
						if($_FILES['pic']['name']!=""){
							$pic_size = $_FILES['pic']['size'];
							$pic_tmp = $_FILES['pic']['tmp_name'];
							if(move_uploaded_file($pic_tmp, $profile['avatar'])){
								echo "<div class='alert alert-success'>La photo de profile est modifié avec succès</div>";	
							}else{
								echo "<div class='alert alert-danger'>Problème de modifier la photo de profile</div>";
							}
						}
					}else{
						echo "<div class='alert alert-danger'>Erreur d'enregistrement des informations, essayer plus tard</div>";
					}
				}
			}
			?>

			<?php if($page_type=="general") echo "<div class='title'><span>Les informations personnels</span></div>";
				elseif($page_type=="password") echo "<div class='title'><span>Paramêtres de sécurité</span></div>";
				elseif($page_type=="verify") echo "<div class='title'><span>Verifier Votre Email</span></div>";?>

			<div class="content c2">
				<form method="POST" enctype="multipart/form-data">
				<?php if($_GET['section']=="general"){?>
					<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="nom">Nom</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="nom" placeholder="Nom" data-validation="length alphanumeric" data-validation-length="3-20" name="nom" value="<?php echo $profile['nom'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="phone">Tele</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="phone" placeholder="Nom" data-validation="length alphanumeric" data-validation-length="10-10" name="phone" value="<?php echo $profile['phone'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="prenom">Prénom</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="prenom" placeholder="Prénom" data-validation="length alphanumeric" data-validation-length="3-20" name="prenom" value="<?php echo $profile['prenom'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="website">Site web</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="website" placeholder="Votre site web" data-validation="length" data-validation-length="3-50" name="website" value="<?php echo $profile['siteweb'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="email">E-mail</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="email" placeholder="Nom" data-validation="length email" data-validation-length="3-50" name="email" value="<?php echo $profile['email'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="address">Adresse</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="address" placeholder="Votre adresse" data-validation="length" data-validation-length="3-60" name="address" value="<?php echo $profile['address'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="pay">Pays</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="pays" placeholder="Votre pays" data-validation="length" data-validation-length="3-20" name="pays" value="<?php echo $profile['pays'];?>">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="dnais">Raison social</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="raison" placeholder="Date de naissance" data-validation="length" data-validation-length="3-20" name="raison" value="<?php echo $profile['raison'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<div class="col-md-3"><label for="pay">Ville</label></div>
								<div class="col-md-9">
									<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="ville" placeholder="Votre pays" data-validation="length" data-validation-length="3-20" name="ville" value="<?php echo $profile['ville'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-md-12"><label class="col-md-12" for="dnais" id="pdp">Photo de profile</label></div>
								<div class="col-md-12 imgadding"><center>
									<input type="file" id="pic" name="pic" class="hidden" />
									<img src="<?php echo $profile['avatar'];?>" class='img-circle' for='pic' id="picimg">
									<i class="fa fa-edit edtico"></i><br>
									<label class="filenm">parcourir</label></center>
								</div>
							</div>
						</div>
						<div class="row">
							<button type="submit" id="btnsave" name="saveentr" class="btn btn-primary btn-identy pull-right"  style="margin-right: 20px;">Enregistrer</button>
						</div>
				<?php }elseif($page_type=="password"){
							if(isset($_POST['savepwd'])){
								$pass = $_POST['pass'];
								$pass_confirmation = $_POST['pass_confirmation'];
								$oldpwd = $_POST['oldpwd'];
								if(md5($oldpwd)==$profile['pwd']){
									if($pass==$pass_confirmation){
										$pass = md5($pass);
										$res = $conn->query("UPDATE $cmpt SET pwd='$pass' WHERE id=$id");
										if($res){
											echo "<div class='alert alert-success'>Le mot de passe è été modifié avec succès</div>";
										}else{
											echo "<div class='alert alert-danger'>Problème de modifier le mot de passe, essayer plus tard</div>";
										}
									}else{
										echo "<div class='alert alert-danger'>Les deux mots de passe sont différents</div>";
									}
								}else{
									echo "<div class='alert alert-danger'>L'anciant mot de passe est incorrect</div>";
								}
							}
						?>
						<div class="row">
							<div class="col-sm-3"></div>
							<div class="form-group col-sm-6 center-block">
								<label for='oldpwd'>Anciant mot de passe</label>
								<input type="text" class="form-control text-field col-xs-12 col-sm-5" id="oldpwd" data-validation="length" data-validation-length="8-30" name="oldpwd" placeholder="Anciant mot de passe">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"></div>
							<div class="form-group col-sm-6 center-block">
								<label for='pwd'>Nouveau mot de passe</label>
							    <input type="password" class="form-control text-field col-xs-12 col-sm-5" id="pwd" placeholder="Mot de passe" data-validation="length strength" data-validation-length="8-30" data-validation-strength="2" name="pass_confirmation">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"></div>
							<div class="form-group col-sm-6 center-block">
								<label for='pwdconfirm'>Retapper mot de passe</label>
							    <input type="password" class="form-control text-field col-xs-12 col-sm-5" id="pwdconfirm" placeholder="Confirmer le mot de passe" data-validation="confirmation" name="pass">
							</div>
						</div>
						<div class="row">
							<button type="submit" id="btnsave" name="savepwd" class="btn btn-primary btn-identy pull-right"  style="margin-right: 20px;">Enregistrer</button>
						</div>

				<?php }?>
				</form>
			</div>
		</div>
	</div>
</div>
<?php }include('footer.php');?>

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

		$("#additem").click(function(){
			$("#loisir").tagsinput("add", document.getElementById("loiItem").value);
			document.getElementById("loiItem").value="";
			document.getElementById("loiItem").focus();
		})
	})

	function addVal(){
		document.getElementById('Vals').innerHTML += "<input type='text' class='form-control text-field' name='lang[]' style='width: 40%;float: left;' placeholder='langue'> <input type='text'  class='form-control text-field' name='val[]' style='width: 30%;float: right;' placeholder='pourcentage de métrise'><br><br>";
	}
</script>