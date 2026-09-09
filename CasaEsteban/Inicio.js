/* NOTA: este array de productos es de ejemplo. En el paso "Home dinámico"
   se va a reemplazar por los productos reales que traiga conexion.php desde
   la tabla productos. Las imágenes por ahora apuntan a un placeholder. */
const productos = [
    {id:1, nombre:"Producto 1", categoria:"libreria", precio:1850, imagen:"assets/img/placeholder.jpg", descripcion:"Producto destacado de librería para uso diario."},
    {id:2, nombre:"Producto 2", categoria:"escolar", precio:2400, imagen:"assets/img/placeholder.jpg", descripcion:"Una opción práctica para acompañar tus estudios."},
    {id:3, nombre:"Producto 3", categoria:"arte", precio:3200, imagen:"assets/img/placeholder.jpg", descripcion:"Ideal para proyectos creativos y trabajos artísticos."},
    {id:4, nombre:"Producto 4", categoria:"oficina", precio:2750, imagen:"assets/img/placeholder.jpg", descripcion:"Organizá tu espacio de trabajo de forma simple."},
    {id:5, nombre:"Producto 5", categoria:"regaleria", precio:4100, imagen:"assets/img/placeholder.jpg", descripcion:"Una propuesta especial para regalar o regalarte."},
    {id:6, nombre:"Producto 6", categoria:"libreria", precio:1950, imagen:"assets/img/placeholder.jpg", descripcion:"Producto versátil para tu escritorio."},
    {id:7, nombre:"Producto 7", categoria:"escolar", precio:3500, imagen:"assets/img/placeholder.jpg", descripcion:"Pensado para acompañarte durante todo el ciclo escolar."},
    {id:8, nombre:"Producto 8", categoria:"arte", precio:4600, imagen:"assets/img/placeholder.jpg", descripcion:"Para explorar ideas y darle vida a tus proyectos."},
    {id:9, nombre:"Producto 9", categoria:"oficina", precio:2900, imagen:"assets/img/placeholder.jpg", descripcion:"Orden y practicidad para tu oficina."},
    {id:10, nombre:"Producto 10", categoria:"regaleria", precio:5200, imagen:"assets/img/placeholder.jpg", descripcion:"Un detalle diferente para una ocasión especial."},
    {id:11, nombre:"Producto 11", categoria:"libreria", precio:2250, imagen:"assets/img/placeholder.jpg", descripcion:"Una alternativa funcional para todos los días."},
    {id:12, nombre:"Producto 12", categoria:"escolar", precio:2800, imagen:"assets/img/placeholder.jpg", descripcion:"Todo listo para acompañar tus tareas."}
];

let carrito = JSON.parse(localStorage.getItem("carritoCasaEsteban")) || [];
let favoritos = JSON.parse(localStorage.getItem("favoritosCasaEsteban")) || [];
let filtroActual = "todos";
let busquedaActual = "";
let categoriaBusqueda = "todos";
let productoModalActual = null;

const formatoPrecio = valor => "$" + valor.toLocaleString("es-AR");

function guardarEstado() {
    localStorage.setItem("carritoCasaEsteban", JSON.stringify(carrito));
    localStorage.setItem("favoritosCasaEsteban", JSON.stringify(favoritos));
}

function crearTarjetaProducto(producto) {
    const esFavorito = favoritos.includes(producto.id);
    const cantidad = carrito.find(item => item.id === producto.id)?.cantidad || 0;

    return `
        <article class="tarjeta-producto" data-id="${producto.id}">
            <div class="producto-imagen">
                <img src="${producto.imagen}" alt="${producto.nombre}" loading="lazy">
                <button class="boton-favorito ${esFavorito ? "seleccionado" : ""}" data-favorito="${producto.id}" aria-label="Agregar ${producto.nombre} a favoritos">
                    ${esFavorito ? "♥" : "♡"}
                </button>
                ${cantidad ? `<span class="cantidad-en-carrito">${cantidad} en carrito</span>` : ""}
            </div>
            <div class="producto-contenido">
                <span class="producto-categoria">${producto.categoria.replace("regaleria","Regalería").replace("libreria","Librería").replace("escolar","Escolar").replace("arte","Arte y dibujo").replace("oficina","Oficina")}</span>
                <h3>${producto.nombre}</h3>
                <p>${producto.descripcion}</p>
                <div class="producto-pie">
                    <strong>${formatoPrecio(producto.precio)}</strong>
                    <button class="boton-agregar" data-agregar="${producto.id}" aria-label="Agregar al carrito">+</button>
                </div>
                <button class="boton-ver" data-ver="${producto.id}">Ver producto</button>
            </div>
        </article>
    `;
}

