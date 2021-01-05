<?php include('header.php');include('isvalide.php');?>

<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="Filters">
					<div class="byCat">
						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    Selectionner une catégorie
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						  	<li><a href="projects.php">Tout les catégories</a></li>
						    <?php
						    	$res = $conn->query("SELECT * FROM categorie");
						    	while($row = $res->fetch_array()){
						    		echo "<li><a href='projects.php?cat={$row['id_cat']}'>{$row['titre_cat']}</a></li>";
						    	}
						    ?>
						  </ul>
						</div>
					</div>
					<div class="byStat">
						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							touts les projets
							<span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li><a href="projects.php?etat=0">disponible</a></li>
							<li><a href="projects.php?etat=1">encoure</a></li>
							<li><a href="projects.php?etat=2">finish</a></li>
						  </ul>
						</div>
					</div>
					<div class="byPrix">
						<span>Selon le prix &nbsp;</span>
						<input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="50" data-slider-max="5000" data-slider-step="1" data-slider-value="[1000,4900]" onchange="setPrice(this)"/>
					</div>
					<div class="ByRecherche text-right">
						<form action="" method="post">
							<i class="fa fa-search" aria-hidden="true"></i>
							<input class='key' type="text" name="key" value="" placeholder="Recherche ...">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="projects">
			<!-- the javascript code will generate projects using JSON table. look at the bottom of the page -->
		</div>
		<div class="row">
			<div class="col-md-12">
				<hr>
				<div class="loading hidden">
					<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
					<span class="sr-only">Loading...</span>
				</div>
				<div class="noLoading hidden text-center text-danger"><b>Il n'y a plus de projets</b></div>
			</div>
		</div>
	</div>
</div>
<br>

<script type="text/javascript">
var max_data_per_page = 8; ///// nombre de projets affiché dans la pages avant le scroll = 8
var current_data_page = 0; ///// nombre de projets actuellement chargé
var last_value = ""; ////////// this is so important to be able to change the slider and affect new values
	function setPrice(obj){
		var valo = document.getElementById("ex1").value;
		if(valo != last_value){
			$(".noLoading").addClass("hidden");
			current_data_page=0;
			last_value=valo;
		}
		var min, max, output="",isFinish="",finOrNot="";
		min = obj.value.substring(0, obj.value.search(','));
		max = obj.value.substring(obj.value.search(',')+1, obj.value.length);
		if(projects.length<max_data_per_page) max_data_per_page = projects.length;
		for(var i=0;i<current_data_page+max_data_per_page;i++){
			if(projects[i].prix>=min && projects[i].prix<=max){
				if(projects[i].etat == 2){
					isFinish = "ProFinish";
					finOrNot = "<div class='BoxProShadow'></div><div class='fin'>FINISH</div>";
				}else{
					finOrNot = "<div class='BoxProPlus'><i class='fa fa-plus-circle' aria-hidden='true'></i></div>";
				}
				output+="<div class='col-md-3 col-sm-12'><div class='BoxPro "+isFinish+"'><div class='BoxProTitle'><h3><a href='project.php?p="+projects[i].id+"'>"+projects[i].titre+"</a></h3></div><a href='project.php?p="+projects[i].id+"'><div class='BoxProImg' style='background-image: url("+projects[i].pic+");'><div class='BoxProShadow'>"+finOrNot+"</div><div class='BoxProPrix'>"+projects[i].prix+" DHs</div></div></a><div class='BoxProFooter'><div class='row'><div class='col-md-6'><div class='Boxentrtitre'><i class='fa fa-user' aria-hidden='true'></i> entreprise</div><div class='Boxentr'>"+projects[i].entreprise+"</div></div><div class='col-md-6'><div class='Boxentrtitre'><i class='fa fa-clock-o' aria-hidden='true'></i> temp maximal</div><div class='Boxentr'>"+projects[i].duree+" jours</div></div></div></div></div></div>";
			}
		}
		$("#projects").html(output);
	}

	//// initialize projects : JSON DATATABLE
	var projects = [
	<?php
		if(isset($_GET['cat']) && is_numeric($_GET['cat']) && $_GET['cat']>=1){
			$cat = addslashes($_GET['cat']);
			$sql = "SELECT * FROM entreprise NATURAL JOIN projet WHERE id_cat='$cat' ORDER BY prix_p";	
		}elseif(isset($_GET['etat']) && is_numeric($_GET['etat']) && $_GET['etat']>=0 && $_GET['etat']<=2){
			$etat = addslashes($_GET['etat']);
			$sql = "SELECT * FROM entreprise NATURAL JOIN projet WHERE etat_p='$etat' ORDER BY prix_p";
		}else $sql = "SELECT * FROM entreprise NATURAL JOIN projet ORDER BY prix_p";
		$res = $conn->query($sql);
		while($row = $res->fetch_array()){
			echo "{
				'id' : '{$row['id_p']}',
				'titre' : '{$row['titre_p']}',
				'prix' : '{$row['prix_p']}',
				'pic' : '{$row['pic_p']}',
				'etat' : '{$row['etat_p']}',
				'duree' : '{$row['duree_p']}',
				'entreprise' : '{$row['prenom']} {$row['nom']}'
			},";
		}
	?>
	]

///////////////////: autoload projects on scroll
setTimeout(function(){setPrice(document.getElementById("ex1"));
last_value=document.getElementById("ex1").value}, 10);
function getMoreData(){
	if($(window).scrollTop() + $(window).height() >= $(document).height()){
		$(".loading").removeClass("hidden");
		setTimeout(function(){current_data_page+=max_data_per_page;
		if(projects.length<=current_data_page){$(".noLoading").removeClass("hidden");$(".loading").addClass("hidden");return 0;}
		setPrice(document.getElementById("ex1"));$(".loading").addClass("hidden");}, 1300);
	}
}
</script>

<?php include('footer.php');?>
