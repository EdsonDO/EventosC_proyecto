<?php
require_once __DIR__ . '/../../backend/componentes/cliente.php';

$clienteModel = new Cliente(); 
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => $_POST['nombre'],
        'apellidos' => $_POST['apellidos'],
        'dni' => $_POST['dni'],
        'telefono' => $_POST['telefono'],
        'correo' => $_POST['correo'],
        'estado' => 'Activo'
    ];

    try {
        $clienteModel->crear($datos);
        $mensaje = "<div class='alert alert-success'><i class='bx bx-check-circle'></i> Cliente registrado</div>";
    } catch (Exception $e) {
        $mensaje = "<div class='alert' style='color:#f87171; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);'><i class='bx bx-error'></i> Error: " . $e->getMessage() . "</div>";
    }
}

$lista = $clienteModel->listar(); 
$totalClientes = count($lista);

$pageTitle = "Clientes";
include '../layout/header.php';
?>

<div class="kpi-grid">
    <div class="kpi-card kpi-blue">
        <div class="kpi-value"><?php echo $totalClientes; ?></div>
        <div class="kpi-label">Total Clientes</div>
        <i class='bx bx-user kpi-icon'></i>
    </div>
</div>

<?php echo $mensaje; ?>

<div class="card">
    <div class="card-header-text">Nuevo Cliente</div>
    <form method="POST">
        <div class="row">
            <div class="col"><input type="text" name="nombre" class="form-input" placeholder="Nombre" required></div>
            <div class="col"><input type="text" name="apellidos" class="form-input" placeholder="Apellidos" required></div>
            <div class="col"><input type="text" name="dni" class="form-input" placeholder="DNI" required></div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col"><input type="text" name="telefono" class="form-input" placeholder="Teléfono" required></div>
            <div class="col"><input type="email" name="correo" class="form-input" placeholder="Email" required></div>
            <div style="width: auto;">
                <button type="submit" class="btn-primary"><i class='bx bx-user-plus'></i> Guardar</button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $c): ?>
                    <tr>
                        <td>#<?php echo $c['id']; ?></td>
                        <td><?php echo $c['nombre'] . ' ' . $c['apellidos']; ?></td>
                        <td><?php echo $c['dni']; ?></td>
                        <td><?php echo $c['telefono']; ?></td>
                        <td><?php echo $c['correo']; ?></td>
                        <td><span class="badge"><?php echo $c['estado']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center; color:#666">No hay clientes</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../layout/footer.php'; ?>