<!doctype html>
<html lang="es" xmlns:th="http://www.w3.org/1999/xhtml">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=yes">
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <script src="https://kit.fontawesome.com/8c9db8153c.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href=".//css/cabezapie.css">
    <link rel="stylesheet" href=".//css/prove.css">
    <script type="text/javascript" src="./js/Mostrar.js"></script>
    <title>Venta</title>
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
            $Cobrar=1;
          }else{
            $Cobrar=0;
          }
        }else{
          $Cobrar=0;
        }
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
              <h1 class="text-center">Venta<i class="fa fa-cart-plus"></i></h1>
            <div class="row">
              <label class="col-1" for="id_cliente">Cliente</label>
              <!-- Optional JavaScript -->
              <input type="hidden" id="tP_idCliente" value="0">
              <input type="hidden" id="tP_Total" value="0">
              <!-- Optional JavaScript -->
              <input type="hidden" id="Descuento" value="0">

              <select required class="form-control col-2" name="id_cliente" id="id_cliente" onchange="Descuento();" >
                      <option value="1">cliente general</option>   
                        <?php
                          require_once('./php/Conexion.php');
                          $result= mysqli_query($conexion, "select * from cliente");
                          $row = mysqli_fetch_array($result);
                          while ($row = mysqli_fetch_array($result)) {
                              echo '<option value="'.$row['id_Cliente'].'" >'.$row['Nombre'].' - '.$row['Telefono'].'</option>';
                          }
                        ?>      
              </select>
              <label class="col-1" for="cantidad">Cantidad</label>
              <input id="cantidad" autocomplete="off" name="cantidad" type="number" value=1
                      class="form-control col-1" placeholder="Cantidad de productos">
              <label class="col-1" for="codigo">Código</label>
              <input id="codigo" autocomplete="off" required name="codigo" type="text"
                      class="form-control col-2" onchange="leer();"
                      placeholder="Código">
              <label class="col-1" for="Nombre">Nombre</label>
              <input id="Nombre" autocomplete="off" name="codigo" type="text"
                      class="form-control col-2" placeholder="Nombre" onchange="BusquedaNombre();">
            </div>
            <div class="table-responsive mt-4 ">
                <table class="table table-bordered" id="Productos">
                    <thead>
                    <tr>
                        <th width=20%>Código de barras</th>
                        <th width=35%>Descripción</th>
                        <th width=15%>Precio unitario</th>
                        <th width=5%>Cantidad</th>
                        <th width=5%>Subtotal</th>
                        <th width=10%>Quitar</th>
                    </tr>
                    </thead>
                    <tbody id="Productos2">
                    </tbody>
                </table>
            </div>
            <div class="row p-2 m-2">
              <div class="col-10 text-right">
                <label >Total: $ </label>
              </div>
              <div class="col-2">
              <input id="Total" class="form-control" type="text" value="0.0" disabled>
              </div>
            </div>
            <div class="form-group float-right">
            <?php 
              if ($Cobrar==1) {
                echo '<button class="btn btn-secondary mb-2 ml-2 mr-2 float-right" onclick="mostrarPendientes();" >Tickets por cobrar</button>';
                echo '<button class="btn btn-success mb-2 ml-2 mr-2 float-right" onclick="pagar_modal();" >Pagar</button>';
              }
              else{
                echo '<button class="btn btn-secondary mb-2 ml-2 mr-2 float-right" onclick="modalNombrePendiente();" >Enviar compra a caja</button>';
              } 
            ?>                  
            </div>
        </div>
    </div>
    <div class="modal fade" id="Pagar">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title ">Cobrar</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <form id="Pago1" >
              <div class="row">
                <div class="col-5 text-right">
                  <label class="label ">Total a pagar: $</label>
                </div>
                <div class="col-7">
                  <input autocomplete="off" name="Total" class="form-control col-sm" id="modal_Total" type="text" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-5 text-right">
                  <label class="label">Efectivo: $</label>
                </div>
                <div class="col-7">
                <input required autocomplete="off" onkeyup="calcular_cambio();" onchange="pago();" name="modal_Pago" class="form-control" id="modal_Pago" type="decimal(9,2)" placeholder="Ingresa el monto entregado" autofocus>
                </div>
              </div>
              <div class="row">
                <div class="col-5 text-right">
                <label class="label">Cambio: $</label>
                </div>
                <div class="col-7">
                <input required autocomplete="off" name="modal_Cambio" class="form-control" id="modal_Cambio" type="decimal(9,2)" placeholder="0.00" readonly>                    </div>
              </div>
              <div class="form-group m-2">
                <input type="hidden" name="Operacion" id="Operacion" value="Modificar" />
                <button type="button" class="btn btn-success float-right m-2" onclick="pagoEfectivo();">Pago efectivo</button>
                <button type="button" class="btn btn-secondary float-right m-2" onclick="pagoCredito();">Pago Credito</button>
                <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
          </div> 
          </div>
        </div>
      </div> 

    <div class="modal fade" id="listaBusqueda">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title ">Lista de productos</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Existencias</th>
                  <th>Precio Lista </th>
                  <th>Precio Publico</th>
                  <th>Precio Medio Mayoreo</th>
                  <th>Precio Mayoreo</th>
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

    <div class="modal fade" id="TicketsPendientes">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title ">Pendientes por cobrar</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Id Venta pendiente</th>
                  <th>Nombre cliente</th>
                  <th>Seleccionar</th>
                </tr>
              </thead>
              <tbody id="cuerpoPendientes">
              </tbody>
            </table>
          </div> 
          </div>
        </div>
      </div> 

      <div class="modal fade" id="ticketPendiente">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title ">Enviar a caja</h2>
              <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <label class="label">Nombre</label>
              <input required autocomplete="off" class="form-control" id="nombre_tPendiente" type="text">
              <button class="btn btn-success float-right mt-2" onclick="guardarPendiente();">Enviar a Caja</button>
            </div> 
          </div>
        </div>
      </div> 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script src="./js/venta.js"></script>
  </body>
</html>