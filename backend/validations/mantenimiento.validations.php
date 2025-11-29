<?php

function validarMantenimientoId($id) {
    $errores = [];
    if (empty($id)) {
        $errores[] = 'El ID es obligatorio.';
    } else if (!is_numeric($id) || $id <= 0) {
        $errores[] = 'El ID debe ser un número entero positivo.';
    }
    return $errores;
}

function validarMantenimientoDatos($data) {
    $errores = [];
    if (empty($data['fecha'])) {
        $errores[] = 'La "fecha" es obligatoria.';
    }
    if (empty($data['costo'])) {
        $errores[] = 'El "costo" es obligatorio.';
    } else if (!is_numeric($data['costo']) || $data['costo'] < 0) {
        $errores[] = 'El "costo" debe ser un número positivo.';
    }
    if (empty($data['descripcion'])) {
        $errores[] = 'La "descripcion" es obligatoria.';
    }
    if (empty($data['id_recursos'])) {
        $errores[] = 'El "id_recursos" es obligatorio.';
    } else if (!is_numeric($data['id_recursos']) || $data['id_recursos'] <= 0) {
        $errores[] = 'El "id_recursos" debe ser un ID válido.';
    }
    return $errores;
}
?>