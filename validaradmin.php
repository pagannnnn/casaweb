<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Consulta exacta
$sql = "SELECT * FROM admin WHERE usuario='$usuario' AND password='$password'";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado) > 0) {
    $admin = mysqli_fetch_assoc($resultado);

    // Guardar sesión
    $_SESSION['admin_activo'] = $admin['nombre'];

    // Importante: verifica que esta ruta EXISTE
    header("Location: html/administrador/administrador.php");
    exit;
} else {
    echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='index.php';</script>";
}
?>