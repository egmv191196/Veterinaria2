<!doctype html>
<html lang="es" xmlns:th="http://www.w3.org/1999/xhtml">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <script src="https://kit.fontawesome.com/8c9db8153c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href=".//css/cabezapie.css">
    <link rel="stylesheet" href=".//css/menu.css">
    <script type="text/javascript" src="./js/Mostrar.js"></script>
    <title>Menú-Veterinaria Balbi</title>
  </head>
  <body>
    <?php 
      session_start();
      $Nombre=$_SESSION['k_user'];
    ?> 
      <!---- Navigation -->
        <nav class="navbar navbar-expand-md navbar-black fixed-top">
          <a class="navbar-brand" href="menu.php"><img src="img/BALBI-sin-fondo.png"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <img src="img/Enca/menu.svg" class="img-fluid ">
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <h1>Veterinaria Balbi</h1>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                    <h3 id="hora" ></h3>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link"><?php echo $Nombre;?>
                      <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                    </a>
                </li>
                  <li class="nav-item">
                      <a href="./php/logout.php" class="nav-link">
                        <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>
                      </a>
                  </li>
          </ul>
          </div>
        </nav>	
    <div class="header">
        <div class="encabezado">
            <h1>Bienvenido</h1>
        </div>
    </div>
    <div class="menu-container">
        <div class="hex-wrapper">
          <div class="hex-row ">
          <a href="venta.php" >
            <div class="hexagon" id="nav-home">
              <i class="fas fa-shopping-cart fa-3x"></i>
              Ventas
              <div class="face1"></div>
              <div class="face2"></div>
            </div>
            </a>
            <a href="Compra.php" >
            <div class="hexagon" id="nav-home">
            <i class="fas fa-cart-plus fa-3x" ></i>
              Compras
              <div class="face1"></div>
              <div class="face2"></div>
            </div>
            </a>
            <a href="Caja.php" >
            <div class="hexagon" id="nav-about">
                <i class="fas fa-ticket-alt fa-3x"></i><br>  
                Tickets
                 <div class="face1"></div>
                 <div class="face2"></div>
            </div>
           </a> 
            <a href="productos.php"  >
            <div class="hexagon" id="nav-about">
                <i class="fas fa-box-open fa-3x"></i>
                Productos
                 <div class="face1"></div>
                 <div class="face2"></div>
            </div>
        </a>
        <a href="Proveedor.php" >
            <div class="hexagon" id="nav-about">
                <i class="fas fa-people-carry fa-3x"></i>
                Proveedores
                 <div class="face1"></div>
                 <div class="face2"></div>
            </div>
            </a>
          </div>
          <div class="hex-row shift">
          <a href="Clientes.php" >
            <div class="hexagon" id="nav-about">
                <i class="fas fa-handshake fa-3x"></i>
             Clientes
              <div class="face1"></div>
              <div class="face2"></div>
            </div>
          </a>
          <a href="Creditos.php" >
            <div class="hexagon" id="nav-work">
                <i class="fas fa-hand-holding-usd fa-3x"></i>
              Creditos
              <div class="face1"></div>
              <div class="face2"></div>
            </div>
            </a>
            <a href="Reportes.php" >
            <div class="hexagon" id="nav-contact">
                <i class="fas fa-clipboard fa-3x"></i>
              Reportes y caja
              <div class="face1"></div>
              <div class="face2"></div>
            </div>
            </a>
            <a href="Administrar.php" >
            <div class="hexagon" id="nav-contact">
                <i class="fas fa-users-cog fa-3x"></i>
                Administrar
                <div class="face1"></div>
                <div class="face2"></div>
              </div>
              </a>
          </div>
          
        </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
  </body>
</html>