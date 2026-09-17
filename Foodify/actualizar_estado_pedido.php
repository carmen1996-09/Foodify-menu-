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
$estado = $_POST["estado"] ?? "";

if ($id_pedido === "" || $estado === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos"
    ]);
    exit;
}

$estadosPermitidos = [
    "En Cola",
    "En Preparacion",
    "Despachado",
    "Cancelado"
];

if (!in_array($estado, $estadosPermitidos)) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Estado no válido"
    ]);
    exit;
}

$sql = "UPDATE pedidos
        SET estado_pedido = ?
        WHERE id_pedido = ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $estado,
    $id_pedido
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Estado actualizado correctamente"
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