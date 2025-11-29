<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'componentes/reservasrecursos.php';
require_once '../validations/reservasrecursos.php';

$reservasRecursos = new ReservasRecursos();
$accion = $_GET['accion'] ?? '';

switch ($accion) {
    case 'listar':
        $reservasRecursos->listar();
        break;

    case 'obtener':
        $id_reservas = $_GET['id_reservas'] ?? 0;
        $id_recursos = $_GET['id_recursos'] ?? 0;
        $reservasRecursos->obtener($id_reservas, $id_recursos);
        break;

    case 'crear':
        $data = json_decode(file_get_contents('php://input'), true);
        $valid = validarReservasRecursos($data);
        if (isset($valid['error'])) {
            echo json_encode($valid);
            exit();
        }
        $reservasRecursos->crear($data);
        break;

    case 'eliminar':
        $id_reservas = $_GET['id_reservas'] ?? 0;
        $id_recursos = $_GET['id_recursos'] ?? 0;
        $reservasRecursos->eliminar($id_reservas, $id_recursos);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
}
