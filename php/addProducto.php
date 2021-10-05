<?php
    $id_Producto=$_POST['id_Producto'];
    $Nombre=$_POST['Nombre'];
    $Proveedor=$_POST['Proveedor'];
    $p_Compra=$_POST['p_Compra'];
    $p_VentaC=$_POST['p_VentaC'];
    $p_VentaM=$_POST['p_VentaM'];
    $p_VentaMa=$_POST['p_VentaMa'];
    $stock=$_POST['stock'];
	require_once('./Conexion.php'); 

    $consulta = "INSERT INTO producto (id_Producto, Nombre, Cantidad, p_Compra, p_ventaN, p_VentaMe, p_VentaMa) VALUES (
        '{$id_Producto}','{$Nombre}','{$Stock}','{$p_Compra}','{$p_VentaC}','{$p_VentaM}',{$p_VentaMa})";
    // 6. Imprimimos la cadena para verificar que está bién
    echo $consulta;
    echo "<br />";
    // 7. Se verifica que se haya realizado la consulta correctamente
    if($resultado = mysqli_query($conexion,$consulta))
    {
        header("Location:../productos.php");
    }
    else
    {
        header("Location:../registro productos.php");
    }
?> 