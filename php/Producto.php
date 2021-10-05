<?php
    $Operacion=$_POST['Operacion'];
    require_once('./Conexion.php'); 
    if($Operacion=="Insertar"){
        $id_Producto=$_POST['id_Producto'];
        $Nombre=$_POST['Nombre'];
        $p_Compra=$_POST['p_Compra'];
        $p_Lista=$_POST['p_Lista'];
        $p_VentaC=$_POST['p_VentaC'];
        $p_VentaM=$_POST['p_VentaM'];
        $p_VentaMa=$_POST['p_VentaMa'];
        $stock=$_POST['stock'];
        $consulta = "INSERT INTO producto (id_Producto, Nombre, Cantidad, p_Compra, P_CostoLista, PVPublicoGeneral, PVMedioMayoreo, PVMayoreo) VALUES (
            {$id_Producto},'{$Nombre}',{$stock},{$p_Compra},{$p_Lista},{$p_VentaC},{$p_VentaM},{$p_VentaMa})"; 
        if (mysqli_query($conexion,$consulta)) {
            echo 1;
      } else {
            echo mysqli_errno($conexion);
      } 
    }else if($Operacion=="Eliminar"){
        $id_Producto=$_POST['id_Producto'];
        $consulta = "DELETE FROM producto WHERE id_Producto='$id_Producto'";
        echo mysqli_query($conexion,$consulta);
    }else if($Operacion=="Modificar"){
        $id_Producto=$_POST['id_Producto'];
        $Nombre=$_POST['Nombre'];
        $p_Compra=$_POST['p_Compra'];
        $p_Compralista=$_POST['p_Lista'];
        $p_VentaN=$_POST['p_VentaC'];
        $p_VentaM=$_POST['p_VentaM'];
        $p_VentaMa=$_POST['p_VentaMa'];
        $stock=$_POST['stock'];
        $consulta = "UPDATE producto SET Nombre='$Nombre', Cantidad=$stock, p_Compra=$p_Compra, p_CostoLista=$p_Compralista, PVPublicoGeneral=$p_VentaN , PVMedioMayoreo=$p_VentaM , 
        PVMayoreo=$p_VentaMa WHERE id_Producto=$id_Producto";
        $res=mysqli_query($conexion,$consulta);
        echo $res;
    }else if($Operacion=="Verificar"){
        $id=$_POST['id_Producto'];
        $consulta="SELECT * from producto WHERE id_Producto=$id";
        $result= mysqli_query($conexion, $consulta);
        if($row=mysqli_fetch_array($result)){
            echo $row['Nombre'];//Existe el prodcuto
        } 
        else{
            echo 0; //No existe el producto
        }
    }else if($Operacion=="datosProducto"){
        $id = $_POST['id'];
        $consulta= "SELECT * FROM producto WHERE id_Producto=$id"; 
        $res= mysqli_query($conexion,$consulta);
        $row = mysqli_fetch_array($res);
        $valores=[$row[0], $row[2], $row[3],$row[4],$row[5],$row[6],$row[7],$row[8]];
        echo json_encode($valores);
    }
    
?> 