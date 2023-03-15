 <div class="col-lg-5 col-md-7 col-sm-9 col-xm-12">
  <?php 
  $err = valueof("err");
  if($err==1){
    ?>
    <div class="alert alert-danger alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Erreur!</strong> Login incorrect.
  </div>
    <?php
  }
  ?>
 <form action="process.php" method="POST">
  <input type="hidden"  name="action" value="login" >
  <div class="form-group">
    <label for="email">Adresse mail:</label>
    <input type="email" class="form-control" name="login" id="email">
  </div>
  <div class="form-group">
    <label for="pwd">Mot de passe:</label>
    <input type="password" class="form-control" name="pwd" id="pwd">
  </div>
  <!--------------
      <div class="checkbox">
        <label><input type="checkbox"> Remember me</label>
      </div>
  -->
  <button type="submit" class="btn btn-default">Go</button>
</form> 
</div>

