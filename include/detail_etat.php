<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

<div class="panel panel-default">
      <div class="panel-heading"><h3><?php echo $t['label']?></h3></div>
      <div class="panel-body"> 
        <style>
          .center-block {
            display: block;
            margin-right: auto;
            margin-left: auto;
          }
        </style>
        <div class="center-block" width="155">
          
        <div class="grid">
          
            <section class="center-block">
              <!--<h2><?php echo $res['Label']?></h2>--->
              <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="150" height="150" xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="<?php if($inventory['volume']<$t['seuil_min']){echo "#8B0000";}else{echo "#6f9ecf";}//#8B0000;?>" stroke-width="2" stroke-dasharray="<?php echo $quantity;?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                  <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8" ><?php echo round($quantity);?>%</text>
                  <text class="circle-chart__subline" x="16.91549431" y="20.5" alignment-baseline="central" text-anchor="middle" font-size="4"><?php echo round($inventory['volume']);?> L</text>
                </g>
              </svg>
            </section>
           
            <!--
              <section>
                <h2>Negative chart value</h2>
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                  <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                  <circle class="circle-chart__circle circle-chart__circle--negative" stroke="#00acc1" stroke-width="2" stroke-dasharray="30,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                  <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8">-10%</text>
                    <text class="circle-chart__subline" x="16.91549431" y="20.5" alignment-baseline="central" text-anchor="middle" font-size="2">Oh yes :)</text>
                  </g>
                </svg>
              </section>-->
            
            </div>
          </div>
      </div>
     
      <div class="panel-footer">  
        <label>Capacité:</label> <?php echo round($t['capacite'])." L";?><br>
        <label>Densité:</label> <?php if($inventory['densite']==0){echo "NA";}else{echo round($inventory['densite'],1);} ?><br>
        <label>Temperature:</label><?php echo round($inventory['temperature'],2);?><br>
        <label>Seuil minimum:</label><?php echo round($t["seuil_min"],2);?><br>
        <label>Seuil maximum:</label><?php echo round($t["seuil_max"],2);?><br>
        <label>Date:</label><br>
        <em <?php $date = date("d/m/Y", strtotime($inventory['date'])); 
                  $datec = date("d/m/Y"); 
                  if($date!=$datec){ 
                         echo "style='color:red' alt='$date $datec'"  ;
                          
                        };
                  ?> ><?php echo date("d/m/Y H:i:s", strtotime($inventory['date']));?></em><br>
      </div>
</div>

</div>