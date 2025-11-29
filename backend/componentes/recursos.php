<?php
require_once 'conexion.php';
require_once __DIR__ . '/../validations/RecursoValidation.php';

class Recursos {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }

    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Recursos");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtener($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Recursos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function crear($data) {
        $errores = RecursoValidation::validar($data);
        if (!empty($errores)) {
            $msg = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO Recursos (nombre_recurso, cantidad, ubicacion, estado, prox_mantenimiento, id_tipo)
            VALUES (:nombre_recurso, :cantidad, :ubicacion, :estado, :prox_mantenimiento, :id_tipo)
        ");
        
        $stmt->execute([
            ':nombre_recurso' => $data['nombre_recurso'],
            ':cantidad' => $data['cantidad'] ?? 0,
            ':ubicacion' => $data['ubicacion'] ?? '',
            ':estado' => $data['estado'] ?? 'Disponible',
            ':prox_mantenimiento' => $data['prox_mantenimiento'] ?? null,
            ':id_tipo' => $data['id_tipo']
        ]);
        
        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $data) {
        $errores = RecursoValidation::validar($data);
        if (!empty($errores)) {
            $msg = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            UPDATE Recursos SET
                nombre_recurso = :nombre_recurso,
                cantidad = :cantidad,
                ubicacion = :ubicacion,
                estado = :estado,
                prox_mantenimiento = :prox_mantenimiento,
                id_tipo = :id_tipo
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':nombre_recurso' => $data['nombre_recurso'],
            ':cantidad' => $data['cantidad'] ?? 0,
            ':ubicacion' => $data['ubicacion'] ?? '',
            ':estado' => $data['estado'] ?? 'Disponible',
            ':prox_mantenimiento' => $data['prox_mantenimiento'] ?? null,
            ':id_tipo' => $data['id_tipo']
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Recursos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>