<?php include 'conexion.php'; ?>
<?php
$id_producto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT id_producto, nombre, descripcion, precio, stock, imagen FROM PRODUCTO WHERE id_producto = ?");
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$producto) {
    die("Producto no encontrado. <a href='index.php'>Volver al panel</a>");
}

$ruta_img_actual = !empty($producto['imagen']) ? "uploads/" . htmlspecialchars($producto['imagen']) : "uploads/placeholder.png";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 20px; color: #333; }
        h1, h2 { color: #2c3e50; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 450px; margin: 0 auto; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 10px; font-weight: bold; }
        input { padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { margin-top: 15px; background-color: #3498db; color: white; border: none; cursor: pointer; font-weight: bold; padding: 10px; }
        input[type="submit"]:hover { background-color: #2980b9; }
        .btn-back { display: inline-block; background-color: #7f8c8d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .cabecera { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .cabecera img { width: 50px; height: 50px; }
        .imagen-actual { display: flex; align-items: center; gap: 15px; margin-top: 5px; }
        .imagen-actual img { width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
        .vista-previa { width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; display: none; }
    </style>
    <script>
        function validarEdicion() {
            let nombre = document.getElementById('e_nombre').value.trim();
            let precio = document.getElementById('e_precio').value;
            let stock = document.getElementById('e_stock').value;
            if (nombre === "" || precio <= 0 || stock < 0) {
                alert("Por favor, ingrese datos válidos para el producto.");
                return false;
            }
            return true;
        }
        function previsualizarImagen(input) {
            const preview = document.getElementById('vista_previa_edicion');
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

    <a href="index.php" class="btn-back">← Volver al Panel Principal</a>
    <div class="cabecera">
        <img src="assets/icons/producto.svg" alt="">
        <h1>Editar Producto</h1>
    </div>

    <div class="box">
        <form action="procesar.php" method="POST" enctype="multipart/form-data" onsubmit="return validarEdicion()">
            <input type="hidden" name="accion" value="actualizar_producto">
            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
            <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($producto['imagen'] ?? ''); ?>">

            <label for="e_nombre">Nombre del Producto:</label>
            <input type="text" id="e_nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>

            <label for="e_desc">Descripción:</label>
            <input type="text" id="e_desc" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?>">

            <label for="e_precio">Precio (CLP):</label>
            <input type="number" id="e_precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>

            <label for="e_stock">Stock:</label>
            <input type="number" id="e_stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>

            <label>Foto Actual:</label>
            <div class="imagen-actual">
                <img src="<?php echo $ruta_img_actual; ?>" alt="Foto actual del producto">
                <span>↳ Sube una nueva imagen abajo solo si quieres reemplazarla</span>
            </div>

            <label for="e_imagen">Reemplazar Foto (opcional):</label>
            <div class="imagen-actual">
                <input type="file" id="e_imagen" name="imagen_producto" accept="image/png, image/jpeg, image/webp" onchange="previsualizarImagen(this)">
                <img id="vista_previa_edicion" class="vista-previa" alt="Vista previa">
            </div>

            <input type="submit" value="Guardar Cambios">
        </form>
    </div>

</body>
</html>
