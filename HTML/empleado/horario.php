<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../conexion.php";

// Obtener el horario
$result = $conn->query("SELECT * FROM horario_semanal ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Horario Semanal</title>

  <!-- BOOSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    .navbar-principal {
    background: #067A0F !important;
    padding: 12px 30px;
}

/* LOGO */
.logo-empleado {
    height: 55px;
    background: white;
    padding: 3px;
    border-radius: 5px;
}

/* LINKS DEL MENÚ */
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
    .logo img {
        height: 50px;
        margin-right: 20px;
        background-color: white;
        padding: 5px;
        border-radius: 5px;
    }
  </style>

</head>
<body>


<!-- NAVBAR PRINCIPAL -->
<nav class="navbar navbar-expand-lg navbar-principal">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand" href="empleado.php">
      <img src="../../imagenes/logo.png" class="logo-empleado" alt="Logo">
    </a>

    <!-- BOTÓN RESPONSIVE -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MenuEmpleado">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENÚ CENTRADO -->
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

    <!-- BOTÓN DERECHA -->
    <div class="ms-auto">
      <a href="../../logout.php" class="btn btn-danger fw-bold">Cerrar Sesión</a>
    </div>

  </div>
</nav>



<div class="container mt-5">

  <h1 class="text-center mb-4">Horario Semanal</h1>

  <div class="alert alert-info text-center">
      Este es tu horario asignado. Debes respetar estas horas de trabajo.
  </div>

  <!-- TABLA -->
  <table class="table table-striped table-bordered shadow">
    <thead class="table-dark">
      <tr>
        <th>Día</th>
        <th>Hora inicio</th>
        <th>Hora fin</th>
        <th>Actividad</th>
      </tr>
    </thead>

    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["dia"] ?></td>
        <td><?= $row["hora_inicio"] ?></td>
        <td><?= $row["hora_fin"] ?></td>
        <td><?= $row["actividad"] ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

</div>

</body>
</html>