function productosFiltrados() {
    return productos.filter(producto => {
        const coincideCategoria = filtroActual === "todos" || producto.categoria === filtroActual;
        const coincideBusqueda = !busquedaActual ||
            producto.nombre.toLowerCase().includes(busquedaActual) ||
            producto.descripcion.toLowerCase().includes(busquedaActual);
        const coincideCategoriaBusqueda = categoriaBusqueda === "todos" || producto.categoria === categoriaBusqueda;
        return coincideCategoria && coincideBusqueda && coincideCategoriaBusqueda;
    });
}

function renderProductos() {
    const lista = document.getElementById("listaProductos");
    const resultados = productosFiltrados();

    lista.innerHTML = resultados.map(crearTarjetaProducto).join("");
    document.getElementById("sinResultados").classList.toggle("visible", resultados.length === 0);
    actualizarFiltros();
    conectarEventosProductos();
}

function renderMasVendidos() {
    const lista = document.getElementById("listaMasVendidos");
    lista.innerHTML = productos.slice(0, 6).map(crearTarjetaProducto).join("");
    conectarEventosProductos();
}

function conectarEventosProductos() {
    document.querySelectorAll("[data-favorito]").forEach(boton => {
        boton.addEventListener("click", evento => {
            evento.stopPropagation();
            const id = Number(boton.dataset.favorito);
            if (favoritos.includes(id)) {
                favoritos = favoritos.filter(item => item !== id);
                mostrarAviso("Producto quitado de favoritos");
            } else {
                favoritos.push(id);
                mostrarAviso("Producto agregado a favoritos ♥");
            }
            guardarEstado();
            actualizarContadores();
            renderProductos();
            renderMasVendidos();
        });
    });

    document.querySelectorAll("[data-agregar]").forEach(boton => {
        boton.addEventListener("click", evento => {
            evento.stopPropagation();
            agregarAlCarrito(Number(boton.dataset.agregar));
        });
    });

    document.querySelectorAll("[data-ver]").forEach(boton => {
        boton.addEventListener("click", () => abrirModal(Number(boton.dataset.ver)));
    });
}

function actualizarFiltros() {
    document.querySelectorAll(".filtro").forEach(boton => {
        boton.classList.toggle("activo", boton.dataset.filtro === filtroActual);
    });
}

function aplicarFiltro(filtro) {
    filtroActual = filtro;
    renderProductos();
    document.getElementById("catalogo").scrollIntoView({behavior:"smooth", block:"start"});
}

function agregarAlCarrito(id) {
    const producto = productos.find(item => item.id === id);
    if (!producto) return;

    const existente = carrito.find(item => item.id === id);
    if (existente) {
        existente.cantidad++;
    } else {
        carrito.push({id, cantidad:1});
    }

    guardarEstado();
    actualizarContadores();
    renderCarrito();
    mostrarAviso(`${producto.nombre} agregado al carrito`);
}

function cambiarCantidad(id, cambio) {
    const item = carrito.find(producto => producto.id === id);
    if (!item) return;

    item.cantidad += cambio;
    if (item.cantidad <= 0) {
        carrito = carrito.filter(producto => producto.id !== id);
    }

    guardarEstado();
    actualizarContadores();
    renderCarrito();
    renderProductos();
    renderMasVendidos();
}

function actualizarContadores() {
    const total = carrito.reduce((suma, item) => suma + item.cantidad, 0);
    document.getElementById("contadorCarrito").textContent = total;
    document.getElementById("contadorFavoritos").textContent = favoritos.length;
}

