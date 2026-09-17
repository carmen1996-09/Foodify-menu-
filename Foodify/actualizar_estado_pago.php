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

if ($id_pedido === "") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Falta el ID del pedido"
    ]);
    exit;
}

$sql = "UPDATE pago
        SET estado_pago = 'Pagado',
            fecha_pago = NOW()
        WHERE id_pedido = ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id_pedido
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Pago actualizado correctamente"
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