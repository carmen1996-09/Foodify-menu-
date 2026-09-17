<?php

require "Conexion.php";

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$id_pedido = $_POST["id_pedido"] ?? "";
$id_usuario = $_POST["id_usuario"] ?? "";

if ($id_pedido === "" || $id_usuario === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos para consultar el seguimiento"
    ]);
    exit;
}

$sql = "
    SELECT
        e.id_envio,
        e.id_pedido,
        e.direccion,
        e.estado_envio,
        e.fecha_entrega
    FROM envio e

    INNER JOIN pedidos p
        ON e.id_pedido = p.id_pedido

    WHERE e.id_pedido = ?
      AND p.id_usuario = ?

    LIMIT 1
";

$stmt = mysqli_prepare($miconexion, $sql);

if (!$stmt) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error preparando la consulta"
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $id_pedido,
    $id_usuario
);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

$envio = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

if (!$envio) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "No se encontró un envío para este pedido."
    ]);
    exit;
}

echo json_encode([
    "estado" => "ok",
    "envio" => [
        "id_envio" => (int)$envio["id_envio"],
        "id_pedido" => (int)$envio["id_pedido"],
        "direccion" => $envio["direccion"],
        "estado_envio" => $envio["estado_envio"],
        "fecha_entrega" => $envio["fecha_entrega"]
    ]
], JSON_UNESCAPED_UNICODE);

mysqli_close($miconexion);

?>