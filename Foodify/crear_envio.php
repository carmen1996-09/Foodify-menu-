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
$direccion = trim($_POST["direccion"] ?? "");

if ($id_pedido === "" || $direccion === "") {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Faltan datos del envío"
    ]);

    exit;
}

$id_pedido = (int)$id_pedido;

if ($id_pedido <= 0) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "ID de pedido inválido"
    ]);

    exit;
}

// Verificar que el pedido exista
$sql = "SELECT id_pedido, tipo_servicio
        FROM pedidos
        WHERE id_pedido = ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id_pedido
);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "El pedido no existe"
    ]);

    mysqli_stmt_close($stmt);
    mysqli_close($miconexion);

    exit;
}

$pedido = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

// Verificar que sea un domicilio
if ($pedido["tipo_servicio"] !== "Domicilio") {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Este pedido no es un domicilio"
    ]);

    mysqli_close($miconexion);

    exit;
}

// Verificar que todavía no tenga envío
$sql = "SELECT id_envio
        FROM envio
        WHERE id_pedido = ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id_pedido
);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Este pedido ya tiene un envío registrado"
    ]);

    mysqli_stmt_close($stmt);
    mysqli_close($miconexion);

    exit;
}

mysqli_stmt_close($stmt);

// Crear envío
$sql = "INSERT INTO envio
        (id_pedido, direccion, estado_envio)
        VALUES (?, ?, 'Pendiente')";

$stmt = mysqli_prepare(
    $miconexion,
    $sql
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $id_pedido,
    $direccion
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Envío registrado correctamente",
        "id_envio" => mysqli_insert_id($miconexion)
    ]);

} else {

    echo json_encode([
        "estado" => "error",
        "mensaje" => mysqli_error($miconexion)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($miconexion);