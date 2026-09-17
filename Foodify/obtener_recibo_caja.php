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

if ($id_pedido === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Falta el número del pedido"
    ]);
    exit;
}

$sqlPedido = "
    SELECT
        p.id_pedido,
        p.fecha_pedido,
        p.total,
        p.tipo_servicio,
        p.direccion,
        p.estado_pedido,
        u.nombre AS cliente,
        u.correo,
        pg.metodo_pago,
        pg.estado_pago,
        pg.fecha_pago
    FROM pedidos p

    INNER JOIN usuario u
        ON p.id_usuario = u.id_usuario

    LEFT JOIN pago pg
        ON p.id_pedido = pg.id_pedido

    WHERE p.id_pedido = ?

    LIMIT 1
";

$stmtPedido = mysqli_prepare($miconexion, $sqlPedido);

mysqli_stmt_bind_param(
    $stmtPedido,
    "i",
    $id_pedido
);

mysqli_stmt_execute($stmtPedido);

$resultadoPedido = mysqli_stmt_get_result($stmtPedido);

$pedido = mysqli_fetch_assoc($resultadoPedido);

mysqli_stmt_close($stmtPedido);

if (!$pedido) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "No se encontró el pedido."
    ]);

    exit;
}


$sqlDetalle = "
    SELECT
        d.id_producto,
        d.cantidad,
        d.precio_unitario,
        d.subtotal,
        pr.nombre AS producto

    FROM detalle_pedido d

    INNER JOIN producto pr
        ON d.id_producto = pr.id_producto

    WHERE d.id_pedido = ?

    ORDER BY d.id_detalle ASC
";

$stmtDetalle = mysqli_prepare($miconexion, $sqlDetalle);

mysqli_stmt_bind_param(
    $stmtDetalle,
    "i",
    $id_pedido
);

mysqli_stmt_execute($stmtDetalle);

$resultadoDetalle = mysqli_stmt_get_result($stmtDetalle);

$productos = [];

while ($detalle = mysqli_fetch_assoc($resultadoDetalle)) {

    $productos[] = [
        "id_producto" => (int)$detalle["id_producto"],
        "producto" => $detalle["producto"],
        "cantidad" => (int)$detalle["cantidad"],
        "precio_unitario" => (float)$detalle["precio_unitario"],
        "subtotal" => (float)$detalle["subtotal"]
    ];
}

mysqli_stmt_close($stmtDetalle);


echo json_encode([

    "estado" => "ok",

    "pedido" => [
        "id_pedido" => (int)$pedido["id_pedido"],
        "fecha_pedido" => $pedido["fecha_pedido"],
        "total" => (float)$pedido["total"],
        "tipo_servicio" => $pedido["tipo_servicio"],
        "direccion" => $pedido["direccion"],
        "estado_pedido" => $pedido["estado_pedido"]
    ],

    "cliente" => [
        "nombre" => $pedido["cliente"],
        "correo" => $pedido["correo"]
    ],

    "pago" => [
        "metodo_pago" => $pedido["metodo_pago"],
        "estado_pago" => $pedido["estado_pago"],
        "fecha_pago" => $pedido["fecha_pago"]
    ],

    "productos" => $productos

], JSON_UNESCAPED_UNICODE);

mysqli_close($miconexion);

?>