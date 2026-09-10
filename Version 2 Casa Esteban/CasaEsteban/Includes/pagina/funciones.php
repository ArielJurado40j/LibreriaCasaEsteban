<?php
/* Funciones compartidas por todo el sitio.
   Se incluye junto con conexion.php (require_once __DIR__ . '/funciones.php';). */

/* Convierte filas de la tabla productos (con su categoría ya unida) al
   formato que espera el JavaScript del sitio (tienda.js / inicio.js). */
function formatearProductosParaJs(array $filas): array {
    return array_map(function ($p) {
        return [
            'id'               => (int) $p['id_producto'],
            'nombre'           => $p['nombre_producto'],
            'descripcion'      => $p['descripcion'] ?? '',
            'precio'           => (float) ($p['en_oferta'] && $p['precio_oferta'] ? $p['precio_oferta'] : $p['precio']),
            'precio_original'  => (float) $p['precio'],
            'en_oferta'        => (bool) $p['en_oferta'],
            'imagen'           => $p['imagen_url'] ?: BASE_URL . '/assets/img/placeholder.jpg',
            'categoria'        => (int) $p['id_categoria'],
            'categoria_nombre' => $p['nombre_categoria'],
        ];
    }, $filas);
}