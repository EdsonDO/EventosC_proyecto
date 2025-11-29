<?php
require_once 'conexion.php';

require_once __DIR__ . '/../validations/ServicioValidation.php';

class Servicios {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }

    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Servicios");
            $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($servicios);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function obtener($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Servicios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $servicio = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($servicio);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function crear($data) {
        $errores = ServicioValidation::validar($data);
        if (!empty($errores)) {
            echo json_encode(['errores' => $errores]);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO Servicios (nombre)
                VALUES (:nombre)
            ");
            $stmt->execute([
                ':nombre' => $data['nombre']
            ]);
            echo json_encode(['success' => true, 'id' => $this->pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function actualizar($id, $data) {
        $errores = ServicioValidation::validar($data);
        if (!empty($errores)) {
            echo json_encode(['errores' => $errores]);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("
                UPDATE Servicios SET
                    nombre = :nombre
                WHERE id = :id
            ");
            $stmt->execute([
                ':id' => $id,
                ':nombre' => $data['nombre']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function eliminar($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Servicios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
