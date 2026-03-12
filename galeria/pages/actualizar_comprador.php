<?php
session_start();
include '../scripts/db.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') die("Acceso denegado.");

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $res = mysqli_query($conexion, "SELECT * FROM comprador WHERE id_comprador = '$id'");
    $d = mysqli_fetch_assoc($res);
}

if (isset($_POST['update'])) {
    $id_ori = $_POST['id_original'];
    $id_n = $_POST['id_comprador']; $nom = $_POST['nombre']; $ape = $_POST['apellido'];
    $em = $_POST['email']; $tel = $_POST['telefono']; $dir = $_POST['direccion'];
    $tc = $_POST['tcredito']; $cs = $_POST['cod_seguridad']; $us = $_POST['usuario'];
    $p1 = $_POST['p1']; $p2 = $_POST['p2']; $p3 = $_POST['p3'];

    $sql = "UPDATE comprador SET id_comprador='$id_n', nombre='$nom', apellido='$ape', email='$em', 
            telefono='$tel', direccion='$dir', tcredito='$tc', cod_seguridad='$cs', usuario='$us', 
            p1='$p1', p2='$p2', p3='$p3' WHERE id_comprador='$id_ori'";

    if (mysqli_query($conexion, $sql)) header("Location: admin_panel.php?view=crud&m=1");
}
?>

<!DOCTYPE html>
<head>
    <title>Actualizar Comprador</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<form method="POST" class="form-actualizar">
    <input type="hidden" name="id_original" value="<?php echo $d['id_comprador']; ?>">
    <input type="text" name="id_comprador" value="<?php echo $d['id_comprador']; ?>" placeholder="ID">
    <input type="text" name="nombre" value="<?php echo $d['nombre']; ?>" placeholder="Nombre">
    <input type="text" name="apellido" value="<?php echo $d['apellido']; ?>" placeholder="Apellido">
    <input type="email" name="email" value="<?php echo $d['email']; ?>" placeholder="Email">
    <input type="text" name="telefono" value="<?php echo $d['telefono']; ?>" placeholder="Teléfono">
    <input type="text" name="direccion" value="<?php echo $d['direccion']; ?>" placeholder="Dirección">
    <input type="text" name="tcredito" value="<?php echo $d['tcredito']; ?>" placeholder="T. Crédito">
    <input type="text" name="cod_seguridad" value="<?php echo $d['cod_seguridad']; ?>" placeholder="Cód. Seguridad">
    <input type="text" name="usuario" value="<?php echo $d['usuario']; ?>" placeholder="Usuario">
    <input type="text" name="p1" value="<?php echo $d['p1']; ?>" placeholder="Pregunta 1">
    <input type="text" name="p2" value="<?php echo $d['p2']; ?>" placeholder="Pregunta 2">
    <input type="text" name="p3" value="<?php echo $d['p3']; ?>" placeholder="Pregunta 3">
    <button type="submit" name="update">Actualizar Comprador</button>
</form>