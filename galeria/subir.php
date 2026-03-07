<?php
include 'db.php';

if (isset($_POST['enviar'])) {
    $archivo = $_FILES['foto_obra'];
    $nombreOriginal = $archivo['name'];
    $rutaTemporal = $archivo['tmp_name'];

    // 1. Extraer la extensión del archivo (jpg, png, etc.)
    $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

    // 2. Generar un nombre único
    // uniqid() crea algo como '65a1b2', y lo unimos con el nombre original
    $nombreLimpio = pathinfo($nombreOriginal, PATHINFO_FILENAME);
    $nombreUnico = uniqid() . "_" . $nombreLimpio . "." . $extension;

    // 3. Definir la ruta final con el nombre nuevo
    $carpetaDestino = "img/";
    $rutaFinal = $carpetaDestino . $nombreUnico;

    // 4. Mover e insertar
    if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
        
        // IMPORTANTE: Guardamos $nombreUnico en la base de datos
        $sql = "INSERT INTO obra (descripcion) VALUES ('$nombreUnico')";
        
        if (mysqli_query($conexion, $sql)) {
            echo "¡Obra guardada como: $nombreUnico!";
            header("Refresh:2; url=index.php");
        } else {
            echo "Error en BD: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al subir el archivo.";
    }
}
?>