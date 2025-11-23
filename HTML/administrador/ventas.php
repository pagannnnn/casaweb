<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../conexion.php";

// INSERTAR
if (isset($_POST["accion"]) && $_POST["accion"] === "insertar") {
    $fecha = $_POST["fecha"];
    $usuario = $_POST["usuario"];
    $monto = $_POST["monto"];
    $propina = $_POST["propina"];

    $sql = "INSERT INTO ventas (fecha, usuario, monto, propina)
            VALUES ('$fecha', '$usuario', '$monto', '$propina')";
    $conn->query($sql);
}

// CONSULTA PRINCIPAL
$result = $conn->query("SELECT * FROM ventas ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ventas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

 <style>
  .navbar-fija {
      position: sticky;
      top: 0;
      z-index: 9999;
      background: white;
      padding: 10px 25px;
      border-bottom: 3px solid #cccccc7a;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }
  .logo-nav {
      height: 60px;
      border-radius: 10px;
      background: white;
      padding: 5px;
      transition: 0.2s;
  }
  .logo-nav:hover { transform: scale(1.05); }
  .nav-link {
      font-size: 17px;
      font-weight: bold;
      color: #009944 !important;
      transition: 0.2s;
  }
  .nav-link:hover {
      color: #c8102e !important;
      transform: scale(1.05);
  }
  .btn-cerrar {
      background: #c8102e;
      color: white !important;
      font-weight: bold;
      border-radius: 6px;
  }
  .btn-cerrar:hover { background: #a10b28; }
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-fija">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="administrador.php">
        <img src="../../imagenes/logo.png" alt="Logo" class="logo-nav">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MenuAdmin">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="MenuAdmin">
      <ul class="navbar-nav mb-2 mb-lg-0" style="gap:35px;">
        <li class="nav-item"><a class="nav-link" href="./proveedores.php">Proveedores</a></li>
        <li class="nav-item"><a class="nav-link" href="./inventario.php">Inventario</a></li>
        <li class="nav-item"><a class="nav-link" href="./personal.php">Personal</a></li>
        <li class="nav-item"><a class="nav-link" href="./ventas.php">Ventas</a></li>
        <li class="nav-item"><a class="nav-link" href="./vacacionesadmin.php">Control Vacaciones</a></li>
      </ul>
    </div>

    <div class="ms-auto">
      <a href="../../logout.php" class="btn btn-cerrar px-3">Cerrar sesión</a>
    </div>
  </div>
</nav>

<div class="container mt-5">

  <h1 class="text-center mb-4">Historial de Ventas</h1>

  <!-- FORM AGREGAR -->
  <div class="card shadow p-4 mb-5">
      <h3>Registrar venta</h3>

      <form method="POST" class="row g-3">
          <input type="hidden" name="accion" value="insertar">

          <div class="col-md-3">
              <label class="form-label">Fecha y hora</label>
              <input type="datetime-local" name="fecha" class="form-control" required>
          </div>

          <div class="col-md-3">
              <label class="form-label">Usuario</label>
              <input type="text" name="usuario" class="form-control" required>
          </div>

          <div class="col-md-3">
              <label class="form-label">Monto</label>
              <input type="number" name="monto" class="form-control" required min="0" step="0.01">
          </div>

          <div class="col-md-3">
              <label class="form-label">Propina</label>
              <input type="number" name="propina" class="form-control" min="0" step="0.01" required>
          </div>

          <div class="col-12">
              <button type="submit" class="btn btn-primary">Agregar venta</button>
          </div>
      </form>
  </div>

  <!-- TABLA LISTA DE VENTAS SIN ACCIONES -->
  <h2 class="mb-3">Lista de ventas</h2>

  <table class="table table-striped table-bordered shadow">
    <thead>
      <tr>
        <th>ID</th>
        <th>Fecha y hora</th>
        <th>Usuario</th>
        <th>Monto</th>
        <th>Propina</th>
      </tr>
    </thead>

    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["fecha"] ?></td>
        <td><?= $row["usuario"] ?></td>
        <td>$<?= number_format($row["monto"],2) ?></td>
        <td>$<?= number_format($row["propina"],2) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- REPORTE SEMANAL -->
  <button class="btn btn-primary mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#reporteSemanal">
    📊 Ver Reporte Semanal de Ventas
  </button>

  <div class="collapse" id="reporteSemanal">
    <div class="card card-body shadow">
      <h3 class="mb-3">Reporte Semanal de Ventas</h3>

      <?php
        $queryReporte = "
          SELECT YEAR(fecha) AS anio,
                 WEEK(fecha) AS semana,
                 SUM(monto) AS total,
                 SUM(propina) AS total_propina
          FROM ventas
          GROUP BY anio, semana
          ORDER BY anio DESC, semana DESC
        ";

        $resultadoReporte = $conn->query($queryReporte);
      ?>

      <table class="table table-bordered table-striped">
        <thead style="background:#c8102e; color:white;">
          <tr>
            <th>Año</th>
            <th>Semana</th>
            <th>Total vendido</th>
            <th>Total propinas</th>
          </tr>
        </thead>

        <tbody>
        <?php while ($rep = $resultadoReporte->fetch_assoc()): ?>
          <tr>
            <td><?= $rep['anio'] ?></td>
            <td>Semana <?= $rep['semana'] ?></td>
            <td>$<?= number_format($rep['total'],2) ?></td>
            <td>$<?= number_format($rep['total_propina'],2) ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>

    </div>
  </div>

</div>

</body>
</html>