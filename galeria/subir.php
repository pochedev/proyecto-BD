<?php
session_start();
include 'db.php';

// Verificación de seguridad
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'artista') {
    die("Acceso denegado. inicie sesión como artista para continuar");
}

if (isset($_POST['enviar'])) {
    $id_artista = $_SESSION['id'];
    $id_genero = $_POST['id_genero'];
    $nombre_obra = isset($_POST['nombre_obra']) ? mysqli_real_escape_string($conexion, $_POST['nombre_obra']) : 'Sin título';
    
    // Procesamiento de imagen 
    $archivo = $_FILES['foto_obra'];
    $nombreUnico = uniqid()  . "_" . $nombre_obra. "." . pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $rutaFinal = "img/" . $nombreUnico;

    if (move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
        
        $sql = "INSERT INTO obra ( id_artista, id_genero, nombre, status) 
                VALUES ('$id_artista', '$id_genero', '$nombreUnico', 'disponible')";
        
        if (mysqli_query($conexion, $sql)) {
            echo "¡Obra publicada con éxito!";
            header("Refresh:2; url=index.php");
        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    }
}
?>