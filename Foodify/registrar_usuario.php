<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";

if ($nombre === "" || $correo === "" || $contrasena === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Todos los campos son obligatorios"
    ]);
    exit;
}

// Verificar si el correo ya existe
$sql = "SELECT id_usuario FROM usuario WHERE correo = ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $correo
);

mysqli_stmt_execute($stmt);

mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "El correo ya está registrado"
    ]);

    mysqli_stmt_close($stmt);
    mysqli_close($miconexion);

    exit;
}

mysqli_stmt_close($stmt);

// Encriptar contraseña
$contrasena_hash = password_hash(
    $contrasena,
    PASSWORD_DEFAULT
);

// Registrar usuario
$sql = "INSERT INTO usuario
        (nombre, correo, contrasena, rol)
        VALUES (?, ?, ?, 'cliente')";

$stmt = mysqli_prepare(
    $miconexion,
    $sql
);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $nombre,
    $correo,
    $contrasena_hash
);

if (mysqli_stmt_execute($stmt)) {

    // Obtener el ID generado por MySQL
    $id_usuario = mysqli_insert_id($miconexion);

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Usuario registrado correctamente",
        "id_usuario" => $id_usuario,
        "nombre" => $nombre,
        "correo" => $correo,
        "rol" => "cliente"
    ]);

} else {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error al registrar usuario: " . mysqli_error($miconexion)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($miconexion);