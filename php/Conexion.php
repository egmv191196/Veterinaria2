<?php
    $servername = "localhost";
    $database = "u499704725_Veterinaria";
    $username = "u499704725_Balbi";
    $password = "BalbiVet1";
    // Create connection
    $conexion = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }else{
      //echo "Connected successfully".$usu; 
    }
    
?>
