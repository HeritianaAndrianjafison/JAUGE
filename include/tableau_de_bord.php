<div class="col-lg-10 col-md-10 col-sm-12 col-xm-12">

<div class="col-lg-5 col-md-5 col-sm-12 col-xm-12">
<table class="table table-responsive table-striped">
    <tr>
    	<th></th>
    	<th>Nombre</th>
    	<th>Detail</th>
    </tr>
    <tr>
    	<td>Station en rupture de stock</td>
    	<td><?php echo $station_en_rupture_de_stock;?></td>
    	<td><a href="rupture.php?liste_station_en_rupture_de_stock=<?php echo $liste_station_en_rupture_de_stock;?>" class="btn btn-info btn-sm">Détail</a>
    	</td>
    </tr>
    <tr>
    	<td>Station en dépassement encours</td>
    	<td><?php echo $station_en_depassement;?></td>
    	<td><a href="depassement.php?liste_station_en_depassement=<?php echo $liste_station_en_depassement;?>" class="btn btn-info btn-sm">Détail</a>
    	</td>
    </tr>
    <tr>
    	<td>Gérant connectée hier</td>
    	<td><?php echo $station_connecter;?></td>
    	<td><a href="actif.php?list_station_connecter=<?php echo $list_station_connecter;?>" class="btn btn-info btn-sm">Détail</a></td>
    </tr>
    <tr>
    	<td >Global </td>
      <td colspan="2"><a href="global.php" class="btn btn-info btn-sm">Tous</a> <a href="globalstock.php" class="btn btn-info btn-sm">Stock</a> <a href="globalcompte.php" class="btn btn-info btn-sm">Encours</a></td>
    	
    	</td>
    </tr>
    <tr>
      <td >Station en maintenance </td>
      <td><?php echo $station_a_probleme;?></td>
      <td ><a href="globalprobleme.php" class="btn btn-info btn-sm">Détail</a></td>
      
      </td>
    </tr>
  </table>
</div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12">



<bR><bR> <bR> <bR> <bR> <bR> <bR> <bR> <bR> <bR> <bR>  <bR> <bR> <br><br>  

</div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12">
<div id="piechart"></div>

<script type="text/javascript" src="pie.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['En condition', <?php echo (count($station)-$station_en_rupture_de_stock);?>],
  ['En rupture', <?php echo $station_en_rupture_de_stock;?>],
  
  
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Stock station', 'width':400, 'height':350};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>

</div>


<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12">




<div id="piechart1"></div>



<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['En condition', <?php echo (count($station)-$station_en_depassement);?>],
  ['Station en dépassement', <?php echo $station_en_depassement;?>],
  
  
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Station en dépassement', 'width':400, 'height':350};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
  chart.draw(data, options);
}
</script>

</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12">
<div id="piechart2"></div>



<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  
  ['Gérant connectée', <?php echo $station_connecter;?>],
  ['Gérant non connectée', <?php echo (count($station)-$station_connecter);?>],
  
  
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'connection gérant', 'width':400, 'height':350};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
  chart.draw(data, options);
}
</script>

</div>
  

  
</div>