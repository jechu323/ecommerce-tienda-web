<?php
/**
 * NOTA: Este archivo procesar.php no estaba entre los archivos que me compartiste,
 * así que lo generé desde cero basándome en los campos de los formularios de
 * index.php y compras.php. Si ya tenías un procesar.php con más lógica
 * (validaciones, redirecciones, etc.), fusiona esa lógica con el manejo de
 * subida de imagen que se agregó aquí en la sección "guardar_producto".
 */

include 'conexion.php';

$accion = $_POST['accion'] ?? '';

switch ($accion) {

    case 'guardar_producto':
        $nombre      = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio      = $_POST['precio'];
        $stock       = $_POST['stock'];
        $nombre_imagen = null;

        // Manejo de la subida de la foto del producto (campo: imagen_producto)
        if (isset($_FILES['imagen_producto']) && $_FILES['imagen_producto']['error'] === UPLOAD_ERR_OK) {
            $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
            $tipo_archivo = mime_content_type($_FILES['imagen_producto']['tmp_name']);

            if (in_array($tipo_archivo, $permitidos)) {
                $carpeta_destino = __DIR__ . '/uploads/';
                if (!is_dir($carpeta_destino)) {
                    mkdir($carpeta_destino, 0755, true);
                }

                $extension = pathinfo($_FILES['imagen_producto']['name'], PATHINFO_EXTENSION);
                $nombre_imagen = 'producto_' . uniqid() . '.' . strtolower($extension);
                $ruta_destino = $carpeta_destino . $nombre_imagen;

                if (!move_uploaded_file($_FILES['imagen_producto']['tmp_name'], $ruta_destino)) {
                    $nombre_imagen = null; // Si falla la subida, se guarda el producto sin imagen
                }
            }
        }

        if ($nombre_imagen !== null) {
            $stmt = $conn->prepare("INSERT INTO PRODUCTO (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $stock, $nombre_imagen);
        } else {
            $stmt = $conn->prepare("INSERT INTO PRODUCTO (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);
        }
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit;

    case 'guardar_cliente':
        $nombre    = $_POST['nombre'];
        $email     = $_POST['email'];
        $direccion = $_POST['direccion'];

        $stmt = $conn->prepare("INSERT INTO CLIENTE (nombre, email, direccion) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $direccion);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit;

    case 'guardar_compra':
        $id_cliente  = $_POST['id_cliente'];
        $id_producto = $_POST['id_producto'];
        $cantidad    = $_POST['cantidad'];
        $fecha       = $_POST['fecha'];

        // Se calcula el total en base al precio actual del producto
        $stmt_precio = $conn->prepare("SELECT precio FROM PRODUCTO WHERE id_producto = ?");
        $stmt_precio->bind_param("i", $id_producto);
        $stmt_precio->execute();
        $resultado = $stmt_precio->get_result()->fetch_assoc();
        $stmt_precio->close();

        $total = $resultado ? $resultado['precio'] * $cantidad : 0;

        $stmt = $conn->prepare("INSERT INTO COMPRA (id_cliente, id_producto, cantidad, total, fecha) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiids", $id_cliente, $id_producto, $cantidad, $total, $fecha);
        $stmt->execute();
        $stmt->close();

        header("Location: compras.php");
        exit;

    default:
        header("Location: index.php");
        exit;
}
