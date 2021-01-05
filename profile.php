<?php include('header.php');
if(! isset($_SESSION['user'])) header("location: login.php");
if(! isset($_GET['id']) && ! isset($_GET['t'])) $id = $_SESSION['user'][0];
else{
	if(! is_numeric($_GET['id']) || $_GET['id']<1 || ! is_numeric($_GET['t']) || $_GET['t']!=0 && $_GET['t']!=1) header("location: 404.php");
	$id = $_GET['id'];
}

if(! isset($_GET['id']) && ! isset($_GET['t'])){
	if($_SESSION['user'][1]==0) $cmpt = "freelancer";
	else $cmpt = "entreprise";
}else{
	if($_GET['t']==0) $cmpt = "freelancer";
	else $cmpt = "entreprise";
}
$res = $conn->query("SELECT * FROM $cmpt WHERE id=$id");
$profile = $res->fetch_array();
if(isset($_GET['rate']) && isset($_GET['id'])){
	$is_rated = $conn->query("SELECT * FROM rating WHERE who_rate={$_SESSION['user'][0]} AND to_rate={$_GET['id']}");
	if(mysqli_num_rows($is_rated)<=0){
		$rs = $conn->query("INSERT INTO rating VALUES('', {$_SESSION['user'][0]}, {$_GET['id']}, {$_GET['rate']})");
	}
}
include('isvalide.php');
?>

<div class="page">
	<div class="container">
  <!-- affichage de profile pour les freelancers -->
