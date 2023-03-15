<div class="col-lg-7 col-md-7 col-sm-10 col-xm-12">
  <?php if(isset($_GET["msg_s"])){?>
    <div class="alert alert-success alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Félicitation!</strong> Mot de passe enregistrer.
    </div>
  <?php
  }?>
  <?php if(isset($_GET["msg_err"])&&$_GET["msg_err"]==1){?>
    <div class="alert alert-danger alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Attention!</strong> Ancien mot de passe incorrect.
    </div>
  <?php
  }?>
  <?php if(isset($_GET["msg_err"])&&$_GET["msg_err"]==2){?>
    <div class="alert alert-danger alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Attention!</strong> Confirmation mot de passe incorrect.
    </div>
  <?php
  }?>
   <div class="panel panel-default">
    <div class="panel-heading">
      <label for="email">Modification mot de passe:</label>
    </div>
    
    <div class="panel-body">
              <form action="process.php" method="POST">
                <input type="hidden"  name="action" value="update_password" >
                <div class="form-group">
                          <label for="nom">Ancien mot de passe: *</label>
                          <input type="password" class="form-control" name="old_password">
                </div>
                <div class="form-group">
                          <label for="code">Nouveau mot de passe: *</label>
                          <input type="password" class="form-control" name="new_password">
                </div>
                <div class="form-group">
                          <label for="code">Confirmation nouveau mot de passe: *</label>
                          <input type="password" class="form-control" name="confirmation_new_password">
                </div>
                <button type="submit" class="btn btn-default">Modifier</button>
              </form>
    </div>
  </div>
</div>