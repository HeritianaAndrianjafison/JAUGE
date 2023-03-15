<?php
include "config/config.php";

include "include/header.php";
include "include/left.php";
//include "include/login.php";
?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<br><br> 
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="slide/a.jpg" alt="a" style="width:100%;">
      </div>

      <div class="item">
        <img src="slide/b.jpg" alt="b" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="slide/c.jpg" alt="c" style="width:100%;">
      </div>

      <div class="item">
        <img src="slide/d.jpg" alt="d" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>

<?php
include "include/footer.php";
?>