<!-- Pie -->
    <footer class="pie" id="contacto">
        <div class="contenedor pie-grid">
            <div class="pie-marca">
                <a href="<?= BASE_URL ?>/index.php" class="logo logo-pie">
                    <span class="logo-icono">CE</span>
                    <span><strong>Casa Esteban</strong><small>tienda online</small></span>
                </a>
                <p>Un espacio para estudiar, crear, trabajar y encontrar eso que estabas buscando.</p>
            </div>

            <div class="pie-columna">
                <h3>Catálogo</h3>
                <a href="<?= BASE_URL ?>/productos/catalogo.php">Ver todo</a>
                <a href="<?= BASE_URL ?>/index.php#ofertas">Ofertas</a>
            </div>

            <div class="pie-columna">
                <h3>Ayuda</h3>
                <a href="<?= BASE_URL ?>/index.php#contacto">Preguntas frecuentes</a>
                <a href="<?= BASE_URL ?>/index.php#contacto">Envíos</a>
                <a href="<?= BASE_URL ?>/index.php#contacto">Medios de pago</a>
                <a href="<?= BASE_URL ?>/index.php#contacto">Contacto</a>
            </div>

            <div class="pie-columna">
                <h3>Seguinos</h3>
                <div class="redes">
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="TikTok">TT</a>
                </div>
                <p class="horarios">Lunes a viernes<br>07:30–13:00 · 17:30–21:00</p>
            </div>
        </div>
        <div class="pie-final">
            <div class="contenedor">
                <span>© 2026 Casa Esteban. Todos los derechos reservados.</span>
                <span>Diseño responsive</span>
            </div>
        </div>
    </footer>

    <!-- Panel lateral del carrito -->
    <div class="fondo-panel" id="fondoPanel"></div>
    <aside class="panel-carrito" id="panelCarrito" aria-label="Carrito de compras">
        <div class="cabecera-panel">
            <div>
                <span class="mini-etiqueta">Tu pedido</span>
                <h2>Carrito</h2>
            </div>
            <button class="cerrar-panel" id="cerrarCarrito" aria-label="Cerrar carrito">×</button>
        </div>

        <div class="contenido-carrito" id="contenidoCarrito">
            <div class="carrito-vacio">
                <span>🛒</span>
                <h3>Tu carrito está vacío</h3>
                <p>Agregá productos para comenzar tu pedido.</p>
            </div>
        </div>

        <div class="pie-carrito">
            <div class="fila-total"><span>Subtotal</span><strong id="subtotalCarrito">$0</strong></div>
            <p>El envío y otros costos se calculan al confirmar.</p>
            <button class="boton-principal boton-completo" id="botonFinalizar">Finalizar pedido</button>
        </div>
    </aside>

    <!-- Modal de producto -->
    <div class="modal-fondo" id="modalProducto">
        <div class="modal">
            <button class="cerrar-modal" id="cerrarModal" aria-label="Cerrar">×</button>
            <div class="modal-grid">
                <img src="<?= BASE_URL ?>/assets/img/placeholder.jpg" alt="Producto" id="modalImagen">
                <div>
                    <span class="mini-etiqueta" id="modalCategoria">Categoría</span>
                    <h2 id="modalNombre">Producto</h2>
                    <p id="modalDescripcion">Descripción del producto.</p>
                    <strong class="precio-modal" id="modalPrecio">$0</strong>
                    <button class="boton-principal boton-completo" id="modalAgregar">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp -->
    <a class="boton-whatsapp" href="https://wa.me/3888548007?text=Hola%20Casa%20Esteban%2C%20quiero%20hacer%20una%20consulta." target="_blank" rel="noopener" aria-label="Contactar por WhatsApp">
        <img src="<?= BASE_URL ?>/assets/img/whatsapp.png" alt="WhatsApp">
        <small>¿Necesitás ayuda?</small>
    </a>

    <div class="aviso" id="aviso"></div>

    <!-- tienda.js trae la lógica común (carrito, favoritos, modal) a toda página.
         $scriptPagina lo define cada página antes de incluir este footer,
         con su propio JS específico (ej: 'inicio.js', 'productos/productos.js'). -->
    <script src="<?= BASE_URL ?>/assets/js/tienda.js"></script>
    <?php if (!empty($scriptPagina)): ?>
    <script src="<?= BASE_URL . '/' . $scriptPagina ?>"></script>
    <?php endif; ?>