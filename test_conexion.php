<?php
// Mostrar errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Probar include
echo "Antes del require<br>";

require "conexion.php";

echo "Después del require<br>";
echo "Conectado correctamente";
?>