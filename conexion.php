<?php
    //Autor: Diego Manjarrez Viveros
    //Se conectan al servidor de mySQL
    ini_set('display_errors', 1);
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=classicmodels', 'CuentaPrueba', 'Limanguer12');
        echo '<h2>Conexión exitosa a la BD </h2>';
    } catch (PDOExepction $e) {
        echo '<h3>Error al intentar la conexión</h3>';
        echo 'Error: ' . $e -> getMessage();
        exit();
    }  
?>