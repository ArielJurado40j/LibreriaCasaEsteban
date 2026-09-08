<?php

$conexion = new mysqli("localhost", "root", "", "casa_esteban_db");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Buscar el usuario por correo
$sql = "SELECT * FROM registro WHERE correo = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {

    // Obtener los datos del usuario
    $usuario = $resultado->fetch_assoc();

    // Comprobar contraseña
    if (password_verify($contraseña, $usuario['contraseña'])) {

        echo "Login exitoso. Bienvenido " . $usuario['nombre'];
        <!-- Aquí podrías redirigir al usuario a otra página, por ejemplo: -->
        <!-- <meta http-equiv="refresh" content="0;url=../Inicio/index.html"> -->

        // Acá posteriormente podrías iniciar una sesión:
        // session_start();
        // $_SESSION['id_usuario'] = $usuario['id_usuario'];

    } else {

        echo "Contraseña incorrecta.";

    }

} else {

    echo "El correo no está registrado.";

}

$stmt->close();
$conexion->close();

?>