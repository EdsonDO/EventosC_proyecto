<?php
require_once __DIR__ . '/../../backend/componentes/proveedores.php';

$proveedoresModel = new Proveedores();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre_empresa' => $_POST['nombre_empresa'],
        'nombre_responsable' => $_POST['nombre_responsable'],
        'telefono' => $_POST['telefono'],
        'email' => $_POST['email'],
        'direccion' => $_POST['direccion'],
        'estado' => 'Disponible',
        'id_servicio' => 1 // Hardcodeado (necesitas tabla Servicios)
    ];

    try {
        $proveedoresModel->crear($datos);
        $mensaje = "<div class='alert alert-success'><i class='bx bx-check-circle'></i> Proveedor registrado</div>";
    } catch (Exception $e) {
        $mensaje = "<div class='alert' style='color:#f87171; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);'><i class='bx bx-error'></i> Error: " . $e->getMessage() . "</div>";
    }
}

$lista = $proveedoresModel->listar(); 
$pageTitle = "Proveedores";
include '../layout/header.php';
?>

<?php echo $mensaje; ?>

<div class="card">
    <div class="card-header-text">Registrar Proveedor</div>
    <form method="POST">
        <div class="row">
            <div class="col"><input type="text" name="nombre_empresa" class="form-input" placeholder="Empresa" required></div>
            <div class="col"><input type="text" name="nombre_responsable" class="form-input" placeholder="Responsable" required></div>
            <div class="col"><input type="text" name="telefono" class="form-input" placeholder="Teléfono" required></div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col"><input type="email" name="email" class="form-input" placeholder="Email" required></div>
            <div class="col"><input type="text" name="direccion" class="form-input" placeholder="Dirección" required></div>
            <div style="width: auto;">
                <button type="submit" class="btn-primary"><i class='bx bx-save'></i> Guardar</button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>Responsable</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $prov): ?>
                    <tr>
                        <td>#<?php echo $prov['id']; ?></td>
                        <td><?php echo $prov['nombre_empresa']; ?></td>
                        <td><?php echo $prov['nombre_responsable']; ?></td>
                        <td><?php echo $prov['telefono']; ?></td>
                        <td><?php echo $prov['email']; ?></td>
                        <td><span class="badge"><?php echo $prov['estado']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center; color:#666">No hay proveedores</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../layout/footer.php'; ?>