<?php
    //Autor: Diego Manjarrez Viveros
    //Inserta un renglón en employees
    include "conexion.php";
     
    $valor = $_GET["valor"];
    $humedad = $_GET["humedad"];

    $sql_agregar = "INSERT INTO Temperatura (valor, humedad) VALUES (?, ?)";
    $sentencia_agregar = $pdo -> prepare($sql_agregar);
    $resultado = $sentencia_agregar -> execute(array($valor, $humedad));

    if ($resultado){
        echo "Datos almacenados en la BD";
        $sentencia_agregar = null;
        $pdo = null;
    } else {
        echo "Error al insertar datos";
        echo "Error" . $resultado;
    }
?>