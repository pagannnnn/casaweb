<?php
session_start();

if (!isset($_SESSION['admin_activo'])) {
    header("Location: ../../index.php");
    exit;
}

$admin = $_SESSION['admin_activo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Administrador</title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
body {
    font-family: Montserrat, sans-serif;
    background: #f8f8f8;
    padding: 0px;
}

.card {
    width: 350px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin: auto;
}

.foto {
    width: 120px;
    border-radius: 100px;
    display: block;
    margin: auto;
}

h2 {
    text-align: center;
    margin-top: 10px;
    color: #009944;
}

.info {
    margin-top: 20px;
}
  /* NAV FIJO */
  .navbar-fija {
      position: sticky;
      top: 0;
      z-index: 9999;
      background: white;
      padding: 10px 25px;
      border-bottom: 1px solid #cccccc7a; /* LÍNEA DELGADA */
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

<!-- NAVBAR ESTILO CASA DE TOÑO -->
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


<!-- TARJETA DEL ADMIN -->
<div class="card mt-5">
    <img src="../../imagenes/admin.jpg" class="foto">

    <h2>Administrador Activo</h2>

    <div class="info">
        <p><strong>Nombre:</strong> <?= $_SESSION['admin_activo'] ?></p>
        <p><strong>Puesto:</strong> Administrador General</p>
        <p><strong>Área:</strong> Dirección</p>
        <p><strong>Fecha de ingreso:</strong> 5 enero 2020</p>
        <p><strong>Teléfono:</strong> 55-9876-5432</p>
        <p><strong>Correo:</strong> admin@casadetoño.com</p>
    </div>
</div>

</body>
</html>