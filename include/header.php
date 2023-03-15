<!DOCTYPE html>
<html lang="en">
<head>
  <title>PORTAIL STATION SERVICE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/x-icon" href="public/img/icon/icon.png" />

  <link rel="stylesheet" href="public/bootstrap/css/ubuntu.css">
  <!--<link rel="stylesheet" href="public/bootstrap/css/bootstrap.css">-->
  <link rel="stylesheet" href="public/css/default.css">
  
  <!--<link rel="stylesheet" href="public/css/style.css">-->
  <link rel="stylesheet" href="public/jquery-ui/jquery-ui.min.css">
  <script src="public/bootstrap/js/jquery.js"></script>
  <script src="public/js/default.js"></script>
  <script src="public/jquery-ui/jquery-ui.min.js"></script>
  <script src="public/bootstrap/js/bootstrap.min.js"></script>
  <?php
    if(isset($js)){
      foreach ($js as $j) {
        ?>
        <script src="public/js/<?php echo $j;?>.js"></script>
        <?php
      }
    }
   ?> 
</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"><!--<img src="public\img\jovena.png" class="img-responsive"/> --><em>PORTAIL STATION SERVICE</em></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                  <?php if(isset($_SESSION["SESSION_id"])){
                    ?>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span>
                        <?php echo $_SESSION["SESSION_login"];?>
                    </a></li>
                    
                    <?php
                     if($_SESSION["SESSION_type"]==1){?>
                    
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-th">
                        </span> Paramèttre 
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a href="users.php">Utilisateurs</a></li>
                        <li><a href="stations.php">station</a></li>
                        <li><a href="site_probleme.php">Site à problème</a></li>
                        <li><a href="extraction.php">Extraction</a></li>
                        <li><a href="vente.php">Vente journalière</a></li>
                      </ul>
                    </li>
                   <?php
                        }
                    ?>
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-dashboard"></span> Etat 
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                       <!-- <li><a href="cumul.php">Tableau de bord</a></li>-->
                        <li><a href="etats.php">Encours</a></li>
                        <li><a href="jauges.php">Jauge</a></li>
                        <li><a href="inspection.php">Inspection</a></li>
                        <!-- <li><a href="ca.php">Chiffre d'affaire</a></li>-->
                        <?php if($_SESSION["SESSION_type"]==1||$_SESSION["SESSION_type"]==3){?>
                        
                        <li><a href="history.php">Historique login</a></li>
                        <?php }?>
                      </ul>
                    </li>
                    
                    <li><a href="setting.php"><span class="glyphicon glyphicon-cog"></span> Configuration</a></li>
                    <li><a href="process.php?action=logout"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
                   <?php
                    } ?>
                   <!-- <li><a href="commande.php">commande</a></li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
       
        <!-- /.container -->
    </nav>
  
 <br><br><br>
<div class="container-fluid">
  <div class="row">
