<?php
    $JSONData = file_get_contents("php://input");
    $dataObject = json_decode($JSONData);
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('content-type: application/json; charset=utf-8');
    include "conexion.php";
     try {
        $result = mysqli_query(
            $conexion,"DELETE from categorias where idcategoria = $dataObject->idcategoria ;"
        );
        $exito = mysqli_affected_rows($conexion);
        if($exito>0){
            echo json_encode("success");
        }
        else{
            echo json_encode("Hubo algun error al eliminar el registro");
        }
     }
     catch (Exception $e) {
        echo json_encode('Excepción capturada: ',  $e->getMessage(), "\n");
    }
?>