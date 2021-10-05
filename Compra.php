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
    <script type="text/javascript" src="./js/Mostrar.js"></script>
    <title>Compra de productos</title>
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
          <a class="btn btn-info" href="menu.php" hidden><i class="fa fa-arrow-left"></i>&nbsp;Volver</a>
          <a class="navbar-brand" href="menu.php"><img src="img/BALBI-sin-fondo.png"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            
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
    </div>	
    <div class="header">
        <div class="col-12">
              <h1 class="text-center">Compra<i class="fa fa-cart-plus"></i></h1>
            <div class="row">
                  <label class="col-1" for="id_cliente">Elije proveedor</label>
                  <input type="hidden" id="Descuento" value="0">
                  <select required class="form-control col-2" name="id_Proveedor" id="id_Proveedor" required>
                          <option value="">Selecciona un proveedor</option>   
                            <?php
                              require_once('./php/Conexion.php');
                              $result= mysqli_query($conexion, "select * from proveedor");
                              while ($row = mysqli_fetch_array($result)) {
                                  echo '<option value="'.$row['id_Proveedor'].'" >'.$row['Nombre'].' - '.$row['Telefono'].'</option>';
                              }
                            ?>      
                  </select>
                  <label class="col-1" for="codigo">Numero de ticket</label>
                  <input id="num_Ticket" autocomplete="off" required name="num_Ticket" type="text"
                          class="form-control col-2" placeholder="Código de ticket" required>
                  <label class="col-1" for="codigo">Código </label>
                  <input id="codigo" autocomplete="off" required name="codigo" type="text"
                          class="form-control col-2" onchange="leerCodigo();"
                          placeholder="Código de barras">
                  <label class="col-1" for="Nombre">Nombre</label>
                  <input id="Nombre" autocomplete="off" name="codigo" type="text"
                      class="form-control col-2" placeholder="Nombre" onchange="BusquedaNombre();">        
            </div>
            <div class="table-responsive mt-4 ">
                <table class="table table-bordered" id="Productos">
                    <thead>
                      <tr>
                          <th width=20%>Código de barras</th>
                          <th width=30%>Descripción</th>
                          <th width=10%>Cantidad</th>
                          <th width=15%>Precio de compra</th>
                          <th width=5%>Subtotal</th>
                          <th width=10%>Quitar</th>
                      </tr>
                    </thead>
                    <tbody >
                    </tbody>
                </table>
            </div>
            <div class="row p-2 m-2">
              <div class="col-10 text-right">
                <label >Total: $ </label>
              </div>
              <div class="col-2">
                <input id="Total" class="form-control" type="text" value="0.0">
              </div>
            </div>
            <div class="form-group float-right">
              <button name="accion" value="cancelar" type="submit" class="btn btn-danger">Cancelar compra</button>
                <button class="btn btn-success mb-2 ml-2 mr-2 float-right" onclick="Compra();">Registrar Compra</button>               
            </div>
        </div>
    </div>
    <div class="modal fade" id="comprarProducto">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">Compra producto
                <h2 class="modal-title"></h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Código </label>
                      <input required autocomplete="off" name="id_Producto" class="form-control" id="id_Pro_Compra" autofocus="autofocus"
                            type="text" placeholder="Código" disabled>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Nombre</label>
                      <input required autocomplete="off" name="Nombre" class="form-control" id="nom_Compra"
                            type="text" placeholder="Nombre" disabled>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Existencia</label>
                      <input required autocomplete="off" name="stock" class="form-control" id="stock_Compra"
                            type="decimal(9,2)" placeholder="Existencia" disabled>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Precio de compra anterior</label>
                      <input required autocomplete="off" name="p_Compra" class="form-control" id="pc_Anterior"
                            type="decimal(9,2)" placeholder="Precio de compra" disabled>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Cantidad comprada</label>
                      <input required autocomplete="off" name="p_VentaC" class="form-control" id="piezas_compradas"
                            type="decimal(9,2)" placeholder="Ingresa la cantidad adquirida">
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label class="label">Precio de compra</label>
                      <input required autocomplete="off" name="p_VentaM" class="form-control" id="precio_Compra"
                            type="decimal(9,2)" placeholder="Ingresa el precio de compra">
                    </div>
                  </div>
                </div>
                <div class="float-right">
                  <input type="hidden" name="Operacion" id="Operacion" value="Compra" />
                  <button type="button" class="btn btn-primary m-1" onclick="agregarProducto();">Agregar</button>
                  <button type="button"class="btn btn-secondary  m-1" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="modal fade" id="listaBusqueda">
      <div class="modal-dialog ">
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
    <script src="./js/compra.js"></script>
  </body>
</html>