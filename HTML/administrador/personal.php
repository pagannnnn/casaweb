<?php
session_start();
require_once "../../conexion.php"; // AJUSTA ESTA RUTA SI ES NECESARIO

// ===================================
// INSERTAR NUEVO EMPLEADO
// ===================================
if (isset($_POST["accion"]) && $_POST["accion"] === "insertar") {

    $sql = "INSERT INTO empleados (nombre, usuario, password, correo, telefono, puesto, area, fecha_ingreso)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssss",
        $_POST["nombre"],
        $_POST["usuario"],
        $_POST["password"],
        $_POST["correo"],
        $_POST["telefono"],
        $_POST["puesto"],
        $_POST["area"],
        $_POST["fecha_ingreso"]
    );

    $stmt->execute();
    $stmt->close();

    header("Location: personal.php");
    exit;
}

// ===================================
// ACTUALIZAR EMPLEADO
// ===================================
if (isset($_POST["accion"]) && $_POST["accion"] === "editar") {

    $sql = "UPDATE empleados SET nombre=?, usuario=?, password=?, correo=?, telefono=?, puesto=?, area=?, fecha_ingreso=?
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssi",
        $_POST["nombre"],
        $_POST["usuario"],
        $_POST["password"],
        $_POST["correo"],
        $_POST["telefono"],
        $_POST["puesto"],
        $_POST["area"],
        $_POST["fecha_ingreso"],
        $_POST["id"]
    );

    $stmt->execute();
    $stmt->close();

    header("Location: personal.php");
    exit;
}

// ===================================
// ELIMINAR EMPLEADO
// ===================================
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM empleados WHERE id = $id");
    header("Location: personal.php");
    exit;
}

// ===================================
// OBTENER TODOS LOS EMPLEADOS
// ===================================
$empleados = $conn->query("SELECT * FROM empleados");
?>

<!DOCTYPE html>
<html lang="es">
  
<head>
<meta charset="UTF-8">
<title>Personal - CRUD</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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

<div class="container">

    <h2 class="mb-4">Gestión de Empleados</h2>

    <!-- ========================= -->
    <!-- FORMULARIO AGREGAR -->
    <!-- ========================= -->
    <div class="card mb-4">
        <div class="card-header">Agregar Empleado</div>
        <div class="card-body">

            <form method="POST">
                <input type="hidden" name="accion" value="insertar">

                <div class="row mb-3">
                    <div class="col">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Correo</label>
                        <input type="email" name="correo" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="col">
                        <label>Puesto</label>
                        <input type="text" name="puesto" class="form-control">
                    </div>
                    <div class="col">
                        <label>Área</label>
                        <input type="text" name="area" class="form-control">
                    </div>
                </div>

                <label>Fecha de ingreso</label>
                <input type="date" name="fecha_ingreso" class="form-control mb-3">

                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>

        </div>
    </div>

    <!-- ========================= -->
    <!-- TABLA DE EMPLEADOS -->
    <!-- ========================= -->
    <div class="card">
        <div class="card-header">Lista de Empleados</div>
        <div class="card-body p-0">

            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Puesto</th>
                        <th>Área</th>
                        <th>Ingreso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($e = $empleados->fetch_assoc()): ?>
                    <tr>
                        <td><?= $e["id"] ?></td>
                        <td><?= $e["nombre"] ?></td>
                        <td><?= $e["usuario"] ?></td>
                        <td><?= $e["correo"] ?></td>
                        <td><?= $e["puesto"] ?></td>
                        <td><?= $e["area"] ?></td>
                        <td><?= $e["fecha_ingreso"] ?></td>

                        <td>
                            <!-- BOTÓN EDITAR -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEditar<?= $e["id"] ?>">Editar</button>

                            <!-- BOTÓN ELIMINAR -->
                            <a href="personal.php?eliminar=<?= $e['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
                        </td>
                    </tr>

                    <!-- ========================= -->
                    <!-- MODAL EDITAR -->
                    <!-- ========================= -->
                    <div class="modal fade" id="modalEditar<?= $e["id"] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" class="modal-content">

                                <input type="hidden" name="accion" value="editar">
                                <input type="hidden" name="id" value="<?= $e['id'] ?>">

                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Empleado</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <label>Nombre</label>
                                    <input type="text" name="nombre" class="form-control mb-2"
                                           value="<?= $e['nombre'] ?>">

                                    <label>Usuario</label>
                                    <input type="text" name="usuario" class="form-control mb-2"
                                           value="<?= $e['usuario'] ?>">

                                    <label>Password</label>
                                    <input type="text" name="password" class="form-control mb-2"
                                           value="<?= $e['password'] ?>">

                                    <label>Correo</label>
                                    <input type="email" name="correo" class="form-control mb-2"
                                           value="<?= $e['correo'] ?>">

                                    <label>Teléfono</label>
                                    <input type="text" name="telefono" class="form-control mb-2"
                                           value="<?= $e['telefono'] ?>">

                                    <label>Puesto</label>
                                    <input type="text" name="puesto" class="form-control mb-2"
                                           value="<?= $e['puesto'] ?>">

                                    <label>Área</label>
                                    <input type="text" name="area" class="form-control mb-2"
                                           value="<?= $e['area'] ?>">

                                    <label>Fecha ingreso</label>
                                    <input type="date" name="fecha_ingreso" class="form-control"
                                           value="<?= $e['fecha_ingreso'] ?>">

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>

                            </form>
                        </div>
                    </div>

                    <?php endwhile; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>