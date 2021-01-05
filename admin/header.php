<?php include('../config.php');
/////////////: nombres des messages reçu
$nb_msg = $conn->query("SELECT count(*) as nb FROM contacter WHERE id_to_c=0 AND state_c=0")->fetch_array()['nb'];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ProjectPark - admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <b>ProjectPark</b>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?php echo $nb_msg;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Vous avez <?php echo $nb_msg;?> messages non lu</li>
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                <?php 
                  $res = $conn->query("SELECT id_from_c, type_from_c,content_c,DATE_FORMAT(date_c, '%m/%d/%Y') d,DATE_FORMAT(heur_c, '%r') h FROM contacter WHERE id_to_c=0 AND state_c=0");
                  while($row = $res->fetch_array()){
                    if($row['type_from_c']==0) $tbl = "freelancer";else $tbl = "entreprise";
                    $msg = substr(str_replace("<br>", " ",$row['content_c']), 0, 35);
                    $rowusr = $conn->query("SELECT * FROM $tbl WHERE id={$row['id_from_c']}")->fetch_array();
                    echo "
                      <li>
                      <a href='#'>
                        <div class='pull-left'>
                          <img src='dist/img/user2-160x160.jpg' class='img-circle' alt='User Image'>
                        </div>
                        <h4>
                          {$rowusr['prenom']} {$rowusr['nom']}
                          <small><i class='fa fa-clock-o'></i> ";echo time_passed($row['d']." ".$row['h']); echo "</small>
                        </h4>
                        <p>$msg...</p>
                      </a>
                    </li>";
                  }
                ?>
                  
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <li class="footer"><a href="#">Afficher tout</a></li>
            </ul>
          </li>
          <!-- /.messages-menu -->

          <?php $nb_notify = $conn->query("SELECT count(*) as nb FROM notification WHERE state_notify=0")->fetch_array()['nb'];?>
          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $nb_notify;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Vous avez <?php echo $nb_notify;?> notifications</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                <?php
                  $res = $conn->query("SELECT *,DATE_FORMAT(date_notify, '%m/%d/%Y') d,DATE_FORMAT(heur_notify, '%r') h FROM notification");
                  while($row = $res->fetch_array()){
                    echo "
                      <li>
                        <a href='{$row['link_notify']}' title='";echo time_passed($row['d']." ".$row['h']); echo "'>
                          <i class='fa fa-{$row['type_notify']}'></i> {$row['content_notify']}
                        </a>
                      </li>
                    ";
                  }
                ?>
                </ul>
              </li>
              <li class="footer"><a href="#">Afficher tout</a></li>
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">Zakaria HBA</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Ilyas ARIBA - Web Developer
                  <small>Mombre depuis Nov. 2014</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Ilyas ARIBA</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-list" aria-hidden="true"></i> <span>Les projets</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus" aria-hidden="true"></i> ajouter projets</a></li>
            <li><a href="projectslist.php"><i class="fa fa-list-ol" aria-hidden="true"></i> Lists des projets</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>Les utilisateurs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> ajouter utilisateurs</a></li>
            <li><a href="#"><i class="fa fa-list-ol" aria-hidden="true"></i> Lists des utilisateurs</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-comment" aria-hidden="true"></i> <span>Blog</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus" aria-hidden="true"></i> ajouter un article</a></li>
            <li><a href="#"><i class="fa fa-list-ol" aria-hidden="true"></i> Lists des articles</a></li>
          </ul>
        </li>
        <li class=""><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Les messages</span>
            <span class="pull-right-container">
              <span class="label label-success pull-right"><?php echo $nb_msg;?></span>
            </span>
        </a></li>
        <li class=""><a href="#"><i class="fa fa-bell" aria-hidden="true"></i> <span>Les notifications</span>
            <span class="pull-right-container">
              <span class="label label-info pull-right"><?php echo $nb_notify;?></span>
            </span>
        </a></li>
        <li class=""><a href="#"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Statistiques</span></a></li>
        <li class=""><a href="#"><i class="fa fa-cog" aria-hidden="true"></i> <span>Configuration</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>