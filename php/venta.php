<?php
    session_start();
    $empleado=$_SESSION['id_Empleado'];
    require_once('./Conexion.php'); 
    $Operacion=$_POST['Operacion'];
    if($Operacion=="Venta"){
        $id_Producto=$_POST['id_Producto'];
        $cantidad=$_POST['Cantidad'];
        $Des=$_POST['precio'];
        $consulta = "SELECT * FROM producto WHERE id_Producto=$id_Producto";
        if($res = mysqli_query($conexion,$consulta)){
            $numRows=mysqli_num_rows($res);
            if($numRows>0){
                $datos = mysqli_fetch_array($res);
                $Nombre=$datos['Nombre'];
                $stockReal= $datos['Cantidad'];
                if($stockReal>=$cantidad){
                    if($Des==0){
                        $precio= $datos[6];
                    }else if($Des==1){
                        $precio= $datos[7];
                    }else if($Des==2){
                        $precio= $datos[8];
                    }         
                    $stockFinal=$stockReal-$cantidad;
                    $update = "UPDATE producto SET Cantidad=$stockFinal WHERE id_Producto=$id_Producto";
                    mysqli_query($conexion,$update);
                    $precioTotal=$precio*$cantidad;
                    $producto=array('Id' => $id_Producto,'Nombre' => $Nombre,'Precio' => $precio,'Cantidad' => $cantidad,'Subtotal'=>$precioTotal);
                    echo json_encode($producto);
                }else {
                    echo 2;
                }  
            }else {
                echo 0;
            }   
        }else {
            echo 0;
        } 

    }else if($Operacion=="Devolucion"){
        $id_Producto=$_POST['id_Producto'];
        $cantidad=$_POST['Cantidad'];
        $consulta = "SELECT Cantidad FROM producto WHERE id_Producto=$id_Producto";
        if($res = mysqli_query($conexion,$consulta)){
            $datos = mysqli_fetch_array($res);
            $stock=$datos['Cantidad'];
            $stockNew=$stock+$cantidad;
            $consulta= "UPDATE producto SET Cantidad=$stockNew WHERE id_Producto=$id_Producto";
            mysqli_query($conexion,$consulta);
            echo 1;
        }else {
            echo 0;
        }
    }else if($Operacion=="PagoEfectivo"){
        $Total = $_POST['Total'];
        $Efectivo = number_format($_POST['Efectivo'], 2, '.', '');
        $Cambio = $_POST['Cambio'];
        $Fecha=date('Y-m-d');
        $Hora=date('H:i:s');
        $cliente=$_POST['Cliente'];
        $data = $_POST['Productos'];
        $consulta= "INSERT INTO venta(id_Venta, Fecha, Hora, id_User, id_Cliente, Total, Pago, Cambio,forma_Pago) VALUES 
        (NULL,'$Fecha','$Hora' ,$empleado,$cliente,$Total,$Efectivo,$Cambio,0)";
        //echo $consulta;
        $res= mysqli_query($conexion,$consulta);
        if($res==1){
            $consulta = "SELECT id_Venta FROM venta WHERE id_User=$empleado AND id_Cliente=$cliente ORDER BY id_Venta DESC";
            $res=mysqli_query($conexion,$consulta);
            $datos = mysqli_fetch_array($res);
            $id_Venta=$datos[0];
            //$consulta="INSERT INTO productos_venta (id_Venta, id_Producto, Cantidad, precio_Unitario, precio_Total) VALUES ";
            $consulta="INSERT INTO productos_venta (id_Venta, id_Producto,Nombre, Cantidad, precio_Unitario, precio_Total) VALUES ";
            for ($i=0; $i <count($data); $i++) { 
                $cod=$data[$i][0];
                $Nombre=$data[$i][1];
                $p_Unitario=$data[$i][2];
                $Cant=$data[$i][3];
                $p_Total=$data[$i][4];
                if($i==0){
                    //$consulta =$consulta."({$id_Venta},{$cod},{$Cant},{$p_Unitario},{$p_Total})";
                    $consulta =$consulta."({$id_Venta},{$cod},'{$Nombre}',{$Cant},{$p_Unitario},{$p_Total})";
                }else{
                    //$consulta =$consulta.",({$id_Venta},{$cod},{$Cant},{$p_Unitario},{$p_Total})";
                    $consulta =$consulta.",({$id_Venta},{$cod},'{$Nombre}',{$Cant},{$p_Unitario},{$p_Total})";
                }
            }
            //echo $consulta;
            $res=mysqli_query($conexion,$consulta);
            if($res==1){
                echo $id_Venta;
            }else{
                echo 0;
            }
        }else {
            echo 0;
        }
    }else if ($Operacion=="PagoCredito") {
        $Total = $_POST['Total'];
        $Fecha=date('Y-m-d');
        $Hora=date('H:i:s');
        $cliente=$_POST['Cliente'];
        $data = $_POST['Productos'];
        $consulta= "INSERT INTO venta(id_Venta, Fecha, Hora, id_User, id_Cliente, Total, Pago, Cambio,forma_pago) VALUES 
        (NULL,'$Fecha','$Hora' ,$empleado,$cliente,$Total,0.0,0.0,1)"; 
        $res= mysqli_query($conexion,$consulta);
        if($res==1){
            $consulta = "SELECT id_Venta FROM venta WHERE id_User=$empleado AND id_Cliente=$cliente ORDER BY id_Venta DESC";
            $res=mysqli_query($conexion,$consulta);
            $datos = mysqli_fetch_array($res);
            $id_Venta=$datos[0];
            //Verificar Linea credito
            $consulta = "SELECT * FROM lineacredito WHERE id_Cliente=$cliente";
            $res=mysqli_query($conexion,$consulta);
            $numCreditos=mysqli_num_rows($res);
            if ($numCreditos==0) {
                $consulta = "INSERT INTO lineacredito (id_creditoTotal, montoCredito, montoAbonado, montoRestante, id_Cliente)
                VALUES (NULL,$Total,0.0,$Total,$cliente)";
                $res=mysqli_query($conexion,$consulta);
                if ($res==1) {
                    $consulta = "SELECT * FROM lineacredito WHERE id_Cliente=$cliente";
                    $res=mysqli_query($conexion,$consulta);
                    $datos = mysqli_fetch_array($res);
                    $idLineaCredito=$datos[0];
                }
            }else {
                $consulta = "SELECT * FROM lineacredito WHERE id_Cliente=$cliente";
                $res=mysqli_query($conexion,$consulta);
                $datos = mysqli_fetch_array($res);
                $idLineaCredito=$datos[0];
                $totalDeuda=$datos[1];
                $totalRestante=$datos[3];
                $totalDeuda=$totalDeuda+$Total;
                $totalRestante=$totalRestante+$Total;
                $consulta= "UPDATE lineacredito SET montoCredito=$totalDeuda, montoRestante=$totalRestante WHERE id_creditoTotal=$idLineaCredito";
                mysqli_query($conexion,$consulta);
            }
            ///--------------------------------------------
            
            //Agregar a credito
            $consulta="INSERT INTO creditoventa(id_Credito,Fecha, Hora, monto_Credito, id_Venta, id_creditoTotal) VALUES
                (NULL, '$Fecha','$Hora', $Total, $id_Venta, $idLineaCredito)";
            $res=mysqli_query($conexion,$consulta);
            if ($res==1) {
                $consulta="INSERT INTO productos_venta (id_Venta, id_Producto,Nombre, Cantidad, precio_Unitario, precio_Total) VALUES ";
                for ($i=0; $i <count($data); $i++) { 
                    $cod=$data[$i][0];
                    $Nombre=$data[$i][1];
                    $p_Unitario=$data[$i][2];
                    $Cant=$data[$i][3];
                    $p_Total=$data[$i][4];
                    if($i==0){
                        $consulta =$consulta."({$id_Venta},{$cod},'{$Nombre}',{$Cant},{$p_Unitario},{$p_Total})";
                    }else{
                        $consulta =$consulta.",({$id_Venta},{$cod},'{$Nombre}',{$Cant},{$p_Unitario},{$p_Total})";
                    }
                }
                //echo $consulta;
                $res=mysqli_query($conexion,$consulta);
                if($res==1){
                    echo $id_Venta;
                }else{
                    echo 0;
                }
            }else {
                echo 0;
            }
        }else {
            echo 0;
        }
    }else if ($Operacion=="BuscarPornombre") {
        $texto = $_POST['texto'];
        $consulta= "SELECT * FROM producto WHERE Nombre LIKE '%$texto%'"; 
        $res= mysqli_query($conexion,$consulta);
        $Resultados=array();
        while ($row = mysqli_fetch_array($res)){
            $valores=[$row[0], $row[2], $row[3],$row[5],$row[6],$row[7],$row[8]];
            array_push($Resultados,$valores);
        }
        echo json_encode($Resultados);
    }else if ($Operacion=="suspenderVenta") {
        $data = $_POST['Productos'];
        $cliente = $_POST['cliente'];
        $id_Cliente = $_POST['id_Cliente'];
        $Descuento = $_POST['Descuento'];
        $Total = $_POST['Total'];
        $Fecha=date('Y-m-d');
        $Hora=date('H:i:s');
        $consulta= "INSERT INTO venta_suspendida(id_Venta, nombreCliente, id_Cliente, Descuento, Total, Fecha, Hora, id_User, Estado) VALUES 
        (NULL, '$cliente', $id_Cliente, $Descuento, $Total, '$Fecha', '$Hora', $empleado,1)"; 
        $res= mysqli_query($conexion,$consulta);
        if($res==1){
            $consulta = "SELECT id_Venta FROM venta_suspendida WHERE id_User=$empleado AND id_Cliente=$id_Cliente ORDER BY id_Venta DESC";
            $res=mysqli_query($conexion,$consulta);
            $datos = mysqli_fetch_array($res);
            $id_Venta=$datos[0];
            $consulta="INSERT INTO productos_vsuspendida (id_Venta, id_Producto, Nombre, p_Unitario, Cantidad, Subtotal) VALUES ";
            for ($i=0; $i <count($data); $i++) { 
                $cod=$data[$i][0];
                $Nombre=$data[$i][1];
                $p_Unitario=$data[$i][2];
                $Cant=$data[$i][3];
                $p_Total=$data[$i][4];
                if($i==0){
                    $consulta =$consulta."({$id_Venta},{$cod},'{$Nombre}',{$p_Unitario},{$Cant},{$p_Total})";
                }else{
                    $consulta =$consulta.",({$id_Venta},{$cod},'{$Nombre}',{$p_Unitario},{$Cant},{$p_Total})";
                }
            }
            $res=mysqli_query($conexion,$consulta);
            if($res==1){
                echo $id_Venta;
            }else{
                echo 0;
            }
        }else {
            echo 0;
        }
    }else if ($Operacion=="recuperarVenta") {
        $consulta= "SELECT * FROM venta_suspendida WHERE Estado=1"; 
        $res= mysqli_query($conexion,$consulta);
        $Resultados=array();
        while ($row = mysqli_fetch_array($res)){
            $valores=[$row[0], $row[1], $row[2]];
            array_push($Resultados,$valores);
        }
        echo json_encode($Resultados);
    }else if ($Operacion=="datosvSuspendida") {
        $id_Ticket = $_POST['id_Ticket'];
        $Resultados=array();
        $consulta= "UPDATE venta_suspendida SET Estado=0 WHERE id_Venta=$id_Ticket";
        $res= mysqli_query($conexion,$consulta);
        $consulta= "SELECT * FROM venta_suspendida WHERE id_Venta=$id_Ticket";
        $res= mysqli_query($conexion,$consulta);
        $row = mysqli_fetch_array($res);
        $cliente=[$row[2], $row[3], $row[4],$row[8]];
        array_push($Resultados,$cliente); 
        $consulta= "SELECT * FROM productos_vsuspendida WHERE id_Venta=$id_Ticket";
        $res= mysqli_query($conexion,$consulta);
        while ($row = mysqli_fetch_array($res)){
            $valores=[$row[1], $row[2], $row[3],$row[4], $row[5]];
            array_push($Resultados,$valores);
        }
        echo json_encode($Resultados);
    }else if ($Operacion=="ticketPorFecha") {
        $Fecha = $_POST['Fecha'];
        $date1=date("Y-m-d",strtotime($Fecha));
        $consulta= "SELECT * FROM venta WHERE Fecha='$date1'"; 
        $res= mysqli_query($conexion,$consulta);
        $Resultados=array();
        while ($row = mysqli_fetch_array($res)){
            $valores=[$row[0], $row[1], $row[2],$row[5]];
            array_push($Resultados,$valores);
        }
        echo json_encode($Resultados);
    }else if ($Operacion=="BuscarPornombreEdit") {
        $texto = $_POST['texto'];
        $consulta= "SELECT * FROM producto WHERE Nombre LIKE '%$texto%'"; 
        $res= mysqli_query($conexion,$consulta);
        $Resultados=array();
        while ($row = mysqli_fetch_array($res)){
            $valores=[$row[0],$row[1], $row[2], $row[3],$row[5],$row[6],$row[7],$row[8]];
            array_push($Resultados,$valores);
        }
        echo json_encode($Resultados);
    }
?> 