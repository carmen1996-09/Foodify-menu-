<?php

require "Conexion.php";

$sql = "SELECT
            p.id_pedido,
            p.fecha_pedido,
            p.total,
            p.tipo_servicio,
            p.estado_pedido,
            u.nombre AS cliente,
            pg.id_pago,
            pg.metodo_pago,
            pg.estado_pago
        FROM pedidos p

        INNER JOIN usuario u
            ON p.id_usuario = u.id_usuario

        INNER JOIN pago pg
            ON p.id_pedido = pg.id_pedido

        WHERE pg.estado_pago = 'Pendiente'

        ORDER BY p.id_pedido DESC";

$resultado = mysqli_query($miconexion, $sql);

$pedidos = [];

while ($pedido = mysqli_fetch_assoc($resultado)) {
    $pedidos[] = $pedido;
}

echo json_encode($pedidos);

mysqli_close($miconexion);

?>