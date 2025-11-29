<?php
require_once 'conexion.php';
require_once __DIR__ . '/../validations/reservaProveedorValidation.php';


class ReservasProveedor {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }

    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Reservas_Proveedor");
            $reservas_proveedor = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($reservas_proveedor);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function obtener($id_reservas, $id_proveedores) {
       
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM Reservas_Proveedor 
                WHERE id_reservas = :id_reservas AND id_proveedores = :id_proveedores
            ");
            $stmt->execute([
                ':id_reservas' => $id_reservas,
                ':id_proveedores' => $id_proveedores
            ]);
            $relacion = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($relacion);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function crear($data) {
     $errores = ReservasProveedorValidation::validar($data);
    if (!empty($errores)) {
        echo json_encode(['errores' => $errores]);
        return;
    }
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO Reservas_Proveedor (id_reservas, id_proveedores)
                VALUES (:id_reservas, :id_proveedores)
            ");
            $stmt->execute([
                ':id_reservas' => $data['id_reservas'],
                ':id_proveedores' => $data['id_proveedores']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function eliminar($id_reservas, $id_proveedores) {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM Reservas_Proveedor 
                WHERE id_reservas = :id_reservas AND id_proveedores = :id_proveedores
            ");
            $stmt->execute([
                ':id_reservas' => $id_reservas,
                ':id_proveedores' => $id_proveedores
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
