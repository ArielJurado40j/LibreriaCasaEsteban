/* inicio.js - solo lo específico del home.
   Todo lo común (carrito, favoritos, modal) vive en assets/js/tienda.js,
   que ya se cargó antes que este archivo. */

let filtroActual = "todos";
let busquedaActual = "";

function productosFiltrados() {
    return productos.filter(producto => {
        const coincideCategoria = filtroActual === "todos" || String(producto.categoria) === filtroActual;
        const coincideBusqueda = !busquedaActual ||
            producto.nombre.toLowerCase().includes(busquedaActual) ||
            producto.descripcion.toLowerCase().includes(busquedaActual);
        return coincideCategoria && coincideBusqueda;
    });
}

function actualizarFiltros() {
    document.querySelectorAll(".filtro").forEach(boton => {
        boton.classList.toggle("activo", boton.dataset.filtro === filtroActual);
    });
}

function renderCatalogoHome() {
    const resultados = productosFiltrados();
    renderGrilla("listaProductos", resultados);
    document.getElementById("sinResultados").classList.toggle("visible", resultados.length === 0);
    actualizarFiltros();
}

function aplicarFiltro(filtro) {
    filtroActual = filtro;
    renderCatalogoHome();
    document.getElementById("catalogo").scrollIntoView({behavior:"smooth", block:"start"});
}

/* Se vuelve a pintar cuando cambia el carrito/favoritos (ej: sacar del carrito) */
document.addEventListener("productosActualizados", renderCatalogoHome);

/* Filtros rápidos de la grilla del home */
document.querySelectorAll(".filtro").forEach(boton => {
    boton.addEventListener("click", () => aplicarFiltro(boton.dataset.filtro));
});

/* Búsqueda rápida dentro del home (sin recargar la página) */
document.getElementById("entradaBusqueda").addEventListener("input", evento => {
    busquedaActual = evento.target.value.trim().toLowerCase();
    renderCatalogoHome();
});

document.getElementById("formularioBusqueda").addEventListener("submit", evento => {
    evento.preventDefault();
    document.getElementById("catalogo").scrollIntoView({behavior:"smooth"});
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

/* Pintado inicial */
renderCatalogoHome();
renderGrilla("listaMasVendidos", masVendidos);