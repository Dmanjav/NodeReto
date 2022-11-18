<?php
    //Autor: Diego Manjarrez Viveros
    //Inserta las mediciones en la base de datos
    /*

NO OLVIDAR QUE PARA HACER LOS EJERCICIOS NECESITAS USAR LA CARPETA DE EJERCICIOS

    */
    include "conexionReto0.php";
    
    //Dirección IP y/o Mac Address de la tarjeta

    //http://10.48.76.142/ejercicios/MQpruebaReto0.php?gas1=24&gas2=26&gas3=28&gas4=30
    $gas1 = $_GET["gas1"];
    $gas2 = $_GET["gas2"];
    $gas3 = $_GET["gas3"];
    $gas4 = $_GET["gas4"];
    

    //Esta cosa obtiene la ip pero de la base
    //$ip = getenv("REMOTE_ADDR");

    //Esta cosa obtiene la ip de la computadora
    $ip = gethostbyname(php_uname("n"));
    
    //Fecha y hora 
    date_default_timezone_set('America/Mexico_City');
    $fecha = date("y/m/d");
    $hora = date("h:i:s");

    $sql_agregar = "INSERT INTO mq135 (gas1, gas2, gas3, gas4, ip, fecha, hora) VALUES (?, ?, ?, ?, ?, ? , ?)";
    $sentencia_agregar = $pdo -> prepare($sql_agregar);
    $resultado = $sentencia_agregar -> execute(array($gas1,$gas2 , $gas3, $gas4, $ip , $fecha, $hora));

    if ($resultado){
        echo "Datos almacenados en la BD";
        $sentencia_agregar = null;
        $pdo = null;
    } else {
        echo "Error al insertar datos";
        echo "Error" . $resultado;
    }
?>