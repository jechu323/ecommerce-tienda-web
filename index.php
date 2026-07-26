<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tienda Electrónica</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 20px; color: #333; }
        h1, h2 { color: #2c3e50; text-align: center; }
        .container { display: flex; flex-wrap: wrap; justify-content: space-around; gap: 20px; margin-bottom: 30px; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 45%; min-width: 300px; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 10px; font-weight: bold; }
        input, text-area { padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { margin-top: 15px; background-color: #3498db; color: white; border: none; cursor: pointer; font-weight: bold; }
        input[type="submit"]:hover { background-color: #2980b9; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #2c3e50; color: white; }
        .nav-btn { display: inline-block; padding: 10px 15px; background-color: #2ecc71; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-bottom: 20px; }
        .nav-btn:hover { background-color: #27ae60; }
        .cabecera { display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 5px; }
        .cabecera img { width: 60px; height: 60px; }
        h2 { display: flex; align-items: center; justify-content: center; gap: 8px; }
        h2 img { width: 24px; height: 24px; }
        .img-producto { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
        .campo-imagen { display: flex; align-items: center; gap: 10px; margin-top: 5px; }
        .vista-previa { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; display: none; }
        .btn-editar { display: inline-block; background-color: #f39c12; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.9em; }
        .btn-editar:hover { background-color: #d68910; }
    </style>
    <script>
        // Validación básica con JavaScript
        function validarFormulario(tipo) {
            if (tipo === 'producto') {
                let nombre = document.getElementById('p_nombre').value.trim();
                let precio = document.getElementById('p_precio').value;
                let stock = document.getElementById('p_stock').value;
                
                if (nombre === "" || precio <= 0 || stock < 0) {
                    alert("Por favor, ingrese datos válidos para el producto.");
                    return false;
                }
            } else if (tipo === 'cliente') {
                let nombre = document.getElementById('c_nombre').value.trim();
                let email = document.getElementById('c_email').value.trim();
                
                if (nombre === "" || email === "") {
                    alert("Todos los campos del cliente son obligatorios.");
                    return false;
                }
            }
            return true;
        }

        // Muestra una vista previa de la imagen del producto antes de subirla
        function previsualizarImagen(input) {
            const preview = document.getElementById('vista_previa_producto');
            if (input.files && input.files[0]) {
                const lector = new FileReader();
                lector.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'inline-block';
                };
                lector.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</head>
<body>

    <div class="cabecera">
        <img src="assets/logo.svg" alt="Logo Tienda Electrónica">
        <h1>Panel de Control - Tienda Electrónica</h1>
    </div>
    <div style="text-align: center;">
        <a href="compras.php" class="nav-btn">Ir a Módulo de Compras e Informes Avanzados</a>
    </div>

    <div class="container">
        <!-- Formulario Producto -->
        <div class="box">
            <h2><img src="assets/icons/producto.svg" alt="">Registrar Nuevo Producto</h2>
            <form action="procesar.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario('producto')">
                <input type="hidden" name="accion" value="guardar_producto">
                <label for="p_nombre">Nombre del Producto:</label>
                <input type="text" id="p_nombre" name="nombre" required>
                
                <label for="p_desc">Descripción:</label>
                <input type="text" id="p_desc" name="descripcion">
                
                <label for="p_precio">Precio (CLP):</label>
                <input type="number" id="p_precio" name="precio" required>
                
                <label for="p_stock">Stock Inicial:</label>
                <input type="number" id="p_stock" name="stock" required>

                <label for="p_imagen">Foto del Producto:</label>
                <div class="campo-imagen">
                    <input type="file" id="p_imagen" name="imagen_producto" accept="image/png, image/jpeg, image/webp" onchange="previsualizarImagen(this)">
                    <img id="vista_previa_producto" class="vista-previa" alt="Vista previa">
                </div>
                
                <input type="submit" value="Guardar Producto">
            </form>
        </div>

        <!-- Formulario Cliente -->
        <div class="box">
            <h2><img src="assets/icons/cliente.svg" alt="">Registrar Nuevo Cliente</h2>
            <form action="procesar.php" method="POST" onsubmit="return validarFormulario('cliente')">
                <input type="hidden" name="accion" value="guardar_cliente">
                <label for="c_nombre">Nombre Completo:</label>
                <input type="text" id="c_nombre" name="nombre" required>
                
                <label for="c_email">Correo Electrónico:</label>
                <input type="email" id="c_email" name="email" required>
                
                <label for="c_dir">Dirección de Despacho:</label>
                <input type="text" id="c_dir" name="direccion" required>
                
                <input type="submit" value="Guardar Cliente">
            </form>
        </div>
    </div>

    <hr>

    <!-- Visualización Simple de Datos -->
    <h2>Visualización de Registros Actuales (Consultas Simples)</h2>
    <div class="container">
        <div class="box" style="width: 48%;">
            <h3><img src="assets/icons/producto.svg" alt="" style="width:20px;height:20px;vertical-align:middle;"> Tabla PRODUCTO</h3>
            <table>
                <tr><th>Imagen</th><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr>
                <?php
                $sql = "SELECT id_producto, nombre, precio, stock, imagen FROM PRODUCTO";
                $res = $conn->query($sql);
                if ($res && $res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) {
                        $ruta_img = !empty($row['imagen']) ? "uploads/" . htmlspecialchars($row['imagen']) : "uploads/placeholder.png";
                        echo "<tr><td><img class='img-producto' src='{$ruta_img}' alt='Foto de {$row['nombre']}'></td><td>{$row['id_producto']}</td><td>{$row['nombre']}</td><td>\${$row['precio']}</td><td>{$row['stock']}</td><td><a href='editar_producto.php?id={$row['id_producto']}' class='btn-editar'>Editar</a></td></tr>";
                    }
                } else { echo "<tr><td colspan='6'>No hay productos.</td></tr>"; }
                ?>
            </table>
        </div>

        <div class="box" style="width: 48%;">
            <h3><img src="assets/icons/cliente.svg" alt="" style="width:20px;height:20px;vertical-align:middle;"> Tabla CLIENTE</h3>
            <table>
                <tr><th>ID</th><th>Nombre</th><th>Email</th></tr>
                <?php
                $sql = "SELECT id_cliente, nombre, email FROM CLIENTE";
                $res = $conn->query($sql);
                if ($res && $res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) {
                        echo "<tr><td>{$row['id_cliente']}</td><td>{$row['nombre']}</td><td>{$row['email']}</td></tr>";
                    }
                } else { echo "<tr><td colspan='3'>No hay clientes.</td></tr>"; }
                ?>
            </table>
        </div>
    </div>
</body>
</html>