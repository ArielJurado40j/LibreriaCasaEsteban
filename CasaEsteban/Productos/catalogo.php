<?php
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/funciones.php';

$categoriaId = (isset($_GET['categoria']) && $_GET['categoria'] !== '') ? (int) $_GET['categoria'] : null;
$busqueda = trim($_GET['buscar'] ?? '');

$sql = "SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio,
               p.imagen_url, p.en_oferta, p.precio_oferta,
               c.id_categoria, c.nombre_categoria
        FROM productos p
        JOIN categorias c ON c.id_categoria = p.id_categoria
        WHERE p.activo = 1";
$parametros = [];

if ($categoriaId) {
    $sql .= " AND p.id_categoria = ?";
    $parametros[] = $categoriaId;
}
if ($busqueda !== '') {
    $sql .= " AND (p.nombre_producto LIKE ? OR p.descripcion LIKE ?)";
    $parametros[] = "%$busqueda%";
    $parametros[] = "%$busqueda%";
}
$sql .= " ORDER BY p.nombre_producto";

$consulta = $pdo->prepare($sql);
$consulta->execute($parametros);
$productos = $consulta->fetchAll();

$categorias = $pdo->query("SELECT id_categoria, nombre_categoria FROM categorias ORDER BY nombre_categoria")->fetchAll();

$categoriaActual = null;
foreach ($categorias as $cat) {
    if ($categoriaId && (int) $cat['id_categoria'] === $categoriaId) {
        $categoriaActual = $cat['nombre_categoria'];
        break;
    }
}

$productosJs = formatearProductosParaJs($productos);
$scriptPagina = 'productos/productos.js';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Esteban | <?= $categoriaActual ? htmlspecialchars($categoriaActual) : 'Catálogo completo' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/inicio.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/productos/productos.css">
</head>
<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <section class="seccion">
            <div class="contenedor">
                <div class="cabecera-seccion cabecera-catalogo">
                    <div>
                        <span class="mini-etiqueta">Catálogo completo</span>
                        <h2><?= $categoriaActual ? htmlspecialchars($categoriaActual) : 'Todos los productos' ?></h2>
                    </div>

                    <form class="buscador buscador-catalogo" method="get">
                        <?php if ($categoriaId): ?>
                        <input type="hidden" name="categoria" value="<?= $categoriaId ?>">
                        <?php endif; ?>
                        <input type="search" name="buscar" placeholder="Buscar producto..." value="<?= htmlspecialchars($busqueda) ?>">
                        <button type="submit" aria-label="Buscar">⌕</button>
                    </form>
                </div>

                <div class="filtros-catalogo">
                    <a href="catalogo.php<?= $busqueda !== '' ? '?buscar=' . urlencode($busqueda) : '' ?>" class="filtro <?= !$categoriaId ? 'activo' : '' ?>">Todos</a>
                    <?php foreach ($categorias as $cat): ?>
                    <a href="catalogo.php?categoria=<?= (int) $cat['id_categoria'] ?><?= $busqueda !== '' ? '&buscar=' . urlencode($busqueda) : '' ?>"
                       class="filtro <?= $categoriaId === (int) $cat['id_categoria'] ? 'activo' : '' ?>">
                        <?= htmlspecialchars($cat['nombre_categoria']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="rejilla-productos" id="listaProductos">
                    <!-- Se completa con JavaScript, a partir de productos -->
                </div>

                <div class="sin-resultados <?= !$productos ? 'visible' : '' ?>" id="sinResultados">
                    <span>🔎</span>
                    <h3>No encontramos productos</h3>
                    <p>Probá con otra búsqueda o categoría.</p>
                </div>
            </div>
        </section>
    </main>

    <script>
        const productos = <?= json_encode($productosJs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        window.productosCache = productos;
    </script>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>