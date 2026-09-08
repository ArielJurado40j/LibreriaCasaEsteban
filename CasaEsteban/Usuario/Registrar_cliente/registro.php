<?php

$conexion = new mysqli("localhost", "root", "", "casa_esteban_db");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contraseña = $_POST['contraseña'];

// Encriptar la contraseña
$contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

// Consulta preparada
$sql = "INSERT INTO registro 
        (nombre, apellido, correo, telefono, contraseña)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "sssss",
    $nombre,
    $apellido,
    $correo,
    $telefono,
    $contraseña_hash
);

if ($stmt->execute()) {

    echo "Registro exitoso. <a href='login.html'>Iniciar sesión</a>";

} else {

    if ($conexion->errno == 1062) {
        echo "El correo electrónico ya está registrado.";
    } else {
        echo "Error al registrar: " . $conexion->error;
    }

}

$stmt->close();
$conexion->close();

?>