<?php

require "Conexion.php";

$sql = "SELECT
            id_producto,
            nombre,
            categoria,
            precio,
            descripcion,
            stock,
            ingredientes,
            imagen,
            visible
        FROM producto
        WHERE visible = 1
        ORDER BY id_producto ASC";

$resultado = mysqli_query($miconexion, $sql);

if (!$resultado) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => mysqli_error($miconexion)
    ]);
    exit;
}

$productos = [];

while ($producto = mysqli_fetch_assoc($resultado)) {

    $productos[] = [
        "id" => (int)$producto["id_producto"],
        "name" => $producto["nombre"],
        "category" => $producto["categoria"],
        "price" => (float)$producto["precio"],
        "desc" => $producto["descripcion"],
        "stock" => (int)$producto["stock"],
        "ingredients" => $producto["ingredientes"]
            ? array_map("trim", explode(",", $producto["ingredientes"]))
            : [],
        "img" => $producto["imagen"],
        "visible" => (bool)$producto["visible"]
    ];
}

echo json_encode($productos, JSON_UNESCAPED_UNICODE);

mysqli_close($miconexion);

?>