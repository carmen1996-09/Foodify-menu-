<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$total = $_POST["total"] ?? "";
$cantidad = $_POST["cantidad"] ?? "";
$auditor = $_POST["auditor"] ?? "";

if ($total === "" || $cantidad === "" || $auditor === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos para realizar el cierre"
    ]);
    exit;
}

mysqli_begin_transaction($miconexion);

try {

    // 1. Crear el registro del cierre
    $sql = "INSERT INTO cierres_caja
            (total_cierre, cantidad_pedidos, auditor)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($miconexion, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "dis",
        $total,
        $cantidad,
        $auditor
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($miconexion));
    }

    $id_cierre = mysqli_insert_id($miconexion);

    mysqli_stmt_close($stmt);

    // 2. Asociar los pedidos de hoy al cierre
    $sql = "UPDATE pedidos
            SET id_cierre = ?
            WHERE DATE(fecha_pedido) = CURDATE()
            AND id_cierre IS NULL";

    $stmt = mysqli_prepare($miconexion, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id_cierre
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($miconexion));
    }

    $pedidos_cerrados = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    mysqli_commit($miconexion);

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Cierre de caja realizado correctamente",
        "id_cierre" => $id_cierre,
        "pedidos_cerrados" => $pedidos_cerrados
    ]);

} catch (Exception $e) {

    mysqli_rollback($miconexion);

    echo json_encode([
        "estado" => "error",
        "mensaje" => $e->getMessage()
    ]);
}

mysqli_close($miconexion);

?>