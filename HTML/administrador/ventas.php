<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../conexion.php";

// INSERTAR
if (isset($_POST["accion"]) && $_POST["accion"] === "insertar") {
    $fecha = $_POST["fecha"];
    $usuario = $_POST["usuario"];
    $monto = $_POST["monto"];

    $sql = "INSERT INTO ventas (fecha, usuario, monto)
            VALUES ('$fecha', '$usuario', '$monto')";
    $conn->query($sql);
}

// ELIMINAR
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM ventas WHERE id = $id");
}

// EDITAR
if (isset($_POST["accion"]) && $_POST["accion"] === "editar") {
    $id = $_POST["id"];
    $fecha = $_POST["fecha"];
    $usuario = $_POST["usuario"];
    $monto = $_POST["monto"];

    $conn->query("UPDATE ventas 
                  SET fecha='$fecha',
                      usuario='$usuario',
                      monto='$monto'
                  WHERE id=$id");
}

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
    header { background: #c8102e; padding: 15px; }
    #menu ul { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; align-items: center; }
    #menu a { color: white; text-decoration: none; font-weight: bold; }
    #menu a:hover { color: #f4c300; }
    .logo img { height: 45px; margin-right: 20px; background: white; padding: 5px; border-radius: 5px; }
    body { font-family: 'Montserrat', sans-serif; background-color: #f8f8f8; }
    h1, h2, h3 { color: #c8102e; }
    .card { border: 2px solid #c8102e; }
    .btn-primary { background-color: #c8102e; border-color: #c8102e; }
    .btn-primary:hover { background-color: #a10b28; border-color: #a10b28; }
    .btn-warning { background-color: #f4c300; border-color: #f4c300; color: #000; }
    .btn-warning:hover { background-color: #e0b000; border-color: #e0b000; }
    .btn-danger { background-color: #c8102e; border-color: #c8102e; }
    .table thead { background-color: #c8102e; color: white; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f9dada; }
  </style>
</head>

<body>

<header>
  <nav id="menu" class="container d-flex justify-content-between">
    <a href="./administrador.html" class="logo"><img src="../imagenes/logo.png" alt="Logo"></a>

    <ul>
      <li><a href="./proveedores.php">Proveedores</a></li>
      <li><a href="./inventario.php">Inventario</a></li>
      <li><a href="./personal.php">Personal</a></li>
      <li><a href="./ventas.php">Ventas</a></li>
    </ul>
  </nav>
</header>

<div class="container mt-5">

  <h1 class="text-center mb-4">Historial de Ventas</h1>

  <!-- FORM AGREGAR -->
  <div class="card shadow p-4 mb-5">
      <h3>Registrar venta</h3>

      <form method="POST" class="row g-3">
          <input type="hidden" name="accion" value="insertar">

          <div class="col-md-4">
              <label class="form-label">Fecha y hora</label>
              <input type="datetime-local" name="fecha" class="form-control" required>
          </div>

          <div class="col-md-4">
              <label class="form-label">Usuario</label>
              <input type="text" name="usuario" class="form-control" required>
          </div>

          <div class="col-md-4">
              <label class="form-label">Monto</label>
              <input type="number" name="monto" class="form-control" required min="0" step="0.01">
          </div>

          <div class="col-12">
              <button type="submit" class="btn btn-primary">Agregar venta</button>
          </div>
      </form>
  </div>

  <!-- TABLA LISTA DE VENTAS -->
  <h2 class="mb-3">Lista de ventas</h2>

  <table class="table table-striped table-bordered shadow">
    <thead>
      <tr>
        <th>ID</th>
        <th>Fecha y hora</th>
        <th>Usuario</th>
        <th>Monto</th>
        <th>Acciones</th>
      </tr>
    </thead>

    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["fecha"] ?></td>
        <td><?= $row["usuario"] ?></td>
        <td>$<?= number_format($row["monto"],2) ?></td>

        <td>
          <button class="btn btn-warning btn-sm"
              onclick="mostrarEdicion(<?= $row['id'] ?>, '<?= $row['fecha'] ?>', '<?= $row['usuario'] ?>', <?= $row['monto'] ?>)">
            Editar
          </button>

          <a href="?eliminar=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
             onclick="return confirm('¿Seguro que deseas eliminar?')">
            Eliminar
          </a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>


  <!-- BOTÓN PARA MOSTRAR REPORTE -->
  <button class="btn btn-primary mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#reporteSemanal">
    📊 Ver Reporte Semanal de Ventas
  </button>

  <!-- COLLAPSE DEL REPORTE -->
  <div class="collapse" id="reporteSemanal">
    <div class="card card-body shadow">

      <h3 class="mb-3">Reporte Semanal de Ventas</h3>

      <?php
        $queryReporte = "
          SELECT YEAR(fecha) AS anio,
                 WEEK(fecha) AS semana,
                 SUM(monto) AS total
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
          </tr>
        </thead>

        <tbody>
        <?php while ($rep = $resultadoReporte->fetch_assoc()): ?>
          <tr>
            <td><?= $rep['anio'] ?></td>
            <td>Semana <?= $rep['semana'] ?></td>
            <td>$<?= number_format($rep['total'],2) ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>

    </div>
  </div>


  <!-- FORM EDITAR -->
  <div id="editarForm" class="card shadow p-4 mt-5" style="display:none;">
    <h3>Editar venta</h3>

    <form method="POST" class="row g-3">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" id="edit_id">

        <div class="col-md-4">
            <label class="form-label">Fecha y hora</label>
            <input type="datetime-local" name="fecha" id="edit_fecha" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" id="edit_usuario" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Monto</label>
            <input type="number" name="monto" id="edit_monto" class="form-control" required min="0" step="0.01">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <button type="button" class="btn btn-secondary" onclick="ocultarEdicion()">Cancelar</button>
        </div>
    </form>
  </div>

</div>

<script>
function mostrarEdicion(id, fecha, usuario, monto) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_fecha").value = fecha;
    document.getElementById("edit_usuario").value = usuario;
    document.getElementById("edit_monto").value = monto;
    document.getElementById("editarForm").style.display = "block";
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function ocultarEdicion() {
    document.getElementById("editarForm").style.display = "none";
}
</script>

</body>
</html>