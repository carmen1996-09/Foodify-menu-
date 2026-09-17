<?php

require "Conexion.php";

$sql = "SELECT
            p.id_pedido,
            p.total,
            p.tipo_servicio,
            u.nombre AS cliente,
            pg.metodo_pago,
            pg.estado_pago
        FROM pedidos p

        INNER JOIN usuario u
            ON p.id_usuario = u.id_usuario

        INNER JOIN pago pg
            ON p.id_pedido = pg.id_pedido

        WHERE DATE(p.fecha_pedido) = CURDATE()
        AND p.id_cierre IS NULL

        ORDER BY p.id_pedido DESC";

$resultado = mysqli_query($miconexion, $sql);

$pagos = [];

while ($pago = mysqli_fetch_assoc($resultado)) {

    $id_pedido = $pago["id_pedido"];

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

    $pago["productos"] = [];

    while ($detalle = mysqli_fetch_assoc($resultadoDetalles)) {
        $pago["productos"][] = $detalle;
    }

    $pagos[] = $pago;
}

echo json_encode($pagos);

mysqli_close($miconexion);

?>