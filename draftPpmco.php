<?php
    include "conexionFinal.php";

    $ppmco = $_GET["ppmco"];

    date_default_timezone_set('America/Mexico_City');
    $fecha = date("y/m/d");
    $hora = date("h:i:s");

    $macAddress = "48:3F:DA:44:A2:92";

    $sql_agregar = "INSERT INTO lecturaco (ppmco, fecha, hora, macAddress) VALUES (?, ?, ?, ?)";
    $sentencia_agregar = $pdo -> prepare($sql_agregar);
    $resultado = $sentencia_agregar -> execute(array($ppmco, $fecha, $hora, $macAddress));

    if ($resultado){
        $sentencia_agregar = null;
        $pdo = null;
        echo "Datos almacenados en la BD";
    }
    else {
        echo "Error al insertar datos";
        echo "Error" . $resultado;
    }
?>