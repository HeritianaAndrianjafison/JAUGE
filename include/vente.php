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
      <label for="email">Extraction:</label>
    </div>
    
    <div class="panel-body">
              <form action="vente.php" method="POST">
                <input type="hidden"  name="action" value="vente_journaliere" >
                <div class="form-group">
                  <label for="mail">Date: *</label>
                  <input type="text" class="form-control date" name="date" id="mail">
                </div>  
                <div class="form-group">
                  <label for="utilisateur">Région: *</label>
                  <select class="form-control" name="region" id="region">
                    
                    <?php echo $region;?>
                  </select>
                </div>              
                <button type="submit" class="btn btn-default">Extraire</button>
              </form>
    </div>
  </div>
</div>