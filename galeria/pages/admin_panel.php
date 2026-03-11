<?php
session_start();
include '../scripts/db.php';

// Seguridad: Solo entrar si es Admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$seccion = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Administrador</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #2c3e50; color: white; padding: 20px; }
        .sidebar h2 { border-bottom: 1px solid #34495e; padding-bottom: 10px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { padding: 10px 0; }
        .sidebar a { color: #ecf0f1; text-decoration: none; }
        .sidebar a:hover { color: #3498db; }
        .main-content { flex: 1; padding: 40px; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #34495e; color: white; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2>Gestión Museo</h2>
            <ul>
                <li><a href="admin_panel.php?view=dashboard">📊 Dashboard</a></li>
                <li><a href="admin_panel.php?view=obras">🖼️ Gestionar Obras (CRUD)</a></li>
                <li><a href="admin_panel.php?view=usuarios">👥 Gestionar Usuarios</a></li>
                <li><a href="admin_panel.php?view=reportes">💰 Reportes Financieros</a></li>
                <li><hr></li>
                <li><a href="index.php">🏠 Volver a Galería</a></li>
                <li><a href="../scripts/logout.php">🚪 Cerrar Sesión</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <?php 
                // Cargamos la sección correspondiente
                if($seccion == 'obras') include 'admin_obras.php';
                elseif($seccion == 'reportes') include 'admin_reportes.php';
                else echo "<h1>Bienvenido, " . $_SESSION['nombre'] . "</h1><p>Selecciona una opción del menú lateral.</p>";
            ?>
        </main>
    </div>
</body>
</html>