```php
<?php
session_start();
require_once __DIR__ . '/../Includes/sitio/Conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $whatsapp = trim($_POST['whatsapp']);
    $tipo_negocio = trim($_POST['tipo_negocio']);
    $contraseña = $_POST['contraseña'];

    if ($nombre === '' || $apellido === '' || $correo === '' || $whatsapp === '' || $contraseña === '') {
        $mensaje = 'Completá todos los campos obligatorios.';
    } else {

        // Comprobar si el correo ya está registrado
        $consulta = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
        $consulta->execute([$correo]);

        if ($consulta->fetch()) {
            $mensaje = 'Ese correo ya está registrado.';
        } else {

            // Hashear la contraseña antes de guardarla
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

            $consulta = $pdo->prepare("
                INSERT INTO usuarios
                (nombre, apellido, correo, whatsapp, tipo_negocio, contraseña)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $consulta->execute([
                $nombre,
                $apellido,
                $correo,
                $whatsapp,
                $tipo_negocio,
                $contraseña_hash
            ]);

            $mensaje = 'Usuario registrado correctamente.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - Casa Esteban</title>
</head>

<body>

<h1>Crear cuenta</h1>

<?php if ($mensaje !== ''): ?>
    <p><?= htmlspecialchars($mensaje) ?></p>
<?php endif; ?>

<form method="POST">

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <br><br>

    <label>Apellido:</label>
    <input type="text" name="apellido" required>

    <br><br>

    <label>Correo:</label>
    <input type="email" name="correo" required>

    <br><br>

    <label>WhatsApp:</label>
    <input type="text" name="whatsapp" required>

    <br><br>

    <label>Tipo de negocio:</label>
    <input type="text" name="tipo_negocio">

    <br><br>

    <label>Contraseña:</label>
    <input type="password" name="contraseña" required>

    <br><br>

    <button type="submit">Crear cuenta</button>

</form>

<p>
    ¿Ya tenés una cuenta?
    <a href="login.php">Iniciar sesión</a>
</p>

</body>
</html>
```
