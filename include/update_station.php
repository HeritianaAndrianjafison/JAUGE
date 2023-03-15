<div class="col-lg-7 col-md-7 col-sm-10 col-xm-12">
<?php
$msg=valueof("msg");
if($msg==1){
?>
<div class="alert alert-success">
  <strong>Félicitation!</strong> L'utilisateur a été créé correctement <a href="#" class="alert-link">;)</a>.
</div>

<?php 
}
?>
   <div class="panel panel-default">
    <div class="panel-heading">
      <label for="email">Info station:</label>
    </div>
    
    <div class="panel-body">
              
              <form action="process.php" method="POST">
                <input type="hidden"  name="action" value="update_station" >
                <input type="hidden"  name="code" value="<?php echo valueof("id");?>" >
                <div class="form-group">
                  <label for="code">Code station: <?php echo $station['code'];?></label>
                  
                </div>
                
                
                <div class="form-group">
                  <label for="nom">Libellé: *</label>
                  <input type="test" class="form-control" name="nom" value="<?php echo $station['nom'];?>" id="nom">
                </div>
                <div class="form-group">
                  <label for="mail">Intiluté court: *</label>
                  <input type="text" class="form-control" name="intitule_court" id="nom" value="<?php echo $station['intitule_court'];?>">
                </div>
                <!--
                <div class="form-group">
                  <label for="site_id">Site id: *</label>
                  <select class="form-control" name="site_id" id="site_id">
                    <?php echo $site_option;?>
                  </select>
                </div>
                -->
                <div class="form-group">
                  <?php $user = getUser($station['utilisateur_id']);?>
                  <label for="utilisateur">Gérant: *</label>
                  <select class="form-control" name="utilisateur" id="utilisateur">
                    <option value="<?php echo $station['utilisateur_id'];?>"><?php echo $user['prenom']." ".$user['nom'];?></option>
                    <?php echo $option;?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="nom">Vente Sp: *</label>
                  <input type="test" class="form-control" name="vente_sp" value="<?php echo $station['vente_sp'];?>"/>
                </div>
                <div class="form-group">
                  <label for="nom">Vente Go: *</label>
                  <input type="test" class="form-control" name="vente_go" value="<?php echo $station['vente_go'];?>"/>
                </div>
                <div class="form-group">
                  <label for="nom">Vente Pl: *</label>
                  <input type="test" class="form-control" name="vente_pl" value="<?php echo $station['vente_pl'];?>"/>
                </div>
                <div class="form-group">
                  <label for="nom">Seuil min Sp: *</label>
                  <input type="test" class="form-control" name="seuil_min_sp" value="<?php echo $station['seuil_min_sp'];?>"/>
                </div>
                <div class="form-group">
                  <label for="nom">Seuil min Go: *</label>
                  <input type="test" class="form-control" name="seuil_min_go" value="<?php echo $station['seuil_min_go'];?>"/>
                </div>
                <div class="form-group">
                  <label for="nom">Seuil min Pl: *</label>
                  <input type="test" class="form-control" name="seuil_min_pl" value="<?php echo $station['seuil_min_pl'];?>"/>
                </div>

                <div class="form-group">
                  <label for="utilisateur">Région: *</label>
                  <select class="form-control" name="region" id="region">
                    <option value="<?php echo $station['region'];?>"><?php echo label_region($station['region']);?></option>
                    <?php echo $region;?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="statut">Statut: *</label>
                  <select class="form-control" name="statut" id="statut">
                    <option value="1">Activé</option>
                    <option value="0">Desactivé</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="statut">Station inspection</label>
                  <select class="form-control" name="id_station_inspection" id="statut">
                    <option value="<?php echo $station['id_station_inspection'];?>">-- <?php echo $station['id_station_inspection'];?></option>
                    <?php echo $op_ins_ss;?>
                  </select>
                </div>
                <button type="submit" class="btn btn-default">Modifier</button>
              </form>
    </div>
    <div class="panel-footer">

      <?php if($station['maintenance']==1){?>
      <form action="process.php" method="POST">
                <input type="hidden"  name="action" value="maintenance_station" >
                <input type="hidden"  name="code" value="<?php echo valueof("id");?>" >
                <div class="form-group">
                  <label for="nom">Observation sur la maintenance</label>
                  <textarea class="form-control" name="maintenance"></textarea>
                  
                </div>
                <button type="submit" class="btn btn-warning" style="background-color: red;border-color: red">Mettre la station en mode maintenance</button>
              </form>
      <?php }else{


          ?>
          <div> <strong><?php echo $station['observation_maintenance'];?></strong><hr></div>
          <a class="btn btn-info" style="background-color: green;border-color: green" href="process.php?action=fin_de_maintenance&&code=<?php echo valueof("id");?>">Fin de maintenance</a>
          <?php
      }?>
    </div>
  </div>
</div>