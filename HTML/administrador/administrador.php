<?php
session_start();

if (!isset($_SESSION['admin_activo'])) {
    header("Location: ../../index.php");
    exit;
}

$admin = $_SESSION['admin_activo'];
?><?php
session_start();
if (!isset($_SESSION['admin_activo'])) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Administrador</title>

<style>
body {
    font-family: Montserrat, sans-serif;
    background: #f8f8f8;
    padding: 40px;
}

.card {
    width: 350px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
</style>

</head>

<body>

<div class="card">
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