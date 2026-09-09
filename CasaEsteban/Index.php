<?php
require_once __DIR__ . '/includes/conexion.php';
/* Por ahora el home sigue usando los productos de ejemplo del JS.
   En el paso "Home dinámico" vamos a reemplazar eso por una consulta real
   a la tabla productos usando $pdo. */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tienda online moderna y responsive.">
    <title>Casa Esteban | Tienda</title>
    <link rel="stylesheet" href="inicio.css">
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

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
                            <img src="assets/img/descartables.jpg" alt="Producto destacado">
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
                            <img src="assets/img/libreria.jpg" alt="Productos en oferta">
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
                            <img src="assets/img/libre2.jpg" alt="Catálogo de productos">
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
                    <button class="enlace-seccion" data-filtrar="todos">Ver todas →</button>
                </div>

                <div class="rejilla-categorias">
                    <button class="tarjeta-categoria" data-filtrar="libreria">
                        <span class="icono-categoria">📚</span>
                        <strong>Librería</strong>
                        <small>Productos 1</small>
                    </button>
                    <button class="tarjeta-categoria" data-filtrar="escolar">
                        <span class="icono-categoria">✏️</span>
                        <strong>Escolar</strong>
                        <small>Productos 2</small>
                    </button>
                    <button class="tarjeta-categoria" data-filtrar="arte">
                        <span class="icono-categoria">🎨</span>
                        <strong>Arte y dibujo</strong>
                        <small>Productos 3</small>
                    </button>
                    <button class="tarjeta-categoria" data-filtrar="oficina">
                        <span class="icono-categoria">🗂️</span>
                        <strong>Oficina</strong>
                        <small>Productos 4</small>
                    </button>
                    <button class="tarjeta-categoria" data-filtrar="regaleria">
                        <span class="icono-categoria">🎁</span>
                        <strong>Regalería</strong>
                        <small>Productos 5</small>
                    </button>
                </div>
            </div>
        </section>

        <!-- Ofertas -->
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
                    <!-- Se completa con JavaScript -->
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
                        <button class="filtro" data-filtro="libreria">Librería</button>
                        <button class="filtro" data-filtro="escolar">Escolar</button>
                        <button class="filtro" data-filtro="arte">Arte y dibujo</button>
                        <button class="filtro" data-filtro="oficina">Oficina</button>
                        <button class="filtro" data-filtro="regaleria">Regalería</button>
                    </div>
                </div>

                <div class="rejilla-productos" id="listaProductos">
                    <!-- Se completa con JavaScript -->
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

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
