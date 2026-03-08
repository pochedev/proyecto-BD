<?php
// db.php - Archivo de conexión
include '../scripts/db.php'; 

// Consultar las imágenes de la base de datos
$query = "SELECT nombre FROM obra ORDER BY fecha_publicacion DESC";
$resultado = mysqli_query($conexion, $query);
?>

<head>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <!-- formulario para ingresar imgs -->
    <a href="login.php">Cerrar Sesión</a>
<form action="../scripts/subir.php" method="POST" enctype="multipart/form-data">
    <h2>Subir nueva obra</h2>
    <input type="file" name="foto_obra" required>
    <label>Nombre de la obra:</label>
    <input type="text" name="nombre_obra" placeholder="Título de la obra" required>
    <label>Precio de la obra:</label>
    <input type="number" name="precio" placeholder="precio de la obra" required>
    <label>Género de la obra:</label>
    <select name="id_genero" required>
        <option value="1">Pintura</option>
        <option value="2">Escultura</option>
        <option value="3">Fotografía</option>
        <option value="4">Cerámica</option>
        <option value="5">Orfebrería</option>
    </select>
    <button type="submit" name="enviar">Publicar Imagen</button>
</form>
<!-- -------------------------------------- -->

<!-- contenedor de galeria -->
<div class="galeria-container">
    <?php
    // Mientras haya filas en el resultado, imprimimos una imagen
    while ($fila = mysqli_fetch_assoc($resultado)) {
    $nombreImagen = $fila['nombre'];
    $rutaCompleta = "../resources/" . $nombreImagen;

    // file_exists verifica si el archivo realmente está en la carpeta
    if (file_exists($rutaCompleta)) {
        ?>
        <div class="foto-card">
            <img src="<?php echo $rutaCompleta; ?>" alt="<?php echo $nombreImagen; ?>">
        </div>
        <?php
    } else {
        // Opcional: Mostrar un mensaje o una imagen por defecto
        echo "error en la BD, no esta en la carpeta img";
    }
}
    ?>
</div>    
</body>
