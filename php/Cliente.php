<?php
    $Operacion=$_POST['Operacion'];
    require_once('./Conexion.php'); 
    if($Operacion=="Insertar"){
        $Nombre=$_POST['Nombre'];
        $Direccion=$_POST['Direccion'];
        $Telefono=$_POST['Telefono'];
        $Email=$_POST['Email'];
        $RFC=$_POST['RFC'];
        $t_Cliente=$_POST['t_Cliente'];
        $consulta = "INSERT INTO cliente(Nombre, Direccion, Telefono, Email, RFC, Descuento) VALUES (
            '{$Nombre}','{$Direccion}',{$Telefono},'{$Email}','{$RFC}',{$t_Cliente})";
        echo mysqli_query($conexion,$consulta);   
    }else if($Operacion=="Eliminar"){
        $id_Cliente=$_POST['id_Cliente'];
        $consulta = "DELETE FROM cliente WHERE id_Cliente='$id_Cliente'";
        echo mysqli_query($conexion,$consulta);
    }
    else if($Operacion=="Modificar"){
        $id_Cliente=$_POST['id_Cliente'];
        $Nombre=$_POST['Nombre'];
        $Direccion=$_POST['Direccion'];
        $Telefono=$_POST['Telefono'];
        $Email=$_POST['Email'];
        $RFC=$_POST['RFC'];
        $t_Cliente=$_POST['t_Cliente'];
        $consulta = "UPDATE cliente SET Nombre='$Nombre', Direccion='$Direccion', Telefono=$Telefono, Email='$Email', RFC='$RFC', Descuento=$t_Cliente WHERE id_Cliente=$id_Cliente";
        echo mysqli_query($conexion,$consulta);
    }else if($Operacion=="c_Descuento"){
        $id_Cliente=$_POST['id_Cliente'];
        $consulta="SELECT Descuento FROM cliente WHERE id_Cliente='$id_Cliente'";
        $result= mysqli_query($conexion,$consulta);
        $row = mysqli_fetch_array($result);
        echo $row['Descuento'];
    }
?> 