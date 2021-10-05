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
    <title>Reportes</title>
    </head>
    <body>
        <?php 
        session_start();
        $Nombre=$_SESSION['k_user'];
        $Puesto=$_SESSION['cargo'];
        if ($Puesto==3) {
            header("Location:menu.php");
        }
        ?> 
        <div id="Home">
        <!---- Navigation -->
            <nav class="navbar navbar-expand-md navbar-black fixed-top">
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
                <h1>Reportes<i class="fa fa-file-text"></i></h1>
                <div class="row">
                    <div class="col-sm text-center">
                        <h3>Fondo y corte</h3>
                        <div class="list-group">
                            <a href="" data-toggle="modal" data-target="#asignarFondoModal" class="list-group-item list-group-item-action mt-1" >Asignar fondo</a>
                            <a href="" class="list-group-item list-group-item-action mt-1" data-toggle="modal" data-target="#corteModal">Corte de empleado</a>
                        </div>
                    </div>
                    <div class="col-sm text-center">
                        <h3>Venta</h3>
                        <div class="list-group">
                            <a href="" class="list-group-item list-group-item-action mt-1" onclick="corteDia();">Corte del dia</a>
                        </div>
                    </div>
                    <div class="col-sm text-center">
                        <h3>Productos</h3>
                        <div class="list-group">
                            <a href="" class="list-group-item list-group-item-action mt-1" onclick="bajoStock();">Productos con bajo stock</a>
                            <a href="" class="list-group-item list-group-item-action mt-1" onclick="altoStock();">Productos con Alto stock</a>
                            <a href="" class="list-group-item list-group-item-action mt-1" data-toggle="modal" data-target="#codigoModal">Ver precios de compra</a>
                            <a href="" class="list-group-item list-group-item-action mt-1" onclick="ProductosVendidos();";>Lista de productos vendidos hoy</a>
                        </div>
                    </div>
                    <div class="col-sm text-center">
                        <h3>Creditos</h3>
                        <div class="list-group">
                            <a href="" class="list-group-item list-group-item-action mt-1" data-toggle="modal" data-target="#seleccionarCliente">Reporte de credito del cliente</a>
                        </div>
                    </div>
                    <div class="col-sm text-center">
                        <h3>Tickets</h3>
                        <div class="list-group">
                            <a href="" class="list-group-item list-group-item-action mt-1" data-toggle="modal" data-target="#seleccionarDia">Buscar Ticket por dia</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                </div>
            </div>
        </div>
        <!-- Modal para asignar fondo -->
        <div class="modal fade" id="asignarFondoModal">
            <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                <h2 class="modal-title ">Asignar fondo</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-7 text-right">
                        <label class="label ">Selecciona el empleado </label>
                    </div>
                    
                    <div class="col-5">
                    <select class="form-control" id="id_empleado">
                            <option value="">Elige empleado</option>   
                            <?php
                                require_once('./php/Conexion.php');
                                $result= mysqli_query($conexion, "SELECT * FROM usuario where Puesto>1 AND Estado=1");
                                while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="'.$row['id_User'].'" >'.$row['Nombre'].' - '.$row['id_User'].'</option>';
                                }
                            ?>      
                    </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-7 text-right">
                        <label class="label">Efectivo: $</label>
                    </div>
                    <div class="col-5">
                    <input required autocomplete="off" onchange="asignarFondo();" class="form-control" id="efectivoFondo" type="decimal(9,2)" placeholder="Ingresa el monto " autofocus>
                    </div>
                    </div>
                    <div class="form-group m-2">
                    <button type="button" class="btn btn-success float-right m-2" onclick="asignarFondo();">Asignar fondo</button>
                    <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
                    </div>
                </div> 
                </div>
            </div>
        </div>
        <!-- Modal para Corte -->
        <div class="modal fade" id="corteModal">
            <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                <h2 class="modal-title ">Corte</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-right">
                            <label class="label ">Elige el empleado </label>
                        </div>
                        <div class="col-6">
                        <select class="form-control" id="id_empleadoCorte" onchange="datosCorte();">
                                <option value="">Elige empleado</option>   
                                <?php
                                    require_once('./php/Conexion.php');
                                    $result= mysqli_query($conexion, "SELECT * FROM usuario where Puesto>1 AND Estado=1");
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value="'.$row['id_User'].'" >'.$row['Nombre'].' - '.$row['id_User'].'</option>';
                                    }
                                ?>      
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-right">
                            <label class="label">Fondo: $</label>
                        </div>
                        <div class="col-6">
                        <input class="form-control" id="fondoModal" type="decimal(9,2)" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-right">
                            <label class="label">Total ingreso: $</label>
                        </div>
                        <div class="col-6">
                        <input  class="form-control" id="totalIngreso" type="decimal(9,2)" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-right">
                            <label class="label">Total por entregar: $</label>
                        </div>
                        <div class="col-6">
                        <input  class="form-control" id="totalPorEntregar" type="decimal(9,2)" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-right">
                            <label class="label">Efectivo contado: $</label>
                        </div>
                        <div class="col-6">
                        <input utocomplete="off" onkeyup="calcularDiferencia();" class="form-control" id="efectivoContado" type="decimal(9,2)" placeholder="Ingresa el monto">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-right">
                            <label class="label">Diferencia $</label>
                        </div>
                        <div class="col-6">
                        <input utocomplete="off" class="form-control" id="diferenciaCorte" type="decimal(9,2)" disabled>
                        </div>
                    </div>
                    <div class="form-group m-2">
                    <button type="button" class="btn btn-success float-right m-2" onclick="realizarCorte();">Realizar corte</button>
                    <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
                    </div>
                </div> 
                </div>
            </div>
        </div>
        <!-- Modal para precios de compra -->
        <div class="modal fade" id="codigoModal">
            <div class="modal-dialog ">
            <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title ">Codigo del producto</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 text-right">
                        <label class="label ">Ingresa el codigo del productos </label>
                    </div>
                    <div class="col-6">
                        <input class="form-control" id="codigoProducto" onchange="historialCompra();">
                    </div>
                </div>
                </div>
                <div class="form-group m-2">
                <button type="button" class="btn btn-success float-right m-2" onclick="historialCompra();">Historial de compra</button>
                <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
                </div>
            </div> 
            </div>
        </div>
        <!-- Modal para asignar fondo -->
        <div class="modal fade" id="seleccionarCliente">
            <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                <h2 class="modal-title ">Seleccionar cliente para generar su reporte</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-7 text-right">
                            <label class="label ">Selecciona el cliente </label>
                        </div>
                        
                        <div class="col-5">
                        <select class="form-control" id="id_ClienteModal">
                                <option value="">Selecciona el cliente</option>   
                                <?php
                                    require_once('./php/Conexion.php');
                                    $result= mysqli_query($conexion, "SELECT cliente.id_Cliente, cliente.Nombre  FROM lineacredito JOIN cliente WHERE lineacredito.id_Cliente=cliente.id_Cliente");
                                    while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="'.$row[0].'" >'.$row[1].'</option>';
                                    }
                                ?>      
                        </select>
                        </div>
                    </div>
                    <div class="form-group m-2">
                        <button type="button" class="btn btn-success float-right m-2" onclick="reporteCliente();">Generar Reporte</button>
                        <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
                    </div>
                </div> 
                </div>
            </div>
        </div>
        <!-- Modal para seleccionar dia -->
        <div class="modal fade" id="seleccionarDia">
            <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                <h2 class="modal-title ">Seleccionar fecha</h2>
                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 text-right">
                            <label class="label ">Selecciona fecha</label>
                        </div>
                        
                        <div class="col-7">
                        <input class="form-control" type="date" id="fecha" > 
                        </div>
                    </div>
                    <div class="form-group m-2">
                        <button type="button" class="btn btn-success float-right m-2" onclick="fecha();">Generar Reporte</button>
                        <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
                    </div>
                </div> 
                </div>
            </div>
        </div>
        <!-- Modal para seleccionar dia -->
        <div class="modal fade" id="listarTickets">
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
                        <th># Ticket</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Total</th>
                        <th>Reimprimir</th>
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
        <script src="./js/Reportes.js"></script>
    </body>
</html>