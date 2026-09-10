<?php
require_once __DIR__ . '/includes/sitio/Conexion.php';
require_once __DIR__ . '/includes/pagina/funciones.php';

/* --- Categorías con la cantidad real de productos activos en cada una --- */
$categorias = $pdo->query("
    SELECT c.id_categoria, c.nombre_categoria, COUNT(p.id_producto) AS cantidad_productos
    FROM categorias c
    LEFT JOIN productos p ON p.id_categoria = c.id_categoria AND p.activo = 1
    GROUP BY c.id_categoria, c.nombre_categoria
    ORDER BY c.nombre_categoria
")->fetchAll();

$iconos = [
    'Librería'      => '📚',
    'Escolar'       => '✏️',
    'Arte y dibujo' => '🎨',
    'Oficina'       => '🗂️',
    'Regalería'     => '🎁',
    'Descartables'  => '🥤',
    'Mercería'      => '🧵',
    'Cotillón'      => '🎉',
];

/* --- Productos a mostrar en el catálogo del home --- */
$productos = $pdo->query("
    SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio,
           p.imagen_url, p.en_oferta, p.precio_oferta,
           c.id_categoria, c.nombre_categoria
    FROM productos p
    JOIN categorias c ON c.id_categoria = p.id_categoria
    WHERE p.activo = 1 AND p.mostrar_home = 1
    ORDER BY p.nombre_producto
")->fetchAll();

/* --- Más vendidos: se calcula sobre pedidos entregados.
       Mientras no haya ventas registradas, muestra los primeros del home. --- */
$masVendidos = $pdo->query("
    SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio,
           p.imagen_url, p.en_oferta, p.precio_oferta,
           c.id_categoria, c.nombre_categoria,
           SUM(dp.cantidad) AS total_vendido
    FROM detalle_pedido dp
    JOIN productos p ON p.id_producto = dp.id_producto
    JOIN categorias c ON c.id_categoria = p.id_categoria
    JOIN pedidos pe ON pe.id_pedido = dp.id_pedido
    WHERE pe.estado = 'entregado'
    GROUP BY p.id_producto
    ORDER BY total_vendido DESC
    LIMIT 6
")->fetchAll();

if (!$masVendidos) {
    $masVendidos = array_slice($productos, 0, 6);
}

$productosJs   = formatearProductosParaJs($productos);
$masVendidosJs = formatearProductosParaJs($masVendidos);

/* Le dice a footer.php que cargue inicio.js después de tienda.js */
$scriptPagina = 'inicio.js';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tienda online moderna y responsive.">
    <title>Casa Esteban | Tienda</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/inicio.css">
</head>
<body>

<?php include __DIR__ . '/includes/sitio/Header.php'; ?>

    <main>
        <!-- Hero -->
        <section class="hero">
            <div class="contenedor">
                <div class="carrusel" id="carrusel">
                    <article class="diapositiva activa">
                        <div class="hero-texto">
                            <span class="etiqueta">Novedades</span>
                            <h1>Todo lo que necesitás,<br><strong>en un solo lugar.</strong></h1>
                            <p>Encontrá productos para estudiar, crear, trabajar y regalar.</p>
                            <a class="boton-principal" href="#catalogo">Comprar ahora <span>→</span></a>
                        </div>
                        <div class="hero-imagen">
                            <img src="<?= BASE_URL ?>/assets/img/descartables.jpg" alt="Producto destacado">
                            <div class="burbuja burbuja-menta">Nuevos</div>
                        </div>
                    </article>

                    <article class="diapositiva">
                        <div class="hero-texto">
                            <span class="etiqueta etiqueta-magenta">Oferta especial</span>
                            <h1>Ideas para volver a<br><strong>crear y estudiar.</strong></h1>
                            <p>Seleccionados con precios especiales por tiempo limitado.</p>
                            <a class="boton-principal boton-magenta" href="#ofertas">Ver ofertas <span>→</span></a>
                        </div>
                        <div class="hero-imagen">
                            <img src="<?= BASE_URL ?>/assets/img/libreria.jpg" alt="Productos en oferta">
                            <div class="burbuja burbuja-amarilla">-20%</div>
                        </div>
                    </article>

                    <article class="diapositiva">
                        <div class="hero-texto">
                            <span class="etiqueta etiqueta-amarilla">Para vos</span>
                            <h1>Elegí tus favoritos<br><strong>y armá tu pedido.</strong></h1>
                            <p>Guardá productos, sumalos al carrito y consultanos por WhatsApp.</p>
                            <a class="boton-principal boton-menta" href="#catalogo">Explorar catálogo <span>→</span></a>
                        </div>
                        <div class="hero-imagen">
                            <img src="<?= BASE_URL ?>/assets/img/libre2.jpg" alt="Catálogo de productos">
                            <div class="burbuja burbuja-magenta">Favoritos</div>
                        </div>
                    </article>

                    <button class="control-carrusel anterior" id="anterior" aria-label="Anterior">‹</button>
                    <button class="control-carrusel siguiente" id="siguiente" aria-label="Siguiente">›</button>
                    <div class="indicadores" id="indicadores"></div>
                </div>
            </div>
        </section>

        <!-- Categorías -->
        <section class="seccion categorias" id="categorias">
            <div class="contenedor">
                <div class="cabecera-seccion">
                    <div>
                        <span class="mini-etiqueta">Explorá</span>
                        <h2>Comprar por categoría</h2>
                    </div>
                    <a class="enlace-seccion" href="<?= BASE_URL ?>/productos/catalogo.php">Ver todas →</a>
                </div>

                <div class="rejilla-categorias">
                    <?php foreach ($categorias as $cat): ?>
                    <a class="tarjeta-categoria" href="<?= BASE_URL ?>/productos/catalogo.php?categoria=<?= (int) $cat['id_categoria'] ?>">
                        <span class="icono-categoria"><?= $iconos[$cat['nombre_categoria']] ?? '🛍️' ?></span>
                        <strong><?= htmlspecialchars($cat['nombre_categoria']) ?></strong>
                        <small><?= (int) $cat['cantidad_productos'] ?> producto<?= $cat['cantidad_productos'] == 1 ? '' : 's' ?></small>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Ofertas / Más vendidos -->
        <section class="seccion fondo-suave" id="ofertas">
            <div class="contenedor">
                <div class="cabecera-seccion">
                    <div>
                        <span class="mini-etiqueta">Elegidos para vos</span>
                        <h2>Más vendidos</h2>
                    </div>
                    <div class="controles-seccion">
                        <button class="flecha-seccion" id="desplazarAnterior" aria-label="Anterior">←</button>
                        <button class="flecha-seccion" id="desplazarSiguiente" aria-label="Siguiente">→</button>
                    </div>
                </div>

                <div class="rejilla-productos carrusel-productos" id="listaMasVendidos">
                    <!-- Se completa con JavaScript, a partir de masVendidos -->
                </div>
            </div>
        </section>

        <!-- Catálogo -->
        <section class="seccion" id="catalogo">
            <div class="contenedor">
                <div class="cabecera-seccion cabecera-catalogo">
                    <div>
                        <span class="mini-etiqueta">Nuestro catálogo</span>
                        <h2>Productos destacados</h2>
                    </div>

                    <div class="filtros-catalogo">
                        <button class="filtro activo" data-filtro="todos">Todos</button>
                        <?php foreach ($categorias as $cat): ?>
                        <button class="filtro" data-filtro="<?= (int) $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre_categoria']) ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="rejilla-productos" id="listaProductos">
                    <!-- Se completa con JavaScript, a partir de productos -->
                </div>

                <div class="sin-resultados" id="sinResultados">
                    <span>🔎</span>
                    <h3>No encontramos productos</h3>
                    <p>Probá con otra búsqueda o categoría.</p>
                </div>
            </div>
        </section>

        <!-- Beneficios -->
        <section class="seccion beneficios">
            <div class="contenedor rejilla-beneficios">
                <div class="beneficio">
                    <span>🚚</span>
                    <div><strong>Envíos</strong><small>Consultá zonas disponibles</small></div>
                </div>
                <div class="beneficio">
                    <span>💬</span>
                    <div><strong>Atención personalizada</strong><small>Estamos para ayudarte</small></div>
                </div>
                <div class="beneficio">
                    <span>🔒</span>
                    <div><strong>Compra segura</strong><small>Tus datos protegidos</small></div>
                </div>
                <div class="beneficio">
                    <span>🎁</span>
                    <div><strong>Productos seleccionados</strong><small>Para cada necesidad</small></div>
                </div>
            </div>
        </section>

        <!-- Novedades -->
        <section class="seccion fondo-gradiente" id="novedades">
            <div class="contenedor">
                <div class="banner-newsletter">
                    <div>
                        <span class="mini-etiqueta mini-etiqueta-oscura">Comunidad</span>
                        <h2>Enterate de las novedades</h2>
                        <p>Recibí ofertas, lanzamientos y recomendaciones directamente en tu correo.</p>
                    </div>
                    <form class="formulario-newsletter" id="formularioNewsletter">
                        <input type="email" id="correoNewsletter" placeholder="Tu correo electrónico" required>
                        <button type="submit" class="boton-principal">Suscribirme</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <script>
        /* Datos reales de la base de datos, generados por index.php. */
        const productos = <?= json_encode($productosJs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        const masVendidos = <?= json_encode($masVendidosJs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        window.productosCache = productos.concat(masVendidos);
    </script>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>