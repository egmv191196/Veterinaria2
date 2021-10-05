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
    <link rel="stylesheet" href=".//css/prove.css">
    <link rel="stylesheet" href=".//css/menu.css">
    <script type="text/javascript" src="./js/Mostrar.js"></script>
    <title>Menú-Veterinaria Balbi</title>
  </head>
  <body>
    <?php 
      session_start();
      $Nombre=$_SESSION['k_user'];
      $Puesto=$_SESSION['cargo'];
      if ($Puesto!=1) {
        header("Location:menu.php");
      }
    ?>
    <div id="Home">
      <!---- Navigation -->
        <nav class="navbar navbar-expand-md navbar-black fixed-top">
          <a class="navbar-brand" href="menu.php"><img src="img/BALBI-sin-fondo.png"></a>
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
                    <div id="hora"></div>
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
    </div>	
    <div class="header">
        <div class="col-12">
          <div class="row">
            <h1 class="col-8">Caja <i class="fa fa-list"></i></h1>
            <label class="col-1" for="cantidad"># de ticket</label>
            <div class="col-2"><input id="folio" autocomplete="off" name="folio" type="number" onchange="imprimirTicket();" class="form-control" placeholder="# de Ticket">  </div>
            <a type="button" class="form-control col-1 btn btn-success " onclick="imprimirTicket();"><i class="fa fa-print"></i></a>
          </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Id Ticket</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Empleado</th>
                        <th>Cliente</th>
                        <th>Monto de la venta</th>
                        <th>Imprimir</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $fecha=date('Y-m-d');
                      require_once('./php/Conexion.php');
                      $result= mysqli_query($conexion, "SELECT COUNT(*) AS Total FROM venta JOIN usuario JOIN cliente WHERE Fecha='$fecha' AND venta.id_User=usuario.id_User AND 
                      venta.id_Cliente=cliente.id_Cliente ORDER by id_Venta DESC");
                      $row = mysqli_fetch_array($result);
                      $totalProductos=$row[0];
                      $porPagina=15;
                      if(empty($_GET['pagina'])){
                        $pagina=1;
                      }else{
                        $pagina=$_GET['pagina'];
                      }
                      $desde=($pagina-1)*$porPagina;
                      $totalPaginas=ceil($totalProductos/$porPagina);
                      $result= mysqli_query($conexion, "SELECT * FROM venta JOIN usuario JOIN cliente WHERE Fecha='$fecha' AND venta.id_User=usuario.id_User AND 
                      venta.id_Cliente=cliente.id_Cliente ORDER by id_Venta DESC LIMIT $desde,$porPagina");
                      while ($row = mysqli_fetch_array($result)) {
                          echo '<tr style="text-align: center">';
                          echo '<td>'.$row[0].'</td>';
                          echo '<td>'.$row[1].'</td>';
                          echo '<td>'.$row[2].'</td>';
                          echo '<td>'.$row[12].'</td>';
                          echo '<td>'.$row[18].'</td>';
                          echo '<td>'.$row[5].'</td>';
                          echo '<td> <a class="btn btn-warning" onclick="reimprimirTicket(this);"><i class="fa fa-print"></i></a> </td>';
                          echo '</tr>';
                      }
                      ?>
                    
                    </tbody>
                </table>
                <div class="paginador">
              <ul>
                <?php
                  if ($pagina!=1) 
                  {
                 
                echo '<li><a href="?pagina=1"><i class="fas fa-step-backward"></i> </a> </li>';
                echo '<li><a href="?pagina='.($pagina-1).'"><i class="fas fa-backward"></i> </a> </li>';
                  }
                  for ($i=1; $i<=$totalPaginas;$i++) { 
                    if ($i==$pagina) {
                      echo '<li class="liselected">'.$i.'</li>';
                    }else{
                      echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                    }
                  }
                  if ($pagina!=$totalPaginas) {
                    echo '<li><a href="?pagina='.($pagina+1).'"><i class="fas fa-forward"></i> </a> </li>';
                    echo '<li><a href="?pagina='.$totalPaginas.'"><i class="fas fa-step-forward"></i> </a> </li>';
                  }
                ?>
              </ul>
            </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script src="./js/Funciones.js"></script>
  </body>
</html>