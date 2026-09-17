<?php

require "Conexion.php";

$sql = "SELECT
            e.id_envio,
            e.id_pedido,
            e.direccion,
            e.estado_envio,
            e.fecha_entrega,
            u.nombre AS cliente
        FROM envio e

        INNER JOIN pedidos p
            ON e.id_pedido = p.id_pedido

        INNER JOIN usuario u
            ON p.id_usuario = u.id_usuario

        ORDER BY e.id_envio DESC";

$resultado = mysqli_query($miconexion, $sql);

if (!$resultado) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => mysqli_error($miconexion)
    ]);

    exit;
}

$envios = [];

while ($envio = mysqli_fetch_assoc($resultado)) {

    $envios[] = [
        "id_envio" => (int)$envio["id_envio"],
        "id_pedido" => (int)$envio["id_pedido"],
        "direccion" => $envio["direccion"],
        "estado_envio" => $envio["estado_envio"],
        "fecha_entrega" => $envio["fecha_entrega"],
        "cliente" => $envio["cliente"]
    ];
}

echo json_encode($envios, JSON_UNESCAPED_UNICODE);

mysqli_close($miconexion);