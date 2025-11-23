<?php
session_start();
include("../conexion.php");

// ----------------------------------------------
// INICIALIZAR COMANDA
// ----------------------------------------------
if (!isset($_SESSION['comanda'])) {
    $_SESSION['comanda'] = [];
}

// ----------------------------------------------
// AGREGAR PRODUCTO A LA COMANDA
// ----------------------------------------------
if (isset($_GET['producto']) && isset($_GET['precio'])) {

    $_SESSION['comanda'][] = [
        'nombre' => $_GET['producto'],
        'precio' => floatval($_GET['precio']),
        'cantidad' => 1
    ];

    header("Location: ver_comanda.php");
    exit;
}

// ----------------------------------------------
// AUMENTAR CANTIDAD
// ----------------------------------------------
if (isset($_GET['sumar'])) {
    $id = $_GET['sumar'];

    if (isset($_SESSION['comanda'][$id])) {
        $_SESSION['comanda'][$id]['cantidad'] += 1;
    }

    header("Location: ver_comanda.php");
    exit;
}

// ----------------------------------------------
// RESTAR CANTIDAD
// ----------------------------------------------
if (isset($_GET['restar'])) {
    $id = $_GET['restar'];

    if (isset($_SESSION['comanda'][$id])) {
        $_SESSION['comanda'][$id]['cantidad'] -= 1;

        if ($_SESSION['comanda'][$id]['cantidad'] <= 0) {
            unset($_SESSION['comanda'][$id]);
            $_SESSION['comanda'] = array_values($_SESSION['comanda']);
        }
    }

    header("Location: ver_comanda.php");
    exit;
}

// ----------------------------------------------
// QUITAR ALIMENTO
// ----------------------------------------------
if (isset($_GET['quitar'])) {
    $id = $_GET['quitar'];
    if (isset($_SESSION['comanda'][$id])) {
        unset($_SESSION['comanda'][$id]);
        $_SESSION['comanda'] = array_values($_SESSION['comanda']);
    }
    header("Location: ver_comanda.php");
    exit();
}

// ----------------------------------------------
// REINICIAR COMANDA
// ----------------------------------------------
if (isset($_GET['reiniciar'])) {
    unset($_SESSION['comanda']);
    $_SESSION['comanda'] = [];
    header("Location: ver_comanda.php");
    exit();
}

// ----------------------------------------------
// OBTENER EMPLEADOS
// ----------------------------------------------
$empleados = $conn->query("SELECT id, nombre FROM empleados");

// ----------------------------------------------
// FINALIZAR VENTA
// ----------------------------------------------
if (isset($_POST['finalizar'])) {

    $empleado = $_POST['empleado'];
    $propina = floatval($_POST['propina']);
    $total = floatval($_POST['total']);

    $monto_final = $total + $propina;

    // Insertar venta con propina
    $insert = "INSERT INTO ventas (monto, usuario, fecha, propina)
               VALUES ('$monto_final', '$empleado', NOW(), '$propina')";

    $conn->query($insert);

    // Obtener ID generado
    $id_venta = $conn->insert_id;

    // Insertar detalle de venta
    foreach ($_SESSION['comanda'] as $item) {
        $nombre = $item['nombre'];
        $precio = $item['precio'];
        $cantidad = $item['cantidad'];

        $conn->query("INSERT INTO ventas_detalle (venta_id, producto, precio, cantidad)
                      VALUES ('$id_venta', '$nombre', '$precio', '$cantidad')");
    }

    // Vaciar comanda
    unset($_SESSION['comanda']);
    $_SESSION['comanda'] = [];

    // Redirigir al ticket
    header("Location: ventas_confirmacion.php?id=" . $id_venta);
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Comanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    <a href="menu.php" class="btn btn-primary mb-3">⬅ Regresar al menú</a>

    <h2 class="mb-4 text-center">Comanda Actual</h2>

    <!-- TABLA DE COMANDA -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Alimento</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $total = 0;
        foreach ($_SESSION['comanda'] as $id => $alimento) {

            $subtotal = $alimento['precio'] * $alimento['cantidad'];
            $total += $subtotal;

            echo "
            <tr>
                <td>{$alimento['nombre']}</td>
                <td>\${$alimento['precio']}</td>

                <td>
                    <a href='ver_comanda.php?restar=$id' class='btn btn-danger btn-sm'>-</a>
                    <span class='mx-2'>{$alimento['cantidad']}</span>
                    <a href='ver_comanda.php?sumar=$id' class='btn btn-success btn-sm'>+</a>
                </td>

                <td>\$".$subtotal."</td>

                <td><a href='ver_comanda.php?quitar=$id' class='btn btn-danger btn-sm'>Eliminar</a></td>
            </tr>
            ";
        }
        ?>
        </tbody>
    </table>

    <h3 class="text-end">Total: $<?php echo $total; ?></h3>

    <a href="ver_comanda.php?reiniciar=1" class="btn btn-warning mb-3">Reiniciar Comanda</a>

    <hr>

    <!-- FORMULARIO FINALIZAR VENTA -->
    <h4>Finalizar Venta</h4>

    <form action="" method="POST" class="p-3 bg-white shadow rounded">

        <label class="form-label">Empleado que atendió:</label>
        <select name="empleado" class="form-select mb-3" required>
            <option value="">Selecciona un empleado</option>
            <?php
            while ($e = $empleados->fetch_assoc()) {
                echo "<option value='{$e['nombre']}'>{$e['nombre']}</option>";
            }
            ?>
        </select>

        <label class="form-label">Propina:</label>
        <input type="number" name="propina" class="form-control mb-3" placeholder="0" min="0" required>

        <input type="hidden" name="total" value="<?php echo $total; ?>">

        <button name="finalizar" class="btn btn-success w-100">Finalizar Venta</button>
    </form>

</div>

</body>
</html>