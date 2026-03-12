<?php
session_start();
include '../scripts/db.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

// 1. Obtener datos actuales del empleado
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $query = "SELECT * FROM empleado WHERE id_empleado = '$id'";
    $resultado = mysqli_query($conexion, $query);
    $empleado = mysqli_fetch_assoc($resultado);
    
    if (!$empleado) die("Empleado no encontrado.");
}

// 2. Procesar la actualización
if (isset($_POST['btn_actualizar_emp'])) {
    $id_original = $_POST['id_original'];
    $id_nuevo = mysqli_real_escape_string($conexion, $_POST['id_empleado']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $salario = $_POST['salario'];
    $puesto = mysqli_real_escape_string($conexion, $_POST['puesto']);
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);

    $sql = "UPDATE empleado SET 
            id_empleado = '$id_nuevo', 
            nombre = '$nombre', 
            apellido = '$apellido', 
            telefono = '$telefono', 
            salario = '$salario', 
            puesto = '$puesto', 
            usuario = '$usuario' 
            WHERE id_empleado = '$id_original'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: admin_panel.php?view=crud&msg=actualizado");
        exit();
    } else {
        $error = "Error al actualizar: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Empleado</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Actualizar Datos de Empleado</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="hidden" name="id_original" value="<?php echo $empleado['id_empleado']; ?>">
            
            <label>ID / CI:</label>
            <input type="text" name="id_empleado" value="<?php echo $empleado['id_empleado']; ?>" required>

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $empleado['nombre']; ?>" required>

            <label>Apellido:</label>
            <input type="text" name="apellido" value="<?php echo $empleado['apellido']; ?>" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $empleado['telefono']; ?>">

            <label>Salario Mensual:</label>
            <input type="number" step="0.01" name="salario" value="<?php echo $empleado['salario']; ?>" required>

            <label>Puesto:</label>
            <select name="puesto" required>
                <option value="admin" <?php if($empleado['puesto'] == 'admin') echo 'selected'; ?>>Administrador</option>
                <option value="vendedor" <?php if($empleado['puesto'] == 'vendedor') echo 'selected'; ?>>Vendedor</option>
                <option value="guia" <?php if($empleado['puesto'] == 'guia') echo 'selected'; ?>>Guía</option>
            </select>

            <label>Usuario:</label>
            <input type="text" name="usuario" value="<?php echo $empleado['usuario']; ?>" required>

            <div class="form-buttons">
                <button type="submit" name="btn_actualizar_emp">Guardar Cambios</button>
                <a href="admin_panel.php?view=crud" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>