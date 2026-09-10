<?php
/* header.php necesita que conexion.php ya se haya incluido antes
   (cada página que lo use debe requerirlo primero). */

/* --- Categorías planas, para el menú ☰ --- */
$categoriasNav = $pdo->query("
    SELECT id_categoria, nombre_categoria
    FROM categorias
    ORDER BY nombre_categoria
")->fetchAll();

/* --- Rubros con sus categorías agrupadas, para la barra de navegación --- */
$filasRubros = $pdo->query("
    SELECT r.id_rubro, r.nombre_rubro, c.id_categoria, c.nombre_categoria
    FROM rubros r
    JOIN categorias c ON c.id_rubro = r.id_rubro
    ORDER BY r.nombre_rubro, c.nombre_categoria
")->fetchAll();

$rubrosNav = [];
foreach ($filasRubros as $fila) {
    $idRubro = $fila['id_rubro'];
    if (!isset($rubrosNav[$idRubro])) {
        $rubrosNav[$idRubro] = ['nombre' => $fila['nombre_rubro'], 'categorias' => []];
    }
    $rubrosNav[$idRubro]['categorias'][] = [
        'id'     => $fila['id_categoria'],
        'nombre' => $fila['nombre_categoria'],
    ];
}
?>
    <!-- Barra superior -->
    <div class="barra-superior">
        <div class="contenedor barra-superior-contenido">
            <span>Envíos y atención personalizada</span>

                    
                <div class="barra-enlaces">

                <?php if (isset($_SESSION['id_usuario'])): ?>

                <span>Hola, <?= htmlspecialchars($_SESSION['nombre']) ?></span>
                <a href="<?= BASE_URL ?>/login/logout.php">Cerrar sesión</a>

                <?php else: ?>

                <a href="<?= BASE_URL ?>/login/login.php">Iniciar sesión</a>
                <a href="<?= BASE_URL ?>/login/registro.php">Registrarse</a>

                <?php endif; ?>

            </div>


        </div>
    </div>

    <!-- Encabezado -->
    <header class="encabezado">
        <div class="contenedor encabezado-contenido">
            <button class="boton-menu-movil" id="botonMenuMovil" aria-label="Abrir menú">☰</button>

            <a href="<?= BASE_URL ?>/index.php" class="logo">
                <img src="<?= BASE_URL ?>/assets/img/logo-casaesteban.png" alt="Casa Esteban" class="logo-icono">
            </a>

            <form class="buscador" action="<?= BASE_URL ?>/productos/catalogo.php" method="get">
                <input type="search" name="buscar" id="entradaBusqueda" placeholder="¿Qué estás buscando?" autocomplete="off">
                <button type="submit" aria-label="Buscar">⌕</button>
            </form>

            <div class="acciones-encabezado">
                <button class="accion-encabezado" id="botonFavoritos" aria-label="Favoritos">
                    <span>♡</span>
                    <b id="contadorFavoritos">0</b>
                </button>
                <button class="accion-encabezado" id="botonCarrito" aria-label="Carrito">
                    <span>🛒</span>
                    <b id="contadorCarrito">0</b>
                </button>
            </div>
        </div>
    </header>

    <!-- Navegación -->
    <nav class="navegacion" id="navegacion">
        <div class="contenedor navegacion-contenido">
            <div class="menu-categorias">
                <button class="boton-categorias" id="botonCategorias"></button>
                <div class="menu-desplegable menu-categorias-desplegable" id="menuCategorias">
                    <?php foreach ($categoriasNav as $cat): ?>
                    <a href="<?= BASE_URL ?>/productos/catalogo.php?categoria=<?= (int) $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre_categoria']) ?> <span>›</span></a>
                    <?php endforeach; ?>
                    <a href="<?= BASE_URL ?>/productos/catalogo.php">Ver todos los productos <span>›</span></a>
                </div>
            </div>

            <div class="enlaces-navegacion">
                <a href="<?= BASE_URL ?>/index.php#ofertas">Ofertas</a>

                <?php foreach ($rubrosNav as $rubro): ?>
                <div class="item-menu">
                    <button class="boton-menu"><?= htmlspecialchars($rubro['nombre']) ?> <span>⌄</span></button>
                    <div class="menu-desplegable">
                        <?php foreach ($rubro['categorias'] as $cat): ?>
                        <a href="<?= BASE_URL ?>/productos/catalogo.php?categoria=<?= (int) $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="item-menu">
                    <button class="boton-menu">Más <span>⌄</span></button>
                    <div class="menu-desplegable">
                        <a href="<?= BASE_URL ?>/productos/catalogo.php">Ver todos los productos</a>
                        <a href="<?= BASE_URL ?>/index.php#contacto">Contacto</a>
                    </div>
                </div>
            </div>

            <a class="enlace-visto" href="<?= BASE_URL ?>/index.php#novedades">◷ &nbsp; Vistos recientemente</a>
        </div>
    </nav>