<?php if($_SESSION['user'][1]==0 || isset($_GET['t']) && $_GET['t']==0){?>
		<div class="col-md-4">
		    <div class="col-content col-left">
                <div class="userImg">
                    <img src="<?php echo $profile['avatar'];?>" class="img-responsive img-circle" alt="<?php echo $profile['prenom'].' '.$profile['nom'];?>" title="">
                </div>
                <div class="userName">
                    <h2><?php echo $profile['prenom']." ".$profile['nom'];?></h2>
                    <?php if($profile['verified']==1) echo "<span class='verified'><i class='fa fa-check' aria-hidden='true'></i></span>";?>

                </div>
				<div class="user_stars">
				<?php 
					if(isset($_GET['id']) && isset($_GET['t'])){
						$is_rated = $conn->query("SELECT * FROM rating WHERE who_rate={$_SESSION['user'][0]} AND to_rate={$_GET['id']}");
						if(mysqli_num_rows($is_rated)>0){
							$total_rating = $conn->query("SELECT count(*) nb FROM rating WHERE to_rate=$id")->fetch_array()['nb'];
							$r1 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=1 AND to_rate=$id")->fetch_array()['nb'];
							$r2 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=2 AND to_rate=$id")->fetch_array()['nb'];
							$r3 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=3 AND to_rate=$id")->fetch_array()['nb'];
							$r4 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=4 AND to_rate=$id")->fetch_array()['nb'];
							$r5 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=5 AND to_rate=$id")->fetch_array()['nb'];
							if($total_rating==0){for($i=0;$i<5;$i++) echo "<i class='fa fa-star-o' aria-hidden='true'></i>";}
							else{
								$rating = (5*$r5+4*$r4+3*$r3+2*$r2+1*$r1)/$total_rating;
								for($i=0;$i<floor($rating);$i++){
									echo "<i class='fa fa-star' aria-hidden='true'></i>";
								}
								if($rating>floor($rating)){
									echo "<i class='fa fa-star-half-o' aria-hidden='true'></i>";
									for($i=0;$i<5-(floor($rating)+1);$i++) echo "<i class='fa fa-star-o' aria-hidden='true'></i>";
								}else{
									for($i=0;$i<5-floor($rating);$i++) echo "<i class='fa fa-star-o' aria-hidden='true'></i>";
								}
							}
						}else{
							$rateval = array("Mauvais", "Acceptable", "Bien", "Très Bien", "Excellent");
							for($i=1;$i<=5;$i++) echo "<a href='profile.php?id={$_GET['id']}&t={$_GET['t']}&rate=$i' title='".$rateval[$i-1]."' data-toggle='tooltip' data-placement='top'><i class='fa fa-star-o rate' aria-hidden='true'></i></a>";
						}
					}else{
						$total_rating = $conn->query("SELECT count(*) nb FROM rating WHERE to_rate=$id")->fetch_array()['nb'];
						$r1 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=1 AND to_rate=$id")->fetch_array()['nb'];
						$r2 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=2 AND to_rate=$id")->fetch_array()['nb'];
						$r3 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=3 AND to_rate=$id")->fetch_array()['nb'];
						$r4 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=4 AND to_rate=$id")->fetch_array()['nb'];
						$r5 = $conn->query("SELECT count(*) nb FROM rating WHERE value_rate=5 AND to_rate=$id")->fetch_array()['nb'];
						if($total_rating==0){for($i=0;$i<5;$i++) echo "<i class='fa fa-star-o' aria-hidden='true'></i>";}
						else{
							$rating = (5*$r5+4*$r4+3*$r3+2*$r2+$r1)/$total_rating;
							for($i=0;$i<floor($rating);$i++){
								echo "<i class='fa fa-star' aria-hidden='true'></i>";
							}
							if($rating>floor($rating)){
								echo "<i class='fa fa-star-half-o' aria-hidden='true'></i>";
								for($i=0;$i<5-(floor($rating)+1);$i++) echo "<i class='fa fa-star-o' aria-hidden='true'></i>";
							}else{
								for($i=0;$i<5-floor($rating);$i++) echo "<i class='fa fa-star-o' aria-hidden='true'></i>";
							}
						}
					}
				?>
				</div>
                <div class="userBio">
                    <p><?php echo $profile['bio'];?></p>
                </div>
                <div class="contactBtn">
                    <?php if(isset($_GET['id']) && isset($_GET['t'])) echo "<a href='#contact' data-toggle='modal' class='btn btn-primary'>contact me</a>";?>
                </div> 
				<div class="separator"><hr></div>
                <div class="userLangs">
                    <h4>languages metrise</h4>
					<table>
			          <?php
			            $rs = $conn->query("SELECT * FROM langue WHERE id=$id");
			            while($row = $rs->fetch_array()){
			              echo "
			                <tr>
			                <td>{$row['title_l']}</td>
			                <td>
			                  <div class='range'>
			                    <div class='range2' style='width: ".($row['prc']*1.5+7)."px;'></div>
			                    <div class='bool' style='left: ".($row['prc']*1.5)."px;'></div>
			                  </div>
			                </td>	
			              </tr>";
			            }
			          ?>
					</table>
                </div>
				<div class="separator"><hr></div>
				<div class="userLinks">
                    <ul>
                        <?php
                        	if($profile['siteweb']!="") echo "<li><a href='{$profile['siteweb']}><i class='fa fa-globe' aria-hidden='true'></i> {$profile['siteweb']}</a></li>";
                        	if($profile['fb']!="") echo "<li><a href='{$profile['fb']}><i class='fa fa-facebook' aria-hidden='true'></i> {$profile['fb']}</a></li>";
                        	if($profile['tw']!="") echo "<li><a href='{$profile['tw']}><i class='fa fa-twitter' aria-hidden='true'></i> {$profile['tw']}</a></li>";
                        	if($profile['gp']!="") echo "<li><a href='{$profile['gp']}><i class='fa fa-google-plus' aria-hidden='true'></i> {$profile['gp']}</a></li>";
                        	if($profile['gh']!="") echo "<li><a href='{$profile['gh']}><i class='fa fa-github' aria-hidden='true'></i> {$profile['gh']}</a></li>";
                        	if($profile['ins']!="") echo "<li><a href='{$profile['ins']}><i class='fa fa-instagram' aria-hidden='true'></i> {$profile['ins']}</a></li>";
                        	if($profile['yt']!="") echo "<li><a href='{$profile['yt']}><i class='fa fa-youtube' aria-hidden='true'></i> {$profile['yt']}</a></li>";
                        ?>
                    </ul>
                </div>
		    </div>
		</div>
		<div class="col-md-8">
		    <div class="col-right">
                <!-- personal Info Section  -->
                <div class="col-section">
                    <div class="sectionTitle">
                        <h4>les informations personailes :</h4>
                    </div>
                    <div class="sectionContent">
                        <table class="table-striped" width="100%">
                            <tr>
                                <td><i class="fa fa-map-marker" aria-hidden="true"></i> Localisation</td>
                                <td><?php echo $profile['address'];?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-calendar" aria-hidden="true"></i> Date d'inscription</td>
                                <td><?php echo dateToString($profile['date_insc']);?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-calendar" aria-hidden="true"></i> Date de naissance</td>
                                <td><?php echo dateToString($profile['date_nais']);?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-<?php if($profile['sexe']=='homme') echo 'male';else echo 'female';?>" aria-hidden="true"></i> Sexe</td>
                                <td><?php echo ucfirst($profile['sexe']);?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-calendar" aria-hidden="true"></i> Dernière activité</td>
                                <td>il y a 8 heures</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-cloud" aria-hidden="true"></i> Projets réalisés</td>
                                <td>5 projets</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-cloud-download" aria-hidden="true"></i> Offres completes</td>
                                <td>6 offres</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- End personal Info Section  -->
                <!-- Experience Section  -->
                <div class="col-section">
                    <div class="sectionTitle">
                        <h4>DIPLOMES ET EXPERIENCES :</h4>
                    </div>
                    <div class="sectionContent">
                        <div class="expTimeline">
                            <ul>
                            <?php
                              $rs = $conn->query("SELECT * FROM diplomexp WHERE id=$id ORDER BY type_dexp, debut DESC");
                              while($row = $rs->fetch_array()){
                                echo "<li>
                                    <div class='expDate'>{$row['debut']} - {$row['fin']}</div>
                                    <div class='expTitle'>{$row['title_dexp']}</div>
                                    <div class='c'></div>
                                </li>";
                              }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Experience Section  -->
                <!-- Last Projects Section  -->
                <div class="col-section">
                    <div class="sectionTitle">
                        <h4>dernieres projets realise</h4>
                    </div>
                    <div class="sectionContent">

						<div class="panel-group" id="accordion">
						    <div class="panel panel-default">
						      <div class="panel-heading">
						        <h4 class="panel-title pull-left">
						          <i class="fa fa-caret-down" aria-hidden="true"></i>
								  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Collapsible Group 1</a>
						        </h4>
								<div class="stars_right pull-right">
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star-half-o" aria-hidden="true"></i>
								</div>
								<div class="c"></div>
						      </div>
						      <div id="collapse1" class="panel-collapse collapse in">
						        <div class="panel-body">
									<div class="row">
										<div class="col-sm-2">
											<img src="images/avatars/Default_Avatar.png" class="img-responsive img-circle comment_user" alt="">
										</div>
										<div class="col-sm-10">
											<div class="comment_content">
												<p>
													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
												</p>
											</div>
										</div>
									</div>
								</div>
						      </div>
						    </div>
						    <div class="panel panel-default">
						      <div class="panel-heading">
						        <h4 class="panel-title">
						          <i class="fa fa-caret-down" aria-hidden="true"></i>
								  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Collapsible Group 2</a>
						        </h4>
						      </div>
						      <div id="collapse2" class="panel-collapse collapse">
								  <div class="panel-body">
  									<div class="row">
  										<div class="col-sm-2">
  											<img src="images/avatars/Default_Avatar.png" class="img-responsive img-circle comment_user" alt="">
  										</div>
  										<div class="col-sm-10">
  											<div class="comment_content">
  												<p>
  													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
  												</p>
  											</div>
  										</div>
  									</div>
  								</div>
						      </div>
						    </div>
						    <div class="panel panel-default">
						      <div class="panel-heading">
						        <h4 class="panel-title">
						          <i class="fa fa-caret-down" aria-hidden="true"></i>
								  <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Collapsible Group 3</a>
						        </h4>
						      </div>
						      <div id="collapse3" class="panel-collapse collapse">
								  <div class="panel-body">
  									<div class="row">
  										<div class="col-sm-2">
  											<img src="images/avatars/Default_Avatar.png" class="img-responsive img-circle comment_user" alt="">
  										</div>
  										<div class="col-sm-10">
  											<div class="comment_content">
  												<p>
  													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
  												</p>
  											</div>
  										</div>
  									</div>
  								</div>
						      </div>
						    </div>
						  </div>

                    </div>
					<!-- end sectionContent -->
                </div>
                <!-- End last projects Section  -->
		    </div>
		</div>
<!-- affichage de profile pour les entreprises -->
<?php }else{?>
    <div class="col-md-4">
        <div class="col-content col-left">
            <div class="userImg">
                <img src="<?php echo $profile['avatar'];?>" class="img-responsive img-circle" alt="<?php echo $profile['prenom'].' '.$profile['nom'];?>">
            </div>
            <div class="userName">
                <h2><?php echo $profile['prenom']." ".$profile['nom'];?></h2>
            </div>
        </div>
    </div>
    <div class="col-content col-md-8">
        <div class="col-right">
          <div class="col-section">
            <div class="sectionTitle">
              <h4>Mes projets</h4>
            </div>
            <div class="contentSection">
              <div class="myProjects">
              <?php 
                $rsp = $conn->query("SELECT * FROM projet WHERE id=$id");
                while($rowp = $rsp->fetch_array()){
                  
                }
              ?>
            </div>
          </div>
            
        </div>
    </div>
<?php }?>
	</div>
