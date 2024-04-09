<?php
    $host="localhost";
    $database="wafleria";
    $userDB="root";
    $password="";

    $conexion = new mysqli($host,$userDB,$password,$database);
    if($conexion->connect_errno) {
        echo "erro de conexion a la base de datos";
        exit();
    }
?>