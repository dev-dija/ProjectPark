<?php include('header.php');
//////////////: nombres d'utilisateur
$nb_users = $conn->query("SELECT count(*) as nb FROM freelancer ")->fetch_array()['nb'];
$nb_users += $conn->query("SELECT count(*) as nb FROM entreprise ")->fetch_array()['nb'];
$nb_projets = $conn->query("SELECT count(*) as nb FROM projet WHERE etat_p=0")->fetch_array()['nb'];
$nb_offres = $conn->query("SELECT count(*) as nb FROM offre WHERE etat_of=0")->fetch_array()['nb'];


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $nb_users;?></h3>

              <p>Utilisateurs</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $nb_projets;?><sup style="font-size: 20px"></sup></h3>

              <p>Projet disponible</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-circle" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $nb_offres;?></h3>

              <p>Offres accepté</p>
            </div>
            <div class="icon">
              <i class="fa fa-bullhorn" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Visiteurs en ligne</p>
            </div>
            <div class="icon">
              <i class="fa fa-wifi" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
          <div class="col-lg-12 col-xs-12">
              <!-- LINE CHART -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Statistiques des projets</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body chart-responsive">
                  <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div>
                <!-- /.box-body -->
              </div>

          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('footer.php');?>