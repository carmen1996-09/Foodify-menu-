<?php

require "Conexion.php";

// ==========================================
// CUENTAS DE PERSONAL DE FOODIFY
// ==========================================

$empleados = [
    [
        "nombre" => "Gerente Admin",
        "correo" => "admin@foodify.com",
        "contrasena" => "admin123",
        "rol" => "admin"
    ],
    [
        "nombre" => "Jefe de Cocina",
        "correo" => "cocina@foodify.com",
        "contrasena" => "cocina123",
        "rol" => "cocina"
    ],
    [
        "nombre" => "Cajero Central",
        "correo" => "caja@foodify.com",
        "contrasena" => "caja123",
        "rol" => "caja"
    ]
];

foreach ($empleados as $empleado) {

    // Verificar si ya existe
    $sql = "SELECT id_usuario
            FROM usuario
            WHERE correo = ?";

    $stmt = mysqli_prepare($miconexion, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $empleado["correo"]
    );

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {

        echo "Ya existe: " . $empleado["correo"] . "<br>";

        mysqli_stmt_close($stmt);

        continue;
    }

    mysqli_stmt_close($stmt);

    // Encriptar contraseña
    $hash = password_hash(
        $empleado["contrasena"],
        PASSWORD_DEFAULT
    );

    // Crear usuario
    $sql = "INSERT INTO usuario
            (nombre, correo, contrasena, rol)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare(
        $miconexion,
        $sql
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $empleado["nombre"],
        $empleado["correo"],
        $hash,
        $empleado["rol"]
    );

    if (!mysqli_stmt_execute($stmt)) {

        echo "❌ Error creando usuario " .
             $empleado["correo"] .
             ": " .
             mysqli_error($miconexion) .
             "<br>";

        mysqli_stmt_close($stmt);

        continue;
    }

    $id_usuario = mysqli_insert_id($miconexion);

    mysqli_stmt_close($stmt);

    // ==========================================
    // CREAR REGISTRO EN EMPLEADO
    // ==========================================

    $sql = "INSERT INTO empleado
            (id_usuario, cargo, estado)
            VALUES (?, ?, 'activo')";

    $stmt = mysqli_prepare(
        $miconexion,
        $sql
    );

    mysqli_stmt_bind_param(
        $stmt,
        "is",
        $id_usuario,
        $empleado["rol"]
    );

    if (mysqli_stmt_execute($stmt)) {

        echo "✅ Creado correctamente: " .
             $empleado["correo"] .
             " → " .
             $empleado["rol"] .
             "<br>";

    } else {

        echo "❌ Usuario creado pero error creando empleado: " .
             mysqli_error($miconexion) .
             "<br>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($miconexion);

echo "<br><strong>Proceso terminado.</strong>";