</div>
<br>

<!-- Modal -->
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CONTACTER MOI</h4>
      </div>
      <form method='post' id='registration-form'>
      <div class="modal-body">
      	<div id="buttons">
      		<button type="button" class="btn btn-info send-msg"><i class='fa fa-send' aria-hidden='true'></i> ENVOYER UN MESSAGE</button>
	      	<button type="button" class="btn btn-primary send-mail"><i class='fa fa-envelope' aria-hidden='true'></i> E-MAIL</button>
	      	<button type="button" class="btn btn-warning show-phone"><i class='fa fa-phone' aria-hidden='true'></i> APPELER</button>
      	</div>
      	<div class="bxPhone text-center"><br>
      		<span><b><i class='fa fa-phone' aria-hidden='true'></i> <?php echo $profile['phone'];?></b></span>
      	</div>
      	<div class="bxMsg"><br>
			<div class='row'>
			  	<div class='col-md-12'>
			  	<?php
			  		if(isset($_POST['sendMsg'])){
			  			$msg = addslashes($_POST['msg']);
			  			$res = $conn->query("INSERT INTO contacter VALUES('', '$msg', $id, {$_GET['id']}, {$_SESSION['user'][1]}, {$_GET['t']}, CURDATE(), CURTIME(), 0)");
			  			if($res){
			  				echo "<div class='alert alert-success'>Votre message à été envoyé avec sccès</div>";
			  			}else{
			  				echo "<div class='alert alert-danger'>Erreur d'envoi de message</div>";
			  			}
			  		}
			  	?>
					<div class='form-group'>
						<label for='info'>Message</label>
						<textarea class='form-control' name='msg' id='info' placeholder='Ecrire votre message ici'></textarea>
					</div>
			  	</div>
			</div>
			<div class="row col-xs-12">
				<button type="submit" class="btn btn-primary pull-right btn-identy" name="sendMsg"><i class="fa fa-send" aria-hidden="true"></i> Envoyer</button>
			</div>
      	</div>
      	<div class="bxMail"><br>
      		Email
      	</div>
      	<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
<?php include('footer.php');?>

<script type="text/javascript">
	$(".bxPhone").hide("fase");
	$(".bxMail").hide("fast");
	$(".bxMsg").hide("fast");
	$(".show-phone").click(function(){
		$(".bxPhone").show("slow");
		$(".bxMail").hide("fast");
		$(".bxMsg").hide("fast");
	})
	$(".send-mail").click(function(){
		$(".bxPhone").hide("fast");
		$(".bxMail").show("slow");
		$(".bxMsg").hide("fast");
	})
	$(".send-msg").click(function(){
		$(".bxPhone").hide("fase");
		$(".bxMail").hide("fast");
		$(".bxMsg").show("slow");
	})

$(document).ready(function(){
	$(".rate").mouseenter(function(){
		$(this).removeClass("fa-star-o");
		$(this).addClass("fa-star");
	})
	$(".rate").mouseleave(function(){
		$(this).removeClass("fa-star");
		$(this).addClass("fa-star-o");
	})
})
</script>