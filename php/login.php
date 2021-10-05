<?php 
    session_start();
    $usu=$_POST['user'];
    $pass=$_POST['passwd'];
    require_once('Conexion.php');
    $consulta="Select * FROM usuario WHERE usuario='$usu'";
	$result= mysqli_query($conexion, $consulta);	
    if($row=mysqli_fetch_array($result)){
        if($row['Estado']!=2){
            $cargo=$row['Puesto'];
            if($row['Password']==$pass){
                $_SESSION['k_user']=$usu;
                $_SESSION['cargo']=$row['Puesto'];
                $_SESSION['id_Empleado']=$row['id_User'];
                echo 1;
            }else{
                echo 2;
            }
        }else{
            echo 4;
        }       
	}else{
		echo 3; 
	}
?>  