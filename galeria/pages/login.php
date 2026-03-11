<?php
session_start();
include '../scripts/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $pass = $_POST['password'];

    // Arreglo de tablas y roles para buscar secuencialmente
    $tablas = [
        'artista' => 'id_artista',
        'comprador' => 'id_comprador',
        'empleado' => 'CI'
    ];

    $encontrado = false;

    foreach ($tablas as $tabla => $id_col) {
        $query = "SELECT * FROM $tabla WHERE usuario = '$user'";
        $res = mysqli_query($conexion, $query);
        
        if ($fila = mysqli_fetch_assoc($res)) {
            if (password_verify($pass, $fila['password'])) {
                // ... (dentro del if de password_verify)
                $_SESSION['id'] = $fila[$id_col];
                $rolFinal = ($tabla == 'empleado') ? $fila['puesto'] : $tabla;
                $_SESSION['rol'] = $rolFinal;
                $_SESSION['nombre'] = $fila['nombre'];

                // Redirección inteligente basada en el ROL
                if ($rolFinal === 'admin') {
                    header("Location: admin_panel.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        }
    }
    $error = "Usuario o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Galería de Arte</title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Iniciar Sesión</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <p>¿No tienes cuenta? Regístrate como <a href="registro_artista.php">Artista</a> o <a href="registro_comprador.php">Comprador</a></p>
    </div>
</body>
</html>