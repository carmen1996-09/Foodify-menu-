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
$metodo_pago = $_POST["metodo_pago"] ?? "";
$banco = $_POST["banco"] ?? null;
$nombre_titular = $_POST["nombre_titular"] ?? null;
$documento = $_POST["documento"] ?? null;

if ($id_pedido === "" || $metodo_pago === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos del pago"
    ]);
    exit;
}

// Si no es PSE, no necesitamos banco
if ($metodo_pago !== "PSE") {
    $banco = null;
}

// Si es efectivo, tampoco necesitamos titular ni documento
if ($metodo_pago === "Pagar en Efectivo") {
    $nombre_titular = null;
    $documento = null;
}

$estado_pago = ($metodo_pago === "PSE" || $metodo_pago === "Tarjeta de Crédito")
    ? "Pagado"
    : "Pendiente";

$sql = "INSERT INTO pago
        (id_pedido, metodo_pago, estado_pago, banco, nombre_titular, documento, fecha_pago)
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "isssss",
    $id_pedido,
    $metodo_pago,
    $estado_pago,
    $banco,
    $nombre_titular,
    $documento
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Pago registrado correctamente",
        "id_pago" => mysqli_insert_id($miconexion)
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