function renderCarrito() {
    const contenedor = document.getElementById("contenidoCarrito");
    const subtotal = carrito.reduce((suma, item) => {
        const producto = productos.find(p => p.id === item.id);
        return suma + (producto ? producto.precio * item.cantidad : 0);
    }, 0);

    document.getElementById("subtotalCarrito").textContent = formatoPrecio(subtotal);

    if (!carrito.length) {
        contenedor.innerHTML = `
            <div class="carrito-vacio">
                <span>🛒</span>
                <h3>Tu carrito está vacío</h3>
                <p>Agregá productos para comenzar tu pedido.</p>
            </div>`;
        return;
    }

    contenedor.innerHTML = carrito.map(item => {
        const producto = productos.find(p => p.id === item.id);
        return `
            <div class="item-carrito">
                <img src="${producto.imagen}" alt="${producto.nombre}">
                <div class="item-carrito-info">
                    <strong>${producto.nombre}</strong>
                    <span>${formatoPrecio(producto.precio)}</span>
                    <div class="control-cantidad">
                        <button data-cambiar="${producto.id}" data-cambio="-1">−</button>
                        <b>${item.cantidad}</b>
                        <button data-cambiar="${producto.id}" data-cambio="1">+</button>
                    </div>
                </div>
                <button class="eliminar-item" data-eliminar="${producto.id}" aria-label="Eliminar">×</button>
            </div>`;
    }).join("");

    document.querySelectorAll("[data-cambiar]").forEach(boton => {
        boton.addEventListener("click", () => cambiarCantidad(Number(boton.dataset.cambiar), Number(boton.dataset.cambio)));
    });

    document.querySelectorAll("[data-eliminar]").forEach(boton => {
        boton.addEventListener("click", () => {
            carrito = carrito.filter(item => item.id !== Number(boton.dataset.eliminar));
            guardarEstado();
            actualizarContadores();
            renderCarrito();
            renderProductos();
            renderMasVendidos();
        });
    });
}

function abrirCarrito() {
    document.getElementById("panelCarrito").classList.add("abierto");
    document.getElementById("fondoPanel").classList.add("visible");
    document.body.classList.add("sin-scroll");
}

function cerrarCarrito() {
    document.getElementById("panelCarrito").classList.remove("abierto");
    document.getElementById("fondoPanel").classList.remove("visible");
    document.body.classList.remove("sin-scroll");
}

function abrirModal(id) {
    const producto = productos.find(item => item.id === id);
    if (!producto) return;

    productoModalActual = id;
    document.getElementById("modalImagen").src = producto.imagen;
    document.getElementById("modalImagen").alt = producto.nombre;
    document.getElementById("modalCategoria").textContent = producto.categoria;
    document.getElementById("modalNombre").textContent = producto.nombre;
    document.getElementById("modalDescripcion").textContent = producto.descripcion;
    document.getElementById("modalPrecio").textContent = formatoPrecio(producto.precio);
    document.getElementById("modalProducto").classList.add("visible");
    document.body.classList.add("sin-scroll");
}

function cerrarModal() {
    document.getElementById("modalProducto").classList.remove("visible");
    document.body.classList.remove("sin-scroll");
}

function mostrarAviso(mensaje) {
    const aviso = document.getElementById("aviso");
    aviso.textContent = mensaje;
    aviso.classList.add("visible");
    clearTimeout(window.temporizadorAviso);
    window.temporizadorAviso = setTimeout(() => aviso.classList.remove("visible"), 2400);
}

/* Menú de categorías */
document.getElementById("botonCategorias").addEventListener("click", () => {
    document.getElementById("menuCategorias").classList.toggle("visible");
});

document.querySelectorAll(".menu-categorias-desplegable a").forEach(enlace => {
    enlace.addEventListener("click", () => {
        aplicarFiltro(enlace.dataset.categoria);
        document.getElementById("menuCategorias").classList.remove("visible");
    });
});

/* Menús desplegables */
document.querySelectorAll(".boton-menu").forEach(boton => {
    boton.addEventListener("click", evento => {
        evento.stopPropagation();
        const menu = boton.nextElementSibling;
        document.querySelectorAll(".item-menu .menu-desplegable.visible").forEach(abierto => {
            if (abierto !== menu) abierto.classList.remove("visible");
        });
        menu.classList.toggle("visible");
    });
});

document.addEventListener("click", () => {
    document.querySelectorAll(".menu-desplegable.visible").forEach(menu => menu.classList.remove("visible"));
});

/* Filtros */
document.querySelectorAll(".filtro").forEach(boton => {
    boton.addEventListener("click", () => aplicarFiltro(boton.dataset.filtro));
});

document.querySelectorAll("[data-filtrar]").forEach(boton => {
    boton.addEventListener("click", () => aplicarFiltro(boton.dataset.filtrar));
});

document.querySelectorAll("[data-filtro-pie]").forEach(enlace => {
    enlace.addEventListener("click", () => {
        setTimeout(() => aplicarFiltro(enlace.dataset.filtroPie), 100);
    });
});

