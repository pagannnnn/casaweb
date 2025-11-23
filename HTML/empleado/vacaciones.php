<?php
session_start();
require_once "../../conexion.php";

// VERIFICAR SESIÓN
if (!isset($_SESSION["empleado_activo"])) {
    header("Location: ../../index.php");
    exit;
}

$empleado = $_SESSION["empleado_activo"];
$idEmpleado = $empleado["id"];

// ===============================
// PROCESAR SOLICITUD DE VACACIONES
// ===============================
if (isset($_POST["solicitar"])) {

    $inicio = $_POST["fecha_inicio"];
    $fin = $_POST["fecha_fin"];

    // Calcular días
    $dias = (strtotime($fin) - strtotime($inicio)) / 86400 + 1;

    if ($dias <= 0) {
        echo "<script>alert('La fecha final debe ser mayor a la inicial');</script>";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO vacaciones (id_empleado, fecha_inicio, fecha_fin, dias, estado, comentario)
            VALUES (?, ?, ?, ?, 'Pendiente', 'Solicitud enviada')
        ");

        $stmt->bind_param("issi", $idEmpleado, $inicio, $fin, $dias);
        $stmt->execute();
        $stmt->close();

        header("Location: vacaciones.php");
        exit;
    }
}

// CONSULTAR VACACIONES DEL EMPLEADO
$sql = "SELECT * FROM vacaciones WHERE id_empleado = $idEmpleado ORDER BY fecha_inicio DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Vacaciones</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


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
    <h1 class="text-center mb-4">Mis Vacaciones</h1>

    <!-- =========================== -->
    <!-- FORMULARIO PARA SOLICITAR -->
    <!-- =========================== -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            Solicitar Vacaciones
        </div>
        <div class="card-body">

            <form method="POST">

                <div class="row">
                    <div class="col">
                        <label>Fecha Inicio:</label>
                        <input type="date" name="fecha_inicio" required class="form-control">
                    </div>

                    <div class="col">
                        <label>Fecha Fin:</label>
                        <input type="date" name="fecha_fin" required class="form-control">
                    </div>
                </div>

                <button type="submit" name="solicitar" class="btn btn-success mt-3">
                    Enviar Solicitud
                </button>
            </form>

        </div>
    </div>

    <!-- =========================== -->
    <!-- LISTA DE VACACIONES -->
    <!-- =========================== -->
    <?php if ($result->num_rows > 0): ?>
    
        <table class="table table-bordered table-striped shadow">
            <thead class="table-dark">
                <tr>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Días</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                </tr>
            </thead>

            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["fecha_inicio"] ?></td>
                    <td><?= $row["fecha_fin"] ?></td>
                    <td><?= $row["dias"] ?></td>
                    <td>
                        <?php
                            if ($row["estado"] == "Aprobado") {
                                echo "<span class='badge bg-success'>Aprobado</span>";
                            } elseif ($row["estado"] == "Rechazado") {
                                echo "<span class='badge bg-danger'>Rechazado</span>";
                            } else {
                                echo "<span class='badge bg-warning text-dark'>Pendiente</span>";
                            }
                        ?>
                    </td>
                    <td><?= $row["comentario"] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

    <?php else: ?>

        <div class="alert alert-info text-center">
            No tienes vacaciones registradas.
        </div>

    <?php endif; ?>
</div>

</body>
</html>