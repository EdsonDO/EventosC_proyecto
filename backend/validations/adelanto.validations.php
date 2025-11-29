<?php

function validarAdelantoId($id) {
    $errores = [];
    if (empty($id)) {
        $errores[] = 'El ID es obligatorio.';
    } else if (!is_numeric($id) || $id <= 0) {
        $errores[] = 'El ID debe ser un número entero positivo.';
    }
    return $errores;
}

function validarAdelantoDatos($data) {
    $errores = [];
    if (empty($data['valor'])) {
        $errores[] = 'El campo "valor" es obligatorio.';
    } else if (!is_numeric($data['valor']) || $data['valor'] <= 0) {
        $errores[] = 'El "valor" debe ser un número positivo.';
    }
    return $errores;
}
?>