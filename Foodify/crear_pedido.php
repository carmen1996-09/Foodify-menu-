<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$id_usuario = $_POST["id_usuario"] ?? "";
$total = $_POST["total"] ?? "";
$tipo_servicio = $_POST["tipo_servicio"] ?? "";
$direccion = $_POST["direccion"] ?? null;

if ($id_usuario === "" || $total === "" || $tipo_servicio === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos del pedido"
    ]);
    exit;
}

if ($tipo_servicio !== "Domicilio") {
    $direccion = null;
}

$sql = "INSERT INTO pedidos 
        (id_usuario, total, tipo_servicio, direccion)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "idss",
    $id_usuario,
    $total,
    $tipo_servicio,
    $direccion
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "id_pedido" => mysqli_insert_id($miconexion)
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