<?php
// db.php - Archivo de conexión (asegúrate de tenerlo configurado)
include 'db.php'; 

// Consultar las imágenes de la base de datos
$query = "SELECT descripcion FROM obra ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $query);
?>

<!-- formulario para ingresar imgs -->
<form action="subir.php" method="POST" enctype="multipart/form-data">
    <h2>Subir nueva obra</h2>
    <input type="file" name="foto_obra" required>
    <button type="submit" name="enviar">Publicar Imagen</button>
</form>
<!-- -------------------------------------- -->

<!-- contenedor de galeria -->
<div class="galeria-container">
    <?php
    // Mientras haya filas en el resultado, imprimimos una imagen
    while ($fila = mysqli_fetch_assoc($resultado)) {
    $nombreImagen = $fila['descripcion'];
    $rutaCompleta = "img/" . $nombreImagen;

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