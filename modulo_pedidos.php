<?php
// modulo_pedidos.php - Gestión de Pedidos del Carrito
function procesarPedido($idUsuario, $productos, $montoTotal) {
    if (empty($productos) || $montoTotal <= 0) {
        return array("status" => "error", "message" => "El carrito se encuentra vacío.");
    }
    
    // Simulación de inserción en Base de Datos de Pedidos
    $idPedido = rand(1000, 9999);
    
    return array(
        "status" => "success",
        "id_pedido" => $idPedido,
        "message" => "Pedido registrado exitosamente."
    );
}
?>
