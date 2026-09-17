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

$id_usuario = $_POST["id_usuario"] ?? "";

if ($id_usuario === "" || !is_numeric($id_usuario)) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Usuario no válido"
    ]);
    exit;
}

$sql = "
    SELECT
        p.id_pedido,
        p.fecha_pedido,
        p.total,
        p.tipo_servicio,
        p.direccion,
        p.estado_pedido,
        e.id_envio,
        e.estado_envio,
        e.fecha_entrega
    FROM pedidos p

    LEFT JOIN envio e
        ON p.id_pedido = e.id_pedido

    WHERE p.id_usuario = ?

    ORDER BY p.id_pedido DESC
";

$stmt = mysqli_prepare($miconexion, $sql);

if (!$stmt) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error preparando la consulta"
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id_usuario);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

$pedidos = [];

while ($pedido = mysqli_fetch_assoc($resultado)) {

    $pedidos[] = [
        "id_pedido" => (int)$pedido["id_pedido"],
        "fecha_pedido" => $pedido["fecha_pedido"],
        "total" => (float)$pedido["total"],
        "tipo_servicio" => $pedido["tipo_servicio"],
        "direccion" => $pedido["direccion"],
        "estado_pedido" => $pedido["estado_pedido"],
        "id_envio" => $pedido["id_envio"] !== null
            ? (int)$pedido["id_envio"]
            : null,
        "estado_envio" => $pedido["estado_envio"],
        "fecha_entrega" => $pedido["fecha_entrega"]
    ];
}

mysqli_stmt_close($stmt);

echo json_encode([
    "estado" => "ok",
    "pedidos" => $pedidos
], JSON_UNESCAPED_UNICODE);

mysqli_close($miconexion);

?>