<!-- Barra superior -->
    <div class="barra-superior">
        <div class="contenedor barra-superior-contenido">
            <span>Envíos y atención personalizada</span>
            <div class="barra-enlaces">
                <a href="login/login.php">Iniciar sesion</a>
                <a href="login/registro.php">Registrarse</a>
            </div>
        </div>
    </div>

    <!-- Encabezado -->
    <header class="encabezado">
        <div class="contenedor encabezado-contenido">
            <button class="boton-menu-movil" id="botonMenuMovil" aria-label="Abrir menú">☰</button>

            <a href="index.php" class="logo">
                <img src="assets/img/logo-casaesteban.png" alt="Casa Esteban" class="logo-icono">
            </a>

            <form class="buscador" id="formularioBusqueda">
                <input type="search" id="entradaBusqueda" placeholder="¿Qué estás buscando?" autocomplete="off">
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
                    <a href="#catalogo" data-categoria="libreria">Librería <span>›</span></a>
                    <a href="#catalogo" data-categoria="escolar">Escolar <span>›</span></a>
                    <a href="#catalogo" data-categoria="arte">Arte y dibujo <span>›</span></a>
                    <a href="#catalogo" data-categoria="oficina">Oficina <span>›</span></a>
                    <a href="#catalogo" data-categoria="regaleria">Regalería <span>›</span></a>
                    <a href="#catalogo" data-categoria="todos">Ver todos los productos <span>›</span></a>
                </div>
            </div>

            <div class="enlaces-navegacion">
                <a href="#ofertas">Ofertas</a>

                <div class="item-menu">
                    <button class="boton-menu">Librería <span>⌄</span></button>
                    <div class="menu-desplegable">
                        <a href="#catalogo">Categoria 1</a>
                        <a href="#catalogo">Categoria 2</a>
                        <a href="#catalogo">Categoria 3</a>
                        <a href="#catalogo">Categoria 4</a>
                    </div>
                </div>

                <div class="item-menu">
                    <button class="boton-menu">Escolar <span>⌄</span></button>
                    <div class="menu-desplegable">
                        <a href="#catalogo">Categoria 1</a>
                        <a href="#catalogo">Categoria 2</a>
                        <a href="#catalogo">Categoria 3</a>
                        <a href="#catalogo">Categoria 4</a>
                    </div>
                </div>

                <div class="item-menu">
                    <button class="boton-menu">Arte y dibujo <span>⌄</span></button>
                    <div class="menu-desplegable">
                        <a href="#catalogo">Categoria 1</a>
                        <a href="#catalogo">Categoria 2</a>
                        <a href="#catalogo">Categoria 3</a>
                        <a href="#catalogo">Categoria 4</a>
                    </div>
                </div>

                <div class="item-menu">
                    <button class="boton-menu">Oficina <span>⌄</span></button>
                    <div class="menu-desplegable">
                        <a href="#catalogo">Categoria 1</a>
                        <a href="#catalogo">Categoria 2</a>
                        <a href="#catalogo">Categoria 3</a>
                        <a href="#catalogo">Categoria 4</a>
                    </div>
                </div>

                <div class="item-menu">
                    <button class="boton-menu">Más <span>⌄</span></button>
                    <div class="menu-desplegable">
                        <a href="#novedades">Categoria 1</a>
                        <a href="#novedades">Categoria 2</a>
                        <a href="#novedades">Categoria 3</a>
                        <a href="#contacto">Contacto</a>
                    </div>
                </div>
            </div>

            <a class="enlace-visto" href="#novedades">◷ &nbsp; Vistos recientemente</a>
        </div>
    </nav>