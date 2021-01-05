<?php include('header.php');include('isvalide.php');
?>

<div class="page">
	<div class="container">
		<div class="col-md-4">
		    <div class="col-content col-left">
                <div class="sectionTitle">
                    <h4>Paramêtres</h4>
                </div>

                <ul class="sidelist">
                	<li><a href="settings.php?q=general"><i class="fa fa-globe"></i> Paramêtres générale</a></li>
                	<li><a href="settings.php?q=security"><i class="fa fa-key"></i> Sécurité</a></li>
                	<li><a href="settings.php"><i class="fa fa-glob"></i> Lien</a></li>
                	<li><a href="settings.php"><i class="fa fa-glob"></i> Lien</a></li>
                </ul>
		    </div>
		</div>
		<div class="col-md-8">
		    <div class="col-right">
		      <?php if($_GET['q'] == "general"){?>
                <!-- start general settings section  -->
                <div class="col-section">
                    <div class="sectionTitle">
                        <h4>General settings</h4>
                    </div>
                    <div class="sectionContent">
                        
                    </div>
                </div>
                <!-- End general settings section  -->
              <?php }elseif($_GET['q'] == "security"){?>
              	<!-- start security settings section  -->
                <div class="col-section">
                    <div class="sectionTitle">
                        <h4>Security settings</h4>
                    </div>
                    <div class="sectionContent">
                        
                    </div>
                </div>
                <!-- End security settings section  -->
              <?php }?>
		    </div>
		</div>
	</div>
</div>
<br>

<?php include('footer.php');?>
