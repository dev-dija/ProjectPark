<?php include('header.php');
if(! isset($_SESSION['user'])){header("location: login.php");}
else{
	$typeacc=$_SESSION['user'][1];
	if($typeacc==0) $cmpt="freelancer";
	else $cmpt="entreprise";
	$isval = $conn->query("SELECT acc_valide FROM $cmpt WHERE id={$_SESSION['user'][0]}")->fetch_array()['acc_valide'];
	if($isval==1) header("location: profile.php");
}
?>

<div class="page">
	<div class="container">
		<div class="col-sm-3 col-md-4"></div>
		<div class="row col-sm-6 col-md-4">
			<div class="frame">
				<div class="title">
					<span>Activation du compte</span>
				</div>
				<div class="content col-xs-11 login">
					<form method="POST" id="registration-form">
						<div class="row">
							<div class="form-group">
								<span>Vueillez insserez le code d'activation</span>
							    <input type="text" class="form-control text-field" id="validation" data-validation="required number" data-validation-error-msg="code d'activation non valide" name="keycode" placeholder="Votre code d'activation ici">
							  </div>
						</div>
						<div class="row">
							<button type="submit" name="getActive" class="btn btn-primary btn-identy">Activer le compte </button>
						</div>
						<div class="row">
						<?php
							if(isset($_POST['getActive']) || isset($_GET['key'])){
								if(isset($_GET['key'])) $key=$_GET['key'];
								elseif(isset($_POST['keycode'])) $key=md5($_POST['keycode']);
								$typeacc=$_SESSION['user'][1];
								if($typeacc==0) $cmpt="freelancer";
								else $cmpt="entreprise";
								$uid = $_SESSION['user'][0];
								$rsw = $conn->query("SELECT * FROM $cmpt WHERE id=$uid");
								if($rsw){
									$roww = $rsw->fetch_array();
									$ckey = $roww['activation_key'];
									if($ckey==$key){
										$rsact = $conn->query("UPDATE $cmpt SET acc_valide=1 WHERE id=$uid");
										if($rsact){
											echo "<div class='alert alert-success' style='display: block;'>
												<i class='fa fa-check-square'></i> 
												<span class='title'>votre compte è été activé avec succée.</span><br>
												<span class='description' id='wait'>attendez 3s ...</span>
											</div>";
											echo "<meta http-equiv='refresh' content='3; url=profile.php' />";
										}else{
											echo "<div class='alert alert-danger' style='display: block;'>
												<i class='fa fa-exclamation-triangle'></i> 
												<span class='title'>Problème d'activation du compte</span><br>
												<span class='description'></span>
											</div>";
										}
									}else{
										echo "<div class='alert alert-danger' style='display: block;'>
												<i class='fa fa-exclamation-triangle'></i> 
												<span class='title'>Code de validation non valide</span><br>
												<span class='description'></span>
											</div>";
									}
								}
							}
						?>
						</div>
					</form>
				</div><div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3 col-md-4"></div>
	</div>
</div>
<br>

<?php include('footer.php');?>