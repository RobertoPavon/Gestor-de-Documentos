<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Econocomex</title>
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body>
  <div class="main">
    <?php
      include "php/nav.php";
      ?>
      <div class="slider">
        <ul>
          <li><img src="/img/banner-color-gratis.jpg" alt=""></li>
          <li><img src="/img/banner-club-comex.jpg" alt=""></li>
          <li><img src="/img/banner-meses.jpg" alt=""></li>        
        </ul>
      </div>

      <div class="noticias">
        <div class="flyer">
          <a href=""><img src="/img/Producto-Estelar.jpg" alt="">
            <div class="etiqueta">
              <p><strong>Producto Estelar Agosto 2022</strong></p>
            </div>
          </a>        
        </div>

        <div class="flyer">
          <a href=""><img src="/img/HotSale.jpg" alt="">
            <div class="etiqueta">
            <p><strong>Hot Sale 2022</strong></p>
            </div>
          </a>        
        </div>

        <div class="flyer ">
          <a href=""><img src="/img/dia-del-pintor.jpg" alt="">
            <div class="etiqueta">
              <p><strong>Dia del Pintor 2022</strong></p>
            </div>
          </a>        
        </div>   
      </div>
      <br><br><br><br>

      <?php
      include "php/footer.php";
    ?>
  </div>

</body>
</html>
