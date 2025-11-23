<?php
require '../conexion.php';

if (!isset($_GET['id'])) {
    die("Error: No se recibió ID de venta.");
}

$id_venta = $_GET['id'];

// Obtener datos de la venta
$sql = "SELECT * FROM ventas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_venta);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Venta no encontrada.");
}

$venta = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket de venta</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border: 2px dashed #000;
        }
        h2 {
            text-align: center;
        }
        .linea {
            border-bottom: 1px dashed black;
            margin: 10px 0;
        }
        .totales {
            font-size: 18px;
            font-weight: bold;
        }
        .volver {
            display: inline-block;
            padding: 10px 15px;
            background: #00954c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <h2>🧾 Ticket de Venta</h2>

    <div class="linea"></div>

    <p><strong>Folio:</strong> <?= $venta['id'] ?></p>
    <p><strong>Fecha:</strong> <?= $venta['fecha'] ?></p>
    <p><strong>Empleado:</strong> <?= htmlspecialchars($venta['usuario']) ?></p>

    <div class="linea"></div>

    <p><strong>Total comida:</strong> $<?= number_format($venta['monto'] - $venta['propina'], 2) ?></p>
    <p><strong>Propina:</strong> $<?= number_format($venta['propina'], 2) ?></p>

    <p class="totales">Total pagado: $<?= number_format($venta['monto'], 2) ?></p>

    <div class="linea"></div>

    <p style="text-align:center;">¡Gracias por su compra! 🙌</p>

    <a class="volver" href="menu.php">Volver al menú</a>

</body>
</html>