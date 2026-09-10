```php
<?php
session_start();

require_once __DIR__ . '/../Includes/sitio/Conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo']);
    $contraseña = $_POST['contraseña'];

    if ($correo === '' || $contraseña === '') {

        $mensaje = 'Completá el correo y la contraseña.';

    } else {

        $consulta = $pdo->prepare("
            SELECT id_usuario, nombre, apellido, correo, contraseña, rol
            FROM usuarios
            WHERE correo = ?
        ");

        $consulta->execute([$correo]);

        $usuario = $consulta->fetch();

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellido'] = $usuario['apellido'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['rol'] = $usuario['rol'];

            header('Location: ../Index.php');
            exit;

        } else {

            $mensaje = 'Correo o contraseña incorrectos.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión - Casa Esteban</title>

    <link rel="stylesheet" href="login.css">
</head>

<body>

    <div class="login-container">

        <h1>Iniciar sesión</h1>

        <?php if ($mensaje !== ''): ?>
            <p><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form method="POST">

            <label for="correo">Correo:</label>
            <input
                type="email"
                id="correo"
                name="correo"
                required
            >

            <label for="contraseña">Contraseña:</label>
            <input
                type="password"
                id="contraseña"
                name="contraseña"
                required
            >

            <button type="submit">Iniciar sesión</button>

        </form>

        <p>
            ¿No tenés una cuenta?
            <a href="registro.php">Crear cuenta</a>
        </p>

    </div>

</body>
</html>
```
