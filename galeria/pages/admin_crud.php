<?php
// admin_crud.php - Se carga dentro de admin_panel.php
include '../scripts/db.php';

// Consultas para obtener los usuarios
$artistas = mysqli_query($conexion, "SELECT id_artista, nombre, apellido, usuario, nacionalidad FROM artista");
$empleados = mysqli_query($conexion, "SELECT id_empleado, nombre, apellido, puesto, salario FROM empleado");
$compradores = mysqli_query($conexion, "SELECT id_comprador, nombre, usuario FROM comprador");
?>

<div class="crud-section">
    <h2>Gestión Global de Usuarios</h2>

    <div class="admin-actions" style="margin-bottom: 25px; padding: 15px; background: #e8f4f8; border-radius: 8px;">
        <strong>Nuevo Registro:</strong> 
        <a href="registro_artista.php" class="btn-new">+ Nuevo Artista</a> | 
        <a href="registro_empleado.php" class="btn-new">+ Nuevo Empleado</a> | 
        <a href="registro_comprador.php" class="btn-new">+ Nuevo Comprador</a>
    </div>

    <h3>Artistas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($art = mysqli_fetch_assoc($artistas)): ?>
            <tr>
                <td><?php echo $art['id_artista']; ?></td>
                <td><?php echo $art['nombre'] . " " . $art['apellido']; ?></td>
                <td><?php echo $art['usuario']; ?></td>
                <td>
                    <a href="actualizar_artista.php?id=<?php echo $art['id_artista']; ?>" class="btn-update">Actualizar</a>
                    <a href="../scripts/eliminar_usuario.php?id=<?php echo $art['id_artista']; ?>&tipo=artista" class="btn-delete" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Compradores</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($com = mysqli_fetch_assoc($compradores)): ?>
            <tr>
                <td><?php echo $com['id_comprador']; ?></td>
                <td><?php echo $com['nombre']; ?></td>
                <td><?php echo $com['usuario']; ?></td>
                <td>
                    <a href="actualizar_comprador.php?id=<?php echo $com['id_comprador']; ?>" class="btn-update">Actualizar</a>
                    <a href="../scripts/eliminar_usuario.php?id=<?php echo $com['id_comprador']; ?>&tipo=comprador" class="btn-delete" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Empleados (Personal)</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($emp = mysqli_fetch_assoc($empleados)): ?>
            <tr>
                <td><?php echo $emp['id_empleado']; ?></td>
                <td><?php echo $emp['nombre'] . " " . $emp['apellido']; ?></td>
                <td><?php echo $emp['puesto']; ?></td>
                <td>
                    <a href="actualizar_empleado.php?id=<?php echo $emp['id_empleado']; ?>" class="btn-update">Actualizar</a>
                    <a href="../scripts/eliminar_usuario.php?id=<?php echo $emp['id_empleado']; ?>&tipo=empleado" class="btn-delete" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>