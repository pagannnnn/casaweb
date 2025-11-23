<?php
session_start();

if (!isset($_SESSION['empleado_activo'])) {
    header("Location: ../../index.php");
    exit;
}

$empleado = $_SESSION['empleado_activo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Empleado</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<style>

/* NAVBAR PRINCIPAL */
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

/* CARD DEL PERFIL */
.card {
    width: 380px;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* FOTO */
.foto {
    width: 120px;
    border-radius: 100px;
    display: block;
    margin: auto;
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


<!-- TARJETA DE EMPLEADO -->
<div class="card mt-4">
    <img src="../../imagenes/empleado.png" class="foto">

    <h2 class="text-center mt-3">Empleado Activo</h2>

    <p><strong>Nombre:</strong> <?= $empleado['nombre'] ?></p>
    <p><strong>Puesto:</strong> <?= $empleado['puesto'] ?></p>
    <p><strong>Área:</strong> <?= $empleado['area'] ?></p>
    <p><strong>Fecha de ingreso:</strong> <?= $empleado['fecha_ingreso'] ?></p>
    <p><strong>Teléfono:</strong> <?= $empleado['telefono'] ?></p>
    <p><strong>Correo:</strong> <?= $empleado['correo'] ?></p>
</div>

</body>
</html>