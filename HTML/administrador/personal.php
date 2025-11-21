<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../conexion.php";

// INSERTAR
if (isset($_POST["accion"]) && $_POST["accion"] === "insertar") {
    $nombre = $_POST["nombre"];
    $puesto = $_POST["puesto"];
    $horario = $_POST["horario"];
    $sueldo = $_POST["sueldo"];

    $sql = "INSERT INTO personal (nombre, puesto, horario, sueldo)
            VALUES ('$nombre', '$puesto', '$horario', '$sueldo')";
    $conn->query($sql);
}

// ELIMINAR
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM personal WHERE id = $id");
}

// EDITAR
if (isset($_POST["accion"]) && $_POST["accion"] === "editar") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $puesto = $_POST["puesto"];
    $horario = $_POST["horario"];
    $sueldo = $_POST["sueldo"];

    $conn->query("UPDATE personal 
                  SET nombre='$nombre',
                      puesto='$puesto',
                      horario='$horario',
                      sueldo='$sueldo'
                  WHERE id=$id");
}

$result = $conn->query("SELECT * FROM personal");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Personal Activo</title>
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
  <h1 class="text-center mb-4">Personal Activo</h1>

  <!-- FORM AGREGAR -->
  <div class="card shadow p-4 mb-5">
      <h3>Agregar empleado</h3>
      <form method="POST" class="row g-3">
          <input type="hidden" name="accion" value="insertar">
          <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="col-md-6">
              <label class="form-label">Puesto</label>
              <input type="text" name="puesto" class="form-control" required>
          </div>
          <div class="col-md-6">
              <label class="form-label">Horario</label>
              <input type="text" name="horario" class="form-control" required>
          </div>
          <div class="col-md-6">
              <label class="form-label">Sueldo</label>
              <input type="number" name="sueldo" class="form-control" required min="0" step="0.01">
          </div>
          <div class="col-12">
              <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
      </form>
  </div>

  <!-- TABLA -->
  <h2 class="mb-3">Lista de empleados</h2>
  <table class="table table-striped table-bordered shadow">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Puesto</th>
        <th>Horario</th>
        <th>Sueldo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["nombre"] ?></td>
        <td><?= $row["puesto"] ?></td>
        <td><?= $row["horario"] ?></td>
        <td>$<?= number_format($row["sueldo"],2) ?></td>
        <td>
          <button class="btn btn-warning btn-sm"
              onclick="mostrarEdicion(<?= $row['id'] ?>, '<?= $row['nombre'] ?>', '<?= $row['puesto'] ?>', '<?= $row['horario'] ?>', <?= $row['sueldo'] ?>)">
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
    <h3>Editar empleado</h3>
    <form method="POST" class="row g-3">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" id="edit_id">
        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Puesto</label>
            <input type="text" name="puesto" id="edit_puesto" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Horario</label>
            <input type="text" name="horario" id="edit_horario" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Sueldo</label>
            <input type="number" name="sueldo" id="edit_sueldo" class="form-control" required min="0" step="0.01">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <button type="button" class="btn btn-secondary" onclick="ocultarEdicion()">Cancelar</button>
        </div>
    </form>
  </div>
</div>

<script>
function mostrarEdicion(id, nombre, puesto, horario, sueldo) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nombre").value = nombre;
    document.getElementById("edit_puesto").value = puesto;
    document.getElementById("edit_horario").value = horario;
    document.getElementById("edit_sueldo").value = sueldo;
    document.getElementById("editarForm").style.display = "block";
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
function ocultarEdicion() {
    document.getElementById("editarForm").style.display = "none";
}
</script>

</body>
</html>