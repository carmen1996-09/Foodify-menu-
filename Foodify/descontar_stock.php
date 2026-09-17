<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$id_producto = $_POST["id_producto"] ?? "";
$cantidad = $_POST["cantidad"] ?? "";

if ($id_producto === "" || $cantidad === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos"
    ]);
    exit;
}

$id_producto = (int)$id_producto;
$cantidad = (int)$cantidad;

if ($id_producto <= 0 || $cantidad <= 0) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Datos inválidos"
    ]);
    exit;
}

$sql = "UPDATE producto
        SET stock = stock - ?
        WHERE id_producto = ?
        AND stock >= ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iii",
    $cantidad,
    $id_producto,
    $cantidad
);

if (!mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => mysqli_error($miconexion)
    ]);

    exit;
}

if (mysqli_stmt_affected_rows($stmt) === 0) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Stock insuficiente o producto no encontrado"
    ]);

    exit;
}

echo json_encode([
    "estado" => "ok",
    "mensaje" => "Stock actualizado correctamente"
]);

mysqli_stmt_close($stmt);
mysqli_close($miconexion);

?>