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
    <title>Clientes</title>
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
                    <div id="hora"><script type="text/javascript">Mostrar();</script></div>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
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
    <div class="row">
      <div class="col-sm">
        <h1>Clientes <i class="fas fa-handshake"></i></h1>
      </div>
      <div class="col-sm">
        <a href="#VenRegistrar" class="btn btn-success mb-2 float-right" data-toggle="modal">Agregar</a>
      </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr style="text-align: center">
                    <th>Id </th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Telefono</th>
                    <th>e-mail</th>
                    <th>RFC</th>

                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    require_once('./php/Conexion.php');
                    $result= mysqli_query($conexion, "SELECT COUNT(*) AS Total FROM cliente");
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
                    $result= mysqli_query($conexion, "SELECT * FROM cliente LIMIT $desde,$porPagina");
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<tr style="text-align: center">';
                        echo '<td>'.$row['id_Cliente'].'</td>';
                        echo '<td>'.$row['Nombre'].'</td>';
                        echo '<td>'.$row['Direccion'].'</td>';
                        echo '<td>'.$row['Telefono'].'</td>';
                        echo '<td>'.$row['Email'].'</td>';
                        echo '<td>'.$row['RFC'].'</td>';
                        echo '<td> <a class="btn btn-warning" onclick="editCliente(this);"><i class="fa fa-edit"></i></a> </td>';
                        echo '<td> <form action="#" method="post">';
                        echo '<button type="submit" class="btn btn-danger" onclick="delCliente(this);"> <i class="fa fa-trash"></i> </button>';
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
        <div class="modal fade" id="VenRegistrar">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Registrar Cliente</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <form id="addCliente">
                  <div class="row">
                    <div class="col-8">
                      <div class="form-group">
                        <label class="label">Nombre *</label>
                        <input required autocomplete="off" name="Nombre" class="form-control" 
                              type="text" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="col-4">
                    <div class="form-group">
                        <label class="label">Telefono *</label>
                        <input required autocomplete="off" name="Telefono" class="form-control" 
                              type="text" placeholder="Telefono">
                      </div>
                      
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-8">
                      <div class="form-group">
                        <label class="label">Direccion</label>
                        <input required autocomplete="off" name="Direccion" class="form-control" 
                              type="text" placeholder="Direccion">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="label">E-mail</label>
                        <input required autocomplete="off" name="Email" class="form-control" 
                              type="text)" placeholder="E-mail">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label class="label">RFC</label>
                        <input required autocomplete="off" name="RFC" class="form-control" 
                              type="text" placeholder="RFC">
                      </div>
                    </div>
                    <div class="col-6">
                    <label class="label">Tipo de cliente *</label>
                      <select required class="form-control " name="t_Cliente">
                        <option value="">Selecciona el tipo de cliente</option> 
                        <option value="0">Cliente estandar</option>  
                        <option value="1">Cliente Medio Mayoreo</option>
                        <option value="2">Cliente Mayoreo</option>     
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="Operacion" id="Operacion" value="Insertar" />
                  <input type="button" class="btn btn-success float-right m-2" onclick="addCliente();" value="Agregar Cliente">
                  <button type="button"class="btn btn-primary float-right m-2" data-dismiss="modal">Cerrar</button>
              </form>
              </div>
            </div>
          </div>
        </div>
        <!--Modal actualizar  -->
        <div class="modal fade" id="VenActualizar">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Actualizar Cliente</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <form id="upCliente">
                    <div class="row">
                      <div class="col-2">
                        <div class="form-group">
                          <label class="label">Id </label>
                          <input autocomplete="off" name="id_Cliente" class="form-control" id="id_Cliente"
                                type="text" placeholder="Código" readonly>
                        </div>
                      </div>
                      <div class="col-7">
                        <div class="form-group">
                          <label class="label">Nombre</label>
                          <input required autocomplete="off" name="Nombre" class="form-control" id="Nombre"
                                type="text" placeholder="Nombre">
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="form-group">
                          <label class="label">Telefono</label>
                          <input required autocomplete="off" name="Telefono" class="form-control" id="Telefono"
                                type="decimal(9,2)" placeholder="Precio de compra">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-8">
                      <div class="form-group">
                        <label class="label">Direccion</label>
                        <input required autocomplete="off" name="Direccion" class="form-control" id="Direccion"
                              type="text" placeholder="Direccion">
                      </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label class="label">E-mail</label>
                          <input required autocomplete="off" name="Email" class="form-control" id="Email"
                                type="decimal(9,2)" placeholder="Email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <div class="form-group">
                          <label class="label">RFC</label>
                          <input required autocomplete="off" name="RFC" class="form-control" id="RFC"
                                type="decimal(9,2)" placeholder="RFC">
                        </div>
                      </div>
                      <div class="col-6">
                      <label class="label">Tipo de cliente</label>
                          <select required class="form-control" name="t_Cliente" id="t_Cliente">
                            <option value="">Selecciona el tipo de cliente</option> 
                            <option value="0">Cliente estandar</option>  
                            <option value="1">Cliente Medio Mayoreo</option>
                            <option value="2">Cliente Mayoreo</option>     
                          </select>
                      </div>
                    </div>
                  <input type="hidden" name="Operacion" id="Operacion" value="Modificar" />
                  <button class="btn btn-success" onclick="updateCliente();">Guardar</button>
                  <button type="button"class="btn btn-primary" data-dismiss="modal">Cerrar</button>
              </form>
              </div>
            </div>
          </div>
        </div>

        <!--Modal actualizar  -->
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