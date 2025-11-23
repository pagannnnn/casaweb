<?php
session_start();

if (!isset($_SESSION['empleado_activo'])) {
    header("Location: ../../index.php");
    exit;
}

$empleado = $_SESSION['empleado_activo'];
$id_empleado = $empleado['id'];

require_once "../../conexion.php";

// Mes y año actual
$mes = date("n");
$anio = date("Y");

// =============================
// 1. OBTENER DATOS DE PAGOS
// =============================
$sql = "SELECT salario_base, bonos, descuentos, pago_neto 
        FROM pagos
        WHERE id_empleado = $id_empleado
        AND mes = $mes
        AND anio = $anio";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $pago = $resultado->fetch_assoc();
} else {
    $pago = [
        "salario_base" => 0,
        "bonos" => 0,
        "descuentos" => 0,
        "pago_neto" => 0
    ];
}

// =============================
// 2. SUMA DE PROPINAS DEL MES
// =============================
$sqlPropinas = "SELECT SUM(propina) AS total_propinas
                FROM ventas
                WHERE usuario = '{$empleado['nombre']}'
                AND MONTH(fecha) = $mes
                AND YEAR(fecha) = $anio";

$resPropinas = $conn->query($sqlPropinas);
$propinas = $resPropinas->fetch_assoc();
$total_propinas = $propinas["total_propinas"] ?? 0;

// =============================
// 3. CÁLCULO DEL PAGO TOTAL
// =============================
$pago_total = 
    $pago["salario_base"] +
    $pago["bonos"] +
    $total_propinas -
    $pago["descuentos"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago del Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
.navbar-principal {
    background: #067A0F !important;
    padding: 12px 30px;
}

.logo-empleado {
    height: 55px;
    background: white;
    padding: 3px;
    border-radius: 5px;
}

.navbar-principal .nav-link {
    color: white !important;
    font-weight: bold;
    transition: 0.2s;
}

.navbar-principal .nav-link:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

header {
    background: #009900d2;
    padding: 40px;
}
</style>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-principal">
  <div class="container-fluid">

    <a class="navbar-brand" href="empleado.php">
      <img src="../../imagenes/logo.png" class="logo-empleado" alt="Logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MenuEmpleado">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="MenuEmpleado">
      <ul class="navbar-nav mb-2 mb-lg-0" style="gap:35px;">

        <li class="nav-item">
          <a class="nav-link" href="./empleado.php">Información Personal</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./horario.php">Horario Semanal</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./pago.php">Pago</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./vacaciones.php">Vacaciones</a>
        </li>

      </ul>
    </div>

    <div class="ms-auto">
      <a href="../../logout.php" class="btn btn-danger fw-bold">Cerrar Sesión</a>
    </div>

  </div>
</nav>


<div class="container mt-5">
    <div class="card shadow p-4">

        <h3 class="mb-4">Pago correspondiente a <?php echo "$mes / $anio"; ?></h3>

        <table class="table table-bordered">

            <tr>
                <th>Empleado</th>
                <td><?php echo $empleado["nombre"]; ?></td>
            </tr>

            <tr>
                <th>Salario Base</th>
                <td>$<?php echo number_format($pago["salario_base"], 2); ?></td>
            </tr>

            <tr>
                <th>Bonos</th>
                <td>$<?php echo number_format($pago["bonos"], 2); ?></td>
            </tr>

            <tr>
                <th>Descuentos</th>
                <td>$<?php echo number_format($pago["descuentos"], 2); ?></td>
            </tr>

            <tr>
                <th>Propinas del Mes</th>
                <td>$<?php echo number_format($total_propinas, 2); ?></td>
            </tr>

            <tr class="table-success">
                <th><b>Pago Total</b></th>
                <td><b>$<?php echo number_format($pago_total, 2); ?></b></td>
            </tr>

        </table>

        <?php if ($pago["salario_base"] == 0): ?>
            <p class="text-danger mt-3">* Aún no se ha registrado tu pago para este mes.</p>
        <?php endif; ?>

    </div>
</div>

</body>
</html>