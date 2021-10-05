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
    <div id="Home">
      <!---- Navigation -->
        <nav class="navbar navbar-expand-md navbar-black fixed-top">
          <a class="navbar-brand" href="Index.html"><img src="img/BALBI-sin-fondo.png"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <img src="img/Enca/menu.svg" class="img-fluid">
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <h1>Veterinaria Balbi</h1>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                    <div id="hora"><script type="text/javascript">Mostrar();</script></div>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link"><?php echo $Nombre;?>
                      <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                    </a>
                </li>
                  <li class="nav-item">
                      <a href="" class="nav-link">
                        <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>
                      </a>
                  </li>
          </ul>
          </div>
        </nav>
    </div>	
  <div class="header">
    <div class="col-12">
      <form method="POST" action="./php/addProducto.php">
          
          <div class="form-group">
              <label class="label">Código </label>
              <input required autocomplete="off" name="id_Producto" class="form-control"
                     type="text" placeholder="Código ">
          </div>
          <div class="form-group">
              <label class="label">Nombre</label>
              <input required autocomplete="off" name="Nombre" class="form-control"
                     type="text" placeholder="Nombre">
          </div>
          <div class="form-group">
            <label class="label">Proveedor</label>
            <input required autocomplete="off" name="Proveedor" class="form-control"
                   type="text" placeholder="Proveedor">
        </div>
          <div class="form-group">
              <label class="label">Precio de compra</label>
              <input required autocomplete="off" name="p_Compra" class="form-control"
                     type="decimal(9,2)" placeholder="Precio de compra">
          </div>
          <div class="form-group">
              <label class="label">Precio de venta normal</label>
              <input required autocomplete="off" name="p_VentaC" class="form-control"
                     type="decimal(9,2)" placeholder="Precio de venta normal">
          </div>
          <div class="form-group">
            <label class="label">Precio de venta medico</label>
            <input required autocomplete="off" name="p_VentaM" class="form-control"
                   type="decimal(9,2)" placeholder="Precio de venta medico">
        </div>
        <div class="form-group">
          <label class="label">Precio de venta mayoreo</label>
          <input required autocomplete="off" name="p_VentaMa" class="form-control"
                 type="decimal(9,2)" placeholder="Precio de venta mayoreo">
        </div>
          <div class="form-group">
              <label class="label">Existencia</label>
              <input autocomplete="off" name="stock" class="form-control"
                     type="decimal(9,2)" placeholder="Existencia" readonly>
          </div>
          <button class="btn btn-success">Guardar</button>
          <a class="btn btn-primary" href="{{route("productos.index")}}">Volver al listado</a>
      </form>
  </div>
  </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
  </body>
</html>