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
      <label for="email">Nouveau utilisateur:</label>
    </div>
    
    <div class="panel-body">
              <form action="process.php" method="POST">
                <input type="hidden"  name="action" value="update_user" >
                <input type="hidden"  name="id" value="<?php echo valueof('id');?>" >
                <div class="form-group">
                  <label for="mail">Adresse mail (identifiant): *</label>
                  <input type="email" class="form-control" name="mail" id="mail" value="<?php echo $login?>">
                </div>

                <div class="form-group">
                  <label for="prenom">Prenom: *</label>
                  <input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo $prenom?>">
                </div>

                <div class="form-group">
                  <label for="mail">Nom: *</label>
                  <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $nom?>">
                </div>
                <div class="form-group">
                  <label for="pwd">Mot de passe: *</label>
                  <input type="password" class="form-control" name="pwd" id="pwd">
                </div>
                
                <div class="form-group">
                  <label for="pwd">Type: *</label>
                  <select class="form-control" name="type" id="type">
                    <option value="<?php echo $type; ?>"><?php if($type==1){ echo "Admin";} if($type==2){ echo "Gérant";}if($type==3){ echo "Consultation";}?></option>
                    
                    <?php echo $option;?>
                  </select>
                </div>
                <input  type="submit" class="btn btn-default" value="Modififier"/>
              </form>
    </div>
  </div>
</div>