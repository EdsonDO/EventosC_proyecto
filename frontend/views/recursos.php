<?php
require_once __DIR__ . '/../../backend/componentes/recursos.php';

$recursosModel = new Recursos();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre_recurso' => $_POST['nombre_recurso'],
        'cantidad' => $_POST['cantidad'],
        'ubicacion' => $_POST['ubicacion'],
        'estado' => 'Disponible',
        'id_tipo' => 1
    ];

    try {
        $recursosModel->crear($datos);
        $mensaje = "<div class='alert alert-success'><i class='bx bx-check-circle'></i> Recurso agregado</div>";
    } catch (Exception $e) {
        $mensaje = "<div class='alert' style='color:#f87171; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);'><i class='bx bx-error'></i> Error: " . $e->getMessage() . "</div>";
    }
}

$lista = $recursosModel->listar(); 

$total = count($lista);
$disponibles = 0;
$en_uso = 0;
foreach($lista as $r) {
    if($r['estado'] == 'Disponible') $disponibles++;
    if($r['estado'] == 'En uso') $en_uso++;
}

$pageTitle = "Recursos";
include '../layout/header.php';
?>

<?php echo $mensaje; ?>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-value"><?php echo $total; ?></div>
        <div class="kpi-label">Total Recursos</div>
        <i class='bx bx-box kpi-icon'></i>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-value"><?php echo $disponibles; ?></div>
        <div class="kpi-label">Disponibles</div>
        <i class='bx bx-check-circle kpi-icon'></i>
    </div>
    <div class="kpi-card kpi-blue">
        <div class="kpi-value"><?php echo $en_uso; ?></div>
        <div class="kpi-label">En Uso</div>
        <i class='bx bx-info-circle kpi-icon'></i>
    </div>
</div>

<div class="card">
    <div class="card-header-text">Nuevo Recurso</div>
    <form method="POST">
        <div class="row">
            <div class="col"><input type="text" name="nombre_recurso" class="form-input" placeholder="Nombre (Ej. Proyector)" required></div>
            <div class="col"><input type="number" name="cantidad" class="form-input" placeholder="Cantidad" required></div>
            <div class="col"><input type="text" name="ubicacion" class="form-input" placeholder="Ubicación" required></div>
            <div style="width: auto;">
                <button type="submit" class="btn-primary"><i class='bx bx-plus'></i> Agregar</button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Recurso</th>
                <th>Cantidad</th>
                <th>Ubicación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $item): ?>
                    <tr>
                        <td>#<?php echo $item['id']; ?></td>
                        <td><?php echo $item['nombre_recurso']; ?></td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <td><?php echo $item['ubicacion']; ?></td>
                        <td>
                            <span class="badge <?php echo strtolower(str_replace(' ', '-', $item['estado'])); ?>">
                                <?php echo $item['estado']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center; color:#666">No hay recursos</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../layout/footer.php'; ?>