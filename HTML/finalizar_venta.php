<?php
session_start();
require '../conexion.php';

if (!isset($_POST['usuario']) || !isset($_POST['total'])) {
    die("Error: Datos incompletos.");
}

$usuario = $_POST['usuario'];
$total = $_POST['total'];
$propina = isset($_POST['propina']) && $_POST['propina'] !== "" ? $_POST['propina'] : 0;

// TOTAL FINAL (comida + propina)
$monto_final = $total + $propina;

// Insertar en tabla ventas con propina
$sql = "INSERT INTO ventas (fecha, monto, usuario, propina) VALUES (NOW(), ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("dss", $monto_final, $usuario, $propina);
$stmt->execute();

// Obtener ID de venta recién insertado
$id_venta = $stmt->insert_id;

// Limpiar comanda
unset($_SESSION['comanda']);

// Redirigir al ticket
header("Location: ventas_confirmacion.php?id=".$id_venta);
exit;
?>