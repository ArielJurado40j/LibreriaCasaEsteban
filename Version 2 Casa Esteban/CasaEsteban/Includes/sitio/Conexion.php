<?php
/* Conexión a la base de datos - Casa Esteban
   Este archivo se incluye desde cualquier .php que necesite consultar la base
   (require_once __DIR__ . '/includes/conexion.php';) y deja lista la
   variable $pdo para usar en el resto del sitio. */

/* URL base del proyecto, relativa al dominio. Se usa para armar todos los
   enlaces e imágenes del sitio (BASE_URL . '/inicio.css', etc.), así
   funcionan igual sin importar en qué carpeta esté la página que los pide.
   Si movés el proyecto a otra carpeta, o lo subís al dominio raíz, actualizá
   este valor (por ejemplo a ''). */
define('BASE_URL', '/CasaEsteban');

$host    = 'bfsyweevvrduldc3j6qs-mysql.services.clever-cloud.com';   /* ej: bxxxxxxxxx-mysql.services.clever-cloud.com */
$puerto  = '3306';
$bd      = 'bfsyweevvrduldc3j6qs';
$usuario = 'uiojhtvacmjtfvmc';
$clave   = 'UPg0i0wOnBcc7lGQADkw';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4",
        $usuario,
        $clave,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $error) {
    /* En producción no conviene mostrar el mensaje de error real al usuario */
    die('No se pudo conectar a la base de datos. Probá de nuevo en unos minutos.');
}
