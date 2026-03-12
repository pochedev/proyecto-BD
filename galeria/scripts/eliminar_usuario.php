<?php
session_start();
include 'db.php';

if ($_SESSION['rol'] === 'admin' && isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $tipo = $_GET['tipo'];

    // Definir tabla y columna según el tipo
    if ($tipo === 'artista') {
    $tabla = "artista";
    $columna = "id_artista";
} elseif ($tipo === 'comprador') {
    $tabla = "comprador";
    $columna = "id_comprador";
} else {
    $tabla = "empleado";
    $columna = "id_empleado";
}

    $sql = "DELETE FROM $tabla WHERE $columna = '$id'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../pages/admin_panel.php?view=crud&msg=eliminado");
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no autorizado.";
}
?>