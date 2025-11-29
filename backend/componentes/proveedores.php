<?php
require_once 'conexion.php';
require_once __DIR__ . '/../validations/proveedorValidation.php';

class Proveedores {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }

    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Proveedores");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtener($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Proveedores WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function crear($data) {
        $errores = ProveedorValidation::validar($data);
        if (!empty($errores)) {
            $msg = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO Proveedores (nombre_empresa, nombre_responsable, telefono, email, direccion, estado, id_servicio)
            VALUES (:nombre_empresa, :nombre_responsable, :telefono, :email, :direccion, :estado, :id_servicio)
        ");
        
        $stmt->execute([
            ':nombre_empresa' => $data['nombre_empresa'],
            ':nombre_responsable' => $data['nombre_responsable'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':direccion' => $data['direccion'],
            ':estado' => $data['estado'] ?? 'Disponible',
            ':id_servicio' => $data['id_servicio']
        ]);
        
        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $data) {
        $errores = ProveedorValidation::validar($data);
        if (!empty($errores)) {
            $msg = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            UPDATE Proveedores SET
                nombre_empresa = :nombre_empresa,
                nombre_responsable = :nombre_responsable,
                telefono = :telefono,
                email = :email,
                direccion = :direccion,
                estado = :estado,
                id_servicio = :id_servicio
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':nombre_empresa' => $data['nombre_empresa'],
            ':nombre_responsable' => $data['nombre_responsable'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':direccion' => $data['direccion'],
            ':estado' => $data['estado'] ?? 'Disponible',
            ':id_servicio' => $data['id_servicio']
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Proveedores WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>