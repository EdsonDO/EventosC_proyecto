<?php
require_once __DIR__ . '/../../backend/componentes/pagos.php';

$pagosModel = new Pagos();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'numero_tarjeta' => $_POST['numero_tarjeta'],
        'voucer' => $_POST['voucer'],
        'id_tipo_pago' => 1,
        'id_adelanto' => 1
    ];

    try {
        $pagosModel->crear($datos);
        $mensaje = "<div class='alert alert-success'><i class='bx bx-check-circle'></i> Pago registrado</div>";
    } catch (Exception $e) {
        $mensaje = "<div class='alert' style='color:#f87171; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);'><i class='bx bx-error'></i> Error: " . $e->getMessage() . "</div>";
    }
}

$lista = $pagosModel->listar(); 
$stats = $pagosModel->estadisticas(); 

$pageTitle = "Pagos";
include '../layout/header.php';
?>

<div class="kpi-grid">
    <div class="kpi-card kpi-green">
        <div class="kpi-value">S/. <?php echo number_format($stats['total_adelantos'], 2); ?></div>
        <div class="kpi-label">Total Adelantos</div>
        <i class='bx bx-money kpi-icon'></i>
    </div>
    <div class="kpi-card kpi-blue">
        <div class="kpi-value"><?php echo $stats['a_tiempo']; ?></div>
        <div class="kpi-label">Pagos a Tiempo</div>
        <i class='bx bx-time kpi-icon'></i>
    </div>
    <div class="kpi-card kpi-yellow">
        <div class="kpi-value"><?php echo $stats['por_vencerse']; ?></div>
        <div class="kpi-label">Por Vencerse</div>
        <i class='bx bx-bell kpi-icon'></i>
    </div>
</div>

<?php echo $mensaje; ?>

<div class="card">
    <div class="card-header-text">Registrar Transacción</div>
    <form method="POST">
        <div class="row">
            <div class="col"><input type="text" name="voucer" class="form-input" placeholder="N° Voucher" required></div>
            <div class="col"><input type="text" name="numero_tarjeta" class="form-input" placeholder="N° Tarjeta (Opcional)"></div>
            <div style="width: auto;">
                <button type="submit" class="btn-primary"><i class='bx bx-save'></i> Registrar</button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header-text">Transacciones Registradas</div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Voucher</th>
                <th>Tipo</th>
                <th>Adelanto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $p): ?>
                    <tr>
                        <td>#<?php echo $p['id']; ?></td>
                        <td><?php echo $p['voucer']; ?></td>
                        <td><?php echo $p['tipo_pago_nombre'] ?? 'N/A'; ?></td>
                        <td>S/. <?php echo number_format($p['adelanto_valor'] ?? 0, 2); ?></td>
                        <td>
                            <button class="btn-primary" style="padding: 5px 12px; font-size: 0.8rem;">Ver</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center; color:#666">No hay pagos registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../layout/footer.php'; ?>