<?php
session_start();
include '../scripts/db.php';

// Verificación de seguridad: Solo Administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado. Se requieren permisos de administrador.");
}

// 1. Obtener datos actuales del artista
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $query = "SELECT * FROM artista WHERE id_artista = '$id'";
    $resultado = mysqli_query($conexion, $query);
    $artista = mysqli_fetch_assoc($resultado);
    
    if (!$artista) die("Artista no encontrado.");
}

// 2. Procesar la actualización
if (isset($_POST['btn_actualizar'])) {
    $id_original = $_POST['id_original'];
    $id_nuevo = mysqli_real_escape_string($conexion, $_POST['id_artista']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $nacionalidad = mysqli_real_escape_string($conexion, $_POST['nacionalidad']);
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);

    $sql = "UPDATE artista SET 
            id_artista = '$id_nuevo', 
            nombre = '$nombre', 
            apellido = '$apellido', 
            email = '$email', 
            telefono = '$telefono', 
            nacionalidad = '$nacionalidad', 
            usuario = '$usuario' 
            WHERE id_artista = '$id_original'";

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
    <title>Actualizar Artista</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Actualizar Perfil de Artista</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="hidden" name="id_original" value="<?php echo $artista['id_artista']; ?>">
            
            <label>ID / Cédula:</label>
            <input type="text" name="id_artista" value="<?php echo $artista['id_artista']; ?>" required>

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $artista['nombre']; ?>" required>

            <label>Apellido:</label>
            <input type="text" name="apellido" value="<?php echo $artista['apellido']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $artista['email']; ?>" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $artista['telefono']; ?>">

            <label>Nacionalidad:</label>
            <input type="text" name="nacionalidad" value="<?php echo $artista['nacionalidad']; ?>">

            <label>Usuario:</label>
            <input type="text" name="usuario" value="<?php echo $artista['usuario']; ?>" required>

            <div class="form-buttons">
                <button type="submit" name="btn_actualizar">Guardar Cambios</button>
                <a href="admin_panel.php?view=crud" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>