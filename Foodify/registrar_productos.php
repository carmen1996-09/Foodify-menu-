<?php

require_once "Conexion.php";

$productos = [
    [
        "nombre" => "Hamburguesa Monster Cheese",
        "categoria" => "hamburguesas",
        "precio" => 24900,
        "descripcion" => "Doble carne angus, queso cheddar fundido y salsa secreta.",
        "stock" => 15,
        "ingredientes" => "Carne Angus, Cheddar",
        "imagen" => "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500"
    ],
    [
        "nombre" => "Hamburguesa BBQ Bacon",
        "categoria" => "hamburguesas",
        "precio" => 26500,
        "descripcion" => "Tocino ahumado, aros de cebolla crocantes y salsa BBQ.",
        "stock" => 12,
        "ingredientes" => "Carne Res, Tocino",
        "imagen" => "https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=500"
    ],
    [
        "nombre" => "Pizza Pepperoni Supreme",
        "categoria" => "pizzas",
        "precio" => 32000,
        "descripcion" => "Masa italiana artesanal con abundante pepperoni madurado.",
        "stock" => 10,
        "ingredientes" => "Pepperoni, Mozzarella",
        "imagen" => "https://images.unsplash.com/photo-1628840042765-356cda07504e?w=500"
    ],
    [
        "nombre" => "Alitas BBQ Crujientes",
        "categoria" => "alitas",
        "precio" => 20000,
        "descripcion" => "Bañadas en salsa de barbacoa dulce ahumada.",
        "stock" => 55,
        "ingredientes" => "Alitas x8, BBQ",
        "imagen" => "https://images.unsplash.com/photo-1567620832903-9fc6debc209f?w=500"
    ],
    [
        "nombre" => "Papas Nativas Especiales",
        "categoria" => "acompañamientos",
        "precio" => 12500,
        "descripcion" => "Papas rústicas con tocineta picada y queso cheddar.",
        "stock" => 30,
        "ingredientes" => "Papas, Cheddar",
        "imagen" => "https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=500"
    ],
    [
        "nombre" => "Perro Americano Gigante",
        "categoria" => "perros calientes",
        "precio" => 15900,
        "descripcion" => "Salchicha suiza de 22cm con papa ripiada.",
        "stock" => 14,
        "ingredientes" => "Salchicha Suiza, Ripio",
        "imagen" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJH54C02cZmm_OKCIT4jX1kg9dULUNHPcexehf73DZeg&s=10"
    ],
    [
        "nombre" => "Limonada de Coco Fresh",
        "categoria" => "bebidas",
        "precio" => 8500,
        "descripcion" => "Zumo de limón natural batido con crema de coco espesa.",
        "stock" => 20,
        "ingredientes" => "Limón, Coco",
        "imagen" => "https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=500"
    ]
];

foreach ($productos as $producto) {

    $sql = "INSERT INTO producto 
            (nombre, categoria, precio, descripcion, stock, ingredientes, imagen, visible)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($miconexion, $sql);

    $visible = 1;

    mysqli_stmt_bind_param(
    $stmt,
    "ssdisssi",
    $producto["nombre"],
    $producto["categoria"],
    $producto["precio"],
    $producto["descripcion"],
    $producto["stock"],
    $producto["ingredientes"],
    $producto["imagen"],
    $visible
);

    mysqli_stmt_execute($stmt);
}

echo "✅ Los productos fueron registrados correctamente.";

?>