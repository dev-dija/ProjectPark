<?php include('header.php');?>

<div class="content-wrapper">
	<div class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
		            <div class="box-header">
		              <h3 class="box-title">La liste des projects <small>(<?php echo $conn->query("SELECT count(*) as nb FROM projet")->fetch_array()['nb'];?> projets)</small></h3>
		            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <table id="example1" class="table table-bordered table-striped">
	                <thead>
		                <tr>
		                  <th>ID</th>
		                  <th>Titre</th>
		                  <th>Catégorie</th>
		                  <th>Date</th>
		                  <th>Prix</th>
		                  <th>Durée</th>
		                  <th>Publié par</th>
		                  <th>Etat</th>
		                  <th>Opération</th>
		                </tr>
	                </thead>
	                <tbody>
	                <?php
	                $sql = "SELECT * FROM entreprise NATURAL JOIN projet NATURAL JOIN categorie";
	                $res = $conn->query($sql);
	                while($row = $res->fetch_array()){
	                	echo "<tr>
		                  <td>{$row['id_p']}</td>
		                  <td><a href='../project.php?p={$row['id_p']}' target='_blank'>{$row['titre_p']}</a></td>
		                  <td>{$row['titre_cat']}</td>
		                  <td>{$row['date_p']}</td>
		                  <td>{$row['prix_p']}</td>
		                  <td>{$row['duree_p']}</td>
		                  <td>{$row['prenom']} {$row['nom']}</td>
		                  <td>{$row['etat_p']}</td>
		                  <td><i class='fa fa-edit pull-left text-blue'></i>
		                  <i class='fa fa-trash pull-right text-red'></i></td> 
		                </tr>";
		            }
		            ?>
	                </tbody>
	                <tfoot>
	                <tr>
	                  <th>ID</th>
		                  <th>Titre</th>
		                  <th>Catégorie</th>
		                  <th>Date</th>
		                  <th>Prix</th>
		                  <th>Durée</th>
		                  <th>Publié par</th>
		                  <th>Etat</th>
		                  <th>Opération</th>
	                </tr>
	                </tfoot>
	              </table>
	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
		</div>
	</div>
</div>

<?php include('footer.php');?>