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
    <title>Productos</title>
  </head>
  <body>
    <?php 
      session_start();
      $Nombre=$_SESSION['k_user'];
      $cargo=$_SESSION['cargo'];
      if ($cargo==3) {
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
  <div class="col-12">
  <div class="header1">
    <div class="row">
      <div class="col-sm">
      <h1>Productos <i class="fas fa-box-open"></i></h1>
      </div>
      <div class="col-2">
        <input required autocomplete="off" name="Nombre" id="nombreBusqueda" class="form-control" type="text" placeholder="Ingresa el Nombre" onchange="editProductoBusqueda();">         
      </div>
      <div class="col-1">
        <a href="" class="btn btn-success mb-2 float-right" data-toggle="modal" onclick="editProductoBusqueda();">Buscar</a>
      </div>
      <div class="col-1">
        <a href="#VenRegistrar" class="btn btn-success mb-2 float-right" data-toggle="modal">Agregar</a>
      </div>
    </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr style="text-align: center">
                    <th>Código </th>
                    <th>Laboratorio</th>
                    <th>Nombre</th>
                    <th>Precio de compra</th>
                    <th>Precio lista</th>
                    <th>Precio publico</th>
                    <th>Precio medio mayoreo</th>
                    <th>Precio mayoreo</th>
                    <th>Existencia</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    require_once('./php/Conexion.php');
                    $result= mysqli_query($conexion, "SELECT COUNT(*) AS Total FROM producto");
                    $row = mysqli_fetch_array($result);
                    $totalProductos=$row[0];
                    $porPagina=25;
                    if(empty($_GET['pagina'])){
                      $pagina=1;
                    }else{
                      $pagina=$_GET['pagina'];
                    }
                    $desde=($pagina-1)*$porPagina;
                    $totalPaginas=ceil($totalProductos/$porPagina);
                    $result= mysqli_query($conexion, "SELECT * FROM producto LIMIT $desde,$porPagina");
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<tr style="text-align: center">';
                        echo '<td>'.$row[0].'</td>';
                        echo '<td>'.$row[1].'</td>';
                        echo '<td>'.$row[2].'</td>';
                        echo '<td>'.$row[4].'</td>';
                        echo '<td>'.$row[5].'</td>';
                        echo '<td>'.$row[6].'</td>';
                        echo '<td>'.$row[7].'</td>';
                        echo '<td>'.$row[8].'</td>';
                        echo '<td>'.$row[3].'</td>';                 
                        echo '<td> <a class="btn btn-warning" onclick="editProducto(this);"><i class="fa fa-edit"></i></a> </td>';
                        echo '<td> <form action="#" method="post">';
                        echo '<button type="submit" class="btn btn-danger" onclick="delProducto(this);"> <i class="fa fa-trash"></i> </button>';
                        echo '</form></td>';
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
    <div class="modal fade" id="VenRegistrar">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Registrar producto</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Código </label>
                      <input required autocomplete="off" name="id_Producto" class="form-control" id="id_Pro_reg" autofocus="autofocus"
                            type="text" placeholder="Código" onchange="verificarCodigo();">
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Nombre</label>
                      <input required autocomplete="off" name="Nombre" class="form-control" id="nom_Reg"
                            type="text" placeholder="Nombre">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Existencia</label>
                      <input required autocomplete="off" name="stock" class="form-control" id="stock_Reg"
                            type="decimal(9,2)" placeholder="Existencia">
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Precio de compra</label>
                      <input required autocomplete="off" name="p_Compra" class="form-control" id="pc_Reg"
                            type="decimal(9,2)" placeholder="Precio de compra">
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Precio lista</label>
                      <input required autocomplete="off" name="p_Compra" class="form-control" id="pl_Reg"
                            type="decimal(9,2)" placeholder="Precio de lista">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Precio publico</label>
                      <input required autocomplete="off" name="p_VentaC" class="form-control" id="pv_Reg"
                            type="decimal(9,2)" placeholder="Precio publico">
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Precio medio mayoreo</label>
                      <input required autocomplete="off" name="p_VentaM" class="form-control" id="pvm_Reg"
                            type="decimal(9,2)" placeholder="Precio medio mayoreo">
                    </div>
                  </div>
                  <div class="col-sm">
                  <div class="form-group">
                      <label class="label">Precio mayoreo</label>
                      <input required autocomplete="off" name="p_VentaMa" class="form-control" id="pvma_Reg"
                            type="decimal(9,2)" placeholder="Precio mayoreo">
                    </div>
                  </div>
                </div>
                  <input type="hidden" name="Operacion" id="Operacion" value="Insertar" />
                  <button class="btn btn-success" onclick="addProducto();">Guardar</button>
                  <button type="button"class="btn btn-primary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      <!-- Optional JavaScript -->
      <div class="modal fade" id="VenActualizar">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Actualizar producto</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <form id="upPro">
                  <div class="row">
                    <div class="col-sm">
                      <div class="form-group">
                        <label class="label">Código </label>
                        <input required autocomplete="off" name="id_Producto" class="form-control" id="id_Producto"
                              type="text" placeholder="Código" readonly>
                      </div>
                    </div>
                    <div class="col-sm">
                      <div class="form-group">
                        <label class="label">Nombre</label>
                        <input required autocomplete="off" name="Nombre" class="form-control" id="Nombre"
                              type="text" placeholder="Nombre">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm">
                      <div class="form-group">
                          <label class="label">Existencia</label>
                          <input required autocomplete="off" name="stock" class="form-control" id="stock"
                                type="decimal(9,2)" placeholder="Existencia">
                      </div>
                    </div>
                    <div class="col-sm">
                      <div class="form-group">
                        <label class="label">Precio de compra</label>
                        <input required autocomplete="off" name="p_Compra" class="form-control" id="p_Compra"
                              type="decimal(9,2)" placeholder="Precio de compra">
                      </div>
                    </div>
                    <div class="col-sm">
                      <div class="form-group">
                        <label class="label">Precio lista</label>
                        <input required autocomplete="off" name="p_Lista" class="form-control" id="p_Lista"
                              type="decimal(9,2)" placeholder="Precio de compra">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm">
                      <div class="form-group">
                        <label class="label">Precio publico</label>
                        <input required autocomplete="off" name="p_VentaC" class="form-control" id="p_VentaC"
                              type="decimal(9,2)" placeholder="Precio de venta normal">
                      </div>
                    </div>
                    <div class="col-sm">
                      <div class="form-group">
                        <label class="label">Precio medio mayoreo</label>
                        <input required autocomplete="off" name="p_VentaM" class="form-control" id="p_VentaM"
                              type="decimal(9,2)" placeholder="Precio de venta medico">
                      </div>
                    </div>
                    <div class="col-sm">
                    <div class="form-group">
                        <label class="label">Precio mayoreo</label>
                        <input required autocomplete="off" name="p_VentaMa" class="form-control" id="p_VentaMa"
                              type="decimal(9,2)" placeholder="Precio de venta mayoreo">
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="Operacion" id="Operacion" value="Modificar" />
                  <button class="btn btn-success" onclick="updatePro();">Guardar cambios </button>
                  <button type="button"class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </form>
              </div>
            </div>
          </div>
        </div>           
      <!-- Optional JavaScript -->
  </div>
    <div class="modal fade" id="listaBusqueda">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title ">Lista de productos</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Laboratorio</th>
                  <th>Nombre</th>
                  <th>Seleccionar</th>
                </tr>
              </thead>
              <tbody id="cuerpo">
              </tbody>
            </table>
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
