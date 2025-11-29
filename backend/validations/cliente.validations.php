<?php

function validarClienteId($id) {
    $errores = [];
    if (empty($id)) {
        $errores[] = 'El ID es obligatorio.';
    } else if (!is_numeric($id) || $id <= 0) {
        $errores[] = 'El ID debe ser un número entero positivo.';
    }
    return $errores;
}

function validarClienteDatos($data) {
    $errores = [];
    if (empty($data['nombre'])) {
        $errores[] = 'El "nombre" es obligatorio.';
    }
    if (empty($data['apellidos'])) {
        $errores[] = 'Los "apellidos" son obligatorios.';
    }
    if (empty($data['telefono'])) {
        $errores[] = 'El "telefono" es obligatorio.';
    } else if (!is_numeric($data['telefono']) || strlen($data['telefono']) != 9) {
        $errores[] = 'El "telefono" debe ser un número de 9 dígitos.';
    }
    if (empty($data['dni'])) {
        $errores[] = 'El "DNI" es obligatorio.';
    } else if (!is_numeric($data['dni']) || strlen($data['dni']) != 8) {
        $errores[] = 'El "DNI" debe ser un número de 8 dígitos.';
    }
    return $errores;
}
?>