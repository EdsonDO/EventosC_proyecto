<?php
require_once __DIR__ . '/../../backend/componentes/reservas.php';

$reservasModel = new Reservas();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datosNuevos = [
        'fecha' => $_POST['fecha'],
        'numero_asistentes' => $_POST['numero_asistentes'],
        'total' => $_POST['total'],
        'estado' => 'Por Pagar',
        'id_cliente' => 1,
        'id_pagos' => 1,
        'id_evento' => 1,
        'id_ubicacion' => 1
    ];

    try {
        $reservasModel->crear($datosNuevos);
        $mensaje = "<div class='alert alert-success'><i class='bx bx-check-circle'></i> Reserva guardada con éxito</div>";
    } catch (PDOException $e) {
        if (str_contains($e->getMessage(), '1452')) {
             $errorText = "Error: Estás intentando usar un Cliente, Evento o Pago que NO EXISTE en la base de datos.";
        } else {
             $errorText = "Error de Base de Datos: " . $e->getMessage();
        }
        
        $mensaje = "<div class='alert' style='color:#f87171; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);'><i class='bx bx-error'></i> " . $errorText . "</div>";
    } catch (Exception $e) {
        $mensaje = "<div class='alert' style='color:#f87171; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);'><i class='bx bx-error'></i> Error: " . $e->getMessage() . "</div>";
    }
}

$listaReservas = $reservasModel->listar();

$pageTitle = "Reservas";
include '../layout/header.php';
?>

<?php echo $mensaje; ?>

<div class="card">
    <div class="card-header-text">Registrar Nueva Reserva</div>
    
    <form method="POST">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Fecha del Evento</label>
                    <input type="date" name="fecha" class="form-input" required>
                </div>
            </div>
            <div class="col">
                 <div class="form-group">
                    <label class="form-label">Número de Asistentes</label>
                    <input type="number" name="numero_asistentes" class="form-input" placeholder="0" required>
                </div>
            </div>
             <div class="col">
                 <div class="form-group">
                    <label class="form-label">Total a Pagar ($)</label>
                    <input type="number" name="total" class="form-input" placeholder="0.00" step="0.01" required>
                </div>
            </div>
        </div>
        <div style="margin-top: 15px; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn-primary">
                <i class='bx bx-save'></i> Guardar Reserva
            </button>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header-text">Historial Reciente</div>
    
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Asistentes</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listaReservas)): ?>
                <?php foreach ($listaReservas as $r): ?>
                    <tr>
                        <td>#<?php echo $r['id']; ?></td>
                        <td><?php echo $r['fecha']; ?></td>
                        <td><?php echo $r['numero_asistentes']; ?></td>
                        <td>$<?php echo number_format($r['total'], 2); ?></td>
                        <td>
                            <span class="badge <?php echo strtolower(str_replace(' ', '-', $r['estado'])); ?>">
                                <?php echo $r['estado']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center; color: #666;">No hay reservas registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../layout/footer.php'; ?>