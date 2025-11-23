<?php
session_start();
require_once "conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM empleados WHERE usuario='$usuario' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {

    $empleado = mysqli_fetch_assoc($result);
    $_SESSION['empleado_activo'] = $empleado;

    header("Location: html/empleado/empleado.php");
    exit;

} else {
    echo "<script>alert('Usuario o contraseña incorrectos'); window.location='index.php';</script>";
}
?>