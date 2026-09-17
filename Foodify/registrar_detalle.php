<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$id_pedido = $_POST["id_pedido"] ?? "";
$id_producto = $_POST["id_producto"] ?? "";
$cantidad = $_POST["cantidad"] ?? "";
$precio_unitario = $_POST["precio_unitario"] ?? "";

if (
    $id_pedido === "" ||
    $id_producto === "" ||
    $cantidad === "" ||
    $precio_unitario === ""
) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos del detalle"
    ]);
    exit;
}

$subtotal = $cantidad * $precio_unitario;

$sql = "INSERT INTO detalle_pedido
        (id_pedido, id_producto, cantidad, precio_unitario, subtotal)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iiidd",
    $id_pedido,
    $id_producto,
    $cantidad,
    $precio_unitario,
    $subtotal
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Detalle registrado correctamente"
    ]);

} else {

    echo json_encode([
        "estado" => "error",
        "mensaje" => mysqli_error($miconexion)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($miconexion);

?>