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
      <div class="row">
        <div class="col-sm">
          <h1>Usuarios <i class="fa fa-users"></i></h1>
        </div>
        <div class="col-sm">
            <a href="#addUser" class="btn btn-success mb-2 float-right" data-toggle="modal">Agregar</a>
        </div>
      </div>      
      <div class="table-responsive">
          <table class="table table-bordered">
              <thead>
              <tr>
                <th>Id Empleado</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Status</th>
                <th>Editar</th>
              </tr>
              </thead>
              <tbody>
                  <?php
                      require_once('./php/Conexion.php');
                      $result= mysqli_query($conexion, "select * from usuario");
                      while ($row = mysqli_fetch_array($result)) {
                          echo '<tr style="text-align: center">';
                          echo '<td>'.$row[0].'</td>';
                          echo '<td>'.$row[1].'</td>';
                          echo '<td>'.$row[3].'</td>';
                          switch ($row[4]) {
                              case 1:
                                  echo '<td>Gerente</td>';
                              break;
                              case 2:
                                  echo '<td>Supervisor</td>';
                              break;
                              case 3:
                                  echo '<td>Empleado</td>';
                              break;
                              default:
                              break;
                          }
                          echo '<td>'.$row[5].'</td>';
                          echo '<td>'.$row[6].'</td>';
                          switch ($row[7]) {
                              case 1:
                                  echo '<td><i class="fa fa-check" aria-hidden="true"></i></td>';
                              break;
                              case 2:
                                echo '<td><i class="fa fa-times" aria-hidden="true"></i></td>';
                              break;
                              default:
                              break;
                          }
                          echo '<td> <a class="btn btn-warning" onclick="editUser(this);"><i class="fa fa-edit"></i></a> </td>';
                          echo '</tr>';
                      }
                  ?>
          </tbody>
          </table>
      </div>
    </div>

    <!-- Modal para Agregar Usuario -->
    <div class="modal fade" id="addUser">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title ">Agregar Usuario</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5 ">
                        <label class="label">Nombre: *</label>
                    </div>
                    <div class="col-7">
                      <input class="form-control" id="nombreEmpleado"  type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 ">
                        <label class="label">Telefono: </label>
                    </div>
                    <div class="col-7">
                    <input  class="form-control" id="telefono" type="text" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 ">
                        <label class="label">Correo: </label>
                    </div>
                    <div class="col-7">
                      <input  class="form-control" id="Correo" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 ">
                        <label class="label">Usuario:* </label>
                    </div>
                    <div class="col-7">
                      <input autocomplete="off" class="form-control" id="Usuario" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 ">
                        <label class="label">Contraseña: *</label>
                    </div>
                    <div class="col-7">
                      <input autocomplete="off" class="form-control" id="password" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 ">
                        <label class="label ">Puesto *</label>
                    </div>
                    <div class="col-7">
                      <select class="form-control" id="Puesto" >
                              <option value="">Elige empleado</option> 
                              <option value="1">Gerente</option> 
                              <option value="2">Supervisor</option> 
                              <option value="3">Empleado General</option>           
                      </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 ">
                        <label class="label ">Estado *</label>
                    </div>
                    <div class="col-7">
                      <select class="form-control" id="Estado" >
                              <option value="">Elige el estado</option> 
                              <option value="1">Activo</option> 
                              <option value="2">Inactivo</option>          
                      </select>
                    </div>
                </div>
                <div class="form-group m-2">
                <button type="button" class="btn btn-success float-right m-2" onclick="addUser();">Agregar usuario</button>
                <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
                </div>
            </div> 
            </div>
        </div>
    </div>
    <!-- Modal para Agregar Usuario -->
    <div class="modal fade" id="editUser">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title ">Corte</h2>
            <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="row">
                    <div class="col-3 text-right">
                        <label class="label">ID:</label>
                    </div>
                    <div class="col-9">
                      <input class="form-control" id="editIDEmpleado"  type="text" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <label class="label">Nombre:</label>
                    </div>
                    <div class="col-9">
                      <input class="form-control" id="editnombreEmpleado"  type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <label class="label">Contraseña:</label>
                    </div>
                    <div class="col-9">
                      <input class="form-control" id="editPass"  type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <label class="label">Telefono:</label>
                    </div>
                    <div class="col-9">
                    <input  class="form-control" id="edittelefono" type="text" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <label class="label">Correo:</label>
                    </div>
                    <div class="col-9">
                      <input  class="form-control" id="editCorreo" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <label class="label">Usuario:</label>
                    </div>
                    <div class="col-9">
                      <input autocomplete="off" class="form-control" id="editUsuario" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <label class="label ">Puesto</label>
                    </div>
                    <div class="col-9">
                      <select class="form-control" id="editPuesto" >
                              <option value="">Elige empleado</option> 
                              <option value="1">Gerente</option> 
                              <option value="2">Supervisor</option> 
                              <option value="3">Empleado General</option>           
                      </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <label class="label ">Estado</label>
                    </div>
                    <div class="col-9">
                      <select class="form-control" id="editEstado" >
                              <option value="">Elige el estado</option> 
                              <option value="1">Activo</option> 
                              <option value="2">Inactivo</option>          
                      </select>
                    </div>
                </div>
                <div class="form-group m-2">
                <button type="button" class="btn btn-success float-right m-2" onclick="updateUser();">Guardar Cambios</button>
                <button type="button"class="btn btn-danger float-right m-2" data-dismiss="modal">Cerrar</button>
                </div>
            </div> 
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script src="./js/Administrar.js"></script>
  </body>
</html>