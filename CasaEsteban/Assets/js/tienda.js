/* productos.js - específico de la página de catálogo.
   El filtro por categoría y la búsqueda ya se resolvieron del lado del
   servidor (catalogo.php, vía la URL), así que acá solo falta pintar
   la grilla con lo que PHP ya filtró. */

renderGrilla("listaProductos", productos);

/* Si se agrega/saca algo del carrito o de favoritos, se vuelve a pintar
   para que el corazón y el contador de "en carrito" queden al día. */
document.addEventListener("productosActualizados", () => {
    renderGrilla("listaProductos", productos);
});