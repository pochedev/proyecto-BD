<?php
include '../scripts/db.php';

// 1. Capturar rango de fechas (por defecto el mes actual)
$fecha_inicio = $_POST['desde'] ?? date('Y-m-01');
$fecha_fin = $_POST['hasta'] ?? date('Y-m-d');

// 2. Consulta SQL con funciones de agregado: SUM para dinero y COUNT para cantidad
$query = "SELECT 
            COUNT(id_venta) as total_facturas, 
            SUM(precio_venta) as subtotal,
            SUM(IVA) as total_iva,
            SUM(tarifa_museo) as total_ganancia_museo,
            SUM(total) as gran_total
          FROM venta 
          WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";

$res = mysqli_query($conexion, $query);
$datos = mysqli_fetch_assoc($res);

// Guardamos el conteo en una variable clara
$numero_de_facturas = $datos['total_facturas'] ?? 0;
?>

<div class="reporte-container">
    <h2>Resumen de Facturación y Actividad</h2>

    <form method="POST" class="filter-bar">
        <span>Periodo:</span>
        <input type="date" name="desde" value="<?php echo $fecha_inicio; ?>">
        <input type="date" name="hasta" value="<?php echo $fecha_fin; ?>">
        <button type="submit">Actualizar Reporte</button>
    </form>

    <div class="kpi-grid">
        <div class="kpi-card highlight">
            <h3>Facturas Realizadas</h3>
            <p class="number"><?php echo $numero_de_facturas; ?></p>
            <span>Documentos emitidos</span>
        </div>

        <div class="kpi-card">
            <h3>Recaudación Bruta</h3>
            <p class="number">$<?php echo number_format($datos['gran_total'] ?? 0, 2); ?></p>
            <span>Total clientes</span>
        </div>

        <div class="kpi-card">
            <h3>Comisiones Museo</h3>
            <p class="number" style="color: #27ae60;">$<?php echo number_format($datos['total_ganancia_museo'] ?? 0, 2); ?></p>
            <span>Ganancia neta (15%)</span>
        </div>
    </div>

    <h3>Desglose de Facturas</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nro. Factura</th>
                <th>Fecha</th>
                <th>Monto Obra</th>
                <th>IVA (16%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $detalle = mysqli_query($conexion, "SELECT * FROM venta WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' ORDER BY id_venta DESC");
            if(mysqli_num_rows($detalle) > 0){
                while($v = mysqli_fetch_assoc($detalle)){
                    echo "<tr>
                            <td>#{$v['id_venta']}</td>
                            <td>".date("d/m/Y", strtotime($v['fecha']))."</td>
                            <td>$".number_format($v['precio_venta'], 2)."</td>
                            <td>$".number_format($v['IVA'], 2)."</td>
                            <td><strong>$".number_format($v['total'], 2)."</strong></td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>No hay facturas registradas en este periodo.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>