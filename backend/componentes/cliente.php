<?php
require_once 'conexion.php';
require_once __DIR__ . '/../validations/cliente.validations.php';

class Cliente {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }

    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Cliente");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtener($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Cliente WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function crear($data) {
        $errores = validarClienteDatos($data);
        if (!empty($errores)) {
            $msg = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO Cliente (nombre, apellidos, telefono, dni, correo, estado) 
            VALUES (:nombre, :apellidos, :telefono, :dni, :correo, :estado)
        ");
        
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellidos' => $data['apellidos'],
            ':telefono' => $data['telefono'],
            ':dni' => $data['dni'],
            ':correo' => $data['correo'],
            ':estado' => $data['estado']
        ]);
        
        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $data) {
        $errores = validarClienteDatos($data);
        if (!empty($errores)) {
             $msg = is_array($errores) ? implode(", ", $errores) : $errores;
             throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            UPDATE Cliente 
            SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, dni = :dni, correo = :correo, estado = :estado  
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':apellidos' => $data['apellidos'],
            ':telefono' => $data['telefono'],
            ':dni' => $data['dni'],
            ':correo' => $data['correo'],
            ':estado' => $data['estado']
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Cliente WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>