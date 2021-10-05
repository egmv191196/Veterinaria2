<?php
    require_once('./Conexion.php'); 
    session_start();
    $empleado=$_SESSION['id_Empleado'];
    $Operacion=$_POST['Operacion'];
    $fecha=date('Y-m-d');
    if($Operacion=="Asignacion"){
        $Empleado=$_POST['Empleado'];
        $Monto=$_POST['Monto'];
        $consulta = "SELECT * FROM caja WHERE id_User=$Empleado AND Fecha='$fecha'";
        if($res = mysqli_query($conexion,$consulta)){   
            $numRows=mysqli_num_rows($res);
            if($numRows>0){
                echo "El usuario ya tiene un fondo asignado";
            }else {
                $hora=date('H:i:s');
                $consulta= "INSERT INTO caja(id_Caja, id_User, Fecha, Hora, Fondo, total_Ingreso, totalDia, Corte, horaCorte, Diferencia, Estado) VALUES 
                (NULL, $Empleado, '$fecha', '$hora', $Monto, 0, 0, 0, NULL, 0,1)"; 
                $res= mysqli_query($conexion,$consulta);
                if($res==1){
                    $consulta= "SELECT id_Caja FROM caja WHERE id_User=$Empleado AND Fecha='$fecha'";
                    if($res = mysqli_query($conexion,$consulta)){   
                        $datos = mysqli_fetch_array($res);
                    }
                    echo $datos['id_Caja'];
                }else{
                    echo 0;
                }    
            }   
        }else {
            echo 0;
        } 
    }else if ($Operacion=="CorteDatos") {
        $Empleado=$_POST['Empleado'];
        $consulta = "SELECT * FROM caja WHERE id_User=$Empleado AND Fecha='$fecha'";
        if($res = mysqli_query($conexion,$consulta)){   
            $numRows=mysqli_num_rows($res);
            if($numRows>0){
                $datos = mysqli_fetch_array($res);
                $id_Caja=$datos['id_Caja'];
                $Fondo=$datos['Fondo'];
                $hora=date('H:i:s');
                $consulta= "SELECT Total FROM venta WHERE id_User=$Empleado AND forma_Pago=0 AND Fecha='$fecha'";
                $totalVenta=0.0; 
                $res= mysqli_query($conexion,$consulta);
                while ($row = mysqli_fetch_array($res)) {
                   $venta=$row[0];
                   $totalVenta=$totalVenta+$venta; 
                }
                $consulta= "SELECT Monto FROM operacion_credito WHERE id_User=$Empleado AND Fecha='$fecha'";
                $totalCredito=0.0; 
                $res= mysqli_query($conexion,$consulta);
                while ($row = mysqli_fetch_array($res)) {
                   $credito=$row[0];
                   $totalCredito=$totalCredito+$credito; 
                }
                $totalCorte=$totalCredito+$totalVenta;
                //echo $totalCorte;
                $datosCorte=array('Fondo'=>$Fondo,'IngresoTotal'=>$totalCorte);
                echo json_encode($datosCorte);    
            }else{
                echo 0;
            }   
        }else {
            echo 0;
        }
    }else if ($Operacion=="Corte") {
        $Empleado=$_POST['Empleado'];
        $consulta = "SELECT * FROM caja WHERE id_User=$Empleado AND Fecha='$fecha'";
        if($res = mysqli_query($conexion,$consulta)){   
            $numRows=mysqli_num_rows($res);
            if($numRows>0){
                $datos = mysqli_fetch_array($res);
                $id_Caja=$datos['id_Caja'];
                $totalIngreso=$_POST['totalIngreso'];
                $totalDia=$_POST['totalDia'];
                $efectivo=$_POST['efectivo'];
                $diferencia=$_POST['diferencia'];      
                $hora=date('H:i:s');
                $consulta= "UPDATE caja SET total_Ingreso=$totalIngreso, totalDia=$totalDia, corte=$efectivo,
                horaCorte='$hora',Diferencia=$diferencia, Estado=0 WHERE id_Caja=$id_Caja";
                $res= mysqli_query($conexion,$consulta);
                if ($res==1) {
                    echo $id_Caja;
                }else {
                    echo 0;
                }   
            }else{
                echo 0;
            }   
        }else {
            echo 0;
        }
    }
?> 