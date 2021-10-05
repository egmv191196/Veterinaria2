<?php
    $Operacion=$_POST['Operacion'];
    require_once('./Conexion.php'); 
    if($Operacion=="Insertar"){
        $Nombre=$_POST['Nombre'];
        $Telefono=$_POST['Telefono'];
        $Correo=$_POST['Correo'];
        $Usuario=$_POST['Usuario'];
        $Password=$_POST['Password'];
        $puesto=$_POST['puesto'];
        $estado=$_POST['estado'];
        $consulta = "INSERT INTO usuario(id_User, Usuario, `Password`, Nombre, Puesto, Telefono, Email, Estado) VALUES  
        (NULL,'{$Usuario}','{$Password}','{$Nombre}', {$puesto},{$Telefono},'{$Correo}',{$estado})";
        echo mysqli_query($conexion,$consulta);   
    }else if($Operacion=="Buscar"){
        $id=$_POST['id'];
        $consulta="SELECT * FROM usuario WHERE id_User=$id";
        $result= mysqli_query($conexion,$consulta);
        $row = mysqli_fetch_array($result);
        $user=array('Id' => $row[0],'Usuario' => $row[1], 'Pass'=> $row[2], 'Nombre' => $row[3],'Puesto' => $row[4],'Telefono' => $row[5],'Correo'=>$row[6],'Estado'=>$row[7]);
        echo json_encode($user);
    }
    else if($Operacion=="Actualizar"){
        $Id_User=$_POST['Id_User'];
        $Nombre=$_POST['Nombre'];
        $Pass=$_POST['Pass'];
        $Telefono=$_POST['Telefono'];
        $Correo=$_POST['Correo'];
        $Usuario=$_POST['Usuario'];
        $puesto=$_POST['puesto'];
        $estado=$_POST['estado'];
        $consulta = "UPDATE usuario SET Usuario='$Usuario',Nombre='$Nombre',`Password`='$Pass',
        Puesto=$puesto,Telefono=$Telefono,Email='$Correo',Estado=$estado WHERE id_User=$Id_User";
        echo mysqli_query($conexion,$consulta);
    }
?> 