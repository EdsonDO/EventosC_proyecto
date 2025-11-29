<?php
require_once 'conexion.php';
require_once __DIR__ . '/../validations/pagos.validations.php';

class Pagos {
    private $pdo;

    public function __construct() {
        $db = new Conexion();
        $this->pdo = $db->iniciar();
    }

    public function listar() {
        $sql = "SELECT 
                    p.id,
                    p.numero_tarjeta,
                    p.fecha_vencimiento,
                    p.cvv,
                    p.voucer,
                    p.id_tipo_pago,
                    tp.nombre AS tipo_pago_nombre,
                    p.id_adelanto,
                    a.valor AS adelanto_valor
                FROM Pagos p
                LEFT JOIN Tipo_Pago tp ON p.id_tipo_pago = tp.id
                LEFT JOIN Adelanto a ON p.id_adelanto = a.id";

        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtener($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Pagos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function crear($data) {
        $errores = validarPagoDatos($data);
        if (!empty($errores)) {
            $msg = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO Pagos (numero_tarjeta, fecha_vencimiento, cvv, voucer, id_tipo_pago, id_adelanto)
            VALUES (:numero_tarjeta, :fecha_vencimiento, :cvv, :voucer, :id_tipo_pago, :id_adelanto)
        ");
        
        $stmt->execute([
            ':numero_tarjeta' => $data['numero_tarjeta'] ?? null,
            ':fecha_vencimiento' => $data['fecha_vencimiento'] ?? null,
            ':cvv' => $data['cvv'] ?? null,
            ':voucer' => $data['voucer'] ?? null,
            ':id_tipo_pago' => $data['id_tipo_pago'],
            ':id_adelanto' => $data['id_adelanto']
        ]);
        
        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $data) {
        $errores = validarPagoDatos($data);
        if (!empty($errores)) {
            $msg = is_array($errores) ? implode(", ", $errores) : $errores;
            throw new Exception($msg);
        }

        $stmt = $this->pdo->prepare("
            UPDATE Pagos SET
                numero_tarjeta = :numero_tarjeta,
                fecha_vencimiento = :fecha_vencimiento,
                cvv = :cvv,
                voucer = :voucer,
                id_tipo_pago = :id_tipo_pago,
                id_adelanto = :id_adelanto
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':numero_tarjeta' => $data['numero_tarjeta'] ?? null,
            ':fecha_vencimiento' => $data['fecha_vencimiento'] ?? null,
            ':cvv' => $data['cvv'] ?? null,
            ':voucer' => $data['voucer'] ?? null,
            ':id_tipo_pago' => $data['id_tipo_pago'],
            ':id_adelanto' => $data['id_adelanto']
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Pagos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function listarTiposPago() {
        try {
            $sql = "SELECT * FROM Tipo_Pago";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function listarAdelantos() {
        try {
            $sql = "SELECT * FROM Adelanto";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function estadisticas() {
        $hoy = date('Y-m-d');
        $tresDias = date('Y-m-d', strtotime('+3 days'));

        try {
            $sql1 = $this->pdo->query("SELECT SUM(a.valor) AS total_adelantos FROM Pagos p INNER JOIN Adelanto a ON p.id_adelanto = a.id");
            $sql2 = $this->pdo->query("SELECT COUNT(*) AS a_tiempo FROM Pagos WHERE fecha_vencimiento > '$hoy'");
            $sql3 = $this->pdo->query("SELECT COUNT(*) AS por_vencerse FROM Pagos WHERE fecha_vencimiento BETWEEN '$hoy' AND '$tresDias'");
            $sql4 = $this->pdo->query("SELECT COUNT(*) AS vencidos FROM Pagos WHERE fecha_vencimiento < '$hoy'");

            return [
                'total_adelantos' => $sql1->fetch(PDO::FETCH_ASSOC)['total_adelantos'] ?? 0,
                'a_tiempo'        => $sql2->fetch(PDO::FETCH_ASSOC)['a_tiempo'] ?? 0,
                'por_vencerse'    => $sql3->fetch(PDO::FETCH_ASSOC)['por_vencerse'] ?? 0,
                'vencidos'        => $sql4->fetch(PDO::FETCH_ASSOC)['vencidos'] ?? 0,
            ];
        } catch (Exception $e) {
            return ['total_adelantos' => 0, 'a_tiempo' => 0, 'por_vencerse' => 0, 'vencidos' => 0];
        }
    }
}
?>