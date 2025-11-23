<?php
session_start();
require_once "../../conexion.php";

// VERIFICAR QUE HAYA SESIÓN
if (!isset($_SESSION["empleado_activo"]) && !isset($_SESSION["admin_activo"])) {
    echo "<h2 style='color:red;text-align:center'>Debe iniciar sesión.</h2>";
    exit;
}

// ACCIONES: Aprobar / Rechazar / Eliminar
if (isset($_GET["aprobar"])) {
    $id = intval($_GET["aprobar"]);
    $conn->query("UPDATE vacaciones SET estado='Aprobado' WHERE id=$id");
}
if (isset($_GET["rechazar"])) {
    $id = intval($_GET["rechazar"]);
    $conn->query("UPDATE vacaciones SET estado='Rechazado' WHERE id=$id");
}
if (isset($_GET["eliminar"])) {
    $id = intval($_GET["eliminar"]);
    $conn->query("DELETE FROM vacaciones WHERE id=$id");
}

// CONSULTAR EMPLEADOS Y SUS VACACIONES
$sql = "SELECT e.id AS empleado_id, e.nombre, v.id AS vac_id, v.fecha_inicio, v.fecha_fin, v.dias, v.estado, v.comentario
        FROM empleados e
        LEFT JOIN vacaciones v ON e.id = v.id_empleado
        ORDER BY e.nombre, v.fecha_inicio DESC";

$result = $conn->query($sql);
$empleados = [];
while ($row = $result->fetch_assoc()) {
    $empleados[$row["empleado_id"]]["nombre"] = $row["nombre"];
    if ($row["vac_id"]) {
        $empleados[$row["empleado_id"]]["vacaciones"][] = [
            "id" => $row["vac_id"],
            "fecha_inicio" => $row["fecha_inicio"],
            "fecha_fin" => $row["fecha_fin"],
            "dias" => $row["dias"],
            "estado" => $row["estado"],
            "comentario" => $row["comentario"]
        ];
    } else {
        $empleados[$row["empleado_id"]]["vacaciones"] = [];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Vacaciones Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  /* NAV FIJO */
  .navbar-fija {
      position: sticky;
      top: 0;
      z-index: 9999;
      background: white;
      padding: 10px 25px;
      border-bottom: 3px solid #cccccc7a; /* LÍNEA DELGADA */
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  /* LOGO */
  .logo-nav {
      height: 60px;
      border-radius: 10px;
      background: white;
      padding: 5px;
      transition: 0.2s;
  }
  .logo-nav:hover {
      transform: scale(1.05);
  }

  /* LINKS */
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

  /* BOTÓN DE CERRAR SESIÓN */
  .btn-cerrar {
      background: #c8102e;
      color: white !important;
      font-weight: bold;
      border-radius: 6px;
  }
  .btn-cerrar:hover {
      background: #a10b28;
  }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-fija">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="administrador.php">
        <img src="../../imagenes/logo.png" alt="Logo" class="logo-nav">
    </a>

    <!-- BOTÓN HAMBURGUESA -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MenuAdmin">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENÚ CENTRADO -->
    <div class="collapse navbar-collapse justify-content-center" id="MenuAdmin">
      <ul class="navbar-nav mb-2 mb-lg-0" style="gap:35px;">
        <li class="nav-item">
          <a class="nav-link" href="./proveedores.php">Proveedores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./inventario.php">Inventario</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./personal.php">Personal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./ventas.php">Ventas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./vacacionesadmin.php">Control Vacaciones</a>
        </li>
      </ul>
    </div>

    <!-- BOTÓN CERRAR SESIÓN -->
    <div class="ms-auto">
      <a href="../../logout.php" class="btn btn-cerrar px-3">
        Cerrar sesión
      </a>
    </div>

  </div>
</nav>

<div class="container mt-5">
<h1 class="text-center mb-4">Administración de Vacaciones</h1>

<?php foreach ($empleados as $empleado_id => $data): ?>
    <h3><?= $data["nombre"] ?></h3>
    <?php if (count($data["vacaciones"]) > 0): ?>
        <table class="table table-bordered table-striped mb-4">
            <thead class="table-dark">
                <tr>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Días</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data["vacaciones"] as $vac): ?>
                <tr>
                    <td><?= $vac["fecha_inicio"] ?></td>
                    <td><?= $vac["fecha_fin"] ?></td>
                    <td><?= $vac["dias"] ?></td>
                    <td>
                        <?php
                        if ($vac["estado"] == "Aprobado") echo "<span class='badge bg-success'>Aprobado</span>";
                        elseif ($vac["estado"] == "Rechazado") echo "<span class='badge bg-danger'>Rechazado</span>";
                        else echo "<span class='badge bg-warning text-dark'>Pendiente</span>";
                        ?>
                    </td>
                    <td><?= $vac["comentario"] ?></td>
                    <td>
                        <?php if ($vac["estado"] === "Pendiente"): ?>
                            <a href="?aprobar=<?= $vac['id'] ?>" class="btn btn-success btn-sm">Aprobar</a>
                            <a href="?rechazar=<?= $vac['id'] ?>" class="btn btn-danger btn-sm">Rechazar</a>
                        <?php endif; ?>
                        <a href="?eliminar=<?= $vac['id'] ?>" onclick="return confirm('¿Eliminar registro?')" class="btn btn-secondary btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No tiene vacaciones registradas.</div>
    <?php endif; ?>
<?php endforeach; ?>

</div>

</body>
</html>