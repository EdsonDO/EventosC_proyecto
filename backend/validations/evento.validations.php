<?php

function validarEventoId($id) {
    $errores = [];
    if (empty($id)) {
        $errores[] = 'El ID es obligatorio.';
    } else if (!is_numeric($id) || $id <= 0) {
        $errores[] = 'El ID debe ser un número entero positivo.';
    }
    return $errores;
}

function validarEventoDatos($data) {
    $errores = [];
    if (empty($data['nombre'])) {
        $errores[] = 'El "nombre" del evento es obligatorio.';
    }
    if (empty($data['estado'])) {
        $errores[] = 'El "estado" es obligatorio.';
    } else if (!in_array($data['estado'], ['Disponible', 'No Disponible'])) {
        $errores[] = "El 'estado' solo puede ser 'Disponible' o 'No Disponible'.";
    }
    return $errores;
}
?>