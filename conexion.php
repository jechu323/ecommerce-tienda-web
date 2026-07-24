<?php
// Parámetros de configuración de la conexión
$servername = "localhost"; // Servidor local
$username = "root";        // Usuario administrador predeterminado de XAMPP
$password = "";            // Contraseña vacía por defecto en XAMPP
$dbname = "TIENDA";        // Nombre de la base de datos a conectar

// Creación de la conexión utilizando la extensión MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificación de la conexión
if ($conn->connect_error) {
    die("Error crítico de conexión: " . $conn->connect_error);
}
// Conexión exitosa establecida de forma segura
?>