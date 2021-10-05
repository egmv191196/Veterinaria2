<?php
    session_start();
    $empleado=$_SESSION['id_Empleado'];
    require_once('./Conexion.php'); 
    $Operacion=$_POST['Operacion'];
    if($Operacion=="Consulta"){
        $id_Producto=$_POST['id_Producto'];
        $consulta = "SELECT * FROM producto WHERE id_Producto=$id_Producto";
        if($res = mysqli_query($conexion,$consulta)){
            $numRows=mysqli_num_rows($res);
            if($numRows>0){
                $datos = mysqli_fetch_array($res);
                $Nombre=$datos['Nombre'];
                $stock= $datos['Cantidad'];
                $p_Compra= $datos['p_Compra'];
                $producto=array('Id' => $id_Producto,'Nombre' => $Nombre,'Cantidad' => $stock,'p_Compra' => $p_Compra);
                echo json_encode($producto);
            }else {
                echo 0;
            }   
        }else {
            echo 0;
        } 
    }else if($Operacion=="Agregar"){
        $id_Producto=$_POST['id_Producto'];
        $Nombre=$_POST['Descripcion'];
        $cantidad=$_POST['Cantidad'];
        $p_Compra=$_POST['precio_Compra'];
        $consulta = "SELECT Cantidad FROM producto WHERE id_Producto=$id_Producto";
        if($res = mysqli_query($conexion,$consulta)){
            $datos = mysqli_fetch_array($res);
            $stock=$datos['Cantidad'];
            $stockNew=$stock+$cantidad;
            $subtotal=$cantidad*$p_Compra;
            $consulta= "UPDATE producto SET Cantidad=$stockNew,p_Compra=$p_Compra WHERE id_Producto=$id_Producto";
            $res= mysqli_query($conexion,$consulta);
            if ($res==1) {
                $producto=array('iD'=>$id_Producto,'Nombre'=>$Nombre,'Cantidad'=>$cantidad,'p_Compra'=>$p_Compra,'subtotal'=>$subtotal);
                echo json_encode($producto);
            }else {
                echo 0;
            }            
        }else {
            echo 0;
        }
    }else if ($Operacion=="Devolucion") {
        $id_Producto=$_POST['id_Producto'];
        $cantidad=$_POST['Cantidad'];
        $consulta = "SELECT Cantidad FROM producto WHERE id_Producto=$id_Producto";
        if($res = mysqli_query($conexion,$consulta)){
            $datos = mysqli_fetch_array($res);
            $stock=$datos['Cantidad'];
            $stockNew=$stock-$cantidad;
            $consulta= "UPDATE producto SET Cantidad=$stockNew WHERE id_Producto=$id_Producto";
            mysqli_query($conexion,$consulta);
            echo 1;
        }else {
            echo 0;
        }
    }else if($Operacion=="Pago"){
        $Total = $_POST['Total'];
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');
        $numTicket=$_POST['numTicket'];
        $Proveedor=$_POST['Proveedor'];
        $data = $_POST['Productos'];
        $consulta= "INSERT INTO compra(id_Compra, Fecha, Hora, num_Ticket, Total, id_Proveedor) VALUES 
        (NULL,'$fecha','$hora',$numTicket,$Total,$Proveedor)"; 
        $res= mysqli_query($conexion,$consulta);
        if($res==1){
            $consulta = "SELECT id_Compra FROM compra WHERE id_Proveedor=$Proveedor AND num_Ticket=$numTicket";
            $res=mysqli_query($conexion,$consulta);
            $datos = mysqli_fetch_array($res);
            $id_Compra=$datos[0];
            $consulta="INSERT INTO productos_compra (id_Compra, id_Producto, Nombre, Cantidad,precio_Compra,p_Total) VALUES ";
            for ($i=0; $i <count($data); $i++) { 
                $cod=$data[$i][0];
                $Nombre=$data[$i][1];
                $p_Unitario=$data[$i][2];
                $Cant=$data[$i][3];
                $p_Total=$data[$i][4];
                if($i==0){
                    $consulta =$consulta."({$id_Compra},{$cod},'{$Nombre}',{$Cant},{$p_Unitario},{$p_Total})";
                }else{
                    $consulta =$consulta.",({$id_Compra},{$cod},'{$Nombre}',{$Cant},{$p_Unitario},{$p_Total})";
                }
            }
            //echo $consulta;
            $res=mysqli_query($conexion,$consulta);
            if($res==1){
                echo $id_Compra;
            }else{
                echo 0;
            }
        }else {
            echo 0;
        }
    }
?> 