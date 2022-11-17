<?php
    //Autor: Diego Manjarrez Viveros
    //Inserta las mediciones en la base de datos
    /*

NO OLVIDAR QUE PARA HACER LOS EJERCICIOS NECESITAS USAR LA CARPETA DE EJERCICIOS

    */
    include "conexion.php";
    
    //Dirección IP y/o Mac Address de la tarjeta
    $ip = getenv("REMOTE_ADDR");
    echo "Your IP Address is " . $ip;

    //Fecha y hora 
    $fechaActual = date('d/m/y');
    $horaActual = date("h:i:s");
    $valor = $_GET["valor"];
    $humedad = $_GET["humedad"];

    $sql_agregar = "INSERT INTO temperatura (valor, humedad, ip, fechaActual, horaActual) VALUES (?, ?, ?, ?, ?)";
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