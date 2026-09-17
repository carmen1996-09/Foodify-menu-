<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Método no permitido"
    ]);

    exit;
}

$id_envio = $_POST["id_envio"] ?? "";
$estado = $_POST["estado"] ?? "";

if ($id_envio === "" || $estado === "") {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos del envío"
    ]);

    exit;
}

$id_envio = (int)$id_envio;

$estadosPermitidos = [
    "Pendiente",
    "En camino",
    "Entregado",
    "Cancelado"
];

if (!in_array($estado, $estadosPermitidos, true)) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Estado de envío no válido"
    ]);

    exit;
}

if ($estado === "Entregado") {

    $sql = "UPDATE envio
            SET estado_envio = ?,
                fecha_entrega = NOW()
            WHERE id_envio = ?";

} else {

    $sql = "UPDATE envio
            SET estado_envio = ?,
                fecha_entrega = NULL
            WHERE id_envio = ?";
}

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $estado,
    $id_envio
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Estado del envío actualizado correctamente"
    ]);

} else {

    echo json_encode([
        "estado" => "error",
        "mensaje" => mysqli_error($miconexion)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($miconexion);