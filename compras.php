<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Compras e Informes Avanzados</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 20px; color: #333; }
        h1, h2, h3 { color: #2c3e50; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #2c3e50; color: white; }
        form { display: flex; flex-direction: column; max-width: 400px; }
        label { margin-top: 10px; font-weight: bold; }
        select, input { padding: 8px; margin-top: 5px; }
        .btn { background-color: #3498db; color: white; border: none; padding: 10px; cursor: pointer; font-weight: bold; margin-top: 15px; }
        .btn-back { display: inline-block; background-color: #7f8c8d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <a href="index.php" class="btn-back">← Volver al Panel Principal</a>
    <h1>Módulo de Transacciones de Compra</h1>

    <!-- Formulario para Registrar Compras operacionales -->
    <div class="box">
        <h2>Registrar Nueva Operación de Compra</h2>
        <form action="procesar.php" method="POST">
            <input type="hidden" name="accion" value="guardar_compra">
            
            <label for="id_cliente">Seleccione Cliente:</label>
            <select name="id_cliente" id="id_cliente" required>
                <?php
                $clie = $conn->query("SELECT id_cliente, nombre FROM CLIENTE");
                while($c = $clie->fetch_assoc()) { echo "<option value='{$c['id_cliente']}'>{$c['nombre']}</option>"; }
                ?>
            </select>

            <label for="id_producto">Seleccione Producto:</label>
            <select name="id_producto" id="id_producto" required>
                <?php
                $prod = $conn->query("SELECT id_producto, nombre, precio FROM PRODUCTO");
                while($p = $prod->fetch_assoc()) { echo "<option value='{$p['id_producto']}'>{$p['nombre']} (\${$p['precio']})</option>"; }
                ?>
            </select>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" min="1" value="1" required>

            <label for="fecha">Fecha de Compra:</label>
            <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>

            <input type="submit" class="btn" value="Registrar Compra">
        </form>
    </div>

    <!-- Consulta Simple: Tabla COMPRA -->
    <div class="box">
        <h2>Listado General de Compras (Consulta Simple MySQL)</h2>
        <table>
            <tr><th>ID Compra</th><th>Cliente</th><th>Producto</th><th>Cantidad</th><th>Total</th><th>Fecha</th></tr>
            <?php
            $sql = "SELECT c.id_compra, cl.nombre AS cliente, p.nombre AS producto, c.cantidad, c.total, c.fecha 
                    FROM COMPRA c
                    INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
                    INNER JOIN PRODUCTO p ON c.id_producto = p.id_producto
                    ORDER BY c.id_compra DESC";
            $res = $conn->query($sql);
            if ($res && $res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo "<tr><td>{$row['id_compra']}</td><td>{$row['cliente']}</td><td>{$row['producto']}</td><td>{$row['cantidad']}</td><td>\${$row['total']}</td><td>{$row['fecha']}</td></tr>";
                }
            } else { echo "<tr><td colspan='6'>No se han registrado compras aún.</td></tr>"; }
            ?>
        </table>
    </div>

    <!-- Consulta Avanzada Requerida -->
    <div class="box" style="border-left: 5px solid #e74c3c;">
        <h2>Informe Avanzado: Clientes con más de 2 Compras</h2>
        <p>Esta consulta calcula dinámicamente la cantidad de compras realizadas por cada cliente y filtra únicamente a aquellos con alta frecuencia de transacciones (> 2).</p>
        <table>
            <tr><th>Nombre del Cliente</th><th>Correo Electrónico</th><th>Cantidad de Compras Registradas</th></tr>
            <?php
            // Consulta avanzada combinando tablas, agrupando y aplicando HAVING
            $sql_avanzada = "SELECT cl.nombre, cl.email, COUNT(co.id_compra) AS total_compras
                             FROM CLIENTE cl
                             INNER JOIN COMPRA co ON cl.id_cliente = co.id_cliente
                             GROUP BY cl.id_cliente, cl.nombre, cl.email
                             HAVING total_compras > 2
                             ORDER BY total_compras DESC";
            
            $res_avanzada = $conn->query($sql_avanzada);
            if ($res_avanzada && $res_avanzada->num_rows > 0) {
                while($row = $res_avanzada->fetch_assoc()) {
                    echo "<tr><td><strong>{$row['nombre']}</strong></td><td>{$row['email']}</td><td>{$row['total_compras']} compras</td></tr>";
                }
            } else { echo "<tr><td colspan='3'>Ningún cliente posee más de 2 compras registradas en este momento.</td></tr>"; }
            ?>
        </table>
    </div>
 <p>Pie de Pagina - 2026</p>
</body>
</html>
