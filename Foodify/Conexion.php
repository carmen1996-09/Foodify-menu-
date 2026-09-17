<?php

$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "foodify";

$miconexion = mysqli_connect($host, $usuario, $password, $base_datos);

if (!$miconexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($miconexion, "utf8mb4");

?>