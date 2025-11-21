<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../conexion.php";

// INSERTAR
if (isset($_POST["accion"]) && $_POST["accion"] === "insertar") {
    $producto = $_POST["producto"];
    $cantidad = $_POST["cantidad"];

    $sql = "INSERT INTO inventario (producto, cantidad)
            VALUES ('$producto', '$cantidad')";
    $conn->query($sql);
}

// ELIMINAR
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM inventario WHERE id = $id");
}

// EDITAR
if (isset($_POST["accion"]) && $_POST["accion"] === "editar") {
    $id = $_POST["id"];
    $producto = $_POST["producto"];
    $cantidad = $_POST["cantidad"];

    $conn->query("UPDATE inventario 
                  SET producto='$producto',
                      cantidad='$cantidad'
                  WHERE id=$id");
}

$result = $conn->query("SELECT * FROM inventario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inventario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    header { background: #c8102e; padding: 15px; }
    #menu ul { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; align-items: center; }
    #menu a { color: white; text-decoration: none; font-weight: bold; }
    #menu a:hover { color: #f4c300; }
    .logo img { height: 45px; margin-right: 20px; background: white; padding: 5px; border-radius: 5px; }
    body { font-family: 'Montserrat', sans-serif; background-color: #f8f8f8; }
    h1,h2,h3 { color: #c8102e; }
    .card { border: 2px solid #c8102e; }
    .btn-primary { background-color: #c8102e; border-color: #c8102e; }
    .btn-primary:hover { background-color: #a10b28; border-color: #a10b28; }
    .btn-warning { background-color: #f4c300; border-color: #f4c300; color: #000; }
    .btn-warning:hover { background-color: #e0b000; border-color: #e0b000; }
    .btn-success { background-color: #c8102e; border-color: #c8102e; }
    .btn-secondary { background-color: #6c757d; border-color: #6c757d; }
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
  <h1 class="text-center mb-4">Inventario General</h1>

  <!-- FORM AGREGAR -->
  <div class="card shadow p-4 mb-5">
      <h3>Agregar producto</h3>
      <form method="POST" class="row g-3">
          <input type="hidden" name="accion" value="insertar">
          <div class="col-md-6">
              <label class="form-label">Producto</label>
              <input type="text" name="producto" class="form-control" required>
          </div>
          <div class="col-md-6">
              <label class="form-label">Cantidad</label>
              <input type="number" name="cantidad" class="form-control" required min="0">
          </div>
          <div class="col-12">
              <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
      </form>
  </div>

  <!-- TABLA -->
  <h2 class="mb-3">Lista de productos</h2>
  <table class="table table-striped table-bordered shadow">
    <thead>
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["producto"] ?></td>
        <td><?= $row["cantidad"] ?></td>
        <td>
          <button class="btn btn-warning btn-sm"
              onclick="mostrarEdicion(<?= $row['id'] ?>, '<?= $row['producto'] ?>', <?= $row['cantidad'] ?>)">
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

  <!-- FORM EDITAR -->
  <div id="editarForm" class="card shadow p-4 mt-5" style="display:none;">
    <h3>Editar producto</h3>
    <form method="POST" class="row g-3">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" id="edit_id">
        <div class="col-md-6">
            <label class="form-label">Producto</label>
            <input type="text" name="producto" id="edit_producto" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="edit_cantidad" class="form-control" required min="0">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <button type="button" class="btn btn-secondary" onclick="ocultarEdicion()">Cancelar</button>
        </div>
    </form>
  </div>
</div>

<script>
function mostrarEdicion(id, producto, cantidad) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_producto").value = producto;
    document.getElementById("edit_cantidad").value = cantidad;
    document.getElementById("editarForm").style.display = "block";
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
function ocultarEdicion() {
    document.getElementById("editarForm").style.display = "none";
}
</script>

</body>
</html>