/* Búsqueda
   NOTA: el <select id="selectorBusqueda"> está comentado en header.php,
   así que acá se valida que exista antes de leer su valor. Si más adelante
   se vuelve a habilitar el selector, esto va a empezar a usarlo solo. */
document.getElementById("formularioBusqueda").addEventListener("submit", evento => {
    evento.preventDefault();
    busquedaActual = document.getElementById("entradaBusqueda").value.trim().toLowerCase();
    const selector = document.getElementById("selectorBusqueda");
    categoriaBusqueda = selector ? selector.value : "todos";
    renderProductos();
    document.getElementById("catalogo").scrollIntoView({behavior:"smooth"});
});

document.getElementById("entradaBusqueda").addEventListener("input", evento => {
    busquedaActual = evento.target.value.trim().toLowerCase();
    renderProductos();
});

/* Carrito */
document.getElementById("botonCarrito").addEventListener("click", abrirCarrito);
document.getElementById("cerrarCarrito").addEventListener("click", cerrarCarrito);
document.getElementById("fondoPanel").addEventListener("click", cerrarCarrito);

document.getElementById("botonFinalizar").addEventListener("click", () => {
    if (!carrito.length) {
        mostrarAviso("Agregá al menos un producto al carrito");
        return;
    }
    mostrarAviso("Pedido preparado. Podés conectarlo a tu sistema de ventas.");
});

document.getElementById("botonFavoritos").addEventListener("click", () => {
    if (!favoritos.length) {
        mostrarAviso("Todavía no tenés favoritos");
        return;
    }
    aplicarFiltro("todos");
    busquedaActual = "";
    document.getElementById("entradaBusqueda").value = "";
    mostrarAviso(`Tenés ${favoritos.length} producto${favoritos.length === 1 ? "" : "s"} favorito${favoritos.length === 1 ? "" : "s"}`);
});

/* Modal */
document.getElementById("cerrarModal").addEventListener("click", cerrarModal);
document.getElementById("modalProducto").addEventListener("click", evento => {
    if (evento.target.id === "modalProducto") cerrarModal();
});
document.getElementById("modalAgregar").addEventListener("click", () => {
    if (productoModalActual) {
        agregarAlCarrito(productoModalActual);
        cerrarModal();
    }
});

/* Newsletter */
document.getElementById("formularioNewsletter").addEventListener("submit", evento => {
    evento.preventDefault();
    const correo = document.getElementById("correoNewsletter");
    if (correo.value) {
        mostrarAviso("¡Gracias! Te suscribiste correctamente.");
        correo.value = "";
    }
});

/* Carrusel principal */
const diapositivas = document.querySelectorAll(".diapositiva");
const indicadores = document.getElementById("indicadores");
let diapositivaActual = 0;

diapositivas.forEach((_, indice) => {
    const punto = document.createElement("button");
    punto.className = "indicador";
    punto.addEventListener("click", () => mostrarDiapositiva(indice));
    indicadores.appendChild(punto);
});

function mostrarDiapositiva(indice) {
    diapositivaActual = (indice + diapositivas.length) % diapositivas.length;
    diapositivas.forEach((diapositiva, i) => diapositiva.classList.toggle("activa", i === diapositivaActual));
    document.querySelectorAll(".indicador").forEach((punto, i) => punto.classList.toggle("activo", i === diapositivaActual));
}

document.getElementById("siguiente").addEventListener("click", () => mostrarDiapositiva(diapositivaActual + 1));
document.getElementById("anterior").addEventListener("click", () => mostrarDiapositiva(diapositivaActual - 1));
setInterval(() => mostrarDiapositiva(diapositivaActual + 1), 6000);
mostrarDiapositiva(0);

/* Desplazamiento horizontal de más vendidos */
document.getElementById("desplazarSiguiente").addEventListener("click", () => {
    document.getElementById("listaMasVendidos").scrollBy({left: 330, behavior:"smooth"});
});
document.getElementById("desplazarAnterior").addEventListener("click", () => {
    document.getElementById("listaMasVendidos").scrollBy({left: -330, behavior:"smooth"});
});

/* Menú móvil */
document.getElementById("botonMenuMovil").addEventListener("click", () => {
    document.getElementById("navegacion").classList.toggle("movil-abierto");
});

/* Escape para cerrar paneles */
document.addEventListener("keydown", evento => {
    if (evento.key === "Escape") {
        cerrarCarrito();
        cerrarModal();
    }
});

/* Inicio */
renderProductos();
renderMasVendidos();
renderCarrito();
actualizarContadores();