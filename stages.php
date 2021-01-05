<?php include("header.php");include("isvalide.php");
if(isset($_GET['page']) && $_GET['page']<1) header("location: 404.php");
?>

<div class="page stagelocal">
	<div class="container">
		<div class="col-sm-12">
		<div class="row ref">
			<a href="index.php"><i class="fa fa-home"></i> Accueil</a>
			<span class="ref-current">
				<i class="fa fa-angle-right"></i> Stages
			</span>
			<span class="pull-right"><button type="button" class="btn btn-primary" onclick="setTimeout(function(){frmLocation.submit();}, 2000);" id="btnGetLocation"><i class="fa fa-map-marker"></i> Ma Location (GPS)</button></span>
		</div><br>
			<div class="content">
				<div class="row col-content col-left">
					<div class="title">
						<span>Les stages</span>
					</div><br><br>

					<div class="content">
						<div class="row">
						<?php
							if(isset($_GET['page'])) $current=$_GET['page'];
							else $current=1;
							$max_per_page=32;
							$from = $max_per_page * ($current-1);
							$to = $current+$max_per_page-1;
							$nbpages=ceil($conn->query("SELECT count(*) nb FROM stage")->fetch_array()['nb'])/$max_per_page;
							$sql = "SELECT *,DATE_FORMAT(date_s, '%m/%d/%Y') d,DATE_FORMAT(heur_s, '%r') h FROM stage NATURAL JOIN entreprise ORDER BY date_s DESC, heur_s DESC LIMIT $from,$to";
							$res = $conn->query($sql);
							if(mysqli_num_rows($res)>0){
								while($row = $res->fetch_array()){
							?>
							<div class='col-md-3 col-sm-12'>
								<div class='BoxPro "+isFinish+"'>
									<div class='BoxProTitle'>
										<h3><a ><?php echo $row['titre_s'];?>
										<span style="float: right;"><small><?php echo time_passed($row['d']." ".$row['h'], "il y a");?></small></span></a></h3>
									</div>
									<a >
										<div class='BoxProImg' style='background-image: url("<?php echo $row['pic_s'];?>");'>
										<div class='BoxProPrix center-block'><?php echo ucfirst($row['location_s']);?></div></div>
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
						<?php }?>
							<div class="row col-sm-12 center-block"><center>
								<div class="pagination">
								<?php 
								echo "<a href='stages.php?page=".($current-1)."'><button type='button' class='btn btn-default'";if($current<=1) echo "disabled"; echo ">précédent </button></a>";
									for($i=1;$i<=$nbpages;$i++)
										if($current==$i) echo "<a href='stages.php?page=$i' class='btn btn-none' disabled> $i </a>";
										else echo "<a href='stages.php?page=$i' class='btn btn-default'> $i </a>";
								echo "<a href='stages.php?page=".($current+1)."'><button type='button' class='btn btn-default'";if($current>=$nbpages) echo "disabled"; echo ">suivant </button></a>";
								?>
								</div></center>
							</div>
						<?php }else{
							echo "<div class='alert alert-default'><center>Ne peut pas trouver les stages</center></div>";
						}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php");?>