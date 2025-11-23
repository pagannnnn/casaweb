<?php
session_start();
include '../conexion.php';

$session_id = session_id();
$producto = $_GET['producto'];
$precio = $_GET['precio'];

// 1. Verificamos si el producto existe en la comanda
$sql = "SELECT * FROM comanda WHERE session_id='$session_id' AND producto='$producto'";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    // Si ya existe → sumamos 1
    $conn->query("UPDATE comanda 
                  SET cantidad = cantidad + 1 
                  WHERE session_id='$session_id' 
                  AND producto='$producto'");
} else {
    // Si no existe → insertamos
    $conn->query("INSERT INTO comanda (session_id, producto, precio, cantidad)
                  VALUES ('$session_id', '$producto', '$precio', 1)");
}

// 2. Descontamos inventario en inventario_menu
$descontar = $conn->query(
    "UPDATE inventario_menu 
     SET cantidad = cantidad - 1 
     WHERE nombre = '$producto'"
);

// Si quieres evitar que baje de 0, activa esto:
// $conn->query("UPDATE inventario_menu SET cantidad = 0 WHERE cantidad < 0");

// 3. Regresar al menú
header("Location: menu.php");
exit;
?>