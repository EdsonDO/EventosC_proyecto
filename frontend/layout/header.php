<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Eventos</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

<div class="sidebar">
    <div class="brand">
        <img src="../assets/img/eventosclogo.png" alt="EventosC" class="logo-img">
    </div>
        
        <ul class="menu-list">
            <li>
                <a href="reservas.php" class="menu-item <?php echo (!isset($pageTitle) || $pageTitle == 'Panel') ? 'active' : ''; ?>">
                    <i class='bx bx-grid-alt'></i> Panel General
                </a>
            </li>

            <li>
                <a href="reservas.php" class="menu-item <?php echo (isset($pageTitle) && $pageTitle == 'Reservas') ? 'active' : ''; ?>">
                    <i class='bx bx-calendar'></i> Reservas
                </a>
            </li>

            <li>
                <a href="recursos.php" class="menu-item <?php echo (isset($pageTitle) && $pageTitle == 'Recursos') ? 'active' : ''; ?>">
                    <i class='bx bx-box'></i> Recursos
                </a>
            </li>

            <li>
                <a href="proveedores.php" class="menu-item <?php echo (isset($pageTitle) && $pageTitle == 'Proveedores') ? 'active' : ''; ?>">
                    <i class='bx bx-building'></i> Proveedores
                </a>
            </li>

            <li>
                <a href="clientes.php" class="menu-item <?php echo (isset($pageTitle) && $pageTitle == 'Clientes') ? 'active' : ''; ?>">
                    <i class='bx bx-user'></i> Clientes
                </a>
            </li>

            <li>
                <a href="pagos.php" class="menu-item <?php echo (isset($pageTitle) && $pageTitle == 'Pagos') ? 'active' : ''; ?>">
                    <i class='bx bx-wallet'></i> Pagos
                </a>
            </li>
        </ul>
    </div>

    <div class="main-wrapper">
        
        <div class="topbar">
            <div class="page-title"><?php echo isset($pageTitle) ? $pageTitle : 'Panel'; ?></div>
            
            <div class="user-profile-container">
                <div class="profile-btn">
                    <i class='bx bx-user'></i>
                </div>
                
                <div class="profile-dropdown">
                    <div style="padding: 10px 15px; border-bottom: 1px solid var(--border); margin-bottom: 5px;">
                        <small style="color: #666;">Administrador</small>
                    </div>
                    <a href="#"><i class='bx bx-cog'></i> Configuración</a>
                    <a href="#" style="color: #ef4444;"><i class='bx bx-log-out'></i> Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <div class="content-area">