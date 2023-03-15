<div class="col-lg-2 col-md-2 col-sm-12 col-xm-12">			
		<?php if($_SESSION["SESSION_type"]==1){?>
             <ul class="list-group">
             	<li class="list-group-item"><span class="glyphicon glyphicon-dashboard" style="color:#8B0000"></span><a style="color:black" href="tableau_de_bord.php"> Synthèse</a></li>
             			<li class="list-group-item"><a style="color:black" href="cumul.php">
             				<span class="glyphicon glyphicon-dashboard" style="color:#8B0000"></span> Tableau de bord</a></li>
						<li class="list-group-item"><a style="color:black" href="etats.php">
							<span class="glyphicon glyphicon-credit-card"  style="color:#21497d"></span> Encours</a></li>
						<li class="list-group-item"><a style="color:black" href="jauges.php">
						<span class="glyphicon glyphicon-object-align-bottom" style="color:#0e9c01"></span> Jauge</a></li>
 						<li class="list-group-item"><a style="color:black" href="data.php">
 							<span class="glyphicon glyphicon-saved" style="color:#01aae1"></span> Données enregistrées</a>
 						</li>
  						<li class="list-group-item"><a style="color:black" href="history.php">
  						<span class="glyphicon glyphicon-list-alt" style="color:#a3ae00" ></span> Historique login</a></li>
			</ul> 

		<?php }?>		
			
</div>