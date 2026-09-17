
<?php

require "Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Método no permitido";
    exit;
}

$correo = trim($_POST["correo"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";

if ($correo === "" || $contrasena === "") {
    echo "Todos los campos son obligatorios";
    exit;
}

// Buscar usuario por correo
$sql = "SELECT id_usuario, nombre, correo, contrasena, rol
        FROM usuario
        WHERE correo = ?";

$stmt = mysqli_prepare($miconexion, $sql);

mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
    echo "El correo no está registrado";
    exit;
}

$usuario = mysqli_fetch_assoc($resultado);

// Verificar contraseña
if (!password_verify($contrasena, $usuario["contrasena"])) {
    echo "Contraseña incorrecta";
    exit;
}

// Login correcto
echo json_encode([
    "estado" => "ok",
    "id_usuario" => $usuario["id_usuario"],
    "nombre" => $usuario["nombre"],
    "correo" => $usuario["correo"],
    "rol" => $usuario["rol"]
]);

mysqli_stmt_close($stmt);
mysqli_close($miconexion);

?>

