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
    <title>Creditos</title>
  </head>
  <body>
    <?php 
      session_start();
      $Nombre=$_SESSION['k_user'];
      require_once('./php/Conexion.php');
      $empleado=$_SESSION['id_Empleado'];
      $Fecha=date('Y-m-d');
      $consulta="SELECT * FROM caja WHERE id_User=$empleado AND Fecha='$Fecha'";
      if($res = mysqli_query($conexion,$consulta)){
        $numRows=mysqli_num_rows($res);
        if($numRows>0){
          $datos = mysqli_fetch_array($res);
          $Estado=$datos['Estado'];
          if ($Estado!=0) {
          }else{
            header("Location:menu.php");
          }
        }else{
          header("Location:menu.php");
        }
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
                    <div id="hora"><script type="text/javascript">Mostrar();</script></div>
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
            <h1>Creditos<i class="fa fa-list"></i></h1>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID Credito</th>
                        <th>Cliente</th>
                        <th>Total Credito</th>
                        <th>Monto abonado</th>
                        <th>Monto Restante</th>
                        <th>Abono</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                          require_once('./php/Conexion.php');
                          $result= mysqli_query($conexion, "SELECT COUNT(*) AS Total FROM lineacredito JOIN cliente 
                          WHERE lineacredito.montoRestante>0 AND lineacredito.id_Cliente=cliente.id_Cliente ORDER BY id_CreditoTotal DESC");
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
                          $result= mysqli_query($conexion, "SELECT lineacredito.*, cliente.Nombre FROM lineacredito JOIN cliente 
                          WHERE lineacredito.montoRestante>0 AND lineacredito.id_Cliente=cliente.id_Cliente ORDER BY id_CreditoTotal DESC LIMIT $desde,$porPagina");
                          while ($row = mysqli_fetch_array($result)) {
                              echo '<tr style="text-align: center">';
                              echo '<td>'.$row[0].'</td>';
                              echo '<td>'.$row[5].'</td>';
                              echo '<td>'.$row[1].'</td>';
                              echo '<td> '.number_format($row[2],2).'</td>';
                              echo '<td> '.$row[3].'</td>';
                              echo '<td> <a class="btn btn-success" onclick="venAbono(this);"><i class="fa fa-money"></i></a> </td>';
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
    <div class="modal fade" id="venAbono">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Abono credito</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm">
                      <label class="label">ID Credito </label>
                      <input name="id_Producto" class="form-control" id="id_Credito" placeholder="ID Credito" disabled>
                  </div>
                  <div class="col-sm">
                      <label class="label">Cliente</label>
                      <input name="nom_Cliente" class="form-control" id="nom_Cliente" type="text" placeholder="Nombre" disabled>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm">
                      <label class="label">Total Credito</label>
                      <input name="total_Credito" class="form-control" id="total_Credito" type="decimal(9,2)" placeholder="Total Credito" disabled>
                  </div>
                  <div class="col-sm">
                      <label class="label">Total abonado</label>
                      <input name="total_Abonado" class="form-control" id="total_Abonado" type="decimal(9,2)" placeholder="Total abonado" disabled>
                  </div>
                  <div class="col-sm">
                      <label class="label">Restante</label>
                      <input name="restante" class="form-control" id="restante" type="decimal(9,2)" placeholder="Restante" disabled>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm">
                      <label class="label">Pago</label>
                      <input required autocomplete="off" onkeyup="calcular_restante();" name="monto_Pago" class="form-control" id="monto_Pago"
                            type="decimal(9,2)" placeholder="Ingresa el monto a abonar">
                  </div>
                  <div class="col-sm">
                      <label class="label">Restante por pagar</label>
                      <input name="restante_pagar" class="form-control" id="restante_Pagar" type="decimal(9,2)" disabled placeholder="Restante por pagar">
                  </div>
                </div>
                  <input type="hidden" name="Operacion" id="Operacion" value="Insertar" />
                  <button class="btn btn-success float-right m-2" onclick="pagarAbonoModal();">Pagar</button>
                  <button type="button"class="btn btn-primary float-right m-2" data-dismiss="modal">Cerrar  </button>
              </div>
            </div>
          </div>
        </div>

    <div class="modal fade" id="pagarAbono">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Pago credito</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="row">
                  <label class="label col-4">ID del credito</label>
                  <input name="id_CreditoModal" class="form-control col-8" id="id_CreditoModal" type="decimal(9,2)" placeholder="Total Credito" disabled>
            </div>
            <div class="row">
                  <label class="label col-4">Total a cobrar</label>
                  <input name="total_Pagar" class="form-control col-8" id="total_Pagar" type="decimal(9,2)" placeholder="Monto a cobrar" disabled>
            </div>
              <div class="row">
                  <label class="label col-4">Efectivo</label>
                  <input class="form-control col-8" name="efectivo_Modal"  id="efectivo_Modal" onkeyup="calcular_Cambio();" type="decimal(9,2)" placeholder="Total abonado" >
              </div>
              <div class="row">
                  <label class="label col-4">Cambio</label>
                  <input name="cambio_Modal" class="form-control col-8" id="cambio_Modal" type="decimal(9,2)" placeholder="Restante" disabled>
              </div>
              <input type="hidden" name="Operacion" id="Operacion" value="Insertar" />
              <button class="btn btn-success float-right m-2" onclick="pagarAbono();">Pagar</button>
              <button type="button"class="btn btn-primary float-right m-2" data-dismiss="modal">Cerrar  </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script src="./js/credito.js"></script>
  </body>
</html>