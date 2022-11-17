<?php
    //Autor: Diego Manjarrez Viveros
    //Inserta las mediciones en la base de datos
    /*

NO OLVIDAR QUE PARA HACER LOS EJERCICIOS NECESITAS USAR LA CARPETA DE EJERCICIOS

    */
    include "conexionReto0.php";
    
    //Dirección IP y/o Mac Address de la tarjeta

   //http://localhost/ejercicios/pruebaReto0.php?temp=25.4&humedad=30
    $temp = $_GET["temp"];
    $humedad = $_GET["humedad"];

    //Esta cosa obtiene la ip pero de la base
    //$ip = getenv("REMOTE_ADDR");

    //Esta cosa obtiene la ip de la computadora
    $ip = gethostbyname(php_uname('n'));
    
    //Fecha y hora 
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('y/m/d');
    $hora = date("h:i:s");

    $sql_agregar = "INSERT INTO temperatura (temp, humedad, ip, fecha, hora) VALUES (?, ?, ?, ?, ?)";
    $sentencia_agregar = $pdo -> prepare($sql_agregar);
    $resultado = $sentencia_agregar -> execute(array($temp, $humedad, $ip , $fecha, $hora));

    if ($resultado){
        echo "Datos almacenados en la BD";
        $sentencia_agregar = null;
        $pdo = null;
    } else {
        echo "Error al insertar datos";
        echo "Error" . $resultado;
    }
?>