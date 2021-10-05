<?php
    $Operacion=$_POST['Operacion'];
    require_once('./Conexion.php'); 
    if($Operacion=="Insertar"){
        $Nombre=$_POST['Nombre'];
        $Direccion=$_POST['Direccion'];
        $Telefono=$_POST['Telefono'];
        $Email=$_POST['Email'];
        $RFC=$_POST['RFC'];
        $consulta = "INSERT INTO proveedor(Nombre, Direccion, Telefono, Email, RFC) VALUES (
            '{$Nombre}','{$Direccion}',{$Telefono},'{$Email}','{$RFC}')";
        echo mysqli_query($conexion,$consulta);   
    }else if($Operacion=="Eliminar"){
        $id_Proveedor=$_POST['id_Proveedor'];
        $consulta = "DELETE FROM proveedor WHERE id_Proveedor='$id_Proveedor'";
        echo mysqli_query($conexion,$consulta);
    }
    else if($Operacion=="Modificar"){
        $id_Proveedor=$_POST['id_Proveedor'];
        $Nombre=$_POST['Nombre'];
        $Direccion=$_POST['Direccion'];
        $Telefono=$_POST['Telefono'];
        $Email=$_POST['Email'];
        $RFC=$_POST['RFC'];
        $consulta = "UPDATE proveedor SET Nombre='$Nombre', Direccion='$Direccion', Telefono=$Telefono, Email='$Email'
        , RFC='$RFC' WHERE id_Proveedor=$id_Proveedor";
        echo mysqli_query($conexion,$consulta);
    }
?> 