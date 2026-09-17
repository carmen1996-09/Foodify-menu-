<?php

require "Conexion.php";

$sql = "SELECT 
            p.id_pedido,
            p.fecha_pedido,
            p.total,
            p.tipo_servicio,
            p.direccion,
            p.estado_pedido,
            u.nombre AS cliente
        FROM pedidos p
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario
        ORDER BY p.id_pedido DESC";

$resultado = mysqli_query($miconexion, $sql);

$pedidos = [];

while ($pedido = mysqli_fetch_assoc($resultado)) {

    $id_pedido = $pedido["id_pedido"];

    $sqlDetalles = "SELECT 
                        d.id_producto,
                        d.cantidad,
                        d.precio_unitario,
                        d.subtotal,
                        pr.nombre AS producto
                    FROM detalle_pedido d
                    INNER JOIN producto pr 
                        ON d.id_producto = pr.id_producto
                    WHERE d.id_pedido = $id_pedido";

    $resultadoDetalles = mysqli_query($miconexion, $sqlDetalles);

    $pedido["productos"] = [];

    while ($detalle = mysqli_fetch_assoc($resultadoDetalles)) {
        $pedido["productos"][] = $detalle;
    }

    $pedidos[] = $pedido;
}

echo json_encode($pedidos);

mysqli_close($miconexion);

?>