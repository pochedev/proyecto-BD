<?php
session_start();
include '../scripts/db.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$view = $_GET['view'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <nav class="sidebar">
            <h3>Menú Admin</h3>
            <ul>
                <li><a href="admin_panel.php?view=dashboard">Inicio</a></li>
                <li><a href="admin_panel.php?view=crud">Gestión (CRUD)</a></li>
                <li><a href="admin_panel.php?view=facturacion">Facturación</a></li>
                <li><a href="admin_panel.php?view=rep_obras">Obras Vendidas</a></li>
                <li><a href="admin_panel.php?view=rep_facturacion">Resumen Facturación</a></li>
                <li><a href="admin_panel.php?view=rep_membresias">Membresías</a></li>
                <li><a href="../scripts/logout.php">Salir</a></li>
            </ul>
        </nav>

        <section class="content">
            <?php
            switch ($view) {
                case 'crud': include 'admin_crud.php'; break;
                case 'facturacion': include 'admin_facturacion.php'; break;
                case 'rep_obras': include 'admin_rep_obras.php'; break;
                case 'rep_facturacion': include 'admin_rep_facturacion.php'; break;
                case 'rep_membresias': include 'admin_rep_membresias.php'; break;
                default: echo "<h2>Bienvenido al Panel de Control</h2>"; break;
            }
            ?>
        </section>
    </div>
</body>
</html>