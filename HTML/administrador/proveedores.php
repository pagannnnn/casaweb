<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../conexion.php";

// INSERTAR
if (isset($_POST["accion"]) && $_POST["accion"] === "insertar") {
    $nombre = $_POST["nombre"];
    $producto = $_POST["producto"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $sql = "INSERT INTO proveedores (nombre, producto, telefono, correo)
            VALUES ('$nombre', '$producto', '$telefono', '$correo')";
    $conn->query($sql);
}

// ELIMINAR
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM proveedores WHERE id = $id");
}

// EDITAR
if (isset($_POST["accion"]) && $_POST["accion"] === "editar") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $producto = $_POST["producto"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $conn->query("UPDATE proveedores 
                  SET nombre='$nombre',
                      producto='$producto',
                      telefono='$telefono',
                      correo='$correo'
                  WHERE id=$id");
}

$result = $conn->query("SELECT * FROM proveedores");
?>

<!DOCTYPE html>
<html lang="es">
<head>


  <meta charset="UTF-8">
  <title>Proveedores</title>

  <!-- BOOSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    header {
        background: #009900d2;
        padding: 40px;
    }
    #menu ul {
        list-style: none;
        display: flex;
        gap: 50px;
        margin: 0;
        padding: 0;
        align-items: center;
    }
    #menu a {
        color: white;
        text-decoration: none;
        font-weight: bold;
    }
    #menu a:hover {
        color: #0d6efd;
    }
    .logo img {
        height: 50px;
        margin-right: 20px;
    }
    .logo img {
    height: 50px;
    margin-right: 20px;
    background-color: white; /* Fondo blanco */
    padding: 5px;            /* Espacio alrededor del logo */
    border-radius: 5px;      /* Bordes suavemente redondeados */
}

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

  <h1 class="text-center mb-4">Administración de Proveedores</h1>

  <!-- FORM AGREGAR -->
  <div class="card shadow p-4 mb-5">
      <h3>Agregar proveedor</h3>

      <form method="POST" class="row g-3">
          <input type="hidden" name="accion" value="insertar">

          <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="nombre" class="form-control" required>
          </div>

          <div class="col-md-6">
              <label class="form-label">Producto</label>
              <input type="text" name="producto" class="form-control" required>
          </div>

          <div class="col-md-6">
              <label class="form-label">Teléfono</label>
              <input type="text" name="telefono" class="form-control">
          </div>

          <div class="col-md-6">
              <label class="form-label">Correo</label>
              <input type="email" name="correo" class="form-control">
          </div>

          <div class="col-12">
              <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
      </form>
  </div>

  <!-- TABLA -->
  <h2 class="mb-3">Lista de proveedores</h2>

  <table class="table table-striped table-bordered shadow">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Producto</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Acciones</th>
      </tr>
    </thead>

    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["nombre"] ?></td>
        <td><?= $row["producto"] ?></td>
        <td><?= $row["telefono"] ?></td>
        <td><?= $row["correo"] ?></td>
        <td>
          <button 
              class="btn btn-warning btn-sm"
              onclick="mostrarEdicion(
                <?= $row['id'] ?>, 
                '<?= $row['nombre'] ?>', 
                '<?= $row['producto'] ?>', 
                '<?= $row['telefono'] ?>', 
                '<?= $row['correo'] ?>')">
            Editar
          </button>

          <a href="?eliminar=<?= $row['id'] ?>" 
             class="btn btn-danger btn-sm"
             onclick="return confirm('¿Seguro que deseas eliminar?')">
            Eliminar
          </a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- FORM EDITAR -->
  <div id="editarForm" class="card shadow p-4 mt-5" style="display:none;">
    <h3>Editar proveedor</h3>

    <form method="POST" class="row g-3">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" id="edit_id">

        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Producto</label>
            <input type="text" name="producto" id="edit_producto" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="edit_telefono" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" id="edit_correo" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <button type="button" class="btn btn-secondary" onclick="ocultarEdicion()">Cancelar</button>
        </div>
    </form>
  </div>

</div>

<script>
function mostrarEdicion(id, nombre, producto, telefono, correo) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nombre").value = nombre;
    document.getElementById("edit_producto").value = producto;
    document.getElementById("edit_telefono").value = telefono;
    document.getElementById("edit_correo").value = correo;
    document.getElementById("editarForm").style.display = "block";

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function ocultarEdicion() {
    document.getElementById("editarForm").style.display = "none";
}
</script>

</body>
</html>
