<?php include("header.php");include("isvalide.php");
if(! isset($_POST['myLocation'])) echo "<meta http-equiv='refresh' content='0, 404.php'>";
$location = strtoupper(addslashes($_POST['myLocation']));
?>

<div class="page stagelocal">
	<div class="container">
		<div class="col-sm-12">
		<div class="row ref">
			<a href="index.php"><i class="fa fa-home"></i> Accueil</a>
			<span class="ref-current">
				<i class="fa fa-angle-right"></i> Stages local
			</span>
		</div><br>
			<div class="content">
				<div class="row col-content col-left">
					<div class="title">
						<?php if(strtolower($_POST['myLocation']) != "undefined") echo "<span>Stages dans {$_POST['myLocation']}</span>";
						else echo "<span>Ne peut pas activer le <b>GPS</b></span>";
						?>
					</div><br><br>

					<div class="content">
						<div class="row">
						<?php
							$sql = "SELECT *,DATE_FORMAT(date_s, '%m/%d/%Y') d,DATE_FORMAT(heur_s, '%r') h FROM stage NATURAL JOIN entreprise WHERE location_s='$location' ORDER BY date_s DESC, heur_s DESC";
							$res = $conn->query($sql);
							if(mysqli_num_rows($res)>0){
								while($row = $res->fetch_array()){
							?>
							<div class='col-md-3 col-sm-12'>
								<div class='BoxPro "+isFinish+"'>
									<div class='BoxProTitle'>
										<h3><a href='stage.php?id=<?php echo $row['id_s'];?>'><?php echo $row['titre_s'];?>
										<span style="float: right;"><small><?php echo time_passed($row['d']." ".$row['h'], "il y a");?></small></span></a></h3>
									</div>
									<a href='stage.php?id=<?php echo $row['id_s'];?>'>
										<div class='BoxProImg' style='background-image: url("<?php echo $row['pic_s'];?>");'>
										<div class='BoxProPrix center-block'><?php echo $location;?></div></div>
									</a>
									<div class='BoxProFooter'>
										<div class='row'>
											<div class='col-md-6'>
												<div class='Boxentrtitre'><i class='fa fa-user' aria-hidden='true'></i> entreprise</div>
												<div class='Boxentr'><?php echo $row['prenom']." ".$row['nom'];?></div>
											</div>
											<div class='col-md-6'>
												<div class='Boxentrtitre'><i class='fa fa-users' aria-hidden='true'></i>Nb stagiaires</div>
												<div class='Boxentr'><?php echo $row['nb_s'];?> stagiaires</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php }}else{
							echo "<div class='alert alert-default'><center>Aucun stage dans votre location</center></div>";
						}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php");?>