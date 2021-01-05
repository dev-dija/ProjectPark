<?php include('header.php');include('isvalide.php');
if((!isset($_GET['p']) || $_GET['p']<1 || !is_numeric($_GET['p'])) && !isset($_GET['logout'])) header("location: 404.php");
else{
	$res = $conn->query("SELECT * FROM projet WHERE id_p={$_GET['p']}");
	$projet = $res->fetch_array();
	$entreprise = $conn->query("SELECT * FROM entreprise WHERE id={$projet['id']}")->fetch_array();
	$cat = $conn->query("SELECT * FROM categorie WHERE id_cat={$projet['id_cat']}")->fetch_array();
	$proid=$_GET['p'];
	//////////////// ajouter une offre : $_GET['p'] is nessecary for it
	$of_err="";
	if(isset($_POST['addoffre'])){
		$desc = addslashes($_POST['of_desc']);
		$prix = addslashes($_POST['of_prix']);
		$duree = addslashes($_POST['of_duree']);
		if($prix=="" || $duree=="" || $desc==""){
			$of_err = "<div class='row alert alert-danger'>Vous devez remplir tout les champs</div>";
		}else{
			if(! is_numeric($prix) || ! is_numeric($duree) || $duree<1){
				$of_err = "<div class='row alert alert-danger'>Le prix doit être un double et la durée un entier positive supérieur ou égual à 1.</div>";
			}else{
				if(strlen($desc)>1000){
					$of_err = "<div class='row alert alert-danger'>La description doit contenir au moins 100 caractères.</div>";
				}else{
					$rs = $conn->query("INSERT INTO offre VALUES('','$desc', CURDATE(), CURTIME(), '$prix', '$duree', 0, {$_SESSION['user'][0]}, {$_GET['p']})");
					if($rs){
						$of_err = "<div class='row alert alert-success'>Votre offre à été enregistré</div>";
					}
					else $of_err = "<div class='row alert alert-danger'>Erreur d'enregistrement d'offre, essayer plus tard.</div>";
				}
			}
		}
	}

	$mission = $conn->query("SELECT * FROM mission WHERE id_p={$_GET['p']}")->fetch_array();
	if(isset($_GET['select']) && is_numeric($_GET['select']) && $_GET['select']>0 && isset($_GET['p'])){
		$sum_of = $conn->query("SELECT sum(etat_of) sum FROM offre WHERE id_p={$projet['id_p']}")->fetch_array()['sum'];
		if($sum_of==0){
			$idsel = $_GET['select'];
			$rs = $conn->query("UPDATE offre SET etat_of=1 WHERE id_of=$idsel");
			$rs = $conn->query("UPDATE projet SET etat_p=1 WHERE id_p={$_GET['p']}");
			$idf = $conn->query("SELECT id FROM offre WHERE id_of=$idsel")->fetch_array()['id'];
			$rs = $conn->query("INSERT INTO mission VALUES('', $idsel, $idf, {$_SESSION['user'][0]}, {$_GET['p']}, 0)");
			$res = $conn->query("SELECT * FROM projet WHERE id_p={$_GET['p']}");
			$projet = $res->fetch_array();
		}
	}
	if(isset($_GET['delof']) && is_numeric($_GET['delof']) && $_GET['delof']>0 && isset($_GET['p'])){
		$iddel = $_GET['delof'];
		$rs = $conn->query("DELETE FROM offre WHERE id_of=$iddel");
	}
	if(isset($_POST['sendmsg'])){
		$msg = addslashes($_POST['msg']);
		$from = $_SESSION['user'][0];
		if($mission['id_e']==$from) $to = $mission['id_f'];else $to = $mission['id_e'];
		$from_acc = $_SESSION['user'][1];
		if($from_acc==0) $to_acc=1;else $to_acc=0;
		$rs = $conn->query("INSERT INTO message VALUES('', '$msg', CURDATE(), CURTIME(), 0, {$mission['id_m']}, $from, $to, $from_acc, $to_acc)");
	}
	if(isset($_GET['finish'])){
		$isonefinish = $conn->query("SELECT isonefinish FROM mission WHERE id_m={$mission['id_m']}")->fetch_array()['isonefinish'];
		if($isonefinish==0){
			$rs = $conn->query("UPDATE mission SET isonefinish=1 WHERE id_m={$mission['id_m']}");
		}else{
			$rs = $conn->query("UPDATE projet SET etat_p=2 WHERE id_p={$_GET['p']}");
			$res = $conn->query("SELECT * FROM projet WHERE id_p={$_GET['p']}");
			$projet = $res->fetch_array();
		}
	}
}
?>
<link rel="stylesheet" type="text/css" href="admin/dist/css/AdminLTE.min.css">

<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="MainProject">
					<div class="projectTitle">
						<h2><?php echo $projet['titre_p'];?></h2>
					</div><?php
						if($projet['etat_p']!=0 && ($mission['id_e']==$_SESSION['user'][0] && $_SESSION['user'][1]==1 || $mission['id_f']==$_SESSION['user'][0] && $_SESSION['user'][1]==0)){?>
					<div class="projectInfos">
					
						<div class="Chatting">
							<div class="box box-warning direct-chat direct-chat-warning">
				                <div class="box-header with-border">
				                  <h3 class="box-title">Mission : <?php echo $projet['titre_p'];?></h3>
				                </div>
				                <!-- /.box-header -->
				                <div class="box-body" id="messanger">
				                  <!-- Conversations are loaded here -->
				                  <div class="direct-chat-messages">
				                  <?php
					                  $res = $conn->query("SELECT *,DATE_FORMAT(date_msg, '%m/%d/%Y') d,DATE_FORMAT(heur_msg, '%r') h FROM message  WHERE id_m={$mission['id_m']} ORDER BY id_msg DESC");
					                  while($row = $res->fetch_array()){
					                  	$from = array($row['mfrom'], $row['mfrom_acc']);
					                  	if($from[0] == $_SESSION['user'][0] && $from[1] == $_SESSION['user'][1]){
					                  		if($from[1]==0) $cmpt = "freelancer";else $cmpt = "entreprise";
					                  		$rw = $conn->query("SELECT * FROM $cmpt WHERE id={$from[0]}")->fetch_array();
						                  	echo "
						                    <div class='direct-chat-msg right'>
						                      <div class='direct-chat-info clearfix'>
						                        <span class='direct-chat-name pull-right'>{$rw['prenom']} {$rw['nom']}</span>
						                        <span class='direct-chat-timestamp pull-left'>".(time_passed($row['d'].' '.$row['h'], "il y a"))."</span>
						                      </div>
						                      <!-- /.direct-chat-info -->
						                      <img class='direct-chat-img' src='{$rw['avatar']}' alt='message user image'><!-- /.direct-chat-img -->
						                      <div class='direct-chat-text'>
						                        {$row['content_msg']}
						                      </div>
						                      <!-- /.direct-chat-text -->
						                    </div>";
					                    }else{
					                    	if($from[1]==0) $cmpt = "freelancer";else $cmpt = "entreprise";
					                  		$rw = $conn->query("SELECT * FROM $cmpt WHERE id={$from[0]}")->fetch_array();
						                    echo "
						                    <div class='direct-chat-msg'>
						                      <div class='direct-chat-info clearfix'>
						                        <span class='direct-chat-name pull-left'>{$rw['prenom']} {$rw['nom']}</span>
						                        <span class='direct-chat-timestamp pull-right'>".(time_passed($row['d'].' '.$row['h'], "il y a"))."</span>
						                      </div>
						                      <!-- /.direct-chat-info -->
						                      <img class='direct-chat-img' src='{$rw['avatar']}' alt='message user image'><!-- /.direct-chat-img -->
						                      <div class='direct-chat-text'>
						                        {$row['content_msg']}
						                      </div>
						                      <!-- /.direct-chat-text -->
						                    </div>";
					                	}	
					                   }
				                   ?>
				                  </div>
				                  <!--/.direct-chat-messages-->
				                  </div>
				                  <?php if($projet['etat_p']==1){?>
				                    <div class="box-footer">
					                  <form method="post">
					                    <div class="input-group">
					                      <input type="text" name="msg" placeholder="Tapper un Message ..." class="form-control">
					                          <span class="input-group-btn">
					                            <button type="submit" name="sendmsg" class="btn btn-warning btn-flat">Envoyer</button>
					                          </span>
					                    </div>
					                  </form>
					                </div><?php }?>
					                <!-- /.box-footer-->
				              </div>
				              <!--/.direct-chat -->
						</div>
						<?php if($projet['etat_p']==1) echo "<a href='project.php?p={$_GET['p']}&finish=true' class='btn btn-danger pull-right'>Terminer la mission</a>" ?>
					<div class="clearfix"></div></div><?php }?>

					<div class="projectInfos">
						<div class="rightInfo">
							<div class="budget">
								le budget :
								<h6><?php echo $projet['prix_p'];?> <span>DHs</span></h6>
							</div>
							<div class="duree">
								la durée :
								<h6><?php echo $projet['duree_p'];?> <span>jours</span></h6>
							</div>
						</div>
						<?php echo $rs = $conn->query("SELECT count(*) nb FROM offre NATURAL JOIN freelancer WHERE id_p={$_GET['p']}")->fetch_array()['nb'];?> offre(s) reçue(s), 
						<?php if($projet['etat_p']==0) echo "<span class='stat projectDispo'>disponible</span>";
							  elseif($projet['etat_p']==1) echo "<span class='stat projectEncour'>En cours</span>";
							  elseif($projet['etat_p']==2) echo "<span class='stat projectFinish'>Finish</span>";?>
						<div class="projectCat">
							<i class="fa fa-<?php echo $cat['icon_cat'];?>" aria-hidden="true"></i> <?php echo $cat['titre_cat'];?>
						</div>
						<div class="projectVus">
							<i class="fa fa-eye" aria-hidden="true"></i>  58 vue(s)
						</div>
						<div class="projectTimerest">
							<i class="fa fa-clock-o" aria-hidden="true"></i> 40 jour(s) 16 heure(s) restants.
						</div>
						<div class="projectSkils">
							<h5><i class="fa fa-tasks" aria-hidden="true"></i> Compétences requises :</h5>
							<ul>
								<li>Action commercial</li>
								<li>Strategie commerciale</li>
								<li>php</li>
								<li>HTML/CSS</li>
								<div class="c"></div>
							</ul>
						</div>
					</div>
					<div class="projectDesc">
						<h4><i class="fa fa-list" aria-hidden="true"></i> Description du projet :</h4>
						<p>
							<?php echo $projet['description_p'];?>
						</p>
					</div>
				</div>
				<!-- offers bg-color classes : color1, OfferOK -->
				<div class="OffersSection">
					<div class="OffersSectionTitle">
						<h4><i class="fa fa-comments" aria-hidden="true"></i> APPEL D'OFFRES DES FREELANCERS (<?php echo $conn->query("SELECT count(*) nb FROM offre WHERE id_p={$_GET['p']}")->fetch_array()['nb'];?>)</h4>
					</div>
					<div class="OffersSectionContent">
						<ul>
						<?php
							$rs = $conn->query("SELECT *,DATE_FORMAT(date_of, '%m/%d/%Y') d,DATE_FORMAT(heur_of, '%r') h FROM offre NATURAL JOIN freelancer WHERE id_p={$_GET['p']} ORDER BY date_of DESC, heur_of DESC");
							while($rw = $rs->fetch_array()){
								$ilya = time_passed($rw['d']." ".$rw['h']);
								$isOK="";
								if($rw['etat_of']==1) $isOK = "OfferOK";
								echo "
							<li class='$isOK'>
								<div class='row'>
									<div class='col-md-12'>
										<div class='offerUser'>
											<div class='row'>
												<div class='col-md-2'>
													<div class='offerImg'>
														<img src='{$rw['avatar']}'>
													</div>
													<div class='OfferDetail'>
														<div class='OfferBudjet'>
															{$rw['prix_of']} <span>DHs</span>
														</div>
														<div class='OfferBudjet'>
															{$rw['duree_of']} <span>Jours</span>
														</div>
													</div>
												</div>
												<div class='col-md-10'>
													<h4><a href='profile.php?id={$rw['id']}&t=0'>{$rw['prenom']} {$rw['nom']}</a><span> , <i class='fa fa-clock-o' aria-hidden='true'></i> $ilya</span>
													"; if($rw['etat_of']==0 && $_SESSION['user'][1]==1 && $projet['etat_p']==0) echo "<a href='project.php?p={$_GET['p']}&select={$rw['id_of']}' class='btn btn-success pull-right'>sélectionner</a>";elseif($rw['id']==$_SESSION['user'][0] && $_SESSION['user'][1]==0 && $projet['etat_p']==0) echo "<a href='project.php?p={$_GET['p']}&delof={$rw['id_of']}' class='btn btn-danger pull-right'><i class='fa fa-trash' aria-hidden='true'></i></a>"; echo "</h4>
													<div class='stars'>
														<i class='fa fa-star' aria-hidden='true'></i>
														<i class='fa fa-star' aria-hidden='true'></i>
														<i class='fa fa-star' aria-hidden='true'></i>
														<i class='fa fa-star' aria-hidden='true'></i>
														<i class='fa fa-star-half-o' aria-hidden='true'></i>
													</div>
													<div class='offerComment'>
														<p>
															{$rw['description_of']}
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>";
						}
						?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4 SidebarProject">
				<div class="Entrep">
					<div class="EntrepTitle">
						<h5><i class="fa fa-user" aria-hidden="true"></i> L'ENTREPRENEUR</h5>
					</div>
					<div class="EntrepContent">
						<div class="row">
							<div class="col-md-4 EntrepImg">
								<img src="<?php echo $entreprise['avatar'];?>">
							</div>
							<div class="col-md-8 EntrepInfo">
								<h6><a href="#"><?php echo $entreprise['prenom']." ".$entreprise['nom'];?></a></h6>
								<div class="EntrepLocation">
									<i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $entreprise['address'];?><br>
									<i class="fa fa-phone" aria-hidden="true"></i> <?php echo $entreprise['phone'];?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="poster <?php if($projet['etat_p']==0) echo 'br-ouvert';elseif($projet['etat_p']==1) echo 'br-encours';else echo 'br-finish';?>">
					<div class="posterTitle <?php if($projet['etat_p']==0) echo 'ouvert';elseif($projet['etat_p']==1) echo 'encours';else echo 'finish';?>">
						<h5>MISSION <?php if($projet['etat_p']==0) echo 'OUVERT';elseif($projet['etat_p']==1) echo 'EN COURS';else echo 'FINISH';?></h5>
					</div>
					<div class="posterContent">
						<h5>Vous cherchez à gagner de l'argent ?</h5>
						<ul>
							<li>Fixez votre budget et les délais</li>
							<li>Décrivez votre offre</li>
							<li>Faites-vous payer pour votre travail</li>
						</ul>
						<?php if($projet['etat_p']==0) echo "
						<button data-toggle='modal' data-target='#myModal' class='btn btn-primary' type='button' name='button'><i class='fa fa-pencil' aria-hidden='true'></i> ENVOYER UNE OFFRE</button>";?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ENVOYER UNE OFFRE</h4>
      </div>
      <form method='post' id='registration-form'>
      <div class="modal-body">
      <?php 
     	if(isset($_SESSION['user'])){
      		if($_SESSION['user'][1] == 0){
      			echo "
      			$of_err
				  <div class='row'>
				  	<div class='col-md-6'>
						<div class='form-group'>
							<label for='budget'>Le budget</label>
							<input type='text' name='of_prix' class='form-control' id='budget'>
						</div>
				  	</div>
					<div class='col-md-6'>
						<div class='form-group'>
							<label for='duree'>La durée</label>
							<input type='text' name='of_duree' class='form-control' id='duree'>
						</div>
				  	</div>
				  </div>
				  <div class='row'>
				  	<div class='col-md-12'>
						<div class='form-group'>
							<label for='info'>Détails de l'offre</label>
							<textarea class='form-control' name='of_desc' id='info' placeholder='Ajouter des informations sur votre offre'></textarea>
						</div>
				  	</div>
				  </div>";
			}else{
				echo "<div class=''>Vous êtes pas un freelancer pour poster une offre.</div>";
			}
		}else{
			echo "
		  <div class=''>
			  <div class=''>
				  Pour poster votre offre vous devez identiffier :<br>
    			  <a class='btn btn-primary' href='login.php'>s'iddentiffier</a>
			  </div>
			  <div class=''>
				  Ou s'inscrire :<br>
    			  <a class='btn btn-danger' href='register.php'>s'inscrire</a>
			  </div>
		  </div>";
		}
		?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
        <?php if(isset($_SESSION['user'])) if($_SESSION['user'][1]==0) echo "<button type='submit' class='btn btn-primary' name='addoffre'><i class='fa fa-paper-plane' aria-hidden='true'></i> ENVOYER L'OFFRE</button>";?>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
<?php include('footer.php'); if($projet['etat_p']==1){?>
<script type="text/javascript">
	$(document).ready(function(){
		setInterval(function(){$("#messanger").load("project.php?p=<?php echo $proid;?> #messanger")}, 1000);
	})
</script>
<?php }?>