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
                <input type="hidden"  name="action" value="insert_new_station" >
                <div class="form-group">
                  <label for="code">Code station: *</label>
                  <select class="form-control" name="code" id="code"><?php echo $optionx3;?></select>
                </div>
                
                
                <div class="form-group">
                  <label for="nom">Libellé: *</label>
                  <input type="test" class="form-control" name="nom" id="nom">
                </div>

                <!--
                <div class="form-group">
                  <label for="site_id">Site id: *</label>
                  <select class="form-control" name="site_id" id="site_id">
                    <?php echo $site_option;?>
                  </select>
                </div>-->
                <div class="form-group">
                  <label for="utilisateur">Gérant: *</label>
                  <select class="form-control" name="utilisateur" id="utilisateur">
                    <?php echo $option;?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="utilisateur">Région: *</label>
                  <select class="form-control" name="region" id="region">
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
                    <?php echo $op_ins_ss;?>
                  </select>
                </div>
                <button type="submit" class="btn btn-default">Créer</button>
              </form>
    </div>
  </div>
</div>