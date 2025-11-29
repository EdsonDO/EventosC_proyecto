<?php
require_once 'conexion.php';

class ReservasRecursos {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }

    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Reservas_Recursos");
            $reservas_recursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($reservas_recursos);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function obtener($id_reservas, $id_recursos) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM Reservas_Recursos 
                WHERE id_reservas = :id_reservas AND id_recursos = :id_recursos
            ");
            $stmt->execute([
                ':id_reservas' => $id_reservas,
                ':id_recursos' => $id_recursos
            ]);
            $relacion = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($relacion);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function crear($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO Reservas_Recursos (id_reservas, id_recursos)
                VALUES (:id_reservas, :id_recursos)
            ");
            $stmt->execute([
                ':id_reservas' => $data['id_reservas'],
                ':id_recursos' => $data['id_recursos']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function eliminar($id_reservas, $id_recursos) {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM Reservas_Recursos 
                WHERE id_reservas = :id_reservas AND id_recursos = :id_recursos
            ");
            $stmt->execute([
                ':id_reservas' => $id_reservas,
                ':id_recursos' => $id_recursos
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
