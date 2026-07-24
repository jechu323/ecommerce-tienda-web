<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    // Procesamiento del Registro de Productos
    if ($accion === 'guardar_producto') {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $precio = intval($_POST['precio']);
        $stock = intval($_POST['stock']);

        if (!empty($nombre) && $precio > 0 && $stock >= 0) {
            $sql = "INSERT INTO PRODUCTO (nombre, descripcion, precio, stock) VALUES ('$nombre', '$descripcion', $precio, $stock)";
            if ($conn->query($sql) === TRUE) {
                header("Location: index.php?msg=producto_ok");
            } else { echo "Error: " . $conn->error; }
        }

    // Procesamiento del Registro de Clientes
    } elseif ($accion === 'guardar_cliente') {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $email = $conn->real_escape_string($_POST['email']);
        $direccion = $conn->real_escape_string($_POST['direccion']);

        if (!empty($nombre) && !empty($email) && !empty($direccion)) {
            $sql = "INSERT INTO CLIENTE (nombre, email, direccion) VALUES ('$nombre', '$email', '$direccion')";
            if ($conn->query($sql) === TRUE) {
                header("Location: index.php?msg=cliente_ok");
            } else { echo "Error: " . $conn->error; }
        }
        
    // Procesamiento del Registro de Compras
    } elseif ($accion === 'guardar_compra') {
        $id_cliente = intval($_POST['id_cliente']);
        $id_producto = intval($_POST['id_producto']);
        $cantidad = intval($_POST['cantidad']);
        $fecha = $_POST['fecha'];

        // Obtener datos del producto para calcular el total
        $p_res = $conn->query("SELECT precio FROM PRODUCTO WHERE id_producto = $id_producto");
        if ($p_res && $p_res->num_rows > 0) {
            $prod = $p_res->fetch_assoc();
            $total = $prod['precio'] * $cantidad;

            $sql = "INSERT INTO COMPRA (cantidad, total, fecha, id_producto, id_cliente) VALUES ($cantidad, $total, '$fecha', $id_producto, $id_cliente)";
            if ($conn->query($sql) === TRUE) {
                header("Location: compras.php?msg=compra_ok");
            } else { echo "Error: " . $conn->error; }
        }
    }
}
$conn->close();
?>