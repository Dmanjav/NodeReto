<?php
    //Autor: Diego Manjarrez Viveros
    //Inserta las mediciones en la base de datos

    /*

NO OLVIDAR QUE PARA HACER LOS EJERCICIOS NECESITAS USAR LA CARPETA DE EHERCICIOS

    */
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