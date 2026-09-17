<?php

require "Conexion.php";

$sql = "SELECT
            id_cierre,
            fecha_cierre,
            total_cierre,
            cantidad_pedidos,
            auditor
        FROM cierres_caja
        ORDER BY id_cierre DESC";

$resultado = mysqli_query($miconexion, $sql);

$cierres = [];

while ($cierre = mysqli_fetch_assoc($resultado)) {
    $cierres[] = $cierre;
}

echo json_encode($cierres);

mysqli_close($miconexion);

?>