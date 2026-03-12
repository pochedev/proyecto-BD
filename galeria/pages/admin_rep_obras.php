<?php
include '../scripts/db.php';

// Consulta para obtener las obras con status 'vendida'
// Unimos con artista para saber quién la hizo y con venta/comprador para saber quién la compró
$query = "SELECT o.nombre AS titulo_obra, 
                 o.precio AS precio_base, 
                 a.nombre AS nombre_artista, 
                 a.apellido AS apellido_artista,
                 c.nombre AS nombre_comprador, 
                 v.fecha AS fecha_venta,
                 v.total AS monto_total
          FROM obra o
          JOIN artista a ON o.id_artista = a.id_artista
          JOIN venta v ON o.id_obra = v.id_obra
          JOIN comprador c ON v.id_comprador = c.id_comprador
          WHERE o.status = 'vendida'
          ORDER BY v.fecha DESC";

$resultado = mysqli_query($conexion, $query);
?>

<div class="reporte-obras">
    <h2>Catálogo de Obras Vendidas</h2>
    <p>Listado histórico de piezas que ya no forman parte del inventario disponible.</p>

    <table>
        <thead>
            <tr>
                <th>Obra</th>
                <th>Artista</th>
                <th>Comprador</th>
                <th>Fecha de Venta</th>
                <th>Precio Base</th>
                <th>Total Facturado</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($resultado) > 0):
                while($reg = mysqli_fetch_assoc($resultado)): 
            ?>
                <tr>
                    <td><strong><?php echo $reg['titulo_obra']; ?></strong></td>
                    <td><?php echo $reg['nombre_artista'] . " " . $reg['apellido_artista']; ?></td>
                    <td><?php echo $reg['nombre_comprador']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($reg['fecha_venta'])); ?></td>
                    <td>$<?php echo number_format($reg['precio_base'], 2); ?></td>
                    <td>$<?php echo number_format($reg['monto_total'], 2); ?></td>
                </tr>
            <?php 
                endwhile; 
            else:
            ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No se han registrado ventas aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>