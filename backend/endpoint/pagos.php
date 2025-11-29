<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once(__DIR__ . '/../componentes/pagos.php');


$pagos = new Pagos();
$accion = $_GET['accion'] ?? '';

switch($accion) {
    case 'listar':
        $pagos->listar();
        break;

    case 'obtener':
        $id = $_GET['id'] ?? 0;
        $pagos->obtener($id);
        break;

    case 'crear':
        $data = json_decode(file_get_contents('php://input'), true);
        $pagos->crear($data);
        break;

    case 'actualizar':
        $id = $_GET['id'] ?? 0;
        $data = json_decode(file_get_contents('php://input'), true);
        $pagos->actualizar($id, $data);
        break;

    case 'eliminar':
        $id = $_GET['id'] ?? 0;
        $pagos->eliminar($id);
        break;
    
   case 'estadisticas':
    echo json_encode($pagos->estadisticas());
    break;

    case 'listarTiposPago':
    $pagos->listarTiposPago();
    break;

    case 'listarAdelantos':
    $pagos->listarAdelantos();
    break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
}
