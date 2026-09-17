<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$id = $_POST["id"] ?? "";
$precio = $_POST["precio"] ?? "";
$stock = $_POST["stock"] ?? "";
$visible = $_POST["visible"] ?? "";

if ($id === "" || $precio === "" || $stock === "" || $visible === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos del producto"
    ]);
    exit;
}

$sql = "UPDATE producto
        SET precio = ?,
            stock = ?,
            visible = ?
        WHERE id_producto = ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "diii",
    $precio,
    $stock,
    $visible,
    $id
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Producto actualizado correctamente"
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