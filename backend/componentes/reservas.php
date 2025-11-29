<?php
require_once 'conexion.php';
require_once __DIR__ . '/../validations/reservaValidation.php';

class Reservas {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }
    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Reservas");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; 
        }
    }

    public function obtener($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Reservas WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function crear($data) {
  
        $errores = ReservasValidation::validar($data);
        if (!empty($errores)) {
            $mensajeError = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($mensajeError);
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO Reservas (fecha, numero_asistentes, total, estado, id_cliente, id_pagos, id_evento, id_ubicacion)
            VALUES (:fecha, :numero_asistentes, :total, :estado, :id_cliente, :id_pagos, :id_evento, :id_ubicacion)
        ");
        
        $stmt->execute([
            ':fecha' => $data['fecha'],
            ':numero_asistentes' => $data['numero_asistentes'] ?? 0,
            ':total' => $data['total'] ?? 0,
            ':estado' => $data['estado'] ?? 'Por Pagar',
            ':id_cliente' => $data['id_cliente'],
            ':id_pagos' => $data['id_pagos'],
            ':id_evento' => $data['id_evento'],
            ':id_ubicacion' => $data['id_ubicacion']
        ]);

        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $data) {
        $errores = ReservasValidation::validar($data);
        if (!empty($errores)) {
            $mensajeError = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($mensajeError);
        }

        $stmt = $this->pdo->prepare("
            UPDATE Reservas SET
                fecha = :fecha,
                numero_asistentes = :numero_asistentes,
                total = :total,
                estado = :estado,
                id_cliente = :id_cliente,
                id_pagos = :id_pagos,
                id_evento = :id_evento,
                id_ubicacion = :id_ubicacion
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':fecha' => $data['fecha'],
            ':numero_asistentes' => $data['numero_asistentes'] ?? 0,
            ':total' => $data['total'] ?? 0,
            ':estado' => $data['estado'] ?? 'Por Pagar',
            ':id_cliente' => $data['id_cliente'],
            ':id_pagos' => $data['id_pagos'],
            ':id_evento' => $data['id_evento'],
            ':id_ubicacion' => $data['id_ubicacion']
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Reservas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>