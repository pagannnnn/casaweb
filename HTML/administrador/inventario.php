<?php
require_once "../../conexion.php";

// --------------------------------------------------
// INSERTAR
// --------------------------------------------------
if (isset($_POST["accion"]) && $_POST["accion"] === "insertar") {

    $nombre = $_POST["nombre"];
    $categoria = $_POST["categoria"];
    $precio = floatval($_POST["precio"]);
    $cantidad = intval($_POST["cantidad"]);

    $stmt = $conn->prepare("INSERT INTO inventario_menu (nombre, categoria, precio, cantidad) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $nombre, $categoria, $precio, $cantidad);
    $stmt->execute();

    header("Location: inventario.php");
    exit;
}

// --------------------------------------------------
// ACTUALIZAR
// --------------------------------------------------
if (isset($_POST["accion"]) && $_POST["accion"] === "editar") {

    $id = intval($_POST["id"]);
    $nombre = $_POST["nombre"];
    $categoria = $_POST["categoria"];
    $precio = floatval($_POST["precio"]);
    $cantidad = intval($_POST["cantidad"]);

    $stmt = $conn->prepare("UPDATE inventario_menu SET nombre=?, categoria=?, precio=?, cantidad=? WHERE id=?");
    $stmt->bind_param("ssdii", $nombre, $categoria, $precio, $cantidad, $id);
    $stmt->execute();

    header("Location: inventario.php");
    exit;
}

// --------------------------------------------------
// ELIMINAR
// --------------------------------------------------
if (isset($_GET["eliminar"])) {
    $id = intval($_GET["eliminar"]);
    $conn->query("DELETE FROM inventario_menu WHERE id=$id");
    header("Location: inventario.php");
    exit;
}

// Listado
$resultado = $conn->query("SELECT * FROM inventario_menu ORDER BY categoria, nombre");

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Inventario de Menú</title>

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

<div class="container mt-4">

<h2 class="text-center">Inventario del Menú</h2>

<!-- FORMULARIO DE REGISTRO -->
<div class="card shadow-lg p-3 mb-4">
  <h4>Agregar Nuevo Alimento</h4>
  <form method="POST">
      <input type="hidden" name="accion" value="insertar">

      <div class="row">
        <div class="col-md-3">
          <label>Nombre</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="col-md-3">
          <label>Categoría</label>
          <select name="categoria" class="form-control" required>
            <option value="Antojitos">Antojitos</option>
            <option value="Sopas">Sopas</option>
            <option value="Platillos">Platillos</option>
            <option value="Postres">Postres</option>
            <option value="Bebidas">Bebidas</option>
          </select>
        </div>

        <div class="col-md-2">
          <label>Precio</label>
          <input type="number" name="precio" step="0.01" class="form-control" required>
        </div>

        <div class="col-md-2">
          <label>Cantidad</label>
          <input type="number" name="cantidad" class="form-control" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-primary w-100">Agregar</button>
        </div>
      </div>

  </form>
</div>

<!-- TABLA -->
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Categoría</th>
      <th>Precio</th>
      <th>Cantidad</th>
      <th>Editar</th>
      <th>Eliminar</th>
    </tr>
  </thead>

  <tbody>
    <?php while ($row = $resultado->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["nombre"] ?></td>
        <td><?= $row["categoria"] ?></td>
        <td>$<?= number_format($row["precio"], 2) ?></td>
        <td><?= $row["cantidad"] ?></td>

        <td>
          <button class="btn btn-warning btn-sm"
                  onclick="editar(<?= $row['id'] ?>, '<?= $row['nombre'] ?>', '<?= $row['categoria'] ?>', <?= $row['precio'] ?>, <?= $row['cantidad'] ?>)">
            Editar
          </button>
        </td>

        <td>
          <a class="btn btn-danger btn-sm" href="inventario.php?eliminar=<?= $row['id'] ?>">
            Eliminar
          </a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</div>

<!-- SCRIPT EDITAR -->
<script>
function editar(id, nombre, categoria, precio, cantidad) {
    let form = `
      <form method="POST" class="container mt-4">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" value="${id}">
        <h3>Editar Alimento</h3>
        <label>Nombre</label>
        <input class="form-control" name="nombre" value="${nombre}">
        <label>Categoría</label>
        <input class="form-control" name="categoria" value="${categoria}">
        <label>Precio</label>
        <input class="form-control" name="precio" value="${precio}">
        <label>Cantidad</label>
        <input class="form-control" name="cantidad" value="${cantidad}">
        <button class="btn btn-success mt-3">Guardar Cambios</button>
      </form>
    `;
    document.body.innerHTML = form;
}
</script>

</body